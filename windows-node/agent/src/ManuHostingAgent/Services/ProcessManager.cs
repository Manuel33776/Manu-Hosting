using System.Diagnostics;
using System.Text.Json;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using ManuHostingAgent.Models;
using ManuHostingAgent.Services;

namespace ManuHostingAgent.Services;

public class ProcessManager : IProcessManager
{
    private readonly IConfiguration _configuration;
    private readonly ILogger<ProcessManager> _logger;
    private readonly IFileManager _fileManager;
    private readonly string _serversDir;
    private readonly string _javaPath;
    private readonly int _shutdownTimeout;
    private readonly int _forceKillAfter;
    private readonly List<string> _jvmArgs;
    private readonly Dictionary<string, Process> _processes = new();
    private readonly Dictionary<string, ServerConfig> _serverConfigs = new();
    private readonly object _lock = new();

    public ProcessManager(
        IConfiguration configuration,
        ILogger<ProcessManager> logger,
        IFileManager fileManager)
    {
        _configuration = configuration;
        _logger = logger;
        _fileManager = fileManager;
        _serversDir = _configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers";
        _javaPath = _configuration["Agent:JavaPath"] ?? "java";
        _shutdownTimeout = _configuration.GetValue<int>("Process:ShutdownTimeout", 30);
        _forceKillAfter = _configuration.GetValue<int>("Process:ForceKillAfter", 10);
        _jvmArgs = _configuration.GetSection("Process:JvmArgs").Get<List<string>>() ?? new List<string>();
    }

    public async Task<bool> StartServerAsync(ServerConfig config)
    {
        lock (_lock)
        {
            if (_processes.ContainsKey(config.Uuid) && _processes[config.Uuid]?.HasExited == false)
            {
                _logger.LogWarning("Server {Uuid} is already running", config.Uuid);
                return false;
            }
        }

        try
        {
            _logger.LogInformation("Starting server {Name} ({Uuid})", config.Name, config.Uuid);

            // Ensure server directory exists
            await _fileManager.CreateServerDirectoryAsync(config.Uuid);

            // Write server.properties
            await WriteServerPropertiesAsync(config);

            // Write eula.txt
            await _fileManager.WriteFileAsync(config.Uuid, "eula.txt", "eula=true\n");

            // Prepare startup script
            var startScript = GenerateStartScript(config);
            await _fileManager.WriteFileAsync(config.Uuid, "start.bat", startScript);

            // Prepare JVM arguments
            var jvmArgs = PrepareJvmArgs(config);

            // Find server jar
            var serverJar = await FindServerJarAsync(config.Uuid, config.Software, config.Version);
            if (string.IsNullOrEmpty(serverJar))
            {
                _logger.LogError("Server jar not found for {Uuid}", config.Uuid);
                return false;
            }

            // Create process start info
            var startInfo = new ProcessStartInfo
            {
                FileName = _javaPath,
                Arguments = string.Join(" ", jvmArgs) + $" -jar {serverJar} nogui",
                WorkingDirectory = Path.Combine(_serversDir, config.Uuid),
                UseShellExecute = false,
                RedirectStandardInput = true,
                RedirectStandardOutput = true,
                RedirectStandardError = true,
                CreateNoWindow = true,
                StandardOutputEncoding = System.Text.Encoding.UTF8,
                StandardErrorEncoding = System.Text.Encoding.UTF8
            };

            // Add environment variables
            foreach (var env in config.EnvironmentVariables)
            {
                startInfo.EnvironmentVariables[env.Key] = env.Value;
            }

            var process = new Process { StartInfo = startInfo };
            
            process.OutputDataReceived += (sender, e) =>
            {
                if (!string.IsNullOrEmpty(e.Data))
                {
                    _logger.LogDebug("[{Uuid}] {Output}", config.Uuid, e.Data);
                }
            };

            process.ErrorDataReceived += (sender, e) =>
            {
                if (!string.IsNullOrEmpty(e.Data))
                {
                    _logger.LogDebug("[{Uuid}] ERR: {Error}", config.Uuid, e.Data);
                }
            };

            process.EnableRaisingEvents = true;
            process.Exited += (sender, e) =>
            {
                _logger.LogInformation("Server {Uuid} exited with code {ExitCode}", config.Uuid, process.ExitCode);
                lock (_lock)
                {
                    _processes.Remove(config.Uuid);
                }
            };

            var started = process.Start();
            if (!started)
            {
                _logger.LogError("Failed to start process for {Uuid}", config.Uuid);
                return false;
            }

            process.BeginOutputReadLine();
            process.BeginErrorReadLine();

            lock (_lock)
            {
                _processes[config.Uuid] = process;
                _serverConfigs[config.Uuid] = config;
            }

            _logger.LogInformation("Server {Uuid} started with PID {Pid}", config.Uuid, process.Id);
            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error starting server {Uuid}", config.Uuid);
            return false;
        }
    }

