# MANU HOSTING - INSTALLATION GUIDE

Complete installation guide for both servers.

---

## Prerequisites

### Debian 13 (Control Plane)
- Debian 13 (Trixie) minimal install
- Root or sudo access
- 4 GB RAM minimum, 8 GB recommended
- 20 GB disk space minimum
- Public domain name with DNS A record
- Ports 80, 443, 8080, 8443 accessible

### HP ProLiant DL580 (Windows Node)
- Windows Server 2019/2022 or Windows 10/11 Pro/Enterprise
- Administrator access
- .NET 8 Runtime (installed by script)
- Java 21 (installed by script)
- 32 GB RAM minimum, 64+ GB recommended
- 500 GB+ NVMe/SSD storage
- Minimum 16 CPU cores
- Ports 25565-25665 for Minecraft
- Outbound HTTPS (443) to Debian control plane

---

## Part 1: Debian Control Plane Setup

### 1.1 System Preparation

```bash
# Update system
apt update && apt upgrade -y

# Install required packages
apt install -y nginx php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath mariadb-server certbot python3-certbot-nginx git curl

# Enable services
systemctl enable --now nginx php8.2-fpm mariadb
```

### 1.2 Database Setup

```bash
# Secure MariaDB
mysql_secure_installation

# Create database and user
mysql -u root -p << EOF
CREATE DATABASE manu_hosting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'manu_hosting'@'localhost' IDENTIFIED BY 'CHANGE_THIS_PASSWORD';
GRANT ALL PRIVILEGES ON manu_hosting.* TO 'manu_hosting'@'localhost';
FLUSH PRIVILEGES;
EOF
```

### 1.3 Application Deployment

```bash
# Clone repository
cd /var/www
git clone <your-repo> manu-hosting
cd manu-hosting

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Configure application
cp config/config.example.php config/config.php
# Edit config/config.php with your database credentials, app URL, etc.

# Run migrations
php bin/migrate.php

# Seed database (creates Owner account)
php bin/seed.php
```

### 1.4 Nginx Configuration

```bash
# Copy configuration
cp deployment/debian/nginx/manu-hosting.conf /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/manu-hosting.conf /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and reload
nginx -t && systemctl reload nginx
```

### 1.5 PHP-FPM Configuration

```bash
cp deployment/debian/php/www.conf /etc/php/8.2/fpm/pool.d/manu-hosting.conf
systemctl reload php8.2-fpm
```

### 1.6 SSL Certificates (Let's Encrypt)

```bash
# Get certificate
certbot --nginx -d your-domain.de -d www.your-domain.de

# Auto-renewal is configured via systemd timer
systemctl status certbot.timer
```

### 1.7 Systemd Services

```bash
# Copy service files
cp deployment/debian/systemd/*.service /etc/systemd/system/
systemctl daemon-reload

# Enable and start WebSocket console server
systemctl enable --now manu-hosting-console

# Check status
systemctl status manu-hosting-console
```

### 1.8 Firewall (UFW)

```bash
ufw allow 22/tcp    # SSH
ufw allow 80/tcp    # HTTP
ufw allow 443/tcp   # HTTPS
ufw allow 8080/tcp  # WebSocket (if direct access needed)
ufw allow 8443/tcp  # Node API
ufw enable
```

---

## Part 2: Windows DL580 Node Setup

### 2.1 Prepare Build Machine

The Windows Agent must be built on a machine with .NET 8 SDK:

```powershell
# On build machine (Windows with .NET 8 SDK)
cd C:\path\to\Manu-Hosting\windows-node\agent\src\ManuHostingAgent
dotnet publish -c Release -r win-x64 --self-contained true -o ..\..\..\..\publish
```

### 2.2 Deploy to DL580

Copy the published folder to the DL580 (e.g., via USB, network share, or RDP).

### 2.3 Run Installer

```powershell
# On DL580, run as Administrator
cd C:\path\to\Manu-Hosting\windows-node\installer

# Required: NodeToken (generate a secure random string)
# Example: .\install.ps1 -NodeToken "abc123securetokenxyz" -ControlPlaneUrl "https://your-domain.de"

.\install.ps1 -NodeToken "YOUR_SECURE_TOKEN_HERE" -ControlPlaneUrl "https://your-domain.de"
```

The installer will:
1. Install .NET 8 Runtime (if missing)
2. Install Eclipse Temurin Java 21 (if missing)
3. Create directory structure (D:\ManuHosting\...)
4. Set ACLs for service account
5. Deploy agent binaries
6. Generate config.yaml with your settings
7. Create Windows Service (auto-start, recovery)
8. Configure Windows Firewall (ports 25565-25665)
9. Start the service

