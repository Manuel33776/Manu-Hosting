# MANU HOSTING - DEBIAN 13 SETUP

Complete setup guide for the Debian 13 control plane server.

---

## System Requirements

- **OS**: Debian 13 (Trixie) - minimal install
- **CPU**: 2+ cores (4+ recommended)
- **RAM**: 4 GB minimum, 8 GB recommended
- **Disk**: 20 GB minimum (SSD/NVMe recommended)
- **Network**: Public IPv4, domain name with A record
- **Ports**: 80, 443 (public), 8080, 8443 (internal/node)

---

## Base System Installation

### 1. Install Debian 13

Download Debian 13 netinst ISO from https://www.debian.org/distrib/
- Choose "Minimal" or "Standard system utilities" only
- No desktop environment needed
- Configure static IP or DHCP with reserved address
- Set hostname: `manu-hosting` (or your preferred name)

### 2. Post-Install Configuration

```bash
# Update system
apt update && apt upgrade -y

# Install essential tools
apt install -y sudo vim git curl wget htop net-tools ufw fail2ban

# Configure sudo for your user
usermod -aG sudo yourusername

# Set timezone
timedatectl set-timezone Europe/Berlin

# Configure locale
apt install -y locales
dpkg-reconfigure locales
# Select: en_US.UTF-8, de_DE.UTF-8
```

---

## Required Software Stack

### 1. Nginx

```bash
# Install Nginx
apt install -y nginx

# Enable and start
systemctl enable --now nginx

# Verify
systemctl status nginx
curl -I http://localhost
```

### 2. PHP 8.2 + FPM

```bash
# Add PHP repository (Ondřej Surý)
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update

# Install PHP 8.2 and extensions
apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring \
    php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath \
    php8.2-opcache php8.2-readline php8.2-common

# Verify
php -v
php-fpm8.2 -v
```

### 3. MariaDB 10.11+

```bash
# Install MariaDB
apt install -y mariadb-server mariadb-client

# Secure installation
mysql_secure_installation
# Set root password
# Remove anonymous users
# Disallow root login remotely
# Remove test database
# Reload privilege tables

# Enable and start
systemctl enable --now mariadb

# Verify
mysql -u root -p -e "SELECT VERSION();"
```

### 4. Composer

```bash
# Install Composer globally
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Verify
composer --version
```

### 5. Certbot (Let's Encrypt)

```bash
# Install Certbot with Nginx plugin
apt install -y certbot python3-certbot-nginx

# Verify
certbot --version
```

---

## Application Deployment

### 1. Create Application User

```bash
# Create dedicated user
adduser --system --group --home /var/www/manu-hosting --shell /bin/bash manu-hosting

# Or use www-data if preferred
# usermod -aG www-data manu-hosting
```

### 2. Deploy Application

```bash
# Switch to app user
sudo -u manu-hosting -s

# Clone repository
cd /var/www
git clone <your-repository-url> manu-hosting
cd manu-hosting

# Install dependencies
composer install --no-dev --optimize-autoloader

# Exit app user shell
exit
```

### 3. Configure Application

```bash
# Copy config template
cp /var/www/manu-hosting/config/config.example.php /var/www/manu-hosting/config/config.php

# Edit configuration
# IMPORTANT: Set these values in config.php:
# - database.host, database.name, database.username, database.password
# - app.url (your domain with https)
# - app.timezone = "Europe/Berlin"
# - security settings (argon2, rate limits)
# - email settings (when SMTP ready)
# - bridge.secret (generate secure random string)

vim /var/www/manu-hosting/config/config.php
```

### 4. Database Setup

