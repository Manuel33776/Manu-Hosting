# MANU HOSTING - MAINTENANCE & OPERATIONS

## Daily Operations (Automated via systemd/Task Scheduler)

### Debian 13 (Control Plane)
- **02:00**: Database backup (mariadb-dump + compression)
- **03:00**: Log rotation (nginx, php-fpm, application)
- **04:00**: Backup verification (check file integrity)
- **06:00**: Security updates check (apt list --upgradable)
- **Every 5 min**: Health check (HTTP 200, DB connectivity, Node Agent heartbeat)
- **Every 1 min**: Platform status check (maintenance/WIP/offline flags)

### Windows DL580 (Node)
- **02:30**: Minecraft scheduled backups (per server config)
- **03:30**: Backup cleanup (retention policy)
- **Every 30 sec**: Heartbeat to Control Plane
- **Every 10 sec**: Resource collection (CPU, RAM, Disk, Network)
- **Every 60 sec**: Idle shutdown check (player count = 0)
- **On event**: Player join/quit → Bridge → API → IdleShutdownManager

## Weekly Operations
- **Monday 01:00**: Full system backup (config + db + app)
- **Wednesday**: Security scan (Fail2Ban logs, audit log review)
- **Friday**: Test restore (staging environment)
- **Sunday**: Capacity planning report (disk, RAM, server count trends)

## Monthly Operations
- **1st**: OS security patches (Debian: apt upgrade; Windows: WSUS/Windows Update)
- **15th**: SSL certificate renewal check (Let's Encrypt)
- **End**: Performance review, cost analysis, cleanup old audit logs (>1 year)

## Update Procedures

### Debian Application Update (Zero-Downtime)
1. `git pull` to `/opt/manu-hosting/releases/<timestamp>`
2. `composer install --no-dev --optimize-autoloader`
3. `php artisan migrate --force` (or custom migration runner)
3. `php artisan cache:clear && php artisan config:cache`
4. Atomic symlink switch: `ln -sfn /opt/manu-hosting/releases/<new> /opt/manu-hosting/current`
5. `systemctl reload php8.3-fpm`
6. Health check: `curl -f https://manu-hosting.de/health`
7. Rollback: `ln -sfn /opt/manu-hosting/releases/<old> /opt/manu-hosting/current`

### Windows Node Agent Update
1. Download new release to `C:\ManuHosting\agent\versions\vX.Y.Z\`
2. Stop service: `Stop-Service ManuHostingAgent`
3. Update symlink: `Remove-Item C:\ManuHosting\agent\current; New-Item -ItemType SymbolicLink -Path C:\ManuHosting\agent\current -Target C:\ManuHosting\agent\versions\vX.Y.Z`
4. Start service: `Start-Service ManuHostingAgent`
5. Verify: Check heartbeat in Owner Dashboard

### Minecraft Server Software Update
1. Owner initiates via Dashboard → Server → Update Software
2. Agent downloads new JAR (Paper/Purpur/Vanilla API)
3. Backup current JAR + world
4. Swap JAR, update version in server.properties
5. Restart server
6. Verify: Player join, version check

## Capacity Management
- **Disk Alert**: >80% → Warning, >90% → Critical
- **RAM Alert**: >85% sustained → Warning
- **CPU Alert**: >90% 5min avg → Warning
- **Server Count**: Per-node limit → Block new provisions

## Log Management
- **Application**: `/var/log/manu-hosting/` (daily rotate, 30 days)
- **Nginx**: `/var/log/nginx/` (daily rotate, 14 days)
- **PHP-FPM**: `/var/log/php8.3-fpm.log` (daily rotate, 7 days)
- **MariaDB**: `/var/log/mysql/` (weekly rotate, 30 days)
- **Node Agent**: `C:\ManuHosting\logs\` (daily rotate, 30 days)
- **Minecraft**: `D:\ManuHosting\servers\{id}\logs\` (daily rotate, 7 days)
- **Audit**: Database table (partitioned by month, 2 years retention)

## Emergency Procedures
- **Debian Down**: Check systemd, nginx, php-fpm, mariadb, network
- **Node Offline**: Check Windows service, firewall, VPN, agent logs
- **Server Stuck**: Force kill → Agent recreates process → Verify world integrity
- **DB Corruption**: Stop app → Restore latest backup → Verify → Start app
- **DDoS**: Enable Cloudflare/UFW rate limits, block offending IPs
