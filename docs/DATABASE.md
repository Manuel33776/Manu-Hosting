# MANU HOSTING - DATABASE SCHEMA

## Overview
MariaDB database on Debian 13 Control Plane. All tables use InnoDB, utf8mb4, foreign keys.

## Tables

### users
- id (BIGINT PK)
- username (VARCHAR 50, UNIQUE)
- email (VARCHAR 255, UNIQUE)
- password_hash (VARCHAR 255) -- Argon2id
- role (ENUM: owner, admin, support, customer, subuser)
- status (ENUM: active, suspended, deleted)
- two_factor_secret (VARCHAR 100, nullable)
- two_factor_enabled (BOOLEAN)
- email_verified (BOOLEAN)
- email_verify_token (VARCHAR 100, nullable)
- password_reset_token (VARCHAR 100, nullable)
- password_reset_expires (DATETIME, nullable)
- last_login (DATETIME, nullable)
- last_login_ip (VARCHAR 45, nullable)
- created_at, updated_at

### nodes
- id (BIGINT PK)
- name (VARCHAR 100)
- host (VARCHAR 255) -- IP or hostname
- port (INT) -- Agent API port (default 8443)
- token (VARCHAR 255) -- Agent auth token
- status (ENUM: online, offline, maintenance, error)
- cpu_cores (INT)
- total_ram_mb (BIGINT)
- total_disk_gb (BIGINT)
- used_ram_mb (BIGINT)
- used_disk_gb (BIGINT)
- max_servers (INT)
- version (VARCHAR 50)
- last_heartbeat (DATETIME, nullable)
- created_at, updated_at

### servers
- id (BIGINT PK)
- uuid (CHAR 36, UNIQUE) -- Public identifier
- node_id (FK nodes.id)
- owner_id (FK users.id)
- package_id (FK packages.id, nullable)
- name (VARCHAR 100)
- minecraft_version (VARCHAR 50)
- software (ENUM: vanilla, paper, purpur, spigot, fabric, forge, neoforge, quilt, velocity, bungeecord, bedrock)
- java_version (VARCHAR 20)
- status (ENUM: installing, installed, starting, running, stopping, stopped, error, suspended, deleted)
- ram_mb (INT)
- cpu_limit (DECIMAL 4,2) -- CPU quota percentage
- disk_limit_mb (INT)
- port (INT)
- rcon_port (INT, nullable)
- rcon_password (VARCHAR 100, nullable)
- ip (VARCHAR 45)
- motd (TEXT)
- max_players (INT)
- auto_shutdown_enabled (BOOLEAN)
- auto_shutdown_timeout (INT) -- seconds
- install_progress (JSON)
- last_started_at (DATETIME, nullable)
- last_stopped_at (DATETIME, nullable)
- created_at, updated_at

### packages
- id (BIGINT PK)
- name (VARCHAR 100)
- description (TEXT)
- ram_mb (INT)
- cpu_limit (DECIMAL 4,2)
- disk_mb (INT)
- max_servers (INT)
- max_backups (INT)
- max_subusers (INT)
- allowed_software (JSON)
- allowed_versions (JSON)
- features (JSON) -- console, files, backups, schedule, inventory, anticheat
- price_monthly (DECIMAL 10,2)
- price_quarterly (DECIMAL 10,2)
- price_yearly (DECIMAL 10,2)
- is_active (BOOLEAN)
- sort_order (INT)
- created_at, updated_at

### orders
- id (BIGINT PK)
- order_number (VARCHAR 20, UNIQUE)
- customer_id (FK users.id)
- package_id (FK packages.id)
- node_id (FK nodes.id, nullable)
- server_id (FK servers.id, nullable)
- status (ENUM: draft, requested, pending, payment_pending, approved, provisioning, active, failed, cancelled, terminated)
- billing_cycle (ENUM: monthly, quarterly, yearly)
- amount (DECIMAL 10,2)
- currency (CHAR 3)
- payment_method (VARCHAR 50, nullable)
- payment_reference (VARCHAR 100, nullable)
- paid_at (DATETIME, nullable)
- provisioned_at (DATETIME, nullable)
- cancelled_at (DATETIME, nullable)
- notes (TEXT)
- created_at, updated_at

