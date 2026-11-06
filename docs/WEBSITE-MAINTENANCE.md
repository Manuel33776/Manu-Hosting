# MANU HOSTING - WEBSITE MAINTENANCE & OFFLINE MODE

## Overview
Owner-controlled maintenance mode that takes the public website offline while keeping admin/owner panels accessible.

## Features
- **Instant Toggle**: Immediate offline/online switch
- **Scheduled Maintenance**: Plan start/end times (Europe/Berlin)
- **Custom Message**: Editable title and description
- **Persistent Timer**: Offline duration stored in MariaDB, survives reboots
- **Countdown Display**: If end time set, shows time until recovery
- **Access Preservation**: Owner/Admin/Customer panels remain accessible

## Database Schema
Table: `platform_status`
- `maintenance_enabled` (boolean)
- `maintenance_message` (text)
- `maintenance_title` (varchar)
- `maintenance_started_at` (datetime, nullable)
- `maintenance_planned_end` (datetime, nullable)
- `maintenance_ended_at` (datetime, nullable)
- `maintenance_owner_id` (FK users)

## Timer Logic
- Starts when `maintenance_enabled` = true
- Calculated: `NOW() - maintenance_started_at`
- Persisted in DB, not memory
- Survives Debian restart, PHP-FPM reload, Nginx reload

## Frontend
- Public pages show maintenance page with:
  - Logo, Title, Message
  - "OFFLINE SINCE: HH:MM:SS" (live updating)
  - "ESTIMATED RECOVERY: HH:MM:SS" (if planned_end set)
- Owner Dashboard → Maintenance: Full control UI

## API Endpoints
- GET /api/v1/platform/status (public - returns maintenance state)
- GET /api/v1/owner/maintenance (owner - full config)
- PUT /api/v1/owner/maintenance (owner - update config)
- POST /api/v1/owner/maintenance/toggle (owner - quick toggle)

## Nginx Integration
- Maintenance check in PHP (not Nginx) to preserve API/Admin access
- Returns 503 for public routes only
- Retry-After header when planned_end known
