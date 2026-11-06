# MANU HOSTING - DEPLOYMENT GUIDE

## Overview
Two separate deployment processes for the two servers. No shared scripts, no mixed OS commands.

---

## SERVER 1: DEBIAN 13 CONTROL PLANE

### Prerequisites
- Fresh Debian 13 (bookworm) minimal install
- Root access
- Domain pointing to server IP
- 4GB+ RAM, 2+ CPU cores, 50GB+ disk

### Automated Installation
```bash
# As root
cd /opt
git clone https://github.com/your-org/manu-hosting.git
cd manu-hosting/deployment/debian
chmod +x *.sh
./00-master-install.sh
```

### Manual Steps (what the script does)

#### 1. System Packages
```bash
apt update && apt upgrade -y
apt install -y nginx php8.3-fpm php8.3-cli php8.3-mysql php8.3-xml php8.3-mbstring \
  php8.3-curl php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl php8.3-redis \
  mariadb-server mariadb-client certbot python3-certbot-nginx \
  git composer nodejs npm ufw fail2ban prometheus-node-exporter
```

#### 2. MariaDB Setup
```bash
mysql_secure_installation
mysql -u root -p <<EOF
CREATE DATABASE manu_hosting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER manu_app@localhost IDENTIFIED BY "secure_password";
GRANT ALL ON manu_hosting.* TO manu_app@localhost;
CREATE USER manu_backup@localhost IDENTIFIED BY "backup_password";
GRANT SELECT, LOCK TABLES, SHOW VIEW ON manu_hosting.* TO manu_backup@localhost;
FLUSH PRIVILEGES;
EOF
```

#### 3. PHP-FPM Pool
```ini
; /etc/php/8.3/fpm/pool.d/manu-hosting.conf
[manu-hosting]
user = www-data
group = www-data
listen = /run/php/php8.3-fpm-manu-hosting.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 3
pm.max_spare_servers = 10
php_admin_value[open_basedir] = /opt/manu-hosting/current:/tmp:/var/lib/php/sessions
php_admin_value[disable_functions] = exec,passthru,shell_exec,system,proc_open,popen
```

#### 4. Nginx Configuration
```bash
cp deployment/debian/nginx/manu-hosting.conf /etc/nginx/sites-available/manu-hosting
ln -sf /etc/nginx/sites-available/manu-hosting /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx
```

#### 5. SSL (Let's Encrypt)
```bash
certbot --nginx -d manu-hosting.de -d www.manu-hosting.de
# Auto-renewal via systemd timer (certbot.timer)
```

#### 6. Application Deploy
```bash
# Create release directory
mkdir -p /opt/manu-hosting/releases
cd /opt/manu-hosting/releases
git clone https://github.com/your-org/manu-hosting.git <timestamp>
cd <timestamp>
composer install --no-dev --optimize-autoloader
cp config/config.example.php config/config.php
# Edit config.php with DB credentials, APP_KEY, etc.
php bin/migrate.php
php bin/cache:clear
# Atomic switch
ln -sfn /opt/manu-hosting/releases/<timestamp> /opt/manu-hosting/current
systemctl reload php8.3-fpm
```

#### 7. Systemd Services
```bash
cp deployment/debian/systemd/*.service /etc/systemd/system/
systemctl daemon-reload
systemctl enable --now manu-hosting-console manu-hosting-scheduler manu-hosting-backup
```

#### 8. Firewall
```bash
ufw default deny incoming
ufw default allow outgoing
ufw allow from <admin-ip> to any port 22 proto tcp
ufw allow 80,443/tcp
ufw allow from <monitoring-ip> to any port 9100 proto tcp
ufw allow from <vpn-subnet> to any port 8443 proto tcp
ufw enable
```

---

## SERVER 2: WINDOWS DL580 (MINECRAFT NODE)

### Prerequisites
- Windows Server 2019/2022 or Windows 10/11 Pro
- .NET 8 Runtime (Desktop Runtime)
- Java 17, 21 (multiple via symlinks)
- 64GB+ RAM, 16+ cores, 2TB+ NVMe
- Static IP in same network as Debian

### Automated Installation (PowerShell as Administrator)
```powershell
# Run in PowerShell as Admin
Set-ExecutionPolicy Bypass -Scope Process -Force
cd C:\ManuHosting\installer
.\install.ps1
```

### Manual Steps (what the script does)

#### 1. Install .NET 8 Runtime
```powershell
# Download and install .NET 8 Desktop Runtime
# https://dotnet.microsoft.com/download/dotnet/8.0
```

