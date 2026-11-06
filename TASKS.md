# MANU HOSTING - TASKS

**Legend**: `[x]` Done & Tested | `[~]` In Progress | `[ ]` Open | `[!]` Blocked

---

## Phase 1: Foundation (Weeks 1-2) ✅ COMPLETE

- [x] Project structure setup
- [x] PHP Core Framework (Application, Router, Container, Database, Events)
- [x] Configuration system (config.example.php, environment-based)
- [x] Database abstraction (PDO, migrations, seeds)
- [x] Session management (database-backed, secure cookies)
- [x] CSRF protection
- [x] Rate limiting
- [x] Authentication system (Argon2id, login/register/password reset)
- [x] Authorization (roles: owner, admin, support, customer, subuser)
- [x] Permission system (granular permissions per role)
- [x] Design system (CSS variables, dark theme, purple/blue)
- [x] Global CSS (components, utilities, responsive)
- [x] JavaScript core (EventBus, Toast, Modal, Forms, Tables)
- [x] API Client (CSRF, interceptors, error handling)

## Phase 2: Public Website (Week 2) ✅ COMPLETE

- [x] Landing page (hero, features, pricing, about, CTA)
- [x] Status page (components, incidents, maintenance, auto-refresh)
- [x] Legal: Impressum (placeholders)
- [x] Legal: Datenschutz (GDPR, 15 sections)
- [x] Legal: AGB (Terms, 13 sections)
- [x] Legal: Widerruf (withdrawal form)
- [x] Legal: Cookie Policy (necessary only)
- [x] Work in Progress banner (configurable)
- [x] Servers Offline banner (configurable)
- [x] Maintenance mode (Owner-controlled, persistent timer)
- [x] Seasonal particle animations

## Phase 3: Customer Dashboard (Weeks 3-4) ✅ COMPLETE

- [x] Server list with stats, filters, pagination
- [x] Server overview with tab navigation
- [x] Live WebSocket console (Ratchet, reconnection, history)
- [x] Log viewer (refresh, clear, download)
- [x] Player management (list, kick, ban, OP, whitelist)
- [x] File manager (tree, upload, edit, download, delete, zip)
- [x] Backup management (create, download, restore, delete, schedule)
- [x] Task scheduler (daily restart, auto-backup, commands, maintenance)
- [x] Server settings (idle shutdown, properties, resources, danger zone)
- [x] Server creation wizard (dynamic versions per software)
- [x] Server delete confirmation (multi-step, checkboxes)

## Phase 4: Owner Dashboard (Weeks 4-5) ✅ COMPLETE

- [x] Main dashboard (stats grid, DL580 resources, quick actions, recent servers)
- [x] Server management (table, filters, actions: start/stop/restart/suspend/delete)
- [x] Customer management (list, filters, status, roles)
- [x] Administrator management (CRUD, roles, permissions, password reset)
- [x] Hosting packages (CRUD, resource limits, server counts)
- [x] Node management (list, status, resources)
- [x] Resource monitoring (detailed per-node/server)
- [x] Website maintenance (WIP, Servers Offline, Maintenance + offline timer)
- [x] Email configuration (SMTP settings, test send)
- [x] Live Inventory (placeholder for bridge data)
- [x] Anti-Cheat (placeholder for alerts)
- [x] Backup overview (all servers)
- [x] Support/Ticket management
- [x] Order management
- [x] Audit logs (filterable, paginated)
- [x] Platform settings

## Phase 5: Admin Dashboard (Week 5) ✅ COMPLETE

- [x] Dashboard (assigned resources overview)
- [x] Server management (assigned only)
- [x] Customer management (assigned only)
- [x] Ticket management
- [x] Node status view
- [x] Resource monitoring
- [x] Live Inventory view
- [x] Anti-Cheat alert monitoring

## Phase 6: Minecraft Bridge Plugin (Week 5) ✅ COMPLETE

- [x] Main plugin class (registration, heartbeat, config)
- [x] API Client (HTTP to control plane, auth, retry)
- [x] Player Listener (join/quit events)
- [x] Inventory Listener (inventory/enderchest sync, throttled)
- [x] AntiCheat Listener (suspicious items, movement, combat)
- [x] Commands (/manubridge reload, status, test)
- [x] Configuration (config.yaml with all options)
- [x] Maven build (Paper/Purpur profiles, shaded Gson)
- [x] plugin.yml

## Phase 7: WebSocket Console Backend (Week 5) ✅ COMPLETE

- [x] Ratchet WebSocket server (bin/console-server.php)
- [x] Console token API (/api/v1/console/token, /validate)
- [x] Database migration (console_tokens table)
- [x] Systemd service (manu-hosting-console.service)
- [x] Nginx WebSocket proxy (/console/ws/)
- [x] Customer console page integration

## Phase 8: Windows Node Agent - CORE (Week 6) 🟡 IN PROGRESS

