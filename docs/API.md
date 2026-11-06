# MANU HOSTING - REST API SPECIFICATION

## Base URL
- Production: `https://manu-hosting.de/api/v1`
- Development: `http://localhost/api/v1`

## Authentication
- **Web**: Session cookie (HttpOnly, Secure, SameSite=Strict)
- **API**: Bearer Token (JWT) or API Key
- **Node Agent**: mTLS + Node Token (per-node)

## Headers
```
Content-Type: application/json
Accept: application/json
X-CSRF-Token: <token>  -- Required for state-changing requests
Authorization: Bearer <jwt>  -- For API clients
X-Node-Token: <token>  -- For Node Agent
```

## Rate Limiting
- Default: 60 req/min per IP
- Auth: 10 req/min per IP
- Heavy endpoints: 5 req/min per user

## Error Format
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Human readable message",
    "details": {}
  }
}
```

## Success Format
```json
{
  "success": true,
  "data": {}
}
```

## Endpoints

### Authentication
- POST `/auth/register` - Register customer
- POST `/auth/login` - Login
- POST `/auth/logout` - Logout
- POST `/auth/forgot-password` - Request reset
- POST `/auth/reset-password` - Reset password
- POST `/auth/verify-email` - Verify email
- GET `/auth/me` - Current user
- PUT `/auth/me` - Update profile
- PUT `/auth/password` - Change password

### Owner Endpoints (/owner)
- GET `/owner/dashboard/stats` - Platform statistics
- GET `/owner/servers` - All servers (filter, paginate)
- GET `/owner/servers/{id}` - Server detail
- POST `/owner/servers/{id}/start` - Start server
- POST `/owner/servers/{id}/stop` - Stop server
- POST `/owner/servers/{id}/restart` - Restart server
- POST `/owner/servers/{id}/suspend` - Suspend server
- POST `/owner/servers/{id}/unsuspend` - Unsuspend server
- DELETE `/owner/servers/{id}` - Delete server
- PUT `/owner/servers/{id}/resources` - Change resources
- GET `/owner/customers` - All customers
- GET `/owner/customers/{id}` - Customer detail
- PUT `/owner/customers/{id}/status` - Update status
- POST `/owner/admins` - Create admin (Owner only)
- GET `/owner/admins` - List admins
- PUT `/owner/admins/{id}` - Update admin
- DELETE `/owner/admins/{id}` - Delete admin
- GET `/owner/packages` - List packages
- POST `/owner/packages` - Create package
- PUT `/owner/packages/{id}` - Update package
- DELETE `/owner/packages/{id}` - Delete package
- GET `/owner/nodes` - List nodes
- POST `/owner/nodes` - Register node
- PUT `/owner/nodes/{id}` - Update node
- POST `/owner/nodes/{id}/test` - Test connection
- DELETE `/owner/nodes/{id}` - Delete node
- GET `/owner/resources` - System resources
- GET `/owner/maintenance` - Maintenance config
- PUT `/owner/maintenance` - Update maintenance
- POST `/owner/maintenance/toggle` - Toggle maintenance
- GET `/owner/email` - Email config
- PUT `/owner/email` - Update email config
- POST `/owner/email/test` - Test email
- GET `/owner/inventory` - Live inventory
- GET `/owner/anticheat` - Anti-cheat alerts
- GET `/owner/backups` - All backups
- GET `/owner/tickets` - All tickets
- GET `/owner/orders` - All orders
- PUT `/owner/orders/{id}/status` - Update order status
- GET `/owner/audit-logs` - Audit logs
- GET `/owner/settings` - Platform settings
- PUT `/owner/settings` - Update settings

### Admin Endpoints (/admin)
- GET `/admin/dashboard/stats` - Assigned stats
- GET `/admin/users` - Assigned customers
- GET `/admin/servers` - Assigned servers
- POST `/admin/servers/{id}/start` - Start server
- POST `/admin/servers/{id}/stop` - Stop server
- POST `/admin/servers/{id}/restart` - Restart server
- GET `/admin/nodes` - View nodes
- GET `/admin/packages` - View packages
- GET `/admin/tickets` - Assigned tickets
- POST `/admin/tickets/{id}/reply` - Reply to ticket
- PUT `/admin/tickets/{id}/status` - Update ticket status
- GET `/admin/platform` - Platform status (read-only)
- GET `/admin/audit-logs` - Audit logs (read-only)

### Customer Endpoints (/customer)
- GET `/customer/dashboard` - Own dashboard
- GET `/customer/servers` - Own servers
- GET `/customer/servers/{id}` - Server detail
- POST `/customer/servers/{id}/start` - Start server
- POST `/customer/servers/{id}/stop` - Stop server
- POST `/customer/servers/{id}/restart` - Restart server
- GET `/customer/servers/{id}/console` - Console token
- WS `/ws/console/{serverId}` - Live console
- GET `/customer/servers/{id}/logs` - Logs
- GET `/customer/servers/{id}/players` - Players
- POST `/customer/servers/{id}/players/{uuid}/kick` - Kick player
- POST `/customer/servers/{id}/players/{uuid}/ban` - Ban player
- GET `/customer/servers/{id}/ops` - OP list
- POST `/customer/servers/{id}/ops` - Add OP
- DELETE `/customer/servers/{id}/ops/{uuid}` - Remove OP
- GET `/customer/servers/{id}/files` - File tree
- GET `/customer/servers/{id}/files/content` - File content
- PUT `/customer/servers/{id}/files/content` - Save file
- POST `/customer/servers/{id}/files/upload` - Upload file
- GET `/customer/servers/{id}/backups` - Backups
- POST `/customer/servers/{id}/backups` - Create backup
- POST `/customer/servers/{id}/backups/{backupId}/restore` - Restore
- GET `/customer/servers/{id}/schedule` - Scheduled tasks
- POST `/customer/servers/{id}/schedule` - Create task
- PUT `/customer/servers/{id}/schedule/{taskId}` - Update task
- DELETE `/customer/servers/{id}/schedule/{taskId}` - Delete task
- GET `/customer/servers/{id}/settings` - Server settings
- PUT `/customer/servers/{id}/settings` - Update settings

### Node Agent Endpoints (/node)
- POST `/node/heartbeat` - Heartbeat + metrics
- GET `/node/commands` - Poll pending commands
- POST `/node/commands/{id}/result` - Submit result
- POST `/node/servers/{id}/status` - Update server status
- POST `/node/servers/{id}/resources` - Update resources
- POST `/node/servers/{id}/player-event` - Player join/quit
- POST `/node/servers/{id}/inventory` - Inventory update
- POST `/node/servers/{id}/anticheat` - Anti-cheat alert

### Public
- GET `/status` - Platform status (maintenance, WIP, offline)
- GET `/packages` - Public packages list

## WebSocket Console
- Connect: `wss://manu-hosting.de/ws/console/{serverId}?token=<console_token>`
- Messages:
  - `{ "type": "command", "payload": "say Hello" }`
  - `{ "type": "resize", "payload": { "cols": 80, "rows": 24 } }`
- Server pushes:
  - `{ "type": "output", "payload": "[Server] Hello" }`
  - `{ "type": "status", "payload": "running" }`
  - `{ "type": "error", "payload": "Connection lost" }`
