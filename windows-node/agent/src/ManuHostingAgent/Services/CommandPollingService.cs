using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Configuration;
using ManuHostingAgent.Models;
using ManuHostingAgent.Services;

namespace ManuHostingAgent.Services;

public class CommandPollingService : BackgroundService
{
    private readonly ILogger<CommandPollingService> _logger;
    private readonly IConfiguration _configuration;
    private readonly IControlPlaneApi _controlPlaneApi;
    private readonly IProcessManager _processManager;
    private readonly IFileManager _fileManager;
    private readonly IBackupManager _backupManager;
    private readonly IIdleShutdownManager _idleShutdownManager;
    private readonly string _nodeId;
    private readonly string _nodeToken;
    private readonly int _pollInterval;

    public CommandPollingService(
        ILogger<CommandPollingService> logger,
        IConfiguration configuration,
        IControlPlaneApi controlPlaneApi,
        IProcessManager processManager,
        IFileManager fileManager,
        IBackupManager backupManager,
        IIdleShutdownManager idleShutdownManager)
    {
        _logger = logger;
        _configuration = configuration;
        _controlPlaneApi = controlPlaneApi;
        _processManager = processManager;
        _fileManager = fileManager;
        _backupManager = backupManager;
        _idleShutdownManager = idleShutdownManager;
        _nodeId = _configuration["ControlPlane:NodeId"] ?? "dl580-node-01";
        _nodeToken = _configuration["ControlPlane:NodeToken"] ?? "CHANGE_ME";
        _pollInterval = _configuration.GetValue<int>("Agent:CommandPollInterval", 5);
    }

    protected override async Task ExecuteAsync(CancellationToken stoppingToken)
    {
        _logger.LogInformation("Command polling service started (interval: {Interval}s)", _pollInterval);

        // Initial delay
        await Task.Delay(15000, stoppingToken);

        while (!stoppingToken.IsCancellationRequested)
        {
            try
            {
                await PollAndExecuteCommandsAsync(stoppingToken);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error polling commands");
            }

            await Task.Delay(TimeSpan.FromSeconds(_pollInterval), stoppingToken);
        }

        _logger.LogInformation("Command polling service stopped");
    }

    private async Task PollAndExecuteCommandsAsync(CancellationToken stoppingToken)
    {
        var commands = await _controlPlaneApi.PollCommandsAsync(_nodeId, _nodeToken);
        
        if (commands.Count == 0)
        {
            return;
        }

        _logger.LogInformation("Received {Count} commands from control plane", commands.Count);

        foreach (var command in commands)
        {
            if (stoppingToken.IsCancellationRequested)
                break;

            try
            {
                var result = await ExecuteCommandAsync(command);
                await _controlPlaneApi.SendCommandResultAsync(_nodeId, _nodeToken, result);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error executing command {CommandId}", command.Id);
                
                var errorResult = new CommandResult
                {
                    Id = command.Id,
                    Success = false,
                    Error = ex.Message,
                    CompletedAt = DateTime.UtcNow
                };
                
                await _controlPlaneApi.SendCommandResultAsync(_nodeId, _nodeToken, errorResult);
            }
        }
    }