- [x] Project structure (.NET 8 Worker Service)
- [x] csproj with dependencies (Hosting.WindowsServices, Polly, SharpCompress, YamlDotNet)
- [x] config.yaml & appsettings.json
- [x] Program.cs (DI, hosted services)
- [x] Models (ServerConfig, ServerStatus, CommandRequest, NodeResources, BackupInfo, etc.)
- [x] Interfaces (IControlPlaneApi, IProcessManager, IFileManager, IBackupManager, IIdleShutdownManager)
- [x] ControlPlaneApi (HTTP client, retry, all endpoints)
- [x] ProcessManager (start/stop/restart/console, JVM args, server.properties)
- [x] FileManager (CRUD, upload/download, zip/unzip, path traversal protection)
- [x] BackupManager (create/restore/delete/list/schedule, exclusions)
- [x] IdleShutdownManager (60s default, player join/leave tracking, cancellable)
- [x] AgentWorker (registration, maintenance, graceful shutdown)
- [x] HeartbeatService (30s interval, system resources, server statuses)
- [x] CommandPollingService (5s poll, all command types including install)

## Phase 9: Windows Node Agent - DEPLOYMENT (Week 6) ✅ COMPLETE

- [x] install.ps1 (Admin check, .NET 8, Java 21, dirs, ACLs, service, firewall, config)
- [x] uninstall.ps1 (service, firewall, optional data removal)
- [x] Directory structure (servers, backups, temp, logs, agent)

## Phase 10: Infrastructure & Deployment (Week 7) 🟡 PARTIAL

- [x] Nginx configuration (SSL, rate limits, WebSocket proxy, security headers)
- [x] PHP-FPM pool (security, performance, limits)
- [x] Systemd services (console server)
- [x] Database migrations (17 tables, FKs, indexes)
- [x] Database seeder (Owner account, default packages, default node)
- [ ] SSL certificates (Let's Encrypt automation)
- [ ] Debian deployment script (automated)
- [ ] Windows agent build pipeline
- [ ] Bridge plugin build pipeline
- [ ] Backup automation (systemd timers / Windows Task Scheduler)
- [ ] Log rotation

## Phase 11: Email System (Week 7) [ ] NOT STARTED

- [ ] SMTP configuration in Owner Dashboard
- [ ] Email queue (database table + worker)
- [ ] Templates (welcome, verify, password reset, server events, tickets, orders)
- [ ] Systemd worker for queue processing
- [ ] Test send from Owner Dashboard
- [ ] Rate limiting per email

## Phase 12: Documentation (Week 7-8) 🟡 PARTIAL

- [x] README.md
- [x] STATUS.md
- [ ] TASKS.md (this file)
- [ ] ROADMAP.md
- [ ] CHANGELOG.md
- [ ] LICENSES.md
- [ ] docs/ARCHITECTURE.md
- [ ] docs/DEBIAN-13.md
- [ ] docs/WINDOWS-DL580.md
- [ ] docs/INSTALLATION.md
- [ ] docs/DEPLOYMENT.md
- [ ] docs/DEVELOPMENT.md
- [ ] docs/DATABASE.md
- [ ] docs/API.md
- [ ] docs/SECURITY.md
- [ ] docs/BACKUP.md
- [ ] docs/MAINTENANCE.md
- [ ] docs/TROUBLESHOOTING.md
- [ ] docs/NODE-AGENT.md
- [ ] docs/MINECRAFT.md
- [ ] docs/IDLE-SHUTDOWN.md
- [ ] docs/OWNER-DASHBOARD.md
- [ ] docs/WEBSITE-MAINTENANCE.md
- [ ] docs/EMAIL.md
- [ ] docs/COMMERCIAL-READINESS.md

## Phase 13: Testing & Hardening (Week 8) [ ] NOT STARTED

- [ ] Unit tests (PHP + C#)
- [ ] Integration tests (API, WebSocket, Bridge)
- [ ] Load testing (concurrent consoles, servers)
- [ ] Security audit (SQLi, XSS, CSRF, auth bypass)
- [ ] Penetration testing
- [ ] Idle shutdown stress test
- [ ] Backup/restore verification
- [ ] Failover testing (node disconnect, reconnect)
- [ ] Windows service recovery testing

## Phase 14: Production Readiness (Week 8-9) [ ] NOT STARTED

- [ ] Production Debian setup (hardened)
- [ ] Production Windows DL580 setup (hardened)
- [ ] DNS configuration
- [ ] SSL certificates (production)
- [ ] SMTP credentials (production)
- [ ] Monitoring (Prometheus/Grafana or similar)
- [ ] Alerting (node down, server errors, disk space)
- [ ] Backup retention policy
- [ ] Disaster recovery plan
- [ ] Update procedures (Debian, Windows, Agent, Bridge)

---

## Current Sprint Focus

**Week 6-7**: Complete Windows Agent build, Bridge plugin build, deploy to test servers, integration testing

**Blockers**:
- Need .NET 8 SDK on Windows build machine
- Need Maven + Java 17/21 for Bridge plugin build
- Need access to both Debian and DL580 for deployment testing
