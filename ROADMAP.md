# MANU HOSTING - ROADMAP

## Vision

Build a professional, commercially-viable Minecraft hosting platform that can be operated by a single person or a small team, with the ability to scale to multiple nodes and hundreds of customers.

---

## Version 1.0 - "Foundation" (Current - Q4 2026)

**Goal**: Fully functional hosting platform on two servers (Debian + Windows DL580)

### Core Platform ✅
- [x] Two-server architecture (Debian Control Plane + Windows Node)
- [x] Owner/Customer/Admin dashboards
- [x] Server lifecycle management (create, start, stop, restart, delete)
- [x] Live console (WebSocket)
- [x] File manager
- [x] Backup system
- [x] Task scheduler
- [x] Idle shutdown (60s default, configurable)
- [x] Minecraft Bridge plugin (Paper/Purpur)
- [x] Windows Node Agent (.NET 8)
- [x] Public website with legal pages
- [x] Maintenance modes (WIP, Server Offline, Maintenance + timer)

### Infrastructure ✅
- [x] Nginx + PHP-FPM + MariaDB on Debian
- [x] Windows Service for Node Agent
- [x] Firewall rules (UFW + Windows Firewall)
- [x] Systemd services
- [x] Database migrations & seeder

### To Complete for v1.0
- [ ] Build & test Windows Agent on DL580
- [ ] Build & test Bridge plugin
- [ ] Deploy to test servers
- [ ] Integration testing
- [ ] SSL certificates (Let's Encrypt)
- [ ] Complete documentation
- [ ] Security audit

---

## Version 1.1 - "Operations" (Q1 2027)

**Goal**: Production-hardened operations and monitoring

### Monitoring & Alerting
- [ ] Prometheus metrics endpoint (Debian + Windows)
- [ ] Grafana dashboards (system, Minecraft, business)
- [ ] Alertmanager rules (node down, disk full, server crash, OOM)
- [ ] Uptime monitoring (status page integration)
- [ ] Log aggregation (Loki or Elasticsearch)

### Backup & Disaster Recovery
- [ ] Automated off-site backup (S3-compatible / rsync)
- [ ] Backup encryption (age/gpg)
- [ ] Point-in-time recovery testing
- [ ] Cross-node backup replication
- [ ] Disaster recovery runbook

### Email & Notifications
- [ ] SMTP queue with retry/backoff
- [ ] Template system (Twig or similar)
- [ ] Notification channels (Email, Discord webhook, Telegram, Slack)
- [ ] Per-user notification preferences
- [ ] Digest emails (daily/weekly summaries)

### Platform Operations
- [ ] Automated Debian updates (unattended-upgrades + reboot handling)
- [ ] Windows Update management (WSUS or policy)
- [ ] Agent auto-update (check on startup, staged rollout)
- [ ] Bridge plugin auto-update (via control plane)
- [ ] Maintenance windows (scheduled, with customer notification)

---

## Version 1.2 - "Commercial" (Q2 2027)

**Goal**: Ready for paying customers

### Billing & Orders
- [ ] Payment integration (Stripe, PayPal, Mollie)
- [ ] Subscription management (recurring, proration, cancellation)
- [ ] Invoice generation (PDF, sequential numbers, EU VAT)
- [ ] Payment webhooks (async processing, idempotency)
- [ ] Coupon/discount system
- [ ] Affiliate/referral program
- [ ] Usage-based billing (overage charges)

### Customer Experience
- [ ] Client area redesign (modern, mobile-first)
- [ ] Server installation progress (real-time WebSocket updates)
- [ ] One-click modpack installation (CurseForge, Modrinth, FTB)
- [ ] Server templates (pre-configured setups)
- [ ] Sub-user management (permissions per server)
- [ ] API access for customers (read-only + console)
- [ ] Two-factor authentication (TOTP)

### Resource Management
- [ ] Dynamic resource allocation (burstable CPU/RAM)
- [ ] Node auto-scaling (add/remove DL580s based on demand)
- [ ] Server migration between nodes (live migration)
- [ ] DDoS protection integration (Cloudflare Spectrum, TCPShield)
- [ ] IPv6 support

---

## Version 1.3 - "Scale" (Q3 2027)

**Goal**: Multi-node, high availability, enterprise features

### Multi-Node Architecture
- [ ] Node groups (location, tier, hardware type)
- [ ] Intelligent scheduling (bin packing, affinity, anti-affinity)
- [ ] Cross-node networking (WireGuard mesh)
- [ ] Load balancer integration (HAProxy, NGINX Plus)
- [ ] Geo-distributed deployments

### High Availability
- [ ] Control plane HA (multiple Debian servers, Galera cluster)
- [ ] Database clustering (MariaDB Galera)
- [ ] Session replication (Redis)
- [ ] Automated failover (Patroni or custom)
- [ ] Zero-downtime deployments

### Enterprise Features
- [ ] SSO/SAML/OIDC integration
- [ ] Audit logging (immutable, exportable)
- [ ] Compliance reports (GDPR, SOC2 prep)
- [ ] Custom branding (white-label)
- [ ] Reseller/partner portal
- [ ] SLA management & reporting

---

## Version 2.0 - "Platform" (Q4 2027+)

**Goal**: Extensible platform for game hosting beyond Minecraft

### Plugin Architecture
- [ ] Official plugin SDK (PHP + JavaScript)
- [ ] Marketplace for extensions
- [ ] Game server abstraction layer
- [ ] Support for other games (Valheim, Terraria, Rust, CS2, etc.)
- [ ] Docker support (optional, for isolation-heavy games)

### Advanced Features
- [ ] AI-powered anomaly detection (resource usage, player behavior)
- [ ] Predictive scaling (ML-based demand forecasting)
- [ ] Custom control panels per game type
- [ ] Integrated game panel marketplace

---

## Technical Debt & Refactoring (Ongoing)

- [ ] PHPStan Level 8+ static analysis
- [ ] PHPUnit 90%+ coverage
- [ ] C# nullable reference types strict
- [ ] Automated dependency updates (Dependabot/Renovate)
- [ ] Container images for CI/CD (build only, not runtime)
- [ ] API versioning strategy
- [ ] Database migration safety (no destructive changes)

---

## Milestone Dates (Target)

| Version | Target Date | Key Deliverable |
|---------|-------------|-----------------|
| 1.0 | 2026-12-15 | Working platform on two servers |
| 1.1 | 2027-03-15 | Production monitoring & backup |
| 1.2 | 2027-06-15 | Payment integration, customer ready |
| 1.3 | 2027-09-15 | Multi-node, HA, enterprise |
| 2.0 | 2027-12-15 | Multi-game platform |

---

## Decision Log

| Date | Decision | Rationale |
|------|----------|-----------|
| 2026-11 | No Docker/Containers | Simplicity, control, transferability |
| 2026-11 | Windows on DL580 | Hardware constraint, Windows-only apps |
| 2026-11 | .NET 8 for Agent | Cross-platform, performance, Windows Service support |
| 2026-11 | Ratchet for WebSocket | Pure PHP, no Node.js dependency |
| 2026-11 | Vanilla JS (no framework) | Zero build step, minimal dependencies |
| 2026-11 | MariaDB over PostgreSQL | Team familiarity, JSON support, performance |
| 2026-11 | Argon2id over bcrypt | Modern, memory-hard, PHP native support |

---

*Roadmap is reviewed and updated monthly. Priorities may shift based on business needs and technical discoveries.*
