using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Configuration;
using ManuHostingAgent.Models;
using ManuHostingAgent.Services;

namespace ManuHostingAgent.Services;

public class AgentWorker : BackgroundService
{
    private readonly ILogger<AgentWorker> _logger;
    private readonly IConfiguration _configuration;
    private readonly IControlPlaneApi _controlPlaneApi;
    private readonly IProcessManager _processManager;
    private readonly IIdleShutdownManager _idleShutdownManager;
    private readonly string _nodeId;
    private readonly string _nodeToken;
    private bool _registered = false;

    public AgentWorker(
        ILogger<AgentWorker> logger,
        IConfiguration configuration,
        IControlPlaneApi controlPlaneApi,
        IProcessManager processManager,
        IIdleShutdownManager idleShutdownManager)
    {
        _logger = logger;
        _configuration = configuration;
        _controlPlaneApi = controlPlaneApi;
        _processManager = processManager;
        _idleShutdownManager = idleShutdownManager;
        _nodeId = _configuration["ControlPlane:NodeId"] ?? "dl580-node-01";
        _nodeToken = _configuration["ControlPlane:NodeToken"] ?? "CHANGE_ME";
    }

    protected override async Task ExecuteAsync(CancellationToken stoppingToken)
    {
        _logger.LogInformation("Manu Hosting Agent starting on node {NodeId}", _nodeId);

        // Wait a bit for other services to start
        await Task.Delay(5000, stoppingToken);

        // Register with control plane
        await RegisterWithControlPlaneAsync(stoppingToken);

        // Main loop - keep the service alive
        while (!stoppingToken.IsCancellationRequested)
        {
            try
            {
                // Check if we need to re-register
                if (!_registered)
                {
                    await RegisterWithControlPlaneAsync(stoppingToken);
                }

                // Perform any periodic maintenance
                await PerformMaintenanceAsync(stoppingToken);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error in agent worker loop");
            }

            await Task.Delay(TimeSpan.FromMinutes(1), stoppingToken);
        }

        _logger.LogInformation("Manu Hosting Agent stopping");
    }

    private async Task RegisterWithControlPlaneAsync(CancellationToken stoppingToken)
    {
        try
        {
            // Get current resources
            var resources = await GetNodeResourcesAsync();
            
            var success = await _controlPlaneApi.RegisterNodeAsync(_nodeId, _nodeToken, resources);
            if (success)
            {
                _registered = true;
                _logger.LogInformation("Successfully registered with control plane");
            }
            else
            {
                _logger.LogWarning("Failed to register with control plane, will retry");
            }
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error registering with control plane");
        }
    }

    private async Task<NodeResources> GetNodeResourcesAsync()
    {
        var cpuCores = Environment.ProcessorCount;
        var cpuUsage = GetCpuUsage();
        var ramTotal = GC.GetGCMemoryInfo().TotalAvailableMemoryBytes;
        var ramUsed = GC.GetTotalMemory(false);
        
        // Get disk info
        var drive = new DriveInfo(Path.GetPathRoot(_configuration["Agent:ServersDir"] ?? @"D:\"));
        var diskTotal = drive.TotalSize;
        var diskUsed = drive.TotalSize - drive.AvailableFreeSpace;

        var servers = await _processManager.GetAllServerStatusesAsync();

        return new NodeResources
        {
            CpuCores = cpuCores,
            CpuUsage = cpuUsage,
            RamTotal = ramTotal,
            RamUsed = ramUsed,
            DiskTotal = diskTotal,
            DiskUsed = diskUsed,
            NetworkRx = 0, // Would need performance counters
            NetworkTx = 0,
            ServersOnline = servers.Count(s => s.Status == "online"),
            ServersTotal = servers.Count
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

    private async Task PerformMaintenanceAsync(CancellationToken stoppingToken)
    {
        // Clean up any zombie processes
        var statuses = await _processManager.GetAllServerStatusesAsync();
        foreach (var status in statuses)
        {
            if (status.Status == "error" && status.ErrorMessage?.Contains("exited") == true)
            {
                _logger.LogInformation("Cleaning up errored server {Uuid}", status.Uuid);
                // Could attempt restart here if configured
            }
        }
    }

    public override async Task StopAsync(CancellationToken cancellationToken)
    {
        _logger.LogInformation("Agent worker stopping, shutting down all servers...");
        
        var statuses = await _processManager.GetAllServerStatusesAsync();
        foreach (var status in statuses)
        {
            if (status.Status == "online")
            {
                await _processManager.StopServerAsync(status.Uuid, 10);
            }
        }

        await base.StopAsync(cancellationToken);
    }
}