```bash
# Create database and user
mysql -u root -p << EOF
CREATE DATABASE manu_hosting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'manu_hosting'@'localhost' IDENTIFIED BY 'YOUR_SECURE_DB_PASSWORD';
GRANT ALL PRIVILEGES ON manu_hosting.* TO 'manu_hosting'@'localhost';
FLUSH PRIVILEGES;
EOF

# Run migrations
sudo -u manu-hosting php /var/www/manu-hosting/bin/migrate.php

# Seed database (creates Owner account)
sudo -u manu-hosting php /var/www/manu-hosting/bin/seed.php
```

---

## Nginx Configuration

### 1. Deploy Configuration

```bash
# Copy site configuration
cp /var/www/manu-hosting/deployment/debian/nginx/manu-hosting.conf /etc/nginx/sites-available/

# Enable site
ln -s /etc/nginx/sites-available/manu-hosting.conf /etc/nginx/sites-enabled/

# Disable default site
rm -f /etc/nginx/sites-enabled/default

# Test configuration
nginx -t
```

### 2. Key Configuration Details

The provided configuration includes:
- **SSL/TLS**: Automatic redirect HTTP to HTTPS
- **Security Headers**: HSTS, CSP, X-Frame-Options, etc.
- **Rate Limiting**: Login, register, API endpoints
- **WebSocket Proxy**: `/console/ws/` → `localhost:8080`
- **API Proxy**: `/api/v1/nodes/` → `localhost:8443`
- **PHP-FPM**: Unix socket for performance
- **Static Files**: Direct serving with caching
- **Gzip/Brotli**: Compression enabled

### 3. Reload Nginx

```bash
systemctl reload nginx
```

---

## PHP-FPM Configuration

### 1. Deploy Pool Configuration

```bash
cp /var/www/manu-hosting/deployment/debian/php/www.conf /etc/php/8.2/fpm/pool.d/manu-hosting.conf
```

### 2. Key Settings

```ini
[manu-hosting]
user = manu-hosting
group = manu-hosting
listen = /run/php/php8.2-fpm-manu-hosting.sock
listen.owner = www-data
listen.group = www-data

pm = ondemand
pm.max_children = 50
pm.process_idle_timeout = 10s
pm.max_requests = 500

; Security
php_admin_value[open_basedir] = /var/www/manu-hosting:/tmp
php_admin_value[disable_functions] = exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source

; Performance
php_flag[opcache.enable] = on
php_flag[opcache.enable_cli] = on
php_value[opcache.memory_consumption] = 128
php_value[opcache.interned_strings_buffer] = 8
php_value[opcache.max_accelerated_files] = 10000
```

### 3. Reload PHP-FPM

```bash
systemctl reload php8.2-fpm
```

---

## SSL Certificates (Let's Encrypt)

### 1. Obtain Certificate

```bash
# Replace with your domain
certbot --nginx -d your-domain.de -d www.your-domain.de

# Follow prompts:
# - Enter email for expiry notices
# - Agree to terms
# - Choose redirect (2: Redirect HTTP to HTTPS)
```

### 2. Verify Auto-Renewal

```bash
# Check timer status
systemctl status certbot.timer

# Test renewal (dry run)
certbot renew --dry-run
```

### 3. Certificate Paths

- Cert: `/etc/letsencrypt/live/your-domain.de/fullchain.pem`
- Key: `/etc/letsencrypt/live/your-domain.de/privkey.pem`

Nginx config references these automatically.

---

## Systemd Services

### 1. Deploy Service Files

```bash
cp /var/www/manu-hosting/deployment/debian/systemd/*.service /etc/systemd/system/
systemctl daemon-reload
```

### 2. WebSocket Console Server

```bash
# Enable and start
systemctl enable --now manu-hosting-console

# Check status
systemctl status manu-hosting-console

# View logs
journalctl -u manu-hosting-console -f
```

### 3. Future Workers (when implemented)

```bash
# Background workers for:
# - Email queue processing
# - Scheduled tasks
# - Backup cleanup
# systemctl enable --now manu-hosting-worker-email
# systemctl enable --now manu-hosting-worker-backup
```

---

## Firewall (UFW)

