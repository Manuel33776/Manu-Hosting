# MANU HOSTING - ARCHITECTURE

## Overview

Manu Hosting follows a **two-server architecture** with clear separation of concerns:

- **Debian 13 (Control Plane)**: All web services, database, API, dashboards
- **Windows DL580 (Game Node)**: Minecraft server processes, Windows Node Agent

**No containers, no Docker, no Kubernetes.** Native installation on both operating systems.

---

## System Context Diagram

```
Internet -> [Firewall] -> Debian:443 (Nginx)
                    |
                    v
         Debian:8443 (API) <- [mTLS/Token] -> Windows Agent
```

## Component Details

### 1. Debian Control Plane

#### Nginx
- **Role**: Reverse proxy, SSL termination, static file serving
- **Ports**: 80 (HTTP to HTTPS redirect), 443 (HTTPS), 8080 (WebSocket proxy), 8443 (API proxy)
- **Features**: HTTP/2, TLS 1.2+, Security headers, Rate limiting, WebSocket upgrade, Gzip/Brotli

#### PHP-FPM
- **Role**: PHP application runtime
- **Configuration**: pm=ondemand, max children 50, request timeout 300s
- **Security**: open_basedir restriction, Disabled dangerous functions, OpCache enabled

#### MariaDB
- **Role**: Primary data store
- **Version**: 10.11+
- **Tables**: 17 tables with FKs, indexes, JSON columns

#### PHP Application (Custom MVC)
```
app/
Core/           # Application, Router, Container, Database, Events, Config
Controllers/    # AuthController, OwnerController, AdminController, ServerController
Models/         # User, Server, Node, Package, Order, Ticket, Backup, PlatformStatus
Services/       # Business logic services
Middleware/     # Auth, CSRF, RateLimit, Maintenance
Security/       # Csrf, RateLimiter
Validation/     # Validator
Helpers/        # Session, Cookie
routes/         # web.php, api.php, console_api.php
```

### 2. Windows Node Agent (.NET 8 Worker Service)

```
ManuHostingAgent/
Program.cs              # DI setup, hosted services registration
Models/                 # DTOs: ServerConfig, ServerStatus, CommandRequest, etc.
Services/
  Interfaces.cs         # Service contracts
  ControlPlaneApi.cs    # HTTP client to Debian (Polly retry)
  ProcessManager.cs     # Minecraft process lifecycle
  FileManager.cs        # File operations with path traversal protection
  BackupManager.cs      # ZIP backup with exclusions
  IdleShutdownManager   # 60s auto-shutdown when empty
  AgentWorker.cs        # Registration, maintenance
  HeartbeatService.cs   # 30s resource reporting
  CommandPollingService.cs # 5s command execution
config.yaml / appsettings.json
```

### 3. Minecraft Bridge Plugin (Paper/Purpur)

```
minecraft-bridge/paper/
src/main/java/com/manuhosting/bridge/
ManuHostingBridge.java    # Main plugin class
api/ApiClient.java        # HTTP to control plane
config/BridgeConfig.java  # YAML config binding
listener/
  PlayerListener.java     # Join/quit events
  InventoryListener.java  # Inventory/enderchest sync
  AntiCheatListener.java  # Suspicious activity
command/BridgeCommand.java # /manubridge command
src/main/resources/
  config.yml              # Configuration
  plugin.yml              # Plugin metadata
pom.xml                   # Maven build (Paper/Purpur profiles)
```

## Data Flow

### Server Creation Flow
1. Customer clicks "Create Server" in dashboard
2. Owner/Admin validates package limits
3. POST /api/v1/servers -> PHP creates server record (status: creating)
4. PHP inserts command into server_commands table (command: install)
5. Windows Agent polls commands (5s interval)
6. Agent executes install: creates directory, downloads JAR, writes config, starts briefly
7. PHP updates server status to online
8. Customer sees server in dashboard

### Heartbeat Flow (Every 30s)
1. Agent collects system and per-server metrics
2. POST /api/v1/nodes/{id}/heartbeat with token
3. PHP updates nodes table + server statuses
4. Dashboard reads from DB (real-time via AJAX poll)

### Idle Shutdown Flow
1. Last player leaves server (PlayerQuitEvent via Bridge)
2. Bridge sends player_quit event -> PHP updates players_online = 0
3. Agent receives server status with players_online = 0
4. IdleShutdownManager starts 60s timer for that server UUID
5. If player joins within 60s -> timer cancelled (PlayerJoinEvent)
6. If 60s elapse -> Agent calls ProcessManager.StopServerAsync()
7. Server stops gracefully (stop command -> wait 30s -> force kill)
8. Bridge sends server status "offline" -> PHP updates DB
9. Dashboard shows status: "idle_shutdown"

