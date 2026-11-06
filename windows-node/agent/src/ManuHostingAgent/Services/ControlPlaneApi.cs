using System.Net.Http.Json;
using System.Text.Json;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using ManuHostingAgent.Models;
using Polly;

namespace ManuHostingAgent.Services;

public class ControlPlaneApi : IControlPlaneApi
{
    private readonly HttpClient _httpClient;
    private readonly IConfiguration _configuration;
    private readonly ILogger<ControlPlaneApi> _logger;
    private readonly string _nodeId;
    private readonly string _nodeToken;
    private readonly string _baseUrl;

    public ControlPlaneApi(HttpClient httpClient, IConfiguration configuration, ILogger<ControlPlaneApi> logger)
    {
        _httpClient = httpClient;
        _configuration = configuration;
        _logger = logger;
        _nodeId = _configuration["ControlPlane:NodeId"] ?? "dl580-node-01";
        _nodeToken = _configuration["ControlPlane:NodeToken"] ?? "CHANGE_ME";
        _baseUrl = $"{_configuration["ControlPlane:Url"]}:{_configuration["ControlPlane:ApiPort"]}/api/v1/nodes";
    }

    public async Task<bool> RegisterNodeAsync(string nodeId, string token, NodeResources resources)
    {
        try
        {
            var payload = new
            {
                node_id = nodeId,
                token = token,
                cpu_cores = resources.CpuCores,
                cpu_usage = resources.CpuUsage,
                ram_total = resources.RamTotal,
                ram_used = resources.RamUsed,
                disk_total = resources.DiskTotal,
                disk_used = resources.DiskUsed,
                network_rx = resources.NetworkRx,
                network_tx = resources.NetworkTx,
                servers_online = resources.ServersOnline,
                servers_total = resources.ServersTotal
            };

            var response = await _httpClient.PostAsJsonAsync($"{_baseUrl}/register", payload);
            return response.IsSuccessStatusCode;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to register node");
            return false;
        }
    }

    public async Task<bool> SendHeartbeatAsync(string nodeId, string token, NodeResources resources, List<ServerStatus> servers)
    {
        try
        {
            var payload = new
            {
                node_id = nodeId,
                token = token,
                cpu_cores = resources.CpuCores,
                cpu_usage = resources.CpuUsage,
                ram_total = resources.RamTotal,
                ram_used = resources.RamUsed,
                disk_total = resources.DiskTotal,
                disk_used = resources.DiskUsed,
                network_rx = resources.NetworkRx,
                network_tx = resources.NetworkTx,
                servers_online = resources.ServersOnline,
                servers_total = resources.ServersTotal,
                servers = servers.Select(s => new
                {
                    uuid = s.Uuid,
                    status = s.Status,
                    players_online = s.PlayersOnline,
                    players_max = s.PlayersMax,
                    cpu_usage = s.CpuUsage,
                    ram_usage = s.RamUsage,
                    disk_usage = s.DiskUsage,
                    started_at = s.StartedAt?.ToString("yyyy-MM-dd HH:mm:ss"),
                    error_message = s.ErrorMessage
                }).ToList()
            };

            var response = await _httpClient.PostAsJsonAsync($"{_baseUrl}/heartbeat", payload);
            return response.IsSuccessStatusCode;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to send heartbeat");
            return false;
        }
    }

    public async Task<List<CommandRequest>> PollCommandsAsync(string nodeId, string token)
    {
        try
        {
            var response = await _httpClient.GetAsync($"{_baseUrl}/{nodeId}/commands?token={token}");
            if (!response.IsSuccessStatusCode)
            {
                return new List<CommandRequest>();
            }

            var commands = await response.Content.ReadFromJsonAsync<List<CommandRequest>>();
            return commands ?? new List<CommandRequest>();
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to poll commands");
            return new List<CommandRequest>();
        }
    }

    public async Task<bool> SendCommandResultAsync(string nodeId, string token, CommandResult result)
    {
        try
        {
            var payload = new
            {
                command_id = result.Id,
                success = result.Success,
                output = result.Output,
                error = result.Error,
                completed_at = result.CompletedAt.ToString("yyyy-MM-dd HH:mm:ss")
            };

            var response = await _httpClient.PostAsJsonAsync($"{_baseUrl}/{nodeId}/commands/{result.Id}/result?token={token}", payload);
            return response.IsSuccessStatusCode;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to send command result");
            return false;
        }
    }

    public async Task<bool> SendServerStatusAsync(string nodeId, string token, ServerStatus status)
    {
        try
        {
            var payload = new
            {
                server_uuid = status.Uuid,
                status = status.Status,
                players_online = status.PlayersOnline,
                players_max = status.PlayersMax,
                cpu_usage = status.CpuUsage,
                ram_usage = status.RamUsage,
                disk_usage = status.DiskUsage,
                started_at = status.StartedAt?.ToString("yyyy-MM-dd HH:mm:ss"),
                error_message = status.ErrorMessage
            };

            var response = await _httpClient.PostAsJsonAsync($"{_baseUrl}/{nodeId}/servers/status?token={token}", payload);
            return response.IsSuccessStatusCode;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to send server status");
            return false;
        }
    }

    public async Task<bool> SendInstallProgressAsync(string nodeId, string token, string serverUuid, int progress, string message)
    {
        try
        {
            var payload = new
            {
                server_uuid = serverUuid,
                progress = progress,
                message = message
            };

            var response = await _httpClient.PostAsJsonAsync($"{_baseUrl}/{nodeId}/servers/{serverUuid}/install-progress?token={token}", payload);
            return response.IsSuccessStatusCode;
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Failed to send install progress");
            return false;
        }
    }

    public async Task<bool> TestConnectionAsync()
    {
        try
        {
            var response = await _httpClient.GetAsync($"{_baseUrl}/test");
            return response.IsSuccessStatusCode;
        }
        catch
        {
            return false;
        }
    }
}