    private async Task<CommandResult> ExecuteCommandAsync(CommandRequest command)
    {
        _logger.LogInformation("Executing command {Command} for server {ServerUuid}", command.Command, command.ServerUuid);

        var result = new CommandResult
        {
            Id = command.Id,
            Success = false,
            CompletedAt = DateTime.UtcNow
        };

        switch (command.Command.ToLower())
        {
            case "start":
                result.Success = await _processManager.StartServerAsync(
                    await GetServerConfigAsync(command.ServerUuid));
                result.Output = result.Success ? "Server started" : "Failed to start server";
                break;

            case "stop":
                result.Success = await _processManager.StopServerAsync(command.ServerUuid);
                result.Output = result.Success ? "Server stopped" : "Failed to stop server";
                break;

            case "restart":
                result.Success = await _processManager.RestartServerAsync(command.ServerUuid);
                result.Output = result.Success ? "Server restarted" : "Failed to restart server";
                break;

            case "console":
                var consoleCmd = command.Parameters.GetValueOrDefault("command")?.ToString() ?? "";
                result.Success = await _processManager.SendConsoleCommandAsync(command.ServerUuid, consoleCmd);
                result.Output = result.Success ? "Command sent" : "Failed to send command";
                break;

            case "backup":
                var backup = await _backupManager.CreateBackupAsync(command.ServerUuid);
                result.Success = backup.Status == "completed";
                result.Output = result.Success ? $"Backup created: {backup.Id}" : $"Backup failed: {backup.ErrorMessage}";
                break;

            case "install":
                result.Success = await InstallServerAsync(command);
                result.Output = result.Success ? "Server installed" : "Installation failed";
                break;

            case "update_idle_shutdown":
                var enabled = command.Parameters.GetValueOrDefault("enabled")?.ToString()?.ToLower() == "true";
                var timeout = int.TryParse(command.Parameters.GetValueOrDefault("timeout")?.ToString(), out var t) ? t : 60;
                
                if (enabled)
                {
                    await _idleShutdownManager.StartMonitoringAsync(command.ServerUuid, timeout);
                }
                else
                {
                    await _idleShutdownManager.StopMonitoringAsync(command.ServerUuid);
                }
                result.Success = true;
                result.Output = $"Idle shutdown {(enabled ? "enabled" : "disabled")} with timeout {timeout}s";
                break;

            case "get_status":
                var status = await _processManager.GetServerStatusAsync(command.ServerUuid);
                result.Success = status != null;
                result.Output = System.Text.Json.JsonSerializer.Serialize(status);
                break;

            default:
                result.Error = $"Unknown command: {command.Command}";
                break;
        }

        return result;
    }

