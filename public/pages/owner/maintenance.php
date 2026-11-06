<?php
// Owner Dashboard - Maintenance & Offline Control
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wartung & Offline - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/maintenance" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Wartung & Offline</span></a></li>
                    <li><a href="/owner/email" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span>E-Mail Config</span></a></li>
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
                <h1 class="page-title">Wartung & Offline-Steuerung</h1>
            </header>

            <div class="page-content">
                <!-- Current Status Overview -->
                <div class="stats-grid" style="margin-bottom: 24px;">
                    <div class="stat-card <?php echo ($maintenance_status['enabled'] ?? false) ? 'warning' : ''; ?>">
                        <div class="stat-header">
                            <span class="stat-label">Wartungsmodus</span>
                            <span class="badge badge-<?php echo ($maintenance_status['enabled'] ?? false) ? 'warning' : 'success'; ?>">
                                <?php echo ($maintenance_status['enabled'] ?? false) ? 'AKTIV' : 'INAKTIV'; ?>
                            </span>
                        </div>
                        <div class="stat-value">
                            <?php if ($maintenance_status['enabled'] && $offline_timer !== null): ?>
                                <span id="maintenanceTimer" class="timer-display"><?php echo formatDuration($offline_timer); ?></span>
                                <?php if ($planned_end_countdown !== null): ?>
                                    <br><small class="countdown">Ende in: <span id="plannedEndTimer"><?php echo formatDuration($planned_end_countdown); ?></span></small>
                                <?php endif; ?>
                            <?php else: ?>
                                Bereit
                            <?php endif; ?>
                        </div>
                        <div class="stat-breakdown">
                            <?php if ($maintenance_status['enabled'] && $maintenance_status['started_at']): ?>
                                <span>Seit: <?php echo formatDateTime($maintenance_status['started_at']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stat-card <?php echo ($wip_status['enabled'] ?? false) ? 'info' : ''; ?>">
                        <div class="stat-header">
                            <span class="stat-label">Work in Progress</span>
                            <span class="badge badge-<?php echo ($wip_status['enabled'] ?? false) ? 'info' : 'neutral'; ?>">
                                <?php echo ($wip_status['enabled'] ?? false) ? 'AKTIV' : 'INAKTIV'; ?>
                            </span>
                        </div>
                        <div class="stat-value"><?php echo htmlspecialchars($wip_status['message'] ?? 'Website in Entwicklung'); ?></div>
                    </div>

                    <div class="stat-card <?php echo ($servers_offline_status['enabled'] ?? false) ? 'error' : ''; ?>">
                        <div class="stat-header">
                            <span class="stat-label">Server Offline</span>
                            <span class="badge badge-<?php echo ($servers_offline_status['enabled'] ?? false) ? 'error' : 'neutral'; ?>">
                                <?php echo ($servers_offline_status['enabled'] ?? false) ? 'AKTIV' : 'INAKTIV'; ?>
                            </span>
                        </div>
                        <div class="stat-value"><?php echo htmlspecialchars($servers_offline_status['message'] ?? 'Server sind offline'); ?></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Website Status</span></div>
                        <div class="stat-value">
                            <span class="badge badge-<?php echo (($maintenance_status['enabled'] ?? false) || ($wip_status['enabled'] ?? false)) ? 'warning' : 'success'; ?>">
                                <?php echo (($maintenance_status['enabled'] ?? false) || ($wip_status['enabled'] ?? false)) ? 'EINGESCHRÄNKT' : 'ONLINE'; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Toggle -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Wartungsmodus steuern</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/owner/maintenance/toggle" class="maintenance-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="enabled" id="maintenanceEnabled" <?php echo ($maintenance_status['enabled'] ?? false) ? 'checked' : ''; ?> onchange="toggleMaintenanceFields()">
                                    Wartungsmodus aktivieren
                                </label>
                            </div>

                            <div id="maintenanceFields" style="<?php echo ($maintenance_status['enabled'] ?? false) ? '' : 'display: none;'; ?>">
                                <div class="form-group">
                                    <label for="message">Wartungsnachricht</label>
                                    <textarea id="message" name="message" class="form-input" rows="3" placeholder="Die Website befindet sich in Wartung. Bitte schauen Sie später wieder vorbei."><?php echo htmlspecialchars($maintenance_status['message'] ?? ''); ?></textarea>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="planned_end">Geplantes Wartungsende</label>
                                        <input type="datetime-local" id="planned_end" name="planned_end" class="form-input" value="<?php echo $maintenance_status['planned_end_at'] ? date('Y-m-d\TH:i', strtotime($maintenance_status['planned_end_at'])) : ''; ?>">
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary" id="maintenanceSubmitBtn">
                                        <?php echo ($maintenance_status['enabled'] ?? false) ? 'Wartungsmodus deaktivieren' : 'Wartungsmodus aktivieren'; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- WIP Toggle -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Work in Progress Banner</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/owner/maintenance/wip">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="enabled" <?php echo ($wip_status['enabled'] ?? false) ? 'checked' : ''; ?>> WIP-Banner anzeigen
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="wip_message">Nachricht</label>
                                <input type="text" id="wip_message" name="message" class="form-input" value="<?php echo htmlspecialchars($wip_status['message'] ?? 'Manu Hosting befindet sich aktuell noch in der Entwicklung.'); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </form>
                    </div>
                </div>

                <!-- Servers Offline Toggle -->
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Server Offline Banner</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/owner/maintenance/servers-offline">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="enabled" <?php echo ($servers_offline_status['enabled'] ?? false) ? 'checked' : ''; ?>> Server-Offline-Banner anzeigen
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="servers_offline_message">Nachricht</label>
                                <input type="text" id="servers_offline_message" name="message" class="form-input" value="<?php echo htmlspecialchars($servers_offline_status['message'] ?? 'Unsere Minecraft-Server sind momentan noch nicht verfügbar.'); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </form>
                    </div>
                </div>

                <!-- Maintenance History -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Wartungshistorie</h2>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($maintenance_history)): ?>
                        <div class="empty-state" style="padding: 48px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            <p>Keine Wartungshistorie vorhanden</p>
                        </div>
                        <?php else: ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Beginn</th>
                                        <th>Ende</th>
                                        <th>Dauer</th>
                                        <th>Nachricht</th>
                                        <th>Geplant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($maintenance_history as $entry): ?>
                                    <tr>
                                        <td><?php echo formatDateTime($entry['started_at']); ?></td>
                                        <td><?php echo $entry['ended_at'] ? formatDateTime($entry['ended_at']) : '<span class="text-warning">Läuft</span>'; ?></td>
                                        <td><?php echo $entry['duration'] ? formatDuration($entry['duration']) : '-'; ?></td>
                                        <td><?php echo htmlspecialchars($entry['message'] ?? ''); ?></td>
                                        <td><?php echo $entry['planned_end_at'] ? formatDateTime($entry['planned_end_at']) : '-'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
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

            // Update timers every second
            function updateTimers() {
                const maintenanceTimer = document.getElementById('maintenanceTimer');
                const plannedEndTimer = document.getElementById('plannedEndTimer');
                
                if (maintenanceTimer) {
                    const start = <?php echo $offline_timer ?? 0; ?>;
                    const elapsed = start + (Date.now() / 1000 - <?php echo time(); ?>);
                    if (elapsed > 0) {
                        maintenanceTimer.textContent = formatDuration(Math.max(0, elapsed));
                    }
                }
                
                if (plannedEndTimer) {
                    const remaining = <?php echo $planned_end_countdown ?? 0; ?> - (Date.now() / 1000 - <?php echo time(); ?>);
                    if (remaining > 0) {
                        plannedEndTimer.textContent = formatDuration(remaining);
                    } else {
                        plannedEndTimer.textContent = '0s';
                    }
                }
            }
            
            setInterval(updateTimers, 1000);
            
            function formatDuration(seconds) {
                if (seconds < 60) return Math.floor(seconds) + 's';
                const m = Math.floor(seconds / 60);
                if (m < 60) return m + 'm ' + Math.floor(seconds % 60) + 's';
                const h = Math.floor(m / 60);
                if (h < 24) return h + 'h ' + (m % 60) + 'm';
                const d = Math.floor(h / 24);
                return d + 'd ' + (h % 24) + 'h';
            }

            function toggleMaintenanceFields() {
                const enabled = document.getElementById('maintenanceEnabled').checked;
                const fields = document.getElementById('maintenanceFields');
                const btn = document.getElementById('maintenanceSubmitBtn');
                if (fields) fields.style.display = enabled ? 'block' : 'none';
                if (btn) btn.textContent = enabled ? 'Wartungsmodus aktivieren' : 'Wartungsmodus deaktivieren';
            }
        });
    </script>
</body>
</html>