### 2.4 Verify Installation

```powershell
# Check service status
Get-Service ManuHostingAgent

# Check logs
Get-Content "D:\ManuHosting\logs\*.log" -Tail 50

# Check agent is connecting
# Look for "Successfully registered with control plane" in logs
```

---

## Part 3: Bridge Plugin Build & Deploy

### 3.1 Build Plugin

```bash
# On build machine with Maven and Java 17/21
cd minecraft-bridge/paper
mvn clean package

# For Purpur:
mvn clean package -Ppurpur

# Output: target/manu-hosting-bridge-1.0.0.jar
```

### 3.2 Deploy to Minecraft Server

1. Copy JAR to server's plugins/ folder
2. Configure plugins/ManuHostingBridge/config.yml:
```yaml
platform_url: "https://your-domain.de"
bridge_secret: "SAME_AS_IN_AGENT_CONFIG"
server_uuid: ""  # Auto-generated on first run
node_id: "dl580-node-01"
heartbeat_interval: 30
inventory_update_interval: 5
anticheat_enabled: true
debug_mode: false
```
3. Start/restart the Minecraft server
4. Check logs for "Successfully registered with platform"

---

## Part 4: Configure Node in Owner Dashboard

1. Login to Owner Dashboard: https://your-domain.de/owner
   - Username: Emanuel
   - Password: Dreimuskletiere.com (CHANGE IMMEDIATELY!)

2. Go to Nodes -> Add Node

3. Fill in:
   - Name: DL580 Primary
   - Node ID: dl580-node-01 (must match install.ps1)
   - Token: Same token used in install.ps1
   - Host: IP or hostname of DL580
   - API Port: 8443

4. Save -> Node should show Online within 30 seconds

---

## Part 5: Create Hosting Packages

1. Go to Packages -> Create Package
2. Define packages (e.g., Starter, Pro, Enterprise):
   - Name, Description
   - RAM (MB), CPU (cores), Disk (MB)
   - Max Players
   - Max Servers per Customer
   - Price (for future billing)
   - Supported Software (Paper, Purpur, etc.)
   - Idle Shutdown Default (seconds)
3. Save packages

---

## Part 6: Verify Full Stack

1. Public Website: https://your-domain.de
2. Customer Registration: Register a test account
3. Create Server: Use test account to create a server
4. Start Server: Verify it starts and goes online
5. Console: Open console, run say Hello
6. Bridge: Check player join/quit in Owner Dashboard -> Live Inventory
7. Idle Shutdown: Stop server, wait 60s, verify auto-shutdown
8. Backup: Create backup, download, restore

---

## Post-Installation Checklist

- [ ] Owner password changed
- [ ] SSL certificate valid (https://your-domain.de)
- [ ] Node shows Online in Owner Dashboard
- [ ] Test server creates and starts successfully
- [ ] Console works (WebSocket connection)
- [ ] Bridge plugin reports player events
- [ ] Idle shutdown works (60s default)
- [ ] Backup create/download/restore works
- [ ] Email test send works (after SMTP configured)
- [ ] Firewall rules correct on both servers
- [ ] Systemd services running (Debian)
- [ ] Windows Service running (DL580)
- [ ] Log rotation configured
- [ ] Automated backups scheduled

---

## Troubleshooting

### Node shows Offline
1. Check Windows Service: Get-Service ManuHostingAgent
2. Check agent logs: D:\ManuHosting\logs\*.log
3. Verify firewall allows outbound 443 to Debian
4. Verify NodeId and Token match in both places
5. Check Debian API port 8443 accessible from DL580

### Server won't start
1. Check Java installed: java -version
2. Check server directory permissions
3. Check agent logs for download errors
4. Verify server JAR downloaded correctly
5. Check server.properties port not in use

### Console not connecting
1. Check Nginx WebSocket proxy config
2. Check manu-hosting-console service running
3. Check browser console for WS errors
4. Verify token API returns valid token

### Bridge plugin not connecting
1. Check server logs for bridge errors
2. Verify platform_url in config.yml
3. Verify bridge_secret matches agent config
4. Check Debian API accessible from Minecraft server

---

## Support

For issues, check:
- Application logs: /var/www/manu-hosting/storage/logs/
- Nginx logs: /var/log/nginx/
- PHP-FPM logs: /var/log/php8.2-fpm.log
- MariaDB logs: /var/log/mysql/
- Agent logs: D:\ManuHosting\logs\
- Windows Event Viewer: Application log

Create a ticket in the Owner Dashboard -> Support for platform issues.
