<?php
// Owner Dashboard - Resource Overview
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressourcen - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/resources" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><span>Ressourcen</span></a></li>
                    <li class="nav-section">System</li>
                    <li><a href="/owner/maintenance" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Wartung & Offline</span></a></li>
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
                <h1 class="page-title">Ressourcen-Übersicht</h1>
            </header>

            <div class="page-content">
                <!-- Node Resources -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Node-Ressourcen</h2>
                    </div>
                    <div class="card-body">
                        <?php if (empty($nodes)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg>
                            <p>Keine Nodes konfiguriert</p>
                        </div>
                        <?php else: ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Node</th>
                                        <th>CPU</th>
                                        <th>RAM</th>
                                        <th>Speicher</th>
                                        <th>Netzwerk</th>
                                        <th>Server</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($nodes as $node): ?>
                                    <?php
                                        $cpuPct = $node['cpu_cores'] ? round(($node['cpu_usage'] ?? 0) / $node['cpu_cores'] * 100, 1) : 0;
                                        $ramPct = $node['total_ram'] ? round(($node['ram_used'] ?? 0) / $node['total_ram'] * 100, 1) : 0;
                                        $diskPct = $node['total_disk'] ? round(($node['disk_used'] ?? 0) / $node['total_disk'] * 100, 1) : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <span class="user-name"><?php echo htmlspecialchars($node['name']); ?></span>
                                                <span class="user-id"><?php echo htmlspecialchars($node['host']); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar" style="width: 150px;">
                                                <div class="progress-fill" style="width: <?php echo $cpuPct; ?>%; background: <?php echo $cpuPct > 80 ? 'var(--color-error)' : ($cpuPct > 60 ? 'var(--color-warning)' : 'var(--gradient-primary)'); ?>"></div>
                                            </div>
                                            <span><?php echo $cpuPct; ?>% (<?php echo $node['cpu_usage'] ?? 0; ?>/<?php echo $node['cpu_cores']; ?>)</span>
                                        </td>
                                        <td>
                                            <div class="progress-bar" style="width: 150px;">
                                                <div class="progress-fill" style="width: <?php echo $ramPct; ?>%; background: <?php echo $ramPct > 80 ? 'var(--color-error)' : ($ramPct > 60 ? 'var(--color-warning)' : 'var(--gradient-secondary)'); ?>"></div>
                                            </div>
                                            <span><?php echo $ramPct; ?>% (<?php echo formatBytes($node['ram_used'] ?? 0); ?>/<?php echo formatBytes($node['total_ram']); ?>)</span>
                                        </td>
                                        <td>
                                            <div class="progress-bar" style="width: 150px;">
                                                <div class="progress-fill" style="width: <?php echo $diskPct; ?>%; background: <?php echo $diskPct > 80 ? 'var(--color-error)' : ($diskPct > 60 ? 'var(--color-warning)' : 'var(--gradient-accent)'); ?>"></div>
                                            </div>
                                            <span><?php echo $diskPct; ?>% (<?php echo formatBytes($node['disk_used'] ?? 0); ?>/<?php echo formatBytes($node['total_disk']); ?>)</span>
                                        </td>
                                        <td>
                                            <?php if (!empty($node['network'])): ?>
                                                <?php echo formatBytes($node['network']['rx'] ?? 0); ?> ↓ / <?php echo formatBytes($node['network']['tx'] ?? 0); ?> ↑
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $node['servers_count'] ?? 0; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $node['status'] === 'online' ? 'success' : 'error'; ?>">
                                                <span class="status-dot status-<?php echo $node['status']; ?>"></span>
                                                <?php echo ucfirst($node['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Server Resources -->
                <div class="card" style="margin-top: 24px;">
                    <div class="card-header">
                        <h2 class="card-title">Server-Ressourcen</h2>
                    </div>
                    <div class="card-body">
                        <?php if (empty($servers)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg>
                            <p>Keine Server vorhanden</p>
                        </div>
                        <?php else: ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Server</th>
                                        <th>Kunde</th>
                                        <th>Node</th>
                                        <th>RAM Limit</th>
                                        <th>CPU Limit</th>
                                        <th>Status</th>
                                        <th>Spieler</th>
                                        <th>Uptime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($servers as $server): ?>
                                    <tr>
                                        <td>
                                            <div class="server-name-cell">
                                                <span class="server-name"><?php echo htmlspecialchars($server['name']); ?></span>
                                                <span class="server-id"><?php echo substr($server['uuid'], 0, 8); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($server['owner_name'] ?? 'Unbekannt'); ?></td>
                                        <td><?php echo htmlspecialchars($server['node_name'] ?? 'Keine Node'); ?></td>
                                        <td><?php echo $server['ram_mb']; ?> MB</td>
                                        <td><?php echo $server['cpu_cores']; ?> Kerne</td>
                                        <td>
                                            <span class="badge badge-<?php echo match($server['status']) {
                                                'online' => 'success',
                                                'offline', 'suspended', 'idle_shutdown' => 'neutral',
                                                'starting', 'stopping', 'restarting', 'installing' => 'warning',
                                                'error' => 'error',
                                                default => 'neutral',
                                            } ?>">
                                                <span class="status-dot status-<?php echo $server['status']; ?>"></span>
                                                <?php echo ucfirst(str_replace('_', ' ', $server['status'])); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $server['players_online'] ?? 0; ?> / <?php echo $server['max_players'] ?? 20; ?></td>
                                        <td><?php echo $server['started_at'] ? formatDuration(time() - strtotime($server['started_at'])) : '-'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="stats-grid" style="margin-top: 24px;">
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Gesamt zugewiesener RAM</span></div>
                        <div class="stat-value"><?php echo formatBytes(array_sum(array_column($servers, 'ram_mb')) * 1024 * 1024); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Gesamt zugewiesene CPU</span></div>
                        <div class="stat-value"><?php echo array_sum(array_column($servers, 'cpu_cores')); ?> Kerne</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Laufende Server</span></div>
                        <div class="stat-value"><?php echo count(array_filter($servers, fn($s) => $s['status'] === 'online')); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Gesamt Speicher</span></div>
                        <div class="stat-value"><?php echo formatBytes(array_sum(array_column($servers, 'disk_mb')) * 1024 * 1024); ?></div>
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
        });
    </script>
</body>
</html>