    private async Task<ServerConfig?> GetServerConfigAsync(string serverUuid)
    {
        // In a real implementation, this would fetch from the control plane or local storage
        // For now, return a basic config
        var serverDir = Path.Combine(_configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers", serverUuid);
        if (!Directory.Exists(serverDir))
        {
            return null;
        }

        // Try to read server.properties
        var propsContent = await _fileManager.ReadFileAsync(serverUuid, "server.properties");
        var config = new ServerConfig { Uuid = serverUuid };

        if (!string.IsNullOrEmpty(propsContent))
        {
            foreach (var line in propsContent.Split('\n'))
            {
                var parts = line.Split('=', 2);
                if (parts.Length == 2)
                {
                    var key = parts[0].Trim();
                    var value = parts[1].Trim();
                    
                    switch (key)
                    {
                        case "server-port": int.TryParse(value, out config.Port); break;
                        case "max-players": int.TryParse(value, out config.MaxPlayers); break;
                        case "motd": config.Name = value.Replace("Manu Hosting - ", ""); break;
                    }
                }
            }
        }

        return config;
    }

    private async Task<bool> InstallServerAsync(CommandRequest command)
    {
        var serverUuid = command.ServerUuid;
        var parameters = command.Parameters;

        var config = new ServerConfig
        {
            Uuid = serverUuid,
            Name = parameters.GetValueOrDefault("name")?.ToString() ?? serverUuid,
            Version = parameters.GetValueOrDefault("version")?.ToString() ?? "1.20.4",
            Software = parameters.GetValueOrDefault("software")?.ToString() ?? "paper",
            JavaVersion = parameters.GetValueOrDefault("java_version")?.ToString() ?? "21",
            Ram = int.TryParse(parameters.GetValueOrDefault("ram")?.ToString(), out var r) ? r : 2048,
            Cpu = int.TryParse(parameters.GetValueOrDefault("cpu")?.ToString(), out var c) ? c : 2,
            Disk = int.TryParse(parameters.GetValueOrDefault("disk")?.ToString(), out var d) ? d : 10240,
            Port = int.TryParse(parameters.GetValueOrDefault("port")?.ToString(), out var p) ? p : 25565,
        };

        // Create server directory
        await _fileManager.CreateServerDirectoryAsync(serverUuid);

        // Download server jar
        await _controlPlaneApi.SendInstallProgressAsync(_nodeId, _nodeToken, serverUuid, 10, "Downloading server software...");
        var jarPath = await DownloadServerJarAsync(config);
        if (string.IsNullOrEmpty(jarPath))
        {
            await _controlPlaneApi.SendInstallProgressAsync(_nodeId, _nodeToken, serverUuid, 100, "Failed to download server jar");
            return false;
        }

        await _controlPlaneApi.SendInstallProgressAsync(_nodeId, _nodeToken, serverUuid, 50, "Configuring server...");
        
        // Write server.properties
        var props = new Dictionary<string, string>
        {
            ["server-port"] = config.Port.ToString(),
            ["max-players"] = config.MaxPlayers.ToString(),
            ["motd"] = $"Manu Hosting - {config.Name}",
            ["online-mode"] = "true",
            ["enable-rcon"] = "true",
            ["rcon.port"] = (config.Port + 100).ToString(),
            ["rcon.password"] = Guid.NewGuid().ToString("N")[..16],
        };
        
        var propsContent = string.Join("\n", props.Select(kvp => $"{kvp.Key}={kvp.Value}"));
        await _fileManager.WriteFileAsync(serverUuid, "server.properties", propsContent);
        
        // Write eula.txt
        await _fileManager.WriteFileAsync(serverUuid, "eula.txt", "eula=true\n");

        await _controlPlaneApi.SendInstallProgressAsync(_nodeId, _nodeToken, serverUuid, 80, "Starting server for initial setup...");
        
        // Start server briefly to generate files
        var started = await _processManager.StartServerAsync(config);
        if (started)
        {
            await Task.Delay(10000); // Let it start
            await _processManager.StopServerAsync(serverUuid, 10);
        }

        await _controlPlaneApi.SendInstallProgressAsync(_nodeId, _nodeToken, serverUuid, 100, "Installation complete");
        return true;
    }

    private async Task<string?> DownloadServerJarAsync(ServerConfig config)
    {
        var serverDir = Path.Combine(_configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers", config.Uuid);
        var jarName = config.Software.ToLower() switch
        {
            "paper" => $"paper-{config.Version}.jar",
            "purpur" => $"purpur-{config.Version}.jar",
            "spigot" => $"spigot-{config.Version}.jar",
            "fabric" => $"fabric-server-{config.Version}.jar",
            "velocity" => $"velocity-{config.Version}.jar",
            "bungeecord" => $"BungeeCord-{config.Version}.jar",
            _ => "server.jar"
        };

        var jarPath = Path.Combine(serverDir, jarName);

        // In a real implementation, this would download from the official sources
        // For now, create a placeholder
        var urls = new Dictionary<string, string>
        {
            ["paper"] = $"https://api.papermc.io/v2/projects/paper/versions/{config.Version}/builds/latest/downloads/paper-{config.Version}-latest.jar",
            ["purpur"] = $"https://api.purpurmc.org/v2/purpur/{config.Version}/latest/download",
            ["velocity"] = $"https://api.papermc.io/v2/projects/velocity/versions/{config.Version}/builds/latest/downloads/velocity-{config.Version}-latest.jar"
        };

        if (urls.TryGetValue(config.Software.ToLower(), out var url))
        {
            try
            {
                using var httpClient = new HttpClient();
                httpClient.Timeout = TimeSpan.FromMinutes(5);
                var data = await httpClient.GetByteArrayAsync(url);
                await File.WriteAllBytesAsync(jarPath, data);
                return jarName;
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Failed to download server jar from {Url}", url);
            }
        }

        // For forge/neoforge/fabric, we'd need installer jars
        // This is a simplified implementation
        return null;
    }
}
