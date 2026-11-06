# MANU HOSTING - IDLE SHUTDOWN SYSTEM

## Overview
Automatic Minecraft server shutdown after configurable idle time (default 60 seconds) to save resources on the Windows DL580 node.

## Architecture
- **IdleShutdownManager** (Windows Node Agent): Monitors player count via Bridge API
- **PlatformStatus** (Database): Global and per-server configuration
- **Bridge Plugin** (Paper/Purpur): Reports player join/quit events in real-time

## Configuration
- Global enable/disable
- Default idle timeout (60s, 120s, 300s, 600s, 900s, custom)
- Per-server override
- Per-package default
- Exclude specific servers

## Flow
1. Bridge detects player count = 0
2. Countdown starts (60s default)
3. If player joins during countdown → cancel
4. If countdown completes → graceful stop via RCON/console
5. Agent confirms process termination
6. Status updated to "idle_stopped"

## API Endpoints
- GET /api/v1/servers/{id}/idle-config
- PUT /api/v1/servers/{id}/idle-config
- GET /api/v1/settings/idle-shutdown
- PUT /api/v1/settings/idle-shutdown

## Dashboard
Owner Dashboard → Settings → Idle Shutdown Configuration
