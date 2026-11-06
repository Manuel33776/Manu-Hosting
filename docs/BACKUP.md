# MANU HOSTING - BACKUP & RECOVERY

## Backup Types

### 1. Minecraft Server Backups (Windows DL580)
- **Location**: `D:\ManuHosting\backups\server-{id}\`
- **Format**: Compressed tar.gz (world, plugins, config)
- **Trigger**: Manual (Customer/Owner/Admin) or Scheduled
- **Retention**: Per-package limit (default: 7 daily, 4 weekly, 3 monthly)
- **Consistency**: Server paused via RCON `save-off` + `save-all` before backup

### 2. Platform Database Backups (Debian 13)
- **Location**: `/var/backups/manu-hosting/db/`
- **Format**: Compressed SQL dump (mariadb-dump --single-transaction)
- **Schedule**: Daily 02:00 (systemd timer)
- **Retention**: 30 daily, 12 monthly, 3 yearly
- **Offsite**: Rsync to configured remote (optional)

### 3. Configuration Backups
- **Debian**: `/etc/nginx/`, `/etc/php/8.3/fpm/`, `/opt/manu-hosting/config/`
- **Windows**: `C:\ManuHosting\config\`, Windows Service configs
- **Schedule**: Weekly + on change

## Backup Process (Minecraft)

1. **Validation**: Check server status (must be running for consistent backup)
2. **Freeze**: RCON `save-off` → `save-all` → wait for flush
3. **Archive**: `tar -czf backup-{timestamp}.tar.gz world/ plugins/ server.properties ...`
4. **Unfreeze**: RCON `save-on`
5. **Verify**: Check archive integrity, size > 0
6. **Record**: Insert into `backups` table with metadata
7. **Cleanup**: Apply retention policy (delete oldest)
8. **Notify**: Webhook/email on failure

## Recovery Process

### Minecraft Server Restore
1. **Stop Server**: Graceful stop if running
2. **Select Backup**: List available, show size/date/contents
3. **Confirm**: Show what will be replaced (world, plugins, config)
4. **Extract**: `tar -xzf backup.tar.gz -C server-dir/`
5. **Permissions**: Fix ownership (minecraft user)
6. **Start Server**: Normal startup
7. **Verify**: Check logs, player join test

### Database Restore
1. **Maintenance Mode**: Enable via Owner Dashboard
2. **Stop Services**: `systemctl stop php8.3-fpm nginx`
3. **Restore**: `mariadb < backup.sql.gz`
4. **Migrate**: Run pending migrations
5. **Start Services**: `systemctl start php8.3-fpm nginx`
6. **Verify**: Health checks, test login

## Monitoring & Verification
- **Daily**: Verify backup files exist, non-zero size
- **Weekly**: Test restore to staging (automated)
- **Monthly**: Full disaster recovery drill
- **Alerts**: Backup failure → immediate notification
- **Dashboard**: Owner/Admin can view backup status, last success, next scheduled

## Retention Policies (Configurable per Package)
| Frequency | Daily | Weekly | Monthly | Yearly |
|-----------|-------|--------|---------|--------|
| Default   | 7     | 4      | 3       | 3      |
| Premium   | 14    | 8      | 6       | 5      |

## Storage Requirements
- **Minecraft**: ~500MB-5GB per server per backup
- **Database**: ~50-200MB per dump
- **Plan**: 2x estimated usage for retention + overhead
