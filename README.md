# MANU HOSTING

Professional Minecraft Hosting Platform - Classic Infrastructure, Full Control.

## Overview

Manu Hosting is a complete Minecraft server hosting platform built with a two-server architecture:

- **Debian 13 (Control Plane)**: Website, PHP Backend, MariaDB, Customer/Admin/Owner Dashboards, REST API
- **HP ProLiant DL580 (Windows)**: Minecraft Java Servers, Windows Node Agent, Process Management

**No Docker. No Containers. Native installation on both operating systems.**

## Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    DEBIAN 13 (Control Plane)                    │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐             │
│  │   Nginx     │  │  PHP-FPM    │  │  MariaDB    │             │
│  │  (Web)      │  │  (Backend)  │  │  (Database) │             │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘             │
│         │                │                │                     │
│         └────────────────┼────────────────┘                     │
│                          ▼                                      │
│              ┌───────────────────────┐                          │
│              │   REST API (Port 8443) │                          │
│              └───────────┬───────────┘                          │
└──────────────────────────┼──────────────────────────────────────┘
                           │ HTTPS + mTLS / Token Auth
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                  HP PROLIANT DL580 (Windows)                    │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │           MANU HOSTING WINDOWS NODE AGENT               │   │
│  │  ┌────────────┐ ┌────────────┐ ┌────────────┐          │   │
│  │  │ ProcessMgr │ │ FileMgr    │ │ BackupMgr  │          │   │
│  │  └────────────┘ └────────────┘ └────────────┘          │   │
│  │  ┌────────────┐ ┌────────────┐                          │   │
│  │  │IdleShutdown│ │CommandPoll │                          │   │
│  │  └────────────┘ └────────────┘                          │   │
│  └─────────────────────────────────────────────────────────┘   │
│         │                    │                    │             │
│         ▼                    ▼                    ▼             │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────┐        │
│  │  Paper      │    │  Purpur     │    │  Fabric/    │        │
│  │  Servers    │    │  Servers    │    │  Forge      │        │
│  └─────────────┘    └─────────────┘    └─────────────┘        │
└─────────────────────────────────────────────────────────────────┘
```

## Features

### Owner Dashboard
- Complete platform overview with real-time statistics
- Server management (start, stop, restart, suspend, delete)
- Customer management
- Administrator management (Owner creates ALL admins)
- Hosting package management
- Node management
- Website maintenance mode with persistent offline timer
- Email configuration (SMTP)
- Live Inventory monitoring
- Anti-Cheat monitoring
- Backup management
- Audit logs

### Customer Portal
- Server dashboard with statistics
- Live WebSocket console
- Log viewer
- Player management (kick, ban, OP)
- File manager (upload, edit, download, delete)
- Backup management (create, download, restore, schedule)
- Task scheduling (restarts, backups, commands)
- Server settings (idle shutdown, resources, properties)

### Administrator Dashboard
- Assigned customer/server management
- Ticket management
- Resource monitoring
- Anti-Cheat alerts

### Minecraft Hosting
- **Automatic installation**: Paper, Purpur, Spigot, Fabric, Forge, NeoForge, Quilt, Velocity, BungeeCord
- **Idle shutdown**: Auto-stop after 60s (configurable) when no players online
- **Resource limits**: RAM, CPU, Disk per server
- **Process management**: Windows Job Objects for isolation
- **Live console**: WebSocket-based real-time console
- **Backups**: Scheduled and manual, ZIP compression

### Bridge Plugin (Paper/Purpur)
- Player join/quit tracking
- Live inventory synchronization
- Anti-cheat event reporting
- Server status heartbeat

### Website Features
- Public status page
- Work in Progress / Servers Offline modes
- Legal pages: Impressum, Datenschutz, AGB, Widerruf, Cookie Policy
- Modern dark theme with purple/blue accents
- Seasonal particle animations
- Fully responsive

## Technology Stack

| Component | Technology |
|-----------|------------|
| Frontend | HTML5, CSS3, Vanilla JavaScript (ES6+) |
| Backend | PHP 8.2+, Custom MVC Framework |
| Database | MariaDB 10.11+ |
| Web Server | Nginx + PHP-FPM |
| Control Plane API | REST/JSON over HTTPS |
| Windows Agent | .NET 8 Worker Service |
| Minecraft Bridge | Paper/Purpur Plugin (Java 17/21) |
| Process Isolation | Windows Job Objects |
| Real-time | WebSocket (Ratchet) |
| Scheduling | systemd timers (Debian) / Windows Task Scheduler (DL580) |

## Requirements

### Debian 13 (Control Plane)
- Debian 13 (Trixie)
- Nginx 1.24+
- PHP 8.2+ with FPM
- MariaDB 10.11+
- OpenSSL 3.0+
- 4 GB RAM minimum, 8 GB recommended
- 20 GB disk space minimum

### HP ProLiant DL580 (Windows Node)
- Windows Server 2019/2022 or Windows 10/11 Pro/Enterprise
- .NET 8 Runtime
- Java 21 (Eclipse Temurin recommended)
- 32 GB RAM minimum, 64+ GB recommended
- 500 GB+ NVMe/SSD storage
- Minimum 16 CPU cores

## Quick Start

### 1. Debian Control Plane Setup

```bash
# Clone repository
git clone <repository> /var/www/manu-hosting
cd /var/www/manu-hosting

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Configure
cp config/config.example.php config/config.php
# Edit config/config.php with your settings

