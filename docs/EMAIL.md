# MANU HOSTING - EMAIL SYSTEM

## Overview
SMTP-based email system for transactional and notification emails. Configured via Owner Dashboard, credentials stored securely.

## Configuration (Owner Dashboard → Email)
- **SMTP Host**: e.g., `smtp.mailgun.org`, `smtp.sendgrid.net`, `mail.manu-hosting.de`
- **SMTP Port**: 587 (STARTTLS) or 465 (SSL/TLS) or 25 (plain - not recommended)
- **Username**: SMTP username
- **Password**: SMTP password (encrypted at rest)
- **From Address**: `noreply@manu-hosting.de`
- **From Name**: `Manu Hosting`
- **Reply-To**: `support@manu-hosting.de` (optional)
- **TLS**: Required (STARTTLS or implicit TLS)
- **Authentication**: PLAIN/LOGIN

## Email Templates

### 1. Account Verification
- **Trigger**: User registration
- **Subject**: `Bestätige deine E-Mail-Adresse bei Manu Hosting`
- **Template**: `emails/verify-email.html`
- **Variables**: `{{name}}`, `{{verify_url}}`, `{{expires_hours}}`

### 2. Password Reset
- **Trigger**: Forgot password request
- **Subject**: `Passwort zurücksetzen - Manu Hosting`
- **Template**: `emails/reset-password.html`
- **Variables**: `{{name}}`, `{{reset_url}}`, `{{expires_hours}}`, `{{ip}}`

### 3. Welcome / Account Created
- **Trigger**: Admin creates customer account
- **Subject**: `Willkommen bei Manu Hosting - Deine Zugangsdaten`
- **Template**: `emails/welcome.html`
- **Variables**: `{{name}}`, `{{login_url}}`, `{{temp_password}}`, `{{support_email}}`

### 4. Server Installation Complete
- **Trigger**: Provisioning finished successfully
- **Subject**: `Dein Minecraft-Server ist bereit!`
- **Template**: `emails/server-ready.html`
- **Variables**: `{{server_name}}`, `{{server_ip}}`, `{{server_port}}`, `{{panel_url}}`, `{{software}}`, `{{version}}`

### 5. Server Installation Failed
- **Trigger**: Provisioning error
- **Subject**: `Fehler bei der Server-Installation`
- **Template**: `emails/server-failed.html`
- **Variables**: `{{server_name}}`, `{{error_message}}`, `{{support_ticket_url}}`

### 6. Server Crash / Offline Alert
- **Trigger**: Node Agent detects crash (not graceful stop)
- **Subject**: `[ALERT] Server {{server_name}} ist abgestürzt`
- **Template**: `emails/server-crash.html`
- **Variables**: `{{server_name}}`, `{{server_id}}`, `{{crash_time}}`, `{{log_excerpt}}`, `{{panel_url}}`

### 7. Backup Completed
- **Trigger**: Scheduled or manual backup finished
- **Subject**: `Backup für {{server_name}} abgeschlossen`
- **Template**: `emails/backup-complete.html`
- **Variables**: `{{server_name}}`, `{{backup_name}}`, `{{size}}`, `{{duration}}`, `{{download_url}}`

### 8. Backup Failed
- **Trigger**: Backup process error
- **Subject**: `[WARNUNG] Backup für {{server_name}} fehlgeschlagen`
- **Template**: `emails/backup-failed.html`
- **Variables**: `{{server_name}}`, `{{error_message}}`, `{{retry_url}}`

### 9. Scheduled Maintenance
- **Trigger**: Owner schedules maintenance (24h before)
- **Subject**: `Geplante Wartung am {{date}} - Manu Hosting`
- **Template**: `emails/maintenance-scheduled.html`
- **Variables**: `{{start_time}}`, `{{end_time}}`, `{{message}}`, `{{affected_services}}`

### 10. Maintenance Started
- **Trigger**: Maintenance mode activated
- **Subject**: `Wartung begonnen - Manu Hosting ist vorübergehend offline`
- **Template**: `emails/maintenance-started.html`
- **Variables**: `{{message}}`, `{{estimated_end}}`

### 11. Ticket Reply
- **Trigger**: Admin/Support replies to ticket
- **Subject**: `Antwort auf dein Ticket #{{ticket_number}}: {{subject}}`
- **Template**: `emails/ticket-reply.html`
- **Variables**: `{{ticket_number}}`, `{{subject}}`, `{{message}}`, `{{ticket_url}}`

### 12. Order Confirmation
- **Trigger**: Order placed (payment pending)
- **Subject**: `Bestellbestätigung #{{order_number}} - Manu Hosting`
- **Template**: `emails/order-confirmation.html`
- **Variables**: `{{order_number}}`, `{{package_name}}`, `{{billing_cycle}}`, `{{amount}}`, `{{payment_url}}`

### 13. Invoice / Payment Received
- **Trigger**: Payment confirmed
- **Subject**: `Rechnung #{{invoice_number}} - Zahlung erhalten`
- **Template**: `emails/invoice.html`
- **Variables**: `{{invoice_number}}`, `{{amount}}`, `{{date}}`, `{{pdf_url}}`

## Queue System
- **Table**: `email_queue` (id, to, subject, body_html, body_text, priority, attempts, status, scheduled_at, sent_at, error)
- **Worker**: systemd timer every minute (`php bin/email-worker.php`)
- **Retry**: Exponential backoff (1m, 5m, 15m, 1h, 6h, 24h) max 5 attempts
- **Priority**: high (alerts, resets) → normal (notifications) → low (newsletters)

## Security
- Passwords encrypted with `APP_KEY` (AES-256-GCM)
- TLS certificate verification enforced
- Rate limit: 10 emails/min per user, 100/hour per domain
- Bounce/complaint handling (webhook from provider)
- Unsubscribe header (List-Unsubscribe) for marketing

## Testing
- Owner Dashboard: "Test Email" button → sends to configured address
- Preview: Render template with sample data
- Logs: `/var/log/manu-hosting/email.log` (success, failure, bounce)

## Providers (Recommended)
- **Transactional**: Mailgun, SendGrid, Postmark, Amazon SES
- **Self-hosted**: Postal, Mailcow, Docker-Mailserver (on separate VPS)
- **Enterprise**: Microsoft 365, Google Workspace (SMTP relay)
