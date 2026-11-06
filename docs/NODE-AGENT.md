# MANU HOSTING - WINDOWS NODE AGENT

Technical documentation for the .NET 8 Windows Node Agent.

---

## Overview

The Windows Node Agent is a .NET 8 Worker Service that runs on the HP ProLiant DL580 and manages Minecraft server processes. It communicates with the Debian control plane via HTTPS REST API.

### Key Responsibilities

1. **Process Management** - Start, stop, restart Minecraft servers
2. **File Management** - Read, write, upload, download, zip/unzip server files
3. **Backup Management** - Create, restore, delete, schedule backups
4. **Idle Shutdown** - Auto-stop servers after configurable timeout when empty
5. **Heartbeat** - Report system and server metrics every 30s
6. **Command Polling** - Execute commands from control plane every 5s
7. **Node Registration** - Register and maintain connection to control plane

---

## Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    WINDOWS NODE AGENT (.NET 8)                  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │                    HOSTED SERVICES                         │  │
│  │  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐          │  │
│  │  │ AgentWorker │ │ HeartbeatSvc│ │CommandPollSvc│          │  │
│  │  │ Registration│ │ 30s interval│ │ 5s interval │          │  │
│  │  └──────┬──────┘ └──────┬──────┘ └──────┬──────┘          │  │
│  └─────────┼───────────────┼───────────────┼──────────────────┘  │
│            │               │               │                      │
│  ┌─────────┴───────────────┴───────────────┴────────────────┐   │
│  │                      SERVICES (DI)                         │   │
│  │  ┌────────────┐ ┌────────────┐ ┌────────────┐ ┌────────┐  │   │
│  │  │ProcessMgr  │ │ FileMgr    │ │ BackupMgr  │ │IdleSht │  │   │
│  │  └────────────┘ └────────────┘ └────────────┘ └────────┘  │   │
│  └────────────────────────────────────────────────────────────┘   │
│            │               │               │               │        │
│  ┌─────────┴───────────────┴───────────────┴───────────────┐    │
│  │              CONTROL PLANE API (HTTP + Polly)             │    │
│  │  Register, Heartbeat, Poll Commands, Send Results, etc.   │    │
│  └────────────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────┘
```

---

## Project Structure

```
ManuHostingAgent/
├── Program.cs                    # Entry point, DI configuration
├── ManuHostingAgent.csproj       # Project file
├── config.yaml                   # YAML configuration (runtime)
├── appsettings.json              # .NET configuration
├── Models/
│   └── AgentModels.cs            # DTOs: ServerConfig, ServerStatus, CommandRequest, etc.
├── Services/
│   ├── Interfaces.cs             # Service contracts
│   ├── ControlPlaneApi.cs        # HTTP client to Debian
│   ├── ProcessManager.cs         # Minecraft process lifecycle
│   ├── FileManager.cs            # File operations
│   ├── BackupManager.cs          # Backup operations
│   ├── IdleShutdownManager.cs    # Auto-shutdown logic
│   ├── AgentWorker.cs            # Registration, maintenance
│   ├── HeartbeatService.cs       # 30s metrics reporting
│   └── CommandPollingService.cs  # 5s command execution
└── bin/Release/net8.0/win-x64/publish/
    ├── ManuHostingAgent.exe      # Single-file executable
    ├── config.yaml
    └── appsettings.json
```

---

## Configuration

### config.yaml

Primary configuration file (YAML, supports environment variable override):

```yaml
control_plane:
  url: "https://your-domain.de"
  api_port: 8443
  node_id: "dl580-node-01"
  node_token: "SECURE_TOKEN"
  verify_ssl: true

agent:
  install_dir: "D:\ManuHosting"
  servers_dir: "D:\ManuHosting\servers"
  backups_dir: "D:\ManuHosting\backups"
  temp_dir: "D:\ManuHosting\temp"
  log_dir: "D:\ManuHosting\logs"
  java_path: "java"
  heartbeat_interval: 30
  command_poll_interval: 5
  resource_report_interval: 60
  idle_shutdown_default: 60
  max_idle_shutdown: 900

minecraft:
  default_java_version: "21"
  default_ram: 2048
  default_cpu: 2
  default_disk: 10240
  max_players: 20
  java_versions: ["21", "17", "11", "8"]

process:
  shutdown_timeout: 30
  force_kill_after: 10
  jvm_args: [...]

backup:
  compression: "zip"
  max_backups_per_server: 10
  exclude_patterns: ["*.log", "*.tmp", "cache/*", "plugins/dynmap/*"]