# Run migrations
php bin/migrate.php

# Seed database (creates Owner account: Emanuel / Dreimuskletiere.com)
php bin/seed.php

# Configure Nginx
sudo cp deployment/debian/nginx/manu-hosting.conf /etc/nginx/sites-available/
sudo ln -s /etc/nginx/sites-available/manu-hosting.conf /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# Configure PHP-FPM
sudo cp deployment/debian/php/www.conf /etc/php/8.2/fpm/pool.d/manu-hosting.conf
sudo systemctl reload php8.2-fpm

# Install systemd services
sudo cp deployment/debian/systemd/*.service /etc/systemd/system/
sudo systemctl daemon-reload
sudo systemctl enable --now manu-hosting-console
```

### 2. Windows DL580 Node Setup

```powershell
# Run as Administrator
cd C:\path\to\Manu-Hosting\windows-node\installer

# Build agent first (on build machine)
# dotnet publish -c Release -r win-x64 --self-contained true

# Install
.\install.ps1 -NodeToken "your-secure-token" -ControlPlaneUrl "https://your-domain.de"
```

### 3. Build Bridge Plugin

```bash
cd minecraft-bridge/paper
mvn clean package
# Output: target/manu-hosting-bridge-1.0.0.jar
```

### 4. Configure Node in Owner Dashboard

1. Login as Owner (Emanuel / Dreimuskletiere.com)
2. Go to Owner Dashboard → Nodes
3. Add new node with the same NodeId and NodeToken used in install.ps1
4. Node will connect and appear online

## Default Credentials

**Owner Account** (created by seeder):
- Username: `Emanuel`
- Password: `Dreimuskletiere.com`
- **Must change on first login!**

## Security

- Argon2id password hashing
- CSRF protection on all forms
- Rate limiting (login: 5/5min, register: 3/hour, API: 120/min)
- Secure session handling (HTTP-only, Secure, SameSite=Lax)
- TLS 1.2+ enforced
- Windows Firewall + UFW on Debian
- Mutual TLS or token auth for node communication
- Path traversal protection in file manager
- SQL injection prevention via PDO prepared statements
- XSS prevention via output encoding

## Project Structure

```
Manu-Hosting/
├── app/                    # PHP Backend
│   ├── Controllers/        # HTTP Controllers
│   ├── Core/              # Core Framework Classes
│   ├── Models/            # Database Models
│   ├── Services/          # Business Logic
│   ├── Middleware/        # HTTP Middleware
│   ├── Security/          # CSRF, Rate Limiting
│   ├── Validation/        # Input Validation
│   └── routes/            # Route Definitions
├── bin/                   # CLI Scripts
├── config/                # Configuration
├── database/              # Migrations & Seeds
├── deployment/            # Deployment Configs
│   ├── debian/            # Nginx, PHP-FPM, systemd
│   └── windows/           # Service, Firewall, Installer
├── docs/                  # Documentation
├── minecraft-bridge/      # Paper/Purpur Plugin
├── modules/               # Feature Modules
├── public/                # Web Root
│   ├── assets/            # CSS, JS, Images
│   └── pages/             # PHP Templates
├── scripts/               # Utility Scripts
├── tests/                 # Test Suites
├── windows-node/          # Windows Agent
│   ├── agent/             # .NET 8 Worker Service
│   ├── installer/         # PowerShell Installer
│   └── scripts/           # Utility Scripts
├── composer.json
├── README.md
├── STATUS.md
├── TASKS.md
├── ROADMAP.md
├── CHANGELOG.md
└── LICENSES.md
```

## Documentation

- [Architecture](docs/ARCHITECTURE.md)
- [Debian 13 Setup](docs/DEBIAN-13.md)
- [Windows DL580 Setup](docs/WINDOWS-DL580.md)
- [Installation Guide](docs/INSTALLATION.md)
- [Deployment](docs/DEPLOYMENT.md)
- [API Reference](docs/API.md)
- [Security](docs/SECURITY.md)
- [Backup & Restore](docs/BACKUP.md)
- [Maintenance](docs/MAINTENANCE.md)
- [Troubleshooting](docs/TROUBLESHOOTING.md)
- [Node Agent](docs/NODE-AGENT.md)
- [Minecraft Setup](docs/MINECRAFT.md)
- [Idle Shutdown](docs/IDLE-SHUTDOWN.md)
- [Owner Dashboard](docs/OWNER-DASHBOARD.md)
- [Website Maintenance](docs/WEBSITE-MAINTENANCE.md)
- [Email System](docs/EMAIL.md)
- [Commercial Readiness](docs/COMMERCIAL-READINESS.md)

## License

Proprietary - All rights reserved.

## Support

For issues and questions, check the documentation or create a ticket in the Owner Dashboard.

---

**MANU HOSTING** - Classic Infrastructure. Full Control. Professional Hosting.