```bash
# Default policies
ufw default deny incoming
ufw default allow outgoing

# Allow SSH (adjust port if changed)
ufw allow 22/tcp

# Allow HTTP/HTTPS
ufw allow 80/tcp
ufw allow 443/tcp

# Allow WebSocket console (if direct access needed)
# ufw allow 8080/tcp

# Allow Node API (from DL580 IP only - RECOMMENDED)
# ufw allow from DL580_IP to any port 8443 proto tcp

# Allow Node API (from anywhere - less secure)
ufw allow 8443/tcp

# Enable firewall
ufw enable

# Check status
ufw status verbose
```

### Restrict Node API to DL580 Only (Recommended)

```bash
# Replace DL580_IP with actual IP of your DL580
ufw delete allow 8443/tcp
ufw allow from DL580_IP to any port 8443 proto tcp comment "Manu Hosting Node API"
```

---

## Fail2Ban (Intrusion Prevention)

### 1. Install

```bash
apt install -y fail2ban
```

### 2. Configure

```bash
# Create local config
cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

# Edit jail.local
vim /etc/fail2ban/jail.local
```

### 3. Key Jails

```ini
[sshd]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log
maxretry = 3
bantime = 3600

[nginx-http-auth]
enabled = true
filter = nginx-http-auth
logpath = /var/log/nginx/error.log
maxretry = 3

[nginx-limit-req]
enabled = true
filter = nginx-limit-req
logpath = /var/log/nginx/error.log
maxretry = 5

[manu-hosting-login]
enabled = true
filter = manu-hosting-login
logpath = /var/www/manu-hosting/storage/logs/*.log
maxretry = 5
bantime = 1800
```

### 4. Custom Filter for Login

```bash
cat > /etc/fail2ban/filter.d/manu-hosting-login.conf << EOF
[Definition]
failregex = ^.*Login failed for .* from <HOST>.*$
ignoreregex =
EOF
```

### 5. Start Fail2Ban

```bash
systemctl enable --now fail2ban
fail2ban-client status
```

---

## Log Rotation

### 1. Application Logs

```bash
cat > /etc/logrotate.d/manu-hosting << EOF
/var/www/manu-hosting/storage/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 640 manu-hosting manu-hosting
    sharedscripts
    postrotate
        systemctl reload php8.2-fpm > /dev/null 2>&1 || true
    endscript
}
EOF
```

### 2. Nginx Logs (already configured by package)

```bash
# Check existing config
cat /etc/logrotate.d/nginx
```

---

## Monitoring & Maintenance

### 1. System Updates

```bash
# Configure unattended-upgrades for security updates
apt install -y unattended-upgrades apt-listchanges

# Configure
dpkg-reconfigure -plow unattended-upgrades

# Edit /etc/apt/apt.conf.d/50unattended-upgrades
# Uncomment: "${distro_id}:${distro_codename}-security";
```

### 2. Database Backup

```bash
# Create backup script
cat > /usr/local/bin/backup-manu-hosting-db << 'EOF'
#!/bin/bash
BACKUP_DIR="/var/backups/manu-hosting"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR

mysqldump -u manu_hosting -p'YOUR_DB_PASSWORD' manu_hosting | gzip > $BACKUP_DIR/manu_hosting_$DATE.sql.gz

# Keep last 30 days
find $BACKUP_DIR -name "manu_hosting_*.sql.gz" -mtime +30 -delete
EOF

chmod +x /usr/local/bin/backup-manu-hosting-db

# Add to crontab (daily at 3 AM)
echo "0 3 * * * root /usr/local/bin/backup-manu-hosting-db" >> /etc/crontab
```

### 3. Application Backup

