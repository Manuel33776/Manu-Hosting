# MANU HOSTING - TROUBLESHOOTING GUIDE

## Control Plane (Debian 13) Issues

### Website Not Loading
1. Check Nginx: `systemctl status nginx`
2. Check PHP-FPM: `systemctl status php8.3-fpm`
3. Check logs: `tail -f /var/log/nginx/error.log`
4. Check PHP logs: `tail -f /var/log/php8.3-fpm.log`
5. Verify config: `nginx -t && php-fpm8.3 -t`

### Database Connection Failed
1. Check MariaDB: `systemctl status mariadb`
2. Check credentials in `.env`
3. Test: `mysql -u manu_app -p -h 127.0.0.1 manu_hosting`
4. Check max_connections: `SHOW VARIABLES LIKE "max_connections"`

### API Returns 500
1. Check application logs: `tail -f /var/log/manu-hosting/app.log`
2. Enable debug: `APP_DEBUG=true` in .env (temporary)
3. Check PHP error log
4. Verify migrations ran: `php /opt/manu-hosting/current/bin/migrate.php`

### Node Agent Not Connecting
1. Check agent service: Windows Services
2. Check firewall: UFW (Debian) / Windows Firewall
3. Check VPN: `wg show` or ping test
4. Verify token matches in DB and agent config
5. Check agent logs: `C:\ManuHosting\logs\agent.log`

## Node (Windows DL580) Issues

### Minecraft Server Won't Start
1. Check Java: `java -version` (must be 17+ for 1.18+, 21+ for 1.20.4+)
2. Check port available: `netstat -an | findstr :25565`
3. Check EULA: `eula.txt` contains `eula=true`
3. Check memory: `-Xmx` <= available RAM
4. Check logs: `D:\ManuHosting\servers\server-{id}\logs\latest.log`

### Server Crashes / OutOfMemoryError
1. Increase `-Xmx` in server config (up to package limit)
2. Check JVM flags: `-XX:+UseG1GC -XX:MaxGCPauseMillis=50`
3. Check for memory leaks in plugins
4. Analyze heap dump: `-XX:+HeapDumpOnOutOfMemoryError`

### High CPU / Lag
1. Check TPS: `/manubridge status` or Bridge API
2. Profile: Spark / WarmRoast (if installed)
3. Check entity count: `/manubridge status`
4. Reduce view-distance, entity-activation-range in spigot.yml
5. Limit redstone, hoppers, farms via Paper config

### Port Conflicts
- Game ports: 25565-25665 (configurable per server)
- RCON: 25575+ (offset from game port)
- Agent API: 8443 (HTTPS)
- Ensure Windows Firewall allows these

### Agent Service Won't Start
1. Run manually: `dotnet C:\ManuHosting\agent\current\ManuHostingAgent.dll`
2. Check .NET 8 installed: `dotnet --version`
3. Check config: `C:\ManuHosting\agent\current\appsettings.json`
4. Check logs: Event Viewer Applications ManuHostingAgent

## Bridge Plugin Issues

### Plugin Not Loading
1. Check version: Paper/Purpur 1.20.4+ required
2. Check logs: `plugins/ManuHostingBridge/logs/latest.log`
3. Verify JAR in `plugins/` folder
4. Check dependencies: Gson (shaded)

### Inventory Not Updating
1. Check Bridge config: `server_id` matches DB
2. Check API connectivity: `/manubridge test`
3. Verify event registration: PlayerJoin, PlayerQuit, InventoryClick
4. Check thread safety: All API calls via `runTaskAsynchronously`

### Anti-Cheat False Positives
1. Review alert in Owner Dashboard
2. Check custom items/mods whitelist
3. Adjust thresholds in config.yml
4. Add exception for known plugin items

## Network Issues

### Inter-Server Communication Failed
1. Test VPN: `ping <other-server-vpn-ip>`
2. Test API: `curl -k https://control-plane/api/v1/node/heartbeat`
3. Check certificates: `openssl verify -CAfile ca.pem node.pem`
4. Check firewall rules on both sides

### WebSocket Console Not Connecting
1. Check Nginx proxy: `proxy_pass http://127.0.0.1:8080;`
2. Check upgrade headers: `proxy_set_header Upgrade $http_upgrade;`
3. Verify token valid: Not expired, correct server
4. Browser console: Check for CORS/WS errors

## Performance Tuning

### Database Slow Queries
1. Enable slow query log: `slow_query_log=1, long_query_time=2`
2. Analyze: `mysqldumpslow /var/log/mysql/slow.log`
3. Add indexes: Check `EXPLAIN` on slow queries
4. Partition: `audit_logs`, `server_resources` by month

### High Memory Usage
- PHP-FPM: `pm.max_children` based on RAM
- MariaDB: `innodb_buffer_pool_size` = 70% RAM
- Node Agent: Limit concurrent operations

## Emergency Contacts
- Owner: Emanuel (Dreimuskletiere.com)
- Server Provider: HP ProLiant DL580 support
- Domain/DNS: Registrar support
- SSL: Lets Encrypt / Certbot logs