network:
  port_range_start: 25565
  port_range_end: 25665
  bind_address: "0.0.0.0"

security:
  allowed_ips: []
  mutual_tls: false
```

### appsettings.json

.NET standard configuration:

```json
{
  "Logging": {
    "LogLevel": {
      "Default": "Information",
      "Microsoft": "Warning",
      "ManuHostingAgent": "Debug"
    }
  },
  "ControlPlane": { ... },
  "Agent": { ... },
  "Minecraft": { ... },
  "Process": { ... },
  "Backup": { ... },
  "Network": { ... },
  "Security": { ... }
}
```

### Environment Variable Override

Any config value can be overridden via environment variables using double underscore:

```powershell
# Example: Override node token
$env:CONTROL_PLANE__NODE_TOKEN = "new-token"

# Example: Override servers directory
$env:AGENT__SERVERS_DIR = "E:\MinecraftServers"
```

---

## Services Detail

### 1. ControlPlaneApi

HTTP client for communicating with Debian control plane.

**Endpoints:**
- `POST /api/v1/nodes/register` - Register node
- `POST /api/v1/nodes/{id}/heartbeat` - Send heartbeat
- `GET /api/v1/nodes/{id}/commands?token=...` - Poll commands
- `POST /api/v1/nodes/{id}/commands/{cmdId}/result?token=...` - Send result
- `POST /api/v1/nodes/{id}/servers/status?token=...` - Server status
- `POST /api/v1/nodes/{id}/servers/{uuid}/install-progress?token=...` - Install progress

**Resilience:** Polly retry policy (3 retries, 2s delay) for transient failures.

### 2. ProcessManager

Manages Minecraft server processes.

**Methods:**
- `StartServerAsync(ServerConfig)` - Start server process
- `StopServerAsync(serverUuid, timeout)` - Graceful stop with force kill fallback
- `RestartServerAsync(serverUuid)` - Stop + start
- `SendConsoleCommandAsync(serverUuid, command)` - Send to stdin
- `GetServerStatusAsync(serverUuid)` - Get current status
- `GetAllServerStatusesAsync()` - All servers
- `IsServerRunningAsync(serverUuid)` - Boolean check
- `GetServerPidAsync(serverUuid)` - Process ID

**Process Creation:**
- Working directory: `{servers_dir}/{uuid}/`
- JVM args from config (Aikar flags + placeholders)
- Redirected stdin/stdout/stderr
- `eula.txt` auto-written
- `server.properties` generated from config

**Graceful Shutdown:**
1. Send `stop` command via stdin
2. Wait `shutdown_timeout` (default 30s)
3. Force kill process tree if still running
4. Wait `force_kill_after` (default 10s)

### 3. FileManager

File operations with path traversal protection.

**Methods:**
- `CreateServerDirectoryAsync(serverUuid)`
- `DeleteServerDirectoryAsync(serverUuid)`
- `WriteFileAsync(serverUuid, relativePath, content)`
- `ReadFileAsync(serverUuid, relativePath)`
- `DeleteFileAsync(serverUuid, relativePath)`
- `ListFilesAsync(serverUuid, directory)`
- `UploadFileAsync(serverUuid, relativePath, stream)`
- `DownloadFileAsync(serverUuid, relativePath)` → stream
- `CreateDirectoryAsync(serverUuid, relativePath)`
- `DirectoryExistsAsync(serverUuid, relativePath)`
- `FileExistsAsync(serverUuid, relativePath)`
- `GetDirectorySizeAsync(serverUuid, relativePath)`
- `ZipDirectoryAsync(serverUuid, sourcePath, destPath)`
- `UnzipFileAsync(serverUuid, zipPath, destPath)`

**Security:**
- Path normalization and validation
- Blocks `..`, `~`, `$` in paths
- Ensures resolved path stays within server directory
- Throws `UnauthorizedAccessException` on traversal attempt

### 4. BackupManager

ZIP-based backup with exclusion patterns.

**Methods:**
- `CreateBackupAsync(serverUuid, name?)` → BackupInfo
- `RestoreBackupAsync(serverUuid, backupId)` → bool
- `DeleteBackupAsync(serverUuid, backupId)` → bool
- `ListBackupsAsync(serverUuid)` → List<BackupInfo>
- `GetBackupAsync(serverUuid, backupId)` → BackupInfo?
- `ScheduleBackupAsync(serverUuid, cron, name?)` → bool
- `CancelScheduledBackupAsync(serverUuid, backupId)` → bool

**Backup Process:**
1. Stop server if running (optional, configurable)
2. Create ZIP using SharpCompress
3. Apply exclusion patterns (regex-based)
4. Save to `{backups_dir}/{serverUuid}/backup_{timestamp}_{id}.zip`
5. Auto-cleanup old backups (keep `max_backups_per_server`)

**Exclusion Patterns (default):**
- `*.log`, `*.tmp`
- `cache/*`, `plugins/dynmap/*`
- `logs/*`, `crash-reports/*`

### 5. IdleShutdownManager

Automatic server shutdown when no players online.

**Configuration:**
- Default timeout: 60 seconds (configurable per server/package)
- Max timeout: 900 seconds (15 minutes)
- Disabled if timeout = 0

**Logic:**
1. Track player count per server (via Bridge events)
2. When count goes 0 → start timer
3. If player joins before timeout → cancel timer
4. If timeout reached → call `ProcessManager.StopServerAsync()`
5. Emit `OnIdleShutdown` event with reason

**Thread Safety:** Uses `ConcurrentDictionary` and `Timer` (10s check interval).

**Methods:**
- `StartMonitoringAsync(serverUuid, timeoutSeconds)`
- `StopMonitoringAsync(serverUuid)`
- `IsMonitoringAsync(serverUuid)` → bool
- `GetRemainingTimeAsync(serverUuid)` → seconds
- `RecordPlayerJoin(serverUuid)` / `RecordPlayerLeave(serverUuid)`
- `SetPlayerCount(serverUuid, count)`

### 6. AgentWorker

Background service for node lifecycle.

**Responsibilities:**
- Register node with control plane on startup
- Periodic maintenance (cleanup errored servers)
- Graceful shutdown of all servers on service stop

**Registration Data:**
- Node ID, token
- CPU cores, CPU usage %
- RAM total/used
- Disk total/used
- Server counts

### 7. HeartbeatService

Runs every 30 seconds (configurable).

**Collects:**
- System: CPU cores, usage %, RAM total/used, Disk total/used
- Per-server: status, players online/max, CPU%, RAM MB, disk bytes
- Network: RX/TX bytes (if available)

**Sends to:** `POST /api/v1/nodes/{id}/heartbeat`

### 8. CommandPollingService

Runs every 5 seconds (configurable).

**Polls:** `GET /api/v1/nodes/{id}/commands?token=...`

**Executes Commands:**
| Command | Action |
|---------|--------|
| `start` | StartServerAsync |
| `stop` | StopServerAsync |
| `restart` | RestartServerAsync |
| `console` | SendConsoleCommandAsync |
| `backup` | BackupManager.CreateBackupAsync |
| `install` | Download JAR, configure, start briefly |
| `update_idle_shutdown` | Enable/disable idle shutdown |
| `get_status` | GetServerStatusAsync |

**Result Reporting:** `POST /api/v1/nodes/{id}/commands/{cmdId}/result`

---

## Data Models

### ServerConfig
```csharp
string Uuid, Name, Version, Software, JavaVersion
int Ram, Cpu, Disk, Port, MaxPlayers
bool IdleShutdownEnabled, IdleShutdownTimeout
Dictionary<string,string> EnvironmentVariables
Dictionary<string,string> ServerProperties
```

### ServerStatus
```csharp
string Uuid, Status  // creating, installing, online, offline, starting, stopping, restarting, error, suspended, idle_shutdown
int PlayersOnline, PlayersMax, CpuUsage, RamUsage
long DiskUsage
DateTime? StartedAt, LastHeartbeat
string? ErrorMessage
```

### CommandRequest
```csharp
string Id, ServerUuid, Command
Dictionary<string,object> Parameters
DateTime CreatedAt
```

### CommandResult
```csharp
string Id
bool Success
string Output, Error
DateTime CompletedAt
```

### NodeResources
```csharp
int CpuCores, CpuUsage
long RamTotal, RamUsed, DiskTotal, DiskUsed, NetworkRx, NetworkTx
int ServersOnline, ServersTotal
```

### BackupInfo
```csharp
string Id, ServerUuid, Name, Path
long Size
string Status  // pending, running, completed, failed
DateTime CreatedAt, CompletedAt?
string? ErrorMessage
```

---

## Building

### Prerequisites
- .NET 8 SDK
- Windows 10/11 or Windows Server 2019/2022

### Build Command

```powershell
cd windows-node/agent/src/ManuHostingAgent
dotnet publish -c Release -r win-x64 --self-contained true -p:PublishSingleFile=true -o ../../../../publish
```

### Output

Single-file executable: `ManuHostingAgent.exe` (~60-80 MB)
- Self-contained (no .NET runtime required on target)
- Includes all dependencies
- Native Windows x64

---

## Windows Service

### Installation (via install.ps1)

```powershell
sc.exe create ManuHostingAgent binPath= "D:\ManuHosting\agent\ManuHostingAgent.exe --service" DisplayName= "Manu Hosting Node Agent" start= auto obj= "NT SERVICE\ManuHostingAgent"
sc.exe description ManuHostingAgent "Manages Minecraft servers on this node and communicates with the Manu Hosting control plane"
sc.exe failure ManuHostingAgent reset= 86400 actions= restart/60000/restart/120000/restart/300000
```

### Service Properties

| Property | Value |
|----------|-------|
| Name | ManuHostingAgent |
| Display Name | Manu Hosting Node Agent |
| Startup Type | Automatic (Delayed) |
| Account | NT SERVICE\ManuHostingAgent (Virtual) |
| Recovery | Restart: 1min, 2min, 5min |
| Working Directory | D:\ManuHosting\agent |

### Management

```powershell
# Start
Start-Service ManuHostingAgent

# Stop
Stop-Service ManuHostingAgent

# Restart
Restart-Service ManuHostingAgent

# Status
Get-Service ManuHostingAgent

# Logs
Get-WinEvent -LogName Application -ProviderName "ManuHostingAgent" -MaxEvents 50
```

---

## Logging

### Output
- **Console** (when run manually): Structured JSON logs
- **Event Log** (as Windows Service): Windows Application log
- **File** (configured): `D:\ManuHosting\logs\manu-hosting-agent-.log`

### Log Levels
- **Debug**: Detailed diagnostics (JVM args, file ops)
- **Information**: General flow (start/stop, heartbeats)
- **Warning**: Recoverable issues (command retry, config missing)
- **Error**: Failures (process crash, API unreachable)

### Structured Logging Example
```json
{
  "Timestamp": "2026-11-06T10:30:45.123Z",
  "Level": "Information",
  "Source": "ManuHostingAgent.Services.ProcessManager",
  "Message": "Server abc123 started with PID 4567",
  "Properties": { "ServerUuid": "abc123", "Pid": 4567 }
}
```

---

## Security

### Network
- **Outbound only**: HTTPS to control plane (port 443/8443)
- **No inbound ports** required for agent operation
- **Optional**: Management API on port 8080 (restricted to private IPs)

### Authentication
- **Node Token**: Bearer token in `X-Node-Token` header
- **Mutual TLS**: Planned (configurable `mutual_tls: true`)

### Process Isolation
- Each Minecraft server = separate process
- Windows Job Objects (planned) for CPU/memory limits
- ACLs on server directories for service account only

### File Security
- Path traversal protection in FileManager
- Server directories isolated per UUID
- No symlink following

---

## Troubleshooting

### Common Issues

| Issue | Cause | Solution |
|-------|-------|----------|
| Service won't start | Missing .NET/Java | Run install.ps1 or install manually |
| Node offline | Network/firewall | Check outbound 443, token match |
| Server won't start | Java missing / port in use | `java -version`, check port |
| High memory | Too many servers / JVM args | Review RAM limits, JVM flags |
| Backup fails | Disk full / permissions | Check space, ACLs |
| Idle shutdown not working | Bridge not sending events | Check Bridge plugin config |

### Debug Mode

```powershell
# Run interactively for debugging
cd D:\ManuHosting\agent
$env:ASPNETCORE_ENVIRONMENT = "Development"
.\ManuHostingAgent.exe
```

### Logs Location
- `D:\ManuHosting\logs\manu-hosting-agent-*.log`
- Windows Event Viewer → Application → Source: ManuHostingAgent

---

## API Reference (Control Plane → Agent)

All endpoints require `X-Node-Token` header.

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/v1/nodes/register` | Register node |
| POST | `/api/v1/nodes/{id}/heartbeat` | Heartbeat |
| GET | `/api/v1/nodes/{id}/commands` | Poll commands |
| POST | `/api/v1/nodes/{id}/commands/{cmdId}/result` | Command result |
| POST | `/api/v1/nodes/{id}/servers/status` | Server status |
| POST | `/api/v1/nodes/{id}/servers/{uuid}/install-progress` | Install progress |

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | 2026-11-06 | Initial release |

---

## Support

For issues:
1. Check `D:\ManuHosting\logs\`
2. Check Windows Event Viewer
3. Run agent manually for console output
4. Create ticket in Owner Dashboard → Support
