<?php
// Admin Dashboard - Platform Status
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plattform - Admin Dashboard - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="/admin" class="logo">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="url(#grad)"/>
                        <path d="M8 16L14 22L24 10" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="grad" x1="0" y1="0" x2="32" y2="32">
                                <stop offset="0%" stop-color="#3B82F6"/>
                                <stop offset="100%" stop-color="#8B5CF6"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="logo-text">Manu Hosting</span>
                    <span class="badge badge-primary" style="font-size: 10px; padding: 2px 6px;">Admin</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-section">Übersicht</li>
                    <li><a href="/admin" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><span>Dashboard</span></a></li>
                    <li class="nav-section">Verwaltung</li>
                    <li><a href="/admin/users" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Benutzer</span></a></li>
                    <li><a href="/admin/servers" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg><span>Server</span></a></li>
                    <li><a href="/admin/nodes" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Nodes</span></a></li>
                    <li><a href="/admin/packages" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg><span>Pakete</span></a></li>
                    <li><a href="/admin/tickets" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Tickets</span></a></li>
                    <li class="nav-section">System</li>
                    <li><a href="/admin/platform" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Plattform</span></a></li>
                    <li><a href="/admin/audit-logs" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg><span>Audit-Logs</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($user['username'] ?? 'A', 0, 1)); ?></div>
                    <div class="user-details">
                        <span class="user-name"><?php echo htmlspecialchars($user['username'] ?? 'Admin'); ?></span>
                        <span class="user-role"><?php echo ucfirst($user['role'] ?? 'admin'); ?></span>
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
                <h1 class="page-title">Plattform-Status</h1>
            </header>

            <div class="page-content">
                <div class="grid grid-2">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Website-Status</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-grid">
                                <div class="detail-group">
                                    <label>Wartungsmodus</label>
                                    <span>
                                        <span class="badge badge-<?php echo $maintenanceStatus['enabled'] ? 'warning' : 'success'; ?>">
                                            <?php echo $maintenanceStatus['enabled'] ? 'Aktiv' : 'Inaktiv'; ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>Wartungsnachricht</label>
                                    <span><?php echo htmlspecialchars($maintenanceStatus['message'] ?? 'Keine Nachricht'); ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Geplantes Ende</label>
                                    <span><?php echo $maintenanceStatus['planned_end_at'] ? date('d.m.Y H:i', strtotime($maintenanceStatus['planned_end_at'])) : 'Kein Ende geplant'; ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Work in Progress</label>
                                    <span>
                                        <span class="badge badge-<?php echo $wipStatus['enabled'] ? 'warning' : 'success'; ?>">
                                            <?php echo $wipStatus['enabled'] ? 'Aktiv' : 'Inaktiv'; ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>Server-Offline Anzeige</label>
                                    <span>
                                        <span class="badge badge-<?php echo $serversOfflineStatus['enabled'] ? 'warning' : 'success'; ?>">
                                            <?php echo $serversOfflineStatus['enabled'] ? 'Aktiv' : 'Inaktiv'; ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>Website Offline seit</label>
                                    <span id="offlineTimer">
                                        <?php 
                                            if ($offlineTimer !== null) {
                                                $h = floor($offlineTimer / 3600);
                                                $m = floor(($offlineTimer % 3600) / 60);
                                                $s = $offlineTimer % 60;
                                                echo sprintf('%02d:%02d:%02d', $h, $m, $s);
                                            } else {
                                                echo 'Online';
                                            }
                                        ?>
                                    </span>
                                </div>
                            </div>
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
                                            $v = $db->queryOne("SELECT VERSION() as v");
                                            echo $v['v'] ?? 'Unbekannt';
                                        } catch (Exception $e) { echo 'Fehler'; }
                                    ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Speicherlimit</label>
                                    <span><?php echo ini_get('memory_limit'); ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Max. Upload</label>
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
                                <div class="detail-group">
                                    <label>OPcache</label>
                                    <span><?php echo extension_loaded('opcache') && ini_get('opcache.enable') ? 'Aktiv' : 'Inaktiv'; ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Redis</label>
                                    <span><?php echo extension_loaded('redis') ? 'Verfügbar' : 'Nicht installiert'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Datenbank-Status</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-grid">
                                <?php 
                                    try {
                                        $db = $this->app->db();
                                        $tables = $db->query("SHOW TABLE STATUS");
                                        $totalSize = 0;
                                        $totalRows = 0;
                                        foreach ($tables as $t) {
                                            $totalSize += ($t['Data_length'] ?? 0) + ($t['Index_length'] ?? 0);
                                            $totalRows += $t['Rows'] ?? 0;
                                        }
                                        echo '<div class="detail-group"><label>Tabellen</label><span>' . count($tables) . '</span></div>';
                                        echo '<div class="detail-group"><label>Gesamtgröße</label><span>' . formatBytes($totalSize) . '</span></div>';
                                        echo '<div class="detail-group"><label>Zeilen gesamt</label><span>' . number_format($totalRows) . '</span></div>';
                                    } catch (Exception $e) {
                                        echo '<div class="detail-group" style="grid-column: 1/-1;"><label>Fehler</label><span class="text-error">' . $e->getMessage() . '</span></div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Wartungshistorie</h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Beginn</th>
                                            <th>Ende</th>
                                            <th>Dauer</th>
                                            <th>Nachricht</th>
                                            <th>Verantwortlich</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($maintenanceHistory)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Keine Wartungshistorie</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($maintenanceHistory as $m): ?>
                                            <tr>
                                                <td><?php echo date('d.m.Y H:i', strtotime($m['started_at'])); ?></td>
                                                <td><?php echo $m['ended_at'] ? date('d.m.Y H:i', strtotime($m['ended_at'])) : '<span class="text-warning">Aktiv</span>'; ?></td>
                                                <td>
                                                    <?php 
                                                        if ($m['ended_at']) {
                                                            $diff = strtotime($m['ended_at']) - strtotime($m['started_at']);
                                                            $h = floor($diff / 3600);
                                                            $min = floor(($diff % 3600) / 60);
                                                            echo sprintf('%02d:%02d', $h, $min);
                                                        } else {
                                                            echo '<span class="text-warning">Läuft...</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($m['message'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($m['username'] ?? 'System'); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Dienste-Status</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-grid">
                                <div class="detail-group">
                                    <label>Nginx</label>
                                    <span>
                                        <span class="badge badge-success">Läuft</span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>PHP-FPM</label>
                                    <span>
                                        <span class="badge badge-success">Läuft</span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>MariaDB</label>
                                    <span>
                                        <span class="badge badge-success">Läuft</span>
                                    </span>
                                </div>
                                <div class="detail-group">
                                    <label>Redis</label>
                                    <span>
                                        <span class="badge badge-<?php echo extension_loaded('redis') ? 'success' : 'neutral'; ?>">
                                            <?php echo extension_loaded('redis') ? 'Läuft' : 'Nicht installiert'; ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Schnellaktionen</h2>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button class="btn btn-secondary" onclick="clearCache()">Cache leeren</button>
                                <button class="btn btn-secondary" onclick="runMigrations()">Migrationen prüfen</button>
                                <button class="btn btn-warning" onclick="generateCsrfToken()">Neues CSRF-Token</button>
                                <button class="btn btn-primary" onclick="viewLogs()">System-Logs anzeigen</button>
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

            // Update offline timer
            const timerEl = document.getElementById('offlineTimer');
            if (timerEl && timerEl.textContent !== 'Online') {
                let seconds = 0;
                const parts = timerEl.textContent.split(':').map(Number);
                if (parts.length === 3) {
                    seconds = parts[0] * 3600 + parts[1] * 60 + parts[2];
                }
                setInterval(() => {
                    seconds++;
                    const h = Math.floor(seconds / 3600);
                    const m = Math.floor((seconds % 3600) / 60);
                    const s = seconds % 60;
                    timerEl.textContent = String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                }, 1000);
            }

            // Update server time
            setInterval(() => {
                const el = document.getElementById('serverTime');
                if (el) {
                    fetch('/api/v1/system/time')
                        .then(r => r.json())
                        .then(data => {
                            if (data.timestamp) {
                                el.textContent = new Date(data.timestamp * 1000).toLocaleString('de-DE');
                            }
                        })
                        .catch(() => {
                            el.textContent = new Date().toLocaleString('de-DE');
                        });
                }
            }, 30000);
        });

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        async function clearCache() {
            if (!confirm('Cache wirklich leeren?')) return;
            try {
                await api.post('/api/v1/system/clear-cache', {});
                showToast('Cache geleert', 'success');
            } catch (err) { showToast(err.message, 'error'); }
        }

        async function runMigrations() {
            if (!confirm('Migrationen prüfen und ausführen?')) return;
            try {
                await api.post('/api/v1/system/run-migrations', {});
                showToast('Migrationen ausgeführt', 'success');
            } catch (err) { showToast(err.message, 'error'); }
        }

        async function generateCsrfToken() {
            try {
                const response = await api.post('/api/v1/system/csrf-token', {});
                showToast('Neues CSRF-Token generiert', 'success');
                setTimeout(() => location.reload(), 1000);
            } catch (err) { showToast(err.message, 'error'); }
        }

        function viewLogs() {
            window.open('/admin/logs', '_blank');
        }
    </script>
</body>
</html>
