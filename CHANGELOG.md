# MANU HOSTING - CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0-dev] - 2026-11-06

### Added - Core Framework
- Custom PHP MVC framework (Application, Router, Container, Database, Events, Config)
- PSR-4 autoloading via Composer
- Database abstraction with PDO, prepared statements, transactions
- Migration system (17 migrations with up/down)
- Database seeder with Owner account creation
- Session management (database-backed, secure cookies, encryption)
- CSRF protection (per-form tokens, exempt routes)
- Rate limiting (login: 5/5min, register: 3/hour, API: 120/min, default: 60/min)
- Argon2id password hashing (memory: 64MB, time: 4, threads: 3)
- Role-based access control (owner, admin, support, customer, subuser)
- Granular permission system (permission strings per role)

### Added - Frontend
- Design system (CSS custom properties, dark theme, purple/blue gradients)
- Responsive CSS framework (buttons, forms, cards, tables, modals, toasts, dropdowns, tabs)
- Vanilla JavaScript core (EventBus, ToastManager, ModalManager, FormHandler, TableEnhancer)
- API client with interceptors, CSRF handling, auto-retry on 419
- Seasonal particle animation (spring/summer/autumn/winter themes)
- Utility functions (formatDate, formatBytes, formatDuration, debounce, copyToClipboard)

### Added - Public Website
- Landing page (hero, features grid, pricing cards, about, CTA)
- Public status page (components, incidents, maintenance, auto-refresh 30s)
- Legal: Impressum (German legal notice with placeholders)
- Legal: Datenschutzerklärung (GDPR-compliant, 15 sections)
- Legal: AGB (Terms of Service, 13 sections)
- Legal: Widerrufsbelehrung (right of withdrawal with form template)
- Legal: Cookie Policy (necessary cookies only, no tracking)
- Work in Progress mode (globally toggleable, custom message)
- Servers Offline mode (globally toggleable, custom message)
- Maintenance mode (Owner-controlled, persistent offline timer surviving reboot)

### Added - Authentication
- Login page (username/email, password, remember me, redirect after login)
- Registration page (full name, username, email, password confirm, terms checkbox)
- Password reset flow (email token, secure reset, expiry)
- Email verification flow

### Added - Customer Dashboard (11 Pages)
- Server list (stats cards, filters, pagination, status badges)
- Server overview (tabs: overview, console, logs, players, files, backups, schedule, settings)
- Live WebSocket console (real-time output, command input, history, Ctrl+C, reconnection)
- Log viewer (tail, refresh, clear, download, search)
- Player management (online list, kick, ban, unban, OP/DeOP, whitelist)
- File manager (tree navigation, upload, edit, download, delete, rename, zip)
- Backup management (list, create, download, restore, delete, schedule)
- Task scheduler (templates: daily restart, auto-backup, custom commands, maintenance)
- Server settings (idle shutdown config, server.properties editor, resource limits, danger zone)
- Server creation wizard (software → version → package → resources → preview)
- Server deletion (multi-step confirmation with checkboxes)

### Added - Owner Dashboard (16 Pages)
- Main dashboard (6 stat cards: servers, customers, nodes, tickets, orders, backups)
- DL580 resource visualization (CPU/RAM/Disk progress bars with color coding)
- Quick actions grid (6 common tasks with deep links)
- Recent servers table (latest 10 with status, customer, node)
- Server management (full table with filters, bulk actions: start/stop/restart/suspend/delete)
- Customer management (list, filters, role/status badges, actions)
- Administrator management (CRUD, roles: admin/support, permissions matrix, password reset)
- Hosting packages (CRUD, resource limits, server counts, ordering)
- Node management (list, status, resources, server counts)
- Resource monitoring (detailed per-node/server breakdown)
- Website maintenance (3 modes: WIP, Servers Offline, Maintenance with timer + history)
- Email configuration (SMTP settings, test send, connection verification)
- Live Inventory (placeholder for bridge data)
- Anti-Cheat monitoring (placeholder for alerts)
- Backup overview (all servers, filterable)
- Support/Ticket management (full ticket lifecycle)
- Order management (list, status, revenue)
- Audit logs (filterable by user, action, date range, paginated)
- Platform settings (all config categories editable)

### Added - Admin Dashboard (8 Pages)
- Dashboard (assigned resources overview)
- Server management (assigned servers only)
- Customer management (assigned customers only)
- Ticket management (assigned tickets)
- Node status view (read-only)
- Resource monitoring (read-only)
- Live Inventory view (read-only)
- Anti-Cheat alerts (read-only)

