<?php
// Owner Dashboard - Platform Settings
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen - Owner Dashboard - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="/owner" class="logo">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="url(#grad)"/>
                        <path d="M8 16L14 22L24 10" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="grad" x1="0" y1="0" x2="32" y2="32">
                                <stop offset="0%" stop-color="#8B5CF6"/>
                                <stop offset="100%" stop-color="#3B82F6"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="logo-text">Manu Hosting</span>
                    <span class="badge badge-primary" style="font-size: 10px; padding: 2px 6px;">Owner</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-section">Ãœbersicht</li>
                    <li><a href="/owner" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><span>Dashboard</span></a></li>
                    <li class="nav-section">Server & Kunden</li>
                    <li><a href="/owner/servers" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg><span>Server</span></a></li>
                    <li><a href="/owner/customers" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Kunden</span></a></li>
                    <li><a href="/owner/admins" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg><span>Administratoren</span></a></li>
                    <li class="nav-section">Hosting</li>
                    <li><a href="/owner/packages" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg><span>Pakete</span></a></li>
                    <li><a href="/owner/nodes" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Nodes</span></a></li>
                    <li><a href="/owner/resources" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><span>Ressourcen</span></a></li>
                    <li class="nav-section">System</li>
                    <li><a href="/owner/maintenance" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Wartung & Offline</span></a></li>
                    <li><a href="/owner/email" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span>E-Mail Config</span></a></li>
                    <li><a href="/owner/inventory" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L12 2L4 6L4 18L12 22L20 18L20 6Z"/></svg><span>Live Inventory</span></a></li>
                    <li><a href="/owner/anticheat" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/><path d="M12 6V12L16 14"/></svg><span>Anti-Cheat</span></a></li>
                    <li><a href="/owner/backups" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg><span>Backups</span></a></li>
                    <li><a href="/owner/support" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Support</span></a></li>
                    <li><a href="/owner/orders" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg><span>Bestellungen</span></a></li>
                    <li><a href="/owner/audit-logs" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg><span>Audit-Logs</span></a></li>
                    <li><a href="/owner/settings" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg><span>Einstellungen</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">E</div>
                    <div class="user-details">
                        <span class="user-name">Emanuel</span>
                        <span class="user-role">Owner</span>
                    </div>
                </div>
                <a href="/logout" class="btn btn-secondary btn-sm btn-block">Abmelden</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Sidebar umschalten">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="page-title">Plattform-Einstellungen</h1>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Allgemeine Einstellungen</h2>
                    </div>
                    <div class="card-body">
                        <form id="generalSettingsForm" class="settings-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="site_name">Seitenname</label>
                                    <input type="text" id="site_name" name="site_name" class="form-input" value="<?php echo htmlspecialchars($config['app']['name'] ?? 'Manu Hosting'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="site_url">Seiten-URL</label>
                                    <input type="url" id="site_url" name="site_url" class="form-input" value="<?php echo htmlspecialchars($config['app']['url'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="timezone">Zeitzone</label>
                                    <select id="timezone" name="timezone" class="form-select">
                                        <option value="Europe/Berlin" <?php echo ($config['app']['timezone'] ?? 'Europe/Berlin') === 'Europe/Berlin' ? 'selected' : ''; ?>>Europe/Berlin</option>
                                        <option value="UTC" <?php echo ($config['app']['timezone'] ?? '') === 'UTC' ? 'selected' : ''; ?>>UTC</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="locale">Sprache</label>
                                    <select id="locale" name="locale" class="form-select">
                                        <option value="de" <?php echo ($config['app']['locale'] ?? 'de') === 'de' ? 'selected' : ''; ?>>Deutsch</option>
                                        <option value="en" <?php echo ($config['app']['locale'] ?? '') === 'en' ? 'selected' : ''; ?>>English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="maintenance_message">Standard-Wartungsnachricht</label>
                                <textarea id="maintenance_message" name="maintenance_message" class="form-input" rows="3"><?php echo htmlspecialchars($config['maintenance']['message'] ?? 'Wir arbeiten aktuell an unserer Hosting-Infrastruktur. Bitte schau später noch einmal vorbei.'); ?></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="checkbox-label"><input type="checkbox" name="wip_enabled" value="1" id="wip_enabled" <?php echo ($config['wip']['enabled'] ?? false) ? 'checked' : ''; ?>> Work in Progress Modus aktiv</label>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-label"><input type="checkbox" name="servers_offline_enabled" value="1" id="servers_offline_enabled" <?php echo ($config['servers_offline']['enabled'] ?? false) ? 'checked' : ''; ?>> Server-Offline Anzeige aktiv</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Allgemeine Einstellungen speichern</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Idle-Shutdown Konfiguration</h2>
                    </div>
                    <div class="card-body">
                        <form id="idleSettingsForm" class="settings-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="idle_shutdown_enabled">Globale automatische Abschaltung</label>
                                    <select id="idle_shutdown_enabled" name="idle_shutdown_enabled" class="form-select">
                                        <option value="1" <?php echo ($config['idle_shutdown']['enabled'] ?? true) ? 'selected' : ''; ?>>Aktiviert</option>
                                        <option value="0" <?php echo !($config['idle_shutdown']['enabled'] ?? true) ? 'selected' : ''; ?>>Deaktiviert</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="idle_shutdown_default_timeout">Standard-Wartezeit (Sekunden)</label>
                                    <input type="number" id="idle_shutdown_default_timeout" name="idle_shutdown_default_timeout" class="form-input" min="30" max="3600" step="30" value="<?php echo $config['idle_shutdown']['default_timeout'] ?? 60; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="idle_shutdown_warning_time">Warnzeit vor Abschaltung (Sekunden)</label>
                                    <input type="number" id="idle_shutdown_warning_time" name="idle_shutdown_warning_time" class="form-input" min="0" max="300" step="10" value="<?php echo $config['idle_shutdown']['warning_time'] ?? 10; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="idle_shutdown_exclude_maintenance">Wartungsserver ausschließen</label>
                                    <select id="idle_shutdown_exclude_maintenance" name="idle_shutdown_exclude_maintenance" class="form-select">
                                        <option value="1" <?php echo ($config['idle_shutdown']['exclude_maintenance'] ?? true) ? 'selected' : ''; ?>>Ja</option>
                                        <option value="0" <?php echo !($config['idle_shutdown']['exclude_maintenance'] ?? true) ? 'selected' : ''; ?>>Nein</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="idle_shutdown_notify_owner" value="1" id="idle_shutdown_notify_owner" <?php echo ($config['idle_shutdown']['notify_owner'] ?? true) ? 'checked' : ''; ?>> Owner bei Abschaltung benachrichtigen</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Idle-Shutdown Einstellungen speichern</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Node Agent Einstellungen</h2>
                    </div>
                    <div class="card-body">
                        <form id="nodeSettingsForm" class="settings-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="node_heartbeat_interval">Heartbeat-Intervall (Sekunden)</label>
                                    <input type="number" id="node_heartbeat_interval" name="node_heartbeat_interval" class="form-input" min="10" max="300" value="<?php echo $config['node']['heartbeat_interval'] ?? 30; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="node_command_poll_interval">Command-Polling-Intervall (Sekunden)</label>
                                    <input type="number" id="node_command_poll_interval" name="node_command_poll_interval" class="form-input" min="1" max="60" value="<?php echo $config['node']['command_poll_interval'] ?? 5; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="node_resource_report_interval">Ressourcen-Report-Intervall (Sekunden)</label>
                                    <input type="number" id="node_resource_report_interval" name="node_resource_report_interval" class="form-input" min="30" max="600" value="<?php echo $config['node']['resource_report_interval'] ?? 60; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="node_offline_threshold">Node-Offline-Schwelle (Sekunden)</label>
                                    <input type="number" id="node_offline_threshold" name="node_offline_threshold" class="form-input" min="60" max="1800" value="<?php echo $config['node']['offline_threshold'] ?? 90; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="node_require_ssl" value="1" id="node_require_ssl" <?php echo ($config['node']['require_ssl'] ?? true) ? 'checked' : ''; ?>> HTTPS für Node-Kommunikation erzwingen</label>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="node_verify_cert" value="1" id="node_verify_cert" <?php echo ($config['node']['verify_cert'] ?? true) ? 'checked' : ''; ?>> SSL-Zertifikat verifizieren</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Node-Einstellungen speichern</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Sicherheit</h2>
                    </div>
                    <div class="card-body">
                        <form id="securitySettingsForm" class="settings-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="session_lifetime">Session-Lebensdauer (Minuten)</label>
                                    <input type="number" id="session_lifetime" name="session_lifetime" class="form-input" min="15" max="10080" value="<?php echo $config['security']['session_lifetime'] ?? 120; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="csrf_token_lifetime">CSRF-Token-Lebensdauer (Stunden)</label>
                                    <input type="number" id="csrf_token_lifetime" name="csrf_token_lifetime" class="form-input" min="1" max="168" value="<?php echo $config['security']['csrf_token_lifetime'] ?? 24; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="rate_limit_requests">Rate-Limit Requests</label>
                                    <input type="number" id="rate_limit_requests" name="rate_limit_requests" class="form-input" min="10" max="10000" value="<?php echo $config['security']['rate_limit']['requests'] ?? 100; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="rate_limit_window">Rate-Limit Fenster (Sekunden)</label>
                                    <input type="number" id="rate_limit_window" name="rate_limit_window" class="form-input" min="10" max="3600" value="<?php echo $config['security']['rate_limit']['window'] ?? 60; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="force_https" value="1" id="force_https" <?php echo ($config['security']['force_https'] ?? true) ? 'checked' : ''; ?>> HTTPS erzwingen (HSTS)</label>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="secure_cookies" value="1" id="secure_cookies" <?php echo ($config['security']['secure_cookies'] ?? true) ? 'checked' : ''; ?>> Sichere Cookies (Secure Flag)</label>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="http_only_cookies" value="1" id="http_only_cookies" <?php echo ($config['security']['http_only_cookies'] ?? true) ? 'checked' : ''; ?>> HttpOnly Cookies</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Sicherheitseinstellungen speichern</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Backup-Konfiguration</h2>
                    </div>
                    <div class="card-body">
                        <form id="backupSettingsForm" class="settings-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="backup_enabled">Automatische Backups</label>
                                    <select id="backup_enabled" name="backup_enabled" class="form-select">
                                        <option value="1" <?php echo ($config['backup']['enabled'] ?? true) ? 'selected' : ''; ?>>Aktiviert</option>
                                        <option value="0" <?php echo !($config['backup']['enabled'] ?? true) ? 'selected' : ''; ?>>Deaktiviert</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="backup_retention_days">Aufbewahrung (Tage)</label>
                                    <input type="number" id="backup_retention_days" name="backup_retention_days" class="form-input" min="1" max="365" value="<?php echo $config['backup']['retention_days'] ?? 30; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="backup_schedule">Backup-Zeitplan (Cron)</label>
                                    <input type="text" id="backup_schedule" name="backup_schedule" class="form-input" value="<?php echo htmlspecialchars($config['backup']['schedule'] ?? '0 3 * * *'); ?>" placeholder="z.B. 0 3 * * * für täglich 03:00">
                                </div>
                                <div class="form-group">
                                    <label for="backup_max_size_mb">Max. Backup-Größe (MB)</label>
                                    <input type="number" id="backup_max_size_mb" name="backup_max_size_mb" class="form-input" min="100" max="10240" value="<?php echo $config['backup']['max_size_mb'] ?? 2048; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="backup_compress" value="1" id="backup_compress" <?php echo ($config['backup']['compress'] ?? true) ? 'checked' : ''; ?>> Backups komprimieren</label>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label"><input type="checkbox" name="backup_verify" value="1" id="backup_verify" <?php echo ($config['backup']['verify'] ?? true) ? 'checked' : ''; ?>> Backup-Integrität prüfen</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Backup-Einstellungen speichern</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">System-Informationen</h2>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-group">
                                <label>PHP-Version</label>
                                <span><?php echo PHP_VERSION; ?></span>
                            </div>
                            <div class="detail-group">
                                <label>MariaDB-Version</label>
                                <span><?php 
                                    try {
                                        $db = $this->app->db();
                                        $version = $db->queryOne("SELECT VERSION() as v");
                                        echo $version['v'] ?? 'Unbekannt';
                                    } catch (Exception $e) {
                                        echo 'Fehler';
                                    }
                                ?></span>
                            </div>
                            <div class="detail-group">
                                <label>Speicherlimit</label>
                                <span><?php echo ini_get('memory_limit'); ?></span>
                            </div>
                            <div class="detail-group">
                                <label>Max. Upload-Größe</label>
                                <span><?php echo ini_get('upload_max_filesize'); ?></span>
                            </div>
                            <div class="detail-group">
                                <label>Zeitzone</label>
                                <span><?php echo date_default_timezone_get(); ?></span>
                            </div>
                            <div class="detail-group">
                                <label>Server-Zeit</label>
                                <span id="serverTime"><?php echo date('d.m.Y H:i:s'); ?></span>
                            </div>
                        </div>
                        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                            <button class="btn btn-secondary" onclick="clearCache()">Cache leeren</button>
                            <button class="btn btn-secondary" onclick="runMigrations()">Migrationen prüfen</button>
                            <button class="btn btn-warning" onclick="generateCsrfToken()">Neues CSRF-Token</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/api.js"></script>
    <script src="/assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            if (toggle && sidebar) {
                toggle.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
            }

            // Server time update
            setInterval(() => {
                const el = document.getElementById('serverTime');
                if (el) {
                    const now = new Date();
                    // Fetch actual server time via API to avoid drift
                    fetch('/api/v1/system/time')
                        .then(r => r.json())
                        .then(data => {
                            if (data.timestamp) {
                                el.textContent = new Date(data.timestamp * 1000).toLocaleString('de-DE');
                            }
                        })
                        .catch(() => {
                            el.textContent = now.toLocaleString('de-DE');
                        });
                }
            }, 30000);

            // Form handlers
            document.querySelectorAll('.settings-form').forEach(form => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);
                    delete data.csrf_token;
                    
                    // Convert checkboxes to boolean
                    Object.keys(data).forEach(key => {
                        if (data[key] === '1' || data[key] === 'on') data[key] = true;
                        if (data[key] === '0') data[key] = false;
                    });
                    
                    try {
                        await api.put('/api/v1/settings', data);
                        showToast('Einstellungen gespeichert', 'success');
                    } catch (err) {
                        showToast(err.message, 'error');
                    }
                });
            });
        });

        async function clearCache() {
            if (!confirm('Cache wirklich leeren?')) return;
            try {
                await api.post('/api/v1/system/clear-cache', {});
                showToast('Cache geleert', 'success');
            } catch (err) {
                showToast(err.message, 'error');
            }
        }

        async function runMigrations() {
            if (!confirm('Migrationen prüfen und ausführen?')) return;
            try {
                await api.post('/api/v1/system/run-migrations', {});
                showToast('Migrationen ausgeführt', 'success');
            } catch (err) {
                showToast(err.message, 'error');
            }
        }

        async function generateCsrfToken() {
            try {
                const response = await api.post('/api/v1/system/csrf-token', {});
                showToast('Neues CSRF-Token generiert', 'success');
                setTimeout(() => location.reload(), 1000);
            } catch (err) {
                showToast(err.message, 'error');
            }
        }
    </script>
</body>
</html>
