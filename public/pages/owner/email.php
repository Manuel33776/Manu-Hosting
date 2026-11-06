<?php
// Owner Dashboard - Email Configuration
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mail Konfiguration - Owner Dashboard - Manu Hosting</title>
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
                    <li class="nav-section">Übersicht</li>
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
                    <li><a href="/owner/email" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span>E-Mail Config</span></a></li>
                    <li><a href="/owner/inventory" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L12 2L4 6L4 18L12 22L20 18L20 6Z"/></svg><span>Live Inventory</span></a></li>
                    <li><a href="/owner/anticheat" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/><path d="M12 6V12L16 14"/></svg><span>Anti-Cheat</span></a></li>
                    <li><a href="/owner/backups" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg><span>Backups</span></a></li>
                    <li><a href="/owner/support" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Support</span></a></li>
                    <li><a href="/owner/orders" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg><span>Bestellungen</span></a></li>
                    <li><a href="/owner/audit-logs" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg><span>Audit-Logs</span></a></li>
                    <li><a href="/owner/settings" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg><span>Einstellungen</span></a></li>
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
                <h1 class="page-title">E-Mail Konfiguration</h1>
            </header>

            <div class="page-content">
                <!-- SMTP Configuration -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">SMTP Einstellungen</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/owner/email" id="emailForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="smtp_host">SMTP Host</label>
                                    <input type="text" id="smtp_host" name="smtp_host" class="form-input" value="<?php echo htmlspecialchars($config['smtp_host'] ?? ''); ?>" placeholder="smtp.example.com">
                                </div>
                                <div class="form-group">
                                    <label for="smtp_port">Port</label>
                                    <input type="number" id="smtp_port" name="smtp_port" class="form-input" value="<?php echo $config['smtp_port'] ?? 587; ?>" min="1" max="65535">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="smtp_username">Benutzername</label>
                                    <input type="text" id="smtp_username" name="smtp_username" class="form-input" value="<?php echo htmlspecialchars($config['smtp_username'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="smtp_password">Passwort</label>
                                    <input type="password" id="smtp_password" name="smtp_password" class="form-input" value="" autocomplete="new-password" placeholder="Leer lassen um beizubehalten">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="smtp_from_email">Absender E-Mail</label>
                                    <input type="email" id="smtp_from_email" name="smtp_from_email" class="form-input" value="<?php echo htmlspecialchars($config['smtp_from_email'] ?? ''); ?>" placeholder="noreply@manu-hosting.de">
                                </div>
                                <div class="form-group">
                                    <label for="smtp_from_name">Absender Name</label>
                                    <input type="text" id="smtp_from_name" name="smtp_from_name" class="form-input" value="<?php echo htmlspecialchars($config['smtp_from_name'] ?? 'Manu Hosting'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="smtp_tls" value="1" id="smtp_tls" <?php echo ($config['smtp_tls'] ?? true) ? 'checked' : ''; ?>> TLS Verschlüsselung verwenden
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="smtp_auth" value="1" id="smtp_auth" <?php echo ($config['smtp_auth'] ?? true) ? 'checked' : ''; ?>> Authentifizierung erforderlich
                                </label>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Einstellungen speichern</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Connection Test -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Verbindung testen</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/owner/email/test" id="testEmailForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-row">
                                <div class="form-group" style="flex: 1;">
                                    <label for="test_email">Test E-Mail an</label>
                                    <input type="email" id="test_email" name="test_email" class="form-input" required placeholder="ihre@email.de">
                                </div>
                                <div class="form-group" style="display: flex; align-items: flex-end;">
                                    <button type="submit" class="btn btn-secondary" id="testEmailBtn">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        Test E-Mail senden
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div id="testResult" style="display: none; margin-top: 16px;"></div>
                    </div>
                </div>

                <!-- Current Config Display -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Aktuelle Konfiguration</h2>
                    </div>
                    <div class="card-body">
                        <div class="config-display">
                            <div class="config-row">
                                <span class="config-label">SMTP Host</span>
                                <span class="config-value"><?php echo htmlspecialchars($config['smtp_host'] ?? 'Nicht konfiguriert'); ?></span>
                            </div>
                            <div class="config-row">
                                <span class="config-label">Port</span>
                                <span class="config-value"><?php echo $config['smtp_port'] ?? 'Nicht konfiguriert'; ?></span>
                            </div>
                            <div class="config-row">
                                <span class="config-label">Benutzername</span>
                                <span class="config-value"><?php echo htmlspecialchars($config['smtp_username'] ?? 'Nicht konfiguriert'); ?></span>
                            </div>
                            <div class="config-row">
                                <span class="config-label">Absender</span>
                                <span class="config-value"><?php echo htmlspecialchars(($config['smtp_from_name'] ?? 'Manu Hosting') . ' <' . ($config['smtp_from_email'] ?? '') . '>'); ?></span>
                            </div>
                            <div class="config-row">
                                <span class="config-label">TLS</span>
                                <span class="config-value"><span class="badge badge-<?php echo ($config['smtp_tls'] ?? false) ? 'success' : 'neutral'; ?>"><?php echo ($config['smtp_tls'] ?? false) ? 'Aktiviert' : 'Deaktiviert'; ?></span></span>
                            </div>
                            <div class="config-row">
                                <span class="config-label">Authentifizierung</span>
                                <span class="config-value"><span class="badge badge-<?php echo ($config['smtp_auth'] ?? false) ? 'success' : 'neutral'; ?>"><?php echo ($config['smtp_auth'] ?? false) ? 'Aktiviert' : 'Deaktiviert'; ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Templates Preview -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">E-Mail Templates (Vorschau)</h2>
                    </div>
                    <div class="card-body">
                        <div class="template-grid">
                            <div class="template-card">
                                <h4>Konto-Bestätigung</h4>
                                <p class="text-muted">Wird bei Registrierung gesendet</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('verify')">Vorschau</button>
                            </div>
                            <div class="template-card">
                                <h4>Passwort zurücksetzen</h4>
                                <p class="text-muted">Wird bei Passwort-Vergessen gesendet</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('reset')">Vorschau</button>
                            </div>
                            <div class="template-card">
                                <h4>Server installiert</h4>
                                <p class="text-muted">Benachrichtigung nach Installation</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('server_ready')">Vorschau</button>
                            </div>
                            <div class="template-card">
                                <h4>Server ausgefallen</h4>
                                <p class="text-muted">Warnung bei Server-Ausfall</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('server_down')">Vorschau</button>
                            </div>
                            <div class="template-card">
                                <h4>Wartungsankündigung</h4>
                                <p class="text-muted">Geplante Wartung</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('maintenance')">Vorschau</button>
                            </div>
                            <div class="template-card">
                                <h4>Support-Antwort</h4>
                                <p class="text-muted">Antwort auf Ticket</p>
                                <button class="btn btn-ghost btn-sm" onclick="previewTemplate('ticket_reply')">Vorschau</button>
                            </div>
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

            // Test email form
            const testForm = document.getElementById('testEmailForm');
            if (testForm) {
                testForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const btn = document.getElementById('testEmailBtn');
                    const result = document.getElementById('testResult');
                    const email = document.getElementById('test_email').value;
                    
                    btn.disabled = true;
                    btn.innerHTML = '<svg class="spinner" width="18" height="18" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.4 31.4" stroke-linecap="round"/></svg> Sende...';
                    result.style.display = 'none';
                    
                    try {
                        await api.post('/owner/email/test', { test_email: email });
                        result.innerHTML = '<div class="alert alert-success"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Test-E-Mail erfolgreich an ' + email + ' gesendet!</div>';
                    } catch (err) {
                        result.innerHTML = '<div class="alert alert-error"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Fehler: ' + err.message + '</div>';
                    }
                    result.style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Test E-Mail senden';
                });
            }

            function previewTemplate(type) {
                showToast('Template-Vorschau für ' + type + ' wird implementiert', 'info');
            }
        });
    </script>
</body>
</html>
