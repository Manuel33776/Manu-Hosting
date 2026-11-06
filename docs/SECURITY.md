# MANU HOSTING - SECURITY CONCEPT

## Threat Model (STRIDE)
- **Spoofing**: Argon2id passwords, JWT/API tokens, mTLS for Node Agent
- **Tampering**: CSRF tokens, signed requests, audit logs
- **Repudiation**: Comprehensive audit logging (all actions)
- **Information Disclosure**: Rate limiting, RBAC, data minimization
- **Denial of Service**: Rate limits, connection limits, resource quotas
- **Elevation of Privilege**: Role-based access, Owner-only admin creation

## Authentication
- **Password Hashing**: Argon2id (memory-hard, configurable cost)
- **Sessions**: HTTP-only, Secure, SameSite=Strict cookies
- **Session Rotation**: Regenerate ID on login, privilege change
- **2FA**: TOTP (optional, Owner/Admin)
- **API Tokens**: Short-lived JWT + long-lived refresh tokens

## Authorization (RBAC)
Roles: Owner > Administrator > Support > Customer > Subuser
Permissions: Granular (e.g., `server.start`, `admin.users.manage`)

## Network Security
- **Debian**: UFW (SSH from admin IPs, HTTP/HTTPS, Monitoring, VPN)
- **Windows**: Windows Firewall (SSH from Debian, Game ports, Agent API, Monitoring)
- **Inter-server**: WireGuard VPN or mTLS HTTPS
- **Fail2Ban**: SSH, Nginx, API brute-force protection

## Application Security
- **SQL Injection**: PDO Prepared Statements only
- **XSS**: Output encoding, CSP headers, HttpOnly cookies
- **CSRF**: Per-session tokens, double-submit cookie pattern
- **Path Traversal**: `realpath()` validation, chroot to server directory
- **File Upload**: Type validation, size limits, quarantine scan
- **Rate Limiting**: Per-IP, per-user, per-endpoint (sliding window)

## Infrastructure
- **Debian**: Unattended security updates, SSH key-only, no root login
- **Windows**: Minimal services, dedicated service accounts, ACLs
- **Database**: Least-privilege users, SSL connections, encrypted backups
- **Secrets**: Environment files (not in Git), .env.example template

## Minecraft-Specific
- **Plugin Isolation**: Separate users, process limits, Job Objects
- **Bridge Auth**: Per-server tokens, rotated periodically
- **Console Access**: Token-based, scoped to single server
- **Anti-Cheat Data**: Encrypted at rest, minimal retention

## Incident Response
- Audit log search/filter
- Automated alerts (failed logins, privilege changes, anomalies)
- Backup verification schedule
- Rollback procedures documented