#### 2. Install Java
```powershell
# Java 17 (for 1.18-1.20.3)
# Java 21 (for 1.20.4+)
# Use Eclipse Temurin or Microsoft Build of OpenJDK
# Set JAVA_HOME_17 and JAVA_HOME_21 env vars
```

#### 3. Create Directory Structure
```powershell
New-Item -ItemType Directory -Force -Path D:\ManuHosting\servers
New-Item -ItemType Directory -Force -Path D:\ManuHosting\backups
New-Item -ItemType Directory -Force -Path D:\ManuHosting\config
New-Item -ItemType Directory -Force -Path C:\ManuHosting\agent
New-Item -ItemType Directory -Force -Path C:\ManuHosting\logs
```

#### 4. Create Service Account
```powershell
$password = ConvertTo-SecureString "ComplexPassword123!" -AsPlainText -Force
New-LocalUser -Name "manu-minecraft" -Password $password -Description "Minecraft Server Service Account" -PasswordNeverExpires -UserMayNotChangePassword
# Grant "Log on as a service" via secpol.msc or ntrights.exe
```

#### 5. Deploy Node Agent
```powershell
# Copy published agent to C:\ManuHosting\agent\versions\v1.0.0\
New-Item -ItemType SymbolicLink -Path C:\ManuHosting\agent\current -Target C:\ManuHosting\agent\versions\v1.0.0
# Configure appsettings.json with Control Plane URL, Node ID, Token
```

#### 6. Install Windows Service
```powershell
# Using NSSM or native .NET service
sc.exe create ManuHostingAgent binPath= "C:\ManuHosting\agent\current\ManuHostingAgent.exe" start= auto obj= ".\manu-minecraft" password= "ComplexPassword123!" DisplayName= "Manu Hosting Node Agent"
sc.exe description ManuHostingAgent "Manages Minecraft servers on this node"
Start-Service ManuHostingAgent
```

#### 7. Windows Firewall
```powershell
# Inbound rules
New-NetFirewallRule -DisplayName "Manu SSH from Control Plane" -Direction Inbound -Protocol TCP -LocalPort 22 -RemoteAddress <debian-ip> -Action Allow
New-NetFirewallRule -DisplayName "Manu Minecraft Ports" -Direction Inbound -Protocol TCP -LocalPort 25565-25665 -Action Allow
New-NetFirewallRule -DisplayName "Manu Agent API" -Direction Inbound -Protocol TCP -LocalPort 8443 -RemoteAddress <debian-ip> -Action Allow
New-NetFirewallRule -DisplayName "Manu Monitoring" -Direction Inbound -Protocol TCP -LocalPort 9100 -RemoteAddress <monitoring-ip> -Action Allow
# Outbound: Allow all (or restrict to Control Plane + updates)
```

#### 8. WireGuard VPN (Recommended)
```powershell
# Install WireGuard for Windows
# Configure tunnel to Debian Control Plane
# All inter-server traffic over VPN (10.0.0.x)
```

---

## POST-DEPLOYMENT VERIFICATION

### Control Plane
- [ ] `https://manu-hosting.de` loads (WIP banner visible)
- [ ] `https://manu-hosting.de/health` returns 200 OK
- [ ] Owner login works (Emanuel / Dreimuskletiere.com)
- [ ] Database migrations complete
- [ ] SSL Labs grade A+
- [ ] Monitoring scraping metrics

### Node
- [ ] Agent service running
- [ ] Heartbeat appears in Owner Dashboard → Nodes
- [ ] Test command: Create test server via Dashboard
- [ ] Server starts, console accessible
- [ ] Bridge plugin loads on test server
- [ ] Inventory/AntiCheat events received

### Integration
- [ ] Owner creates Admin account
- [ ] Admin creates Customer account
- [ ] Customer orders package
- [ ] Order → Provisioning → Server running
- [ ] Customer can start/stop/console
- [ ] Idle shutdown works (60s no players)
- [ ] Maintenance mode toggles correctly
- [ ] Offline timer persists across reboot

---

## ROLLBACK PROCEDURES

### Control Plane
```bash
# List releases
ls -la /opt/manu-hosting/releases/
# Switch to previous
ln -sfn /opt/manu-hosting/releases/<previous> /opt/manu-hosting/current
systemctl reload php8.3-fpm
```

### Node Agent
```powershell
Stop-Service ManuHostingAgent
Remove-Item C:\ManuHosting\agent\current
New-Item -ItemType SymbolicLink -Path C:\ManuHosting\agent\current -Target C:\ManuHosting\agent\versions\v<previous>
Start-Service ManuHostingAgent
```

### Database
```bash
# Restore from backup
gunzip -c /var/backups/manu-hosting/db/manu_hosting_20240115_020000.sql.gz | mysql -u manu_app -p manu_hosting
```
