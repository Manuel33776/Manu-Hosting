# MANU HOSTING - OWNER DASHBOARD

## Overview
Exclusive control panel for the platform Owner (Emanuel). Provides complete administrative control over the entire hosting platform.

## Navigation Sections
1. **Dashboard** - System overview, statistics, health status
2. **Server Management** - All servers with full control
3. **Customer Management** - All customers, roles, status
4. **Administrator Management** - Create/manage admins (Owner only)
5. **Package Management** - Hosting packages configuration
6. **Node Management** - Windows DL580 node control
7. **Resource Overview** - CPU, RAM, Disk, Network metrics
8. **Website & Maintenance** - Public site control, offline timer
9. **Email Configuration** - SMTP settings, test sending
10. **Live Inventory** - Player inventory monitoring
11. **Anti-Cheat Monitor** - Cheat detection alerts
12. **Backups** - Backup management across all servers
13. **Support Tickets** - All tickets overview
14. **Orders** - Order management and provisioning
15. **Audit Logs** - Full platform audit trail
16. **Platform Settings** - Global configuration

## Key Features
- **Server Actions**: Start, Stop, Restart, Suspend, Delete, Resource Change
- **Admin Creation**: Only Owner can create admin accounts with granular permissions
- **Maintenance Mode**: Toggle public site offline with persistent timer
- **Idle Shutdown Config**: Global and per-server/package settings
- **Real-time Metrics**: WebSocket updates from Node Agent

## Access Control
- Route prefix: `/owner/*`
- Middleware: `owner` role required
- Session-based authentication
- CSRF protection on all forms

## API Integration
All dashboard data fetched via REST API:
- `/api/v1/owner/*` - Owner-only endpoints
- WebSocket: `/ws/console/{serverId}` for live console