### Added - Minecraft Bridge Plugin (Paper/Purpur)
- Main plugin class (JavaPlugin, lifecycle, config, registration)
- API Client (HTTP to control plane, bridge secret auth, retry logic)
- Player Listener (join/quit events with player count)
- Inventory Listener (inventory/enderchest sync, throttled updates)
- AntiCheat Listener (impossible stacks, invalid enchants, movement, combat)
- Commands (/manubridge reload, status, test, register)
- Configuration (config.yaml: platform URL, bridge secret, intervals, debug)
- Maven build (Paper profile, Purpur profile, shaded Gson, proper manifest)

### Added - WebSocket Console Backend
- Ratchet WebSocket server (bin/console-server.php, port 8080)
- Console token API (POST /api/v1/console/token, POST /api/v1/servers/{id}/console/validate)
- Database migration (console_tokens table with expiry, server binding)
- Systemd service (manu-hosting-console.service, auto-restart)
- Nginx WebSocket proxy (/console/ws/ with upgrade headers)
- Customer console page integration (token auth, auto-connect)

### Added - Infrastructure
- Nginx configuration (SSL, HTTP/2, security headers, rate limits, WebSocket proxy)
- PHP-FPM pool (pm=ondemand, security limits, opcache, disabled functions)
- Systemd services (console server, ready for workers)
- Database schema (17 tables: users, nodes, servers, packages, orders, tickets, messages, backups, platform_status, server_resources, server_commands, player_inventory, anticheat_alerts, audit_logs, rate_limits, sessions, console_tokens)
- Database seeder (Owner: Emanuel/Dreimuskletiere.com, default packages, default node)

### Added - Windows Node Agent (.NET 8)
- Worker Service with Microsoft.Extensions.Hosting.WindowsServices
- Configuration (config.yaml + appsettings.json, environment variable override)
- Models (ServerConfig, ServerStatus, CommandRequest, CommandResult, NodeResources, BackupInfo, InstallRequest)
- Service Interfaces (IControlPlaneApi, IProcessManager, IFileManager, IBackupManager, IIdleShutdownManager)
- ControlPlaneApi (HttpClient + Polly retry, all endpoints: register, heartbeat, poll, results, status, install progress)
- ProcessManager (start/stop/restart/console, JVM args from config, server.properties generation, eula.txt)
- FileManager (CRUD, upload/download, zip/unzip, path traversal protection, size calculation)
- BackupManager (create/restore/delete/list/schedule, exclusion patterns, auto-cleanup)
- IdleShutdownManager (60s default, player join/leave tracking, cancellable timer, event on shutdown)
- AgentWorker (node registration, periodic maintenance, graceful shutdown of all servers)
- HeartbeatService (30s interval, system resources via PerformanceCounter, server statuses)
- CommandPollingService (5s poll, executes: start, stop, restart, console, backup, install, idle_shutdown, get_status)

### Added - Windows Deployment
- install.ps1 (Admin check, .NET 8 install, Java 21 install, dirs, ACLs, service, firewall, config)
- uninstall.ps1 (service removal, firewall cleanup, optional data removal)
- Directory structure (servers, backups, temp, logs, agent)

---

## [Unreleased]

### Planned
- SSL certificate automation (Let's Encrypt via Certbot)
- Email queue system with templates
- Prometheus metrics endpoints
- Grafana dashboards
- Automated backup to S3-compatible storage
- Bridge plugin build pipeline
- Windows Agent build pipeline
- Integration test suite
- Security audit

---

## Migration Guide

### From Pre-1.0 (Docker-based)
This is a complete rewrite with new architecture. No migration path from Docker version.

### Database Migrations
Run migrations in order:
```bash
php bin/migrate.php
```

### Configuration
Copy `config/config.example.php` to `config/config.php` and adjust:
- Database credentials
- App URL and timezone
- Email settings (when ready)
- Bridge secret
- Maintenance defaults

### Windows Node Agent
1. Build: `dotnet publish -c Release -r win-x64 --self-contained true`
2. Run install.ps1 as Administrator on DL580
3. Configure node in Owner Dashboard with same NodeId/NodeToken

### Bridge Plugin
1. Build: `cd minecraft-bridge/paper && mvn clean package`
2. Place JAR in server plugins folder
3. Configure config.yml with platform URL and bridge secret
4. Restart server

---

## Support Policy

| Version | Status | Support Until |
|---------|--------|---------------|
| 1.0.x | Development | 2027-12-31 |
| 0.x | Deprecated | 2026-12-31 |

Only the latest patch version of each minor version receives security updates.