    public async Task<bool> StopServerAsync(string serverUuid, int timeoutSeconds = 30)
    {
        Process? process;
        lock (_lock)
        {
            if (!_processes.TryGetValue(serverUuid, out process) || process.HasExited)
            {
                _logger.LogWarning("Server {Uuid} is not running", serverUuid);
                return true; // Already stopped
            }
        }

        try
        {
            _logger.LogInformation("Stopping server {Uuid} gracefully", serverUuid);

            // Send stop command via stdin
            if (process.StandardInput.BaseStream.CanWrite)
            {
                await process.StandardInput.WriteLineAsync("stop");
                await process.StandardInput.FlushAsync();
            }

            // Wait for graceful shutdown
            var exited = process.WaitForExit(timeoutSeconds * 1000);
            if (exited)
            {
                _logger.LogInformation("Server {Uuid} stopped gracefully", serverUuid);
                lock (_lock)
                {
                    _processes.Remove(serverUuid);
                }
                return true;
            }

            // Force kill if still running
            _logger.LogWarning("Server {Uuid} did not stop gracefully, forcing kill", serverUuid);
            try
            {
                process.Kill(true); // Kill entire process tree
                process.WaitForExit(_forceKillAfter * 1000);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error force killing server {Uuid}", serverUuid);
            }

            lock (_lock)
            {
                _processes.Remove(serverUuid);
            }

            return true;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error stopping server {Uuid}", serverUuid);
            return false;
        }
    }

    public async Task<bool> RestartServerAsync(string serverUuid)
    {
        ServerConfig? config;
        lock (_lock)
        {
            if (!_serverConfigs.TryGetValue(serverUuid, out config))
            {
                _logger.LogError("Server config not found for {Uuid}", serverUuid);
                return false;
            }
        }

        await StopServerAsync(serverUuid);
        await Task.Delay(2000); // Brief pause
        return await StartServerAsync(config);
    }

    public async Task<bool> SendConsoleCommandAsync(string serverUuid, string command)
    {
        Process? process;
        lock (_lock)
        {
            if (!_processes.TryGetValue(serverUuid, out process) || process.HasExited)
            {
                return false;
            }
        }

        try
        {
            if (process.StandardInput.BaseStream.CanWrite)
            {
                await process.StandardInput.WriteLineAsync(command);
                await process.StandardInput.FlushAsync();
                return true;
            }
            return false;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error sending console command to {Uuid}", serverUuid);
            return false;
        }
    }

    public async Task<ServerStatus?> GetServerStatusAsync(string serverUuid)
    {
        Process? process;
        lock (_lock)
        {
            _processes.TryGetValue(serverUuid, out process);
        }

        if (process == null)
        {
            return new ServerStatus
            {
                Uuid = serverUuid,
                Status = "offline",
                PlayersOnline = 0,
                PlayersMax = 20
            };
        }

        if (process.HasExited)
        {
            lock (_lock)
            {
                _processes.Remove(serverUuid);
            }
            return new ServerStatus
            {
                Uuid = serverUuid,
                Status = "error",
                PlayersOnline = 0,
                PlayersMax = 20,
                ErrorMessage = $"Process exited with code {process.ExitCode}"
            };
        }

        // Try to get resource usage
        long workingSet = 0;
        double cpuUsage = 0;
        try
        {
            workingSet = process.WorkingSet64;
            cpuUsage = process.TotalProcessorTime.TotalMilliseconds;
        }
        catch { }

        return new ServerStatus
        {
            Uuid = serverUuid,
            Status = "online",
            PlayersOnline = 0, // Would need RCON or plugin to get actual count
            PlayersMax = _serverConfigs.TryGetValue(serverUuid, out var cfg) ? cfg.MaxPlayers : 20,
            CpuUsage = (int)Math.Min(100, cpuUsage),
            RamUsage = (int)(workingSet / 1024 / 1024), // MB
            StartedAt = process.StartTime
        };
    }