### tickets
- id (BIGINT PK)
- ticket_number (VARCHAR 20, UNIQUE)
- customer_id (FK users.id)
- assignee_id (FK users.id, nullable)
- subject (VARCHAR 255)
- status (ENUM: open, in_progress, waiting_customer, waiting_support, closed)
- priority (ENUM: low, normal, high, urgent)
- category (ENUM: technical, billing, general, abuse, other)
- created_at, updated_at, closed_at

### ticket_messages
- id (BIGINT PK)
- ticket_id (FK tickets.id)
- user_id (FK users.id)
- message (TEXT)
- is_internal (BOOLEAN)
- attachments (JSON)
- created_at

### backups
- id (BIGINT PK)
- server_id (FK servers.id)
- name (VARCHAR 255)
- path (VARCHAR 500)
- size_bytes (BIGINT)
- status (ENUM: creating, completed, failed, restoring, deleted)
- type (ENUM: manual, scheduled)
- includes_world (BOOLEAN)
- includes_plugins (BOOLEAN)
- includes_config (BOOLEAN)
- started_at, completed_at
- created_at

### platform_status
- id (BIGINT PK) -- Always 1
- wip_enabled (BOOLEAN)
- wip_title (VARCHAR 255)
- wip_message (TEXT)
- servers_offline_enabled (BOOLEAN)
- servers_offline_title (VARCHAR 255)
- servers_offline_message (TEXT)
- maintenance_enabled (BOOLEAN)
- maintenance_title (VARCHAR 255)
- maintenance_message (TEXT)
- maintenance_started_at (DATETIME, nullable)
- maintenance_planned_end (DATETIME, nullable)
- maintenance_ended_at (DATETIME, nullable)
- maintenance_owner_id (FK users.id, nullable)
- created_at, updated_at

### server_resources (time-series)
- id (BIGINT PK)
- server_id (FK servers.id)
- cpu_percent (DECIMAL 5,2)
- ram_used_mb (BIGINT)
- ram_max_mb (BIGINT)
- disk_used_mb (BIGINT)
- disk_read_mbps (DECIMAL 10,2)
- disk_write_mbps (DECIMAL 10,2)
- network_rx_mbps (DECIMAL 10,2)
- network_tx_mbps (DECIMAL 10,2)
- player_count (INT)
- tps (DECIMAL 4,2)
- recorded_at (DATETIME)
- INDEX: (server_id, recorded_at)

### server_commands
- id (BIGINT PK)
- server_id (FK servers.id)
- user_id (FK users.id)
- command (TEXT)
- status (ENUM: queued, sent, executed, failed)
- response (TEXT)
- created_at

### player_inventory
- id (BIGINT PK)
- server_id (FK servers.id)
- player_uuid (CHAR 36)
- player_name (VARCHAR 16)
- slot_type (ENUM: main, hotbar, armor, offhand, enderchest)
- slot_index (INT)
- item_id (VARCHAR 100)
- item_name (VARCHAR 255)
- amount (INT)
- durability (INT, nullable)
- enchantments (JSON)
- nbt_data (JSON)
- updated_at

### anticheat_alerts
- id (BIGINT PK)
- server_id (FK servers.id)
- player_uuid (CHAR 36)
- player_name (VARCHAR 16)
- alert_type (VARCHAR 50)
- severity (ENUM: suspicious, violation)
- description (TEXT)
- evidence (JSON)
- inventory_snapshot (JSON)
- status (ENUM: new, reviewing, dismissed, confirmed)
- reviewed_by (FK users.id, nullable)
- reviewed_at (DATETIME, nullable)
- created_at

### audit_logs
- id (BIGINT PK)
- user_id (FK users.id, nullable)
- action (VARCHAR 100)
- resource_type (VARCHAR 50)
- resource_id (VARCHAR 100, nullable)
- old_values (JSON)
- new_values (JSON)
- ip_address (VARCHAR 45)
- user_agent (TEXT)
- created_at
- INDEX: (user_id, created_at), (resource_type, resource_id)

### rate_limits
- id (BIGINT PK)
- identifier (VARCHAR 255) -- IP or user_id
- endpoint (VARCHAR 255)
- requests (INT)
- window_start (DATETIME)
- UNIQUE: (identifier, endpoint, window_start)

### sessions
- id (VARCHAR 128 PK)
- user_id (FK users.id)
- data (TEXT)
- expires_at (DATETIME)
- created_at

### console_tokens
- id (BIGINT PK)
- server_id (FK servers.id)
- token (VARCHAR 64, UNIQUE)
- user_id (FK users.id)
- expires_at (DATETIME)
- created_at
