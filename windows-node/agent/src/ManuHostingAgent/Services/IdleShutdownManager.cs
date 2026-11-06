using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using ManuHostingAgent.Models;
using System.Collections.Concurrent;

namespace ManuHostingAgent.Services;

public class IdleShutdownManager : IIdleShutdownManager
{
    private readonly IConfiguration _configuration;
    private readonly ILogger<IdleShutdownManager> _logger;
    private readonly IProcessManager _processManager;
    private readonly ConcurrentDictionary<string, IdleShutdownState> _monitoredServers = new();
    private readonly Timer _checkTimer;

    public event EventHandler<IdleShutdownEventArgs>? OnIdleShutdown;

    public IdleShutdownManager(
        IConfiguration configuration,
        ILogger<IdleShutdownManager> logger,
        IProcessManager processManager)
    {
        _configuration = configuration;
        _logger = logger;
        _processManager = processManager;

        // Check every 10 seconds
        _checkTimer = new Timer(CheckIdleServers, null, TimeSpan.FromSeconds(10), TimeSpan.FromSeconds(10));
    }

    public Task StartMonitoringAsync(string serverUuid, int timeoutSeconds)
    {
        var state = new IdleShutdownState
        {
            ServerUuid = serverUuid,
            TimeoutSeconds = timeoutSeconds,
            LastPlayerJoin = DateTime.UtcNow,
            IsEnabled = true
        };

        _monitoredServers.AddOrUpdate(serverUuid, state, (key, old) =>
        {
            old.TimeoutSeconds = timeoutSeconds;
            old.IsEnabled = true;
            return old;
        });

        _logger.LogInformation("Started idle shutdown monitoring for server {ServerUuid} with timeout {Timeout}s", 
            serverUuid, timeoutSeconds);

        return Task.CompletedTask;
    }

    public Task StopMonitoringAsync(string serverUuid)
    {
        if (_monitoredServers.TryRemove(serverUuid, out var state))
        {
            _logger.LogInformation("Stopped idle shutdown monitoring for server {ServerUuid}", serverUuid);
        }
        return Task.CompletedTask;
    }

    public Task<bool> IsMonitoringAsync(string serverUuid)
    {
        return Task.FromResult(_monitoredServers.ContainsKey(serverUuid));
    }

    public Task<int> GetRemainingTimeAsync(string serverUuid)
    {
        if (_monitoredServers.TryGetValue(serverUuid, out var state))
        {
            var elapsed = (int)(DateTime.UtcNow - state.LastPlayerJoin).TotalSeconds;
            var remaining = Math.Max(0, state.TimeoutSeconds - elapsed);
            return Task.FromResult(remaining);
        }
        return Task.FromResult(0);
    }

    public void RecordPlayerJoin(string serverUuid)
    {
        if (_monitoredServers.TryGetValue(serverUuid, out var state))
        {
            state.LastPlayerJoin = DateTime.UtcNow;
            state.PlayersOnline++;
            _logger.LogDebug("Player joined server {ServerUuid}, players online: {Count}", serverUuid, state.PlayersOnline);
        }
    }

    public void RecordPlayerLeave(string serverUuid)
    {
        if (_monitoredServers.TryGetValue(serverUuid, out var state))
        {
            state.PlayersOnline = Math.Max(0, state.PlayersOnline - 1);
            if (state.PlayersOnline == 0)
            {
                state.LastPlayerJoin = DateTime.UtcNow; // Start idle timer
                _logger.LogDebug("Last player left server {ServerUuid}, idle timer started", serverUuid);
            }
        }
    }

    public void SetPlayerCount(string serverUuid, int count)
    {
        if (_monitoredServers.TryGetValue(serverUuid, out var state))
        {
            var wasEmpty = state.PlayersOnline == 0;
            state.PlayersOnline = count;
            
            if (wasEmpty && count > 0)
            {
                state.LastPlayerJoin = DateTime.UtcNow; // Reset timer on first player join
                _logger.LogDebug("Player joined empty server {ServerUuid}, idle timer reset", serverUuid);
            }
            else if (!wasEmpty && count == 0)
            {
                state.LastPlayerJoin = DateTime.UtcNow; // Start idle timer
                _logger.LogDebug("Server {ServerUuid} became empty, idle timer started", serverUuid);
            }
        }
    }

    private void CheckIdleServers(object? state)
    {
        foreach (var kvp in _monitoredServers)
        {
            var serverUuid = kvp.Key;
            var idleState = kvp.Value;

            if (!idleState.IsEnabled || idleState.TimeoutSeconds <= 0)
                continue;

            if (idleState.PlayersOnline > 0)
                continue;

            var elapsed = (int)(DateTime.UtcNow - idleState.LastPlayerJoin).TotalSeconds;
            if (elapsed >= idleState.TimeoutSeconds)
            {
                _logger.LogInformation("Server {ServerUuid} idle for {Elapsed}s (timeout: {Timeout}s), initiating shutdown", 
                    serverUuid, elapsed, idleState.TimeoutSeconds);

                // Trigger shutdown
                _ = Task.Run(async () =>
                {
                    try
                    {
                        await _processManager.StopServerAsync(serverUuid);
                        OnIdleShutdown?.Invoke(this, new IdleShutdownEventArgs 
                        { 
                            ServerUuid = serverUuid, 
                            Reason = $"Idle for {elapsed} seconds (timeout: {idleState.TimeoutSeconds}s)" 
                        });
                    }
                    catch (Exception ex)
                    {
                        _logger.LogError(ex, "Error during idle shutdown for {ServerUuid}", serverUuid);
                    }
                });

                // Remove from monitoring after triggering shutdown
                _monitoredServers.TryRemove(serverUuid, out _);
            }
        }
    }

    public void Dispose()
    {
        _checkTimer?.Dispose();
    }
}

internal class IdleShutdownState
{
    public string ServerUuid { get; set; } = string.Empty;
    public int TimeoutSeconds { get; set; } = 60;
    public int PlayersOnline { get; set; } = 0;
    public DateTime LastPlayerJoin { get; set; } = DateTime.UtcNow;
    public bool IsEnabled { get; set; } = true;
}