```bash
# Backup application files (excluding vendor, storage/logs)
cat > /usr/local/bin/backup-manu-hosting-app << 'EOF'
#!/bin/bash
BACKUP_DIR="/var/backups/manu-hosting"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR

tar -czf $BACKUP_DIR/manu-hosting-app_$DATE.tar.gz \
    --exclude=vendor \
    --exclude=storage/logs \
    --exclude=node_modules \
    --exclude=.git \
    -C /var/www manu-hosting

find $BACKUP_DIR -name "manu-hosting-app_*.tar.gz" -mtime +30 -delete
EOF

chmod +x /usr/local/bin/backup-manu-hosting-app

# Weekly backup
echo "0 4 * * 0 root /usr/local/bin/backup-manu-hosting-app" >> /etc/crontab
```

---

## Security Hardening

### 1. SSH Hardening

```bash
# Edit SSH config
vim /etc/ssh/sshd_config

# Key settings:
# Port 2222 (change from default)
# PermitRootLogin no
# PasswordAuthentication no (use keys only)
# PubkeyAuthentication yes
# MaxAuthTries 3
# ClientAliveInterval 300
# ClientAliveCountMax 2

systemctl reload sshd
```

### 2. Kernel Parameters

```bash
cat > /etc/sysctl.d/99-manu-hosting.conf << EOF
# Network hardening
net.ipv4.tcp_syncookies = 1
net.ipv4.conf.all.rp_filter = 1
net.ipv4.conf.default.rp_filter = 1
net.ipv4.conf.all.accept_redirects = 0
net.ipv4.conf.default.accept_redirects = 0
net.ipv4.conf.all.send_redirects = 0
net.ipv4.icmp_echo_ignore_broadcasts = 1
net.ipv4.icmp_ignore_bogus_error_responses = 1

# IPv6
net.ipv6.conf.all.disable_ipv6 = 1
net.ipv6.conf.default.disable_ipv6 = 1
EOF

sysctl --system
```

### 3. Auditd (Optional)

```bash
apt install -y auditd audispd-plugins
systemctl enable --now auditd

# Add rules for important files
auditctl -w /var/www/manu-hosting/config/config.php -p wa -k config_changes
auditctl -w /etc/nginx/ -p wa -k nginx_changes
auditctl -w /etc/php/8.2/fpm/ -p wa -k php_changes
```

---

## Verification Checklist

After installation, verify:

- [ ] Nginx running and serving HTTPS
- [ ] PHP-FPM pool running (manu-hosting)
- [ ] MariaDB running, database accessible
- [ ] Application responds at https://your-domain.de
- [ ] Owner login works (Emanuel / Dreimuskletiere.com)
- [ ] SSL certificate valid (check with SSL Labs)
- [ ] WebSocket console connects (wss://your-domain.de/console/ws/)
- [ ] Node API accessible on port 8443
- [ ] Firewall rules active
- [ ] Fail2Ban running
- [ ] Log rotation configured
- [ ] Database backups scheduled
- [ ] System updates configured

---

## Troubleshooting

### Nginx won't start
```bash
nginx -t
journalctl -u nginx -n 50
```

### PHP-FPM errors
```bash
systemctl status php8.2-fpm
tail -f /var/log/php8.2-fpm.log
```

### Database connection fails
```bash
mysql -u manu_hosting -p -h localhost manu_hosting
# Check config.php credentials
```

### SSL certificate issues
```bash
certbot certificates
certbot renew --dry-run
nginx -t
```

### Permission denied
```bash
# Check file ownership
ls -la /var/www/manu-hosting/
# Should be owned by manu-hosting:manu-hosting
chown -R manu-hosting:manu-hosting /var/www/manu-hosting/storage
chown -R manu-hosting:manu-hosting /var/www/manu-hosting/public/assets
```

---

## Support

For issues, check:
- Nginx logs: `/var/log/nginx/`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`
- MariaDB logs: `/var/log/mysql/`
- Application logs: `/var/www/manu-hosting/storage/logs/`
- Systemd journal: `journalctl -u service-name`

Create a ticket in the Owner Dashboard -> Support for platform issues.