    public async Task<List<ServerStatus>> GetAllServerStatusesAsync()
    {
        var statuses = new List<ServerStatus>();
        string[] uuids;
        lock (_lock)
        {
            uuids = _processes.Keys.ToArray();
        }

        foreach (var uuid in uuids)
        {
            var status = await GetServerStatusAsync(uuid);
            if (status != null)
            {
                statuses.Add(status);
            }
        }

        return statuses;
    }

    public async Task<bool> IsServerRunningAsync(string serverUuid)
    {
        Process? process;
        lock (_lock)
        {
            _processes.TryGetValue(serverUuid, out process);
        }
        return process != null && !process.HasExited;
    }

    public async Task<int?> GetServerPidAsync(string serverUuid)
    {
        Process? process;
        lock (_lock)
        {
            _processes.TryGetValue(serverUuid, out process);
        }
        return process?.HasExited == false ? process.Id : null;
    }

    private async Task WriteServerPropertiesAsync(ServerConfig config)
    {
        var props = new Dictionary<string, string>
        {
            ["server-port"] = config.Port.ToString(),
            ["max-players"] = config.MaxPlayers.ToString(),
            ["motd"] = $"Manu Hosting - {config.Name}",
            ["online-mode"] = "true",
            ["enable-command-block"] = "false",
            ["spawn-protection"] = "16",
            ["view-distance"] = "10",
            ["simulation-distance"] = "10",
            ["hardcore"] = "false",
            ["pvp"] = "true",
            ["difficulty"] = "normal",
            ["gamemode"] = "survival",
            ["level-name"] = "world",
            ["level-seed"] = "",
            ["generator-settings"] = "",
            ["level-type"] = "minecraft:normal",
            ["enable-rcon"] = "true",
            ["rcon.port"] = (config.Port + 100).ToString(),
            ["rcon.password"] = GenerateRconPassword(),
            ["enable-query"] = "false",
            ["query.port"] = config.Port.ToString(),
        };

        // Merge custom properties
        foreach (var kvp in config.ServerProperties)
        {
            props[kvp.Key] = kvp.Value;
        }

        var content = string.Join("\n", props.Select(kvp => $"{kvp.Key}={kvp.Value}"));
        await _fileManager.WriteFileAsync(config.Uuid, "server.properties", content);
    }

    private string GenerateStartScript(ServerConfig config)
    {
        var script = "@echo off\n";
        script += "title " + config.Name + "\n";
        script += "cd /d \"%~dp0\"\n";
        script += "\n";
        script += ":restart\n";
        script += $"\"{_javaPath}\" ";
        script += string.Join(" ", PrepareJvmArgs(config)) + " ";
        script += "-jar server.jar nogui\n";
        script += "\n";
        script += "echo Server stopped. Restarting in 5 seconds...\n";
        script += "timeout /t 5 >nul\n";
        script += "goto restart\n";
        return script;
    }

    private List<string> PrepareJvmArgs(ServerConfig config)
    {
        var args = new List<string>(_jvmArgs);
        
        // Replace placeholders
        for (int i = 0; i < args.Count; i++)
        {
            args[i] = args[i]
                .Replace("{ram}", config.Ram.ToString())
                .Replace("{cpu}", config.Cpu.ToString());
        }

        // Add server-specific args
        args.Add($"-Dserver.uuid={config.Uuid}");
        args.Add($"-Dserver.name={config.Name}");

        return args;
    }

    private async Task<string?> FindServerJarAsync(string serverUuid, string software, string version)
    {
        var serverDir = Path.Combine(_serversDir, serverUuid);
        var jarName = software.ToLower() switch
        {
            "paper" => $"paper-{version}.jar",
            "purpur" => $"purpur-{version}.jar",
            "spigot" => $"spigot-{version}.jar",
            "fabric" => $"fabric-server-{version}.jar",
            "forge" => $"forge-{version}-installer.jar",
            "neoforge" => $"neoforge-{version}-installer.jar",
            "velocity" => $"velocity-{version}.jar",
            "bungeecord" => $"BungeeCord-{version}.jar",
            _ => "server.jar"
        };

        var fullPath = Path.Combine(serverDir, jarName);
        if (File.Exists(fullPath))
        {
            return jarName;
        }

        // Try to find any jar file
        var jars = Directory.GetFiles(serverDir, "*.jar", SearchOption.TopDirectoryOnly);
        if (jars.Length > 0)
        {
            return Path.GetFileName(jars[0]);
        }

        return null;
    }

    private string GenerateRconPassword()
    {
        return Guid.NewGuid().ToString("N")[..16];
    }
}