### Console Flow (WebSocket)
1. Customer opens console page
2. PHP generates short-lived console token (5 min, bound to server UUID)
3. JavaScript connects to wss://domain/console/ws/{token}
4. Nginx proxies to Ratchet server (port 8080)
5. Ratchet validates token, attaches to server process stdin/stdout
6. Bidirectional communication: stdout -> WS, WS -> stdin
7. On disconnect: token invalidated, process continues running

## Security Architecture

### Network Segmentation
Internet -> [Firewall] -> Debian:443 (Nginx)
                    |
                     Debian:8443 (API) <- [mTLS/Token] -> Windows Agent

### Authentication Layers
1. Debian -> Internet: Session cookies (HttpOnly, Secure, SameSite=Lax) + CSRF tokens
2. Windows Agent -> Debian: Node token (header) + optional mTLS
3. Bridge Plugin -> Debian: Bridge secret (header) + Server UUID
4. Console WebSocket: Short-lived token (5 min, single-use, server-bound)

### Data Protection
- Passwords: Argon2id (memory: 64MB, time: 4, threads: 3)
- Sessions: Encrypted in database, rotated on privilege change
- Tokens: Cryptographically random (32 bytes hex), hashed in DB
- Secrets: Stored in config/config.php (not in Git), env vars for production
- Backups: Encrypted at rest (planned: age/gpg)

### Process Isolation (Windows)
- Each Minecraft server runs in separate process
- Windows Job Objects (planned) for CPU/RAM limits
- ACLs on server directories (service account only)
- Path traversal protection in FileManager

## Scalability Considerations

### Horizontal Scaling (Future)
- Control Plane: Multiple Debian servers behind load balancer
  - Shared MariaDB (Galera cluster)
  - Shared Redis for sessions/cache
  - Shared file storage (NFS/S3) for backups
- Game Nodes: Add more Windows DL580s
  - Each registers independently with control plane
  - Scheduler assigns servers based on resources

### Vertical Scaling (Current)
- Debian: Increase CPU/RAM for more concurrent users
- DL580: Add more RAM/CPU for more Minecraft servers
- Database: Optimize queries, add indexes, read replicas

### Performance Targets
| Metric | Target |
|--------|--------|
| Page load (cached) | < 200ms |
| API response (p95) | < 500ms |
| Console latency | < 100ms |
| Server start time | < 30s |
| Heartbeat interval | 30s |
| Command poll interval | 5s |

## Deployment Architecture

### Debian 13
/var/www/manu-hosting/
app/                    # PHP source
bin/                    # CLI scripts
config/
  config.php            # Production config (not in Git)
  config.example.php    # Template
public/                 # Web root (Nginx root)
  index.php             # Front controller
  assets/               # CSS, JS, images
  pages/                # PHP templates
storage/
  logs/                 # Application logs
vendor/                 # Composer dependencies

### Windows DL580
D:\\ManuHosting\\
agent/
  ManuHostingAgent.exe    # Single-file .NET 8 app
  config.yaml             # Runtime config
  appsettings.json        # .NET config
servers/
  {server-uuid}/          # Per-server directory
backups/
  {server-uuid}/
      backup_*.zip
temp/                       # Temporary files
logs/                       # Agent logs

## Technology Choices Rationale

| Decision | Rationale |
|----------|-----------|
| No Docker | Simplicity, direct OS control, easier debugging, transferable |
| Windows on DL580 | Hardware constraint; DL580 runs Windows |
| .NET 8 for Agent | Native Windows Service, performance, self-contained, Polly |
| Vanilla JS | Zero build step, no node_modules, minimal dependencies |
| Custom PHP MVC | Full control, no framework bloat, explicit dependencies |
| MariaDB | JSON support, good performance, Galera for future HA |
| Ratchet WebSocket | Pure PHP, no Node.js, integrates with PHP session auth |
| Paper/Purpur Bridge | Most popular server software, stable API |
| Maven for Bridge | Standard Java build, shaded dependencies, profile support |

## Future Architecture Evolution

### v1.1 - Observability
- Prometheus metrics on both servers
- Grafana dashboards
- Structured logging (JSON) -> Loki

### v1.2 - Multi-Node
- Node groups (location, tier)
- Scheduler with bin-packing
- WireGuard mesh between nodes

### v1.3 - High Availability
- Control plane clustering (2+ Debian)
- MariaDB Galera
- Redis for sessions
- Automated failover

### v2.0 - Platform
- Game server abstraction
- Plugin marketplace
- Multi-game support (Valheim, Rust, etc.)

