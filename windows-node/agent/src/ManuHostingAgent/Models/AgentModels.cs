namespace ManuHostingAgent.Models;

public class ServerConfig
{
    public string Uuid { get; set; } = string.Empty;
    public string Name { get; set; } = string.Empty;
    public string Version { get; set; } = "1.20.4";
    public string Software { get; set; } = "paper";
    public string JavaVersion { get; set; } = "21";
    public int Ram { get; set; } = 2048;
    public int Cpu { get; set; } = 2;
    public int Disk { get; set; } = 10240;
    public int Port { get; set; }
    public int MaxPlayers { get; set; } = 20;
    public bool IdleShutdownEnabled { get; set; } = true;
    public int IdleShutdownTimeout { get; set; } = 60;
    public Dictionary<string, string> EnvironmentVariables { get; set; } = new();
    public Dictionary<string, string> ServerProperties { get; set; } = new();
}

public class ServerStatus
{
    public string Uuid { get; set; } = string.Empty;
    public string Status { get; set; } = "offline"; // creating, installing, online, offline, starting, stopping, restarting, error, suspended, idle_shutdown
    public int PlayersOnline { get; set; }
    public int PlayersMax { get; set; }
    public int CpuUsage { get; set; }
    public int RamUsage { get; set; }
    public long DiskUsage { get; set; }
    public DateTime? StartedAt { get; set; }
    public DateTime? LastHeartbeat { get; set; }
    public string? ErrorMessage { get; set; }
}

public class CommandRequest
{
    public string Id { get; set; } = string.Empty;
    public string ServerUuid { get; set; } = string.Empty;
    public string Command { get; set; } = string.Empty; // start, stop, restart, backup, install, console
    public Dictionary<string, object> Parameters { get; set; } = new();
    public DateTime CreatedAt { get; set; }
}

public class CommandResult
{
    public string Id { get; set; } = string.Empty;
    public bool Success { get; set; }
    public string Output { get; set; } = string.Empty;
    public string Error { get; set; } = string.Empty;
    public DateTime CompletedAt { get; set; }
}

public class NodeResources
{
    public int CpuCores { get; set; }
    public double CpuUsage { get; set; }
    public long RamTotal { get; set; }
    public long RamUsed { get; set; }
    public long DiskTotal { get; set; }
    public long DiskUsed { get; set; }
    public long NetworkRx { get; set; }
    public long NetworkTx { get; set; }
    public int ServersOnline { get; set; }
    public int ServersTotal { get; set; }
}

public class BackupInfo
{
    public string Id { get; set; } = string.Empty;
    public string ServerUuid { get; set; } = string.Empty;
    public string Name { get; set; } = string.Empty;
    public string Path { get; set; } = string.Empty;
    public long Size { get; set; }
    public string Status { get; set; } = "pending"; // pending, running, completed, failed
    public DateTime CreatedAt { get; set; }
    public DateTime? CompletedAt { get; set; }
    public string? ErrorMessage { get; set; }
}

public class InstallRequest
{
    public string ServerUuid { get; set; } = string.Empty;
    public string Name { get; set; } = string.Empty;
    public string Version { get; set; } = "1.20.4";
    public string Software { get; set; } = "paper";
    public string JavaVersion { get; set; } = "21";
    public int Ram { get; set; } = 2048;
    public int Cpu { get; set; } = 2;
    public int Disk { get; set; } = 10240;
    public int Port { get; set; }
}
