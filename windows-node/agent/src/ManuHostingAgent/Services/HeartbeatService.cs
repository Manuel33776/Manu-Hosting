using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Configuration;
using ManuHostingAgent.Models;
using ManuHostingAgent.Services;

namespace ManuHostingAgent.Services;

public class HeartbeatService : BackgroundService
{
    private readonly ILogger<HeartbeatService> _logger;
    private readonly IConfiguration _configuration;
    private readonly IControlPlaneApi _controlPlaneApi;
    private readonly IProcessManager _processManager;
    private readonly string _nodeId;
    private readonly string _nodeToken;
    private readonly int _heartbeatInterval;

    public HeartbeatService(
        ILogger<HeartbeatService> logger,
        IConfiguration configuration,
        IControlPlaneApi controlPlaneApi,
        IProcessManager processManager)
    {
        _logger = logger;
        _configuration = configuration;
        _controlPlaneApi = controlPlaneApi;
        _processManager = processManager;
        _nodeId = _configuration["ControlPlane:NodeId"] ?? "dl580-node-01";
        _nodeToken = _configuration["ControlPlane:NodeToken"] ?? "CHANGE_ME";
        _heartbeatInterval = _configuration.GetValue<int>("Agent:HeartbeatInterval", 30);
    }

    protected override async Task ExecuteAsync(CancellationToken stoppingToken)
    {
        _logger.LogInformation("Heartbeat service started (interval: {Interval}s)", _heartbeatInterval);

        // Initial delay
        await Task.Delay(10000, stoppingToken);

        while (!stoppingToken.IsCancellationRequested)
        {
            try
            {
                await SendHeartbeatAsync(stoppingToken);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error sending heartbeat");
            }

            await Task.Delay(TimeSpan.FromSeconds(_heartbeatInterval), stoppingToken);
        }

        _logger.LogInformation("Heartbeat service stopped");
    }

    private async Task SendHeartbeatAsync(CancellationToken stoppingToken)
    {
        var resources = await GetNodeResourcesAsync();
        var servers = await _processManager.GetAllServerStatusesAsync();

        var success = await _controlPlaneApi.SendHeartbeatAsync(_nodeId, _nodeToken, resources, servers);
        
        if (success)
        {
            _logger.LogDebug("Heartbeat sent successfully (servers: {Online}/{Total})", 
                servers.Count(s => s.Status == "online"), servers.Count);
        }
        else
        {
            _logger.LogWarning("Failed to send heartbeat");
        }
    }

    private async Task<NodeResources> GetNodeResourcesAsync()
    {
        var cpuCores = Environment.ProcessorCount;
        var cpuUsage = GetCpuUsage();
        var ramTotal = GC.GetGCMemoryInfo().TotalAvailableMemoryBytes;
        var ramUsed = GC.GetTotalMemory(false);
        
        // Get disk info
        var serversDir = _configuration["Agent:ServersDir"] ?? @"D:\ManuHosting\servers";
        var drive = new DriveInfo(Path.GetPathRoot(serversDir));
        var diskTotal = drive.TotalSize;
        var diskUsed = drive.TotalSize - drive.AvailableFreeSpace;

        return new NodeResources
        {
            CpuCores = cpuCores,
            CpuUsage = cpuUsage,
            RamTotal = ramTotal,
            RamUsed = ramUsed,
            DiskTotal = diskTotal,
            DiskUsed = diskUsed,
            NetworkRx = 0,
            NetworkTx = 0,
            ServersOnline = (await _processManager.GetAllServerStatusesAsync()).Count(s => s.Status == "online"),
            ServersTotal = (await _processManager.GetAllServerStatusesAsync()).Count
        };
    }

    private double GetCpuUsage()
    {
        try
        {
            using var cpuCounter = new PerformanceCounter("Processor", "% Processor Time", "_Total");
            cpuCounter.NextValue(); // First call returns 0
            await Task.Delay(100);
            return cpuCounter.NextValue();
        }
        catch
        {
            return 0;
        }
    }
}
