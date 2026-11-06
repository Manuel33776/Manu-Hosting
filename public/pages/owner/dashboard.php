<?php
// Owner Dashboard - Main Overview
// This page shows comprehensive statistics and system status
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
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
                    <li><a href="/owner" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><span>Dashboard</span></a></li>
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

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Sidebar umschalten">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="page-title">Owner Dashboard</h1>
                <div class="top-bar-actions">
                    <div class="status-indicator">
                        <span class="status-dot status-online"></span>
                        <span>DL580 Online</span>
                    </div>
                    <a href="/" target="_blank" class="btn btn-ghost btn-sm" title="Website ansehen">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="page-content">
                <!-- Maintenance Banner -->
                <?php if (($maintenance_status['enabled'] ?? false) || ($wip_status['enabled'] ?? false) || ($servers_offline_status['enabled'] ?? false)): ?>
                <div class="maintenance-banner">
                    <div class="banner-content">
                        <?php if ($maintenance_status['enabled']): ?>
                            <div class="banner-item warning">
                                <svg class="banner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <div>
                                    <strong>Wartungsmodus aktiv</strong>
                                    <span><?= htmlspecialchars($maintenance_status['message']) ?></span>
                                    <?php if ($offline_timer): ?>
                                        <span class="timer">Offline seit: <strong id="offlineTimer"><?= formatDuration($offline_timer) ?></strong></span>
                                    <?php endif; ?>
                                    <?php if ($planned_end_countdown): ?>
                                        <span class="timer countdown">Wieder online in: <strong id="plannedEndTimer"><?= formatDuration($planned_end_countdown) ?></strong></span>
                                    <?php endif; ?>
                                </div>
                                <a href="/owner/maintenance" class="btn btn-sm btn-outline">Verwalten</a>
                            </div>
                        <?php endif; ?>
                        <?php if ($wip_status['enabled']): ?>
                            <div class="banner-item info">
                                <svg class="banner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <div><strong>Work in Progress</strong><span><?= htmlspecialchars($wip_status['message']) ?></span></div>
                                <a href="/owner/maintenance" class="btn btn-sm btn-outline">Verwalten</a>
                            </div>
                        <?php endif; ?>
                        <?php if ($servers_offline_status['enabled']): ?>
                            <div class="banner-item error">
                                <svg class="banner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <div><strong>Server Offline</strong><span><?= htmlspecialchars($servers_offline_status['message']) ?></span></div>
                                <a href="/owner/maintenance" class="btn btn-sm btn-outline">Verwalten</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <!-- Server Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Minecraft Server</span>
                            <span class="badge badge-primary"><?= $server_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= $server_stats['online'] ?> / <?= $server_stats['total'] ?></div>
                        <div class="stat-breakdown">
                            <span class="stat-item success"><span class="status-dot status-online"></span>Online: <?= $server_stats['online'] ?></span>
                            <span class="stat-item neutral"><span class="status-dot status-offline"></span>Offline: <?= $server_stats['offline'] ?></span>
                            <span class="stat-item warning"><span class="status-dot status-starting"></span>Start: <?= $server_stats['starting'] + $server_stats['installing'] ?></span>
                            <span class="stat-item error"><span class="status-dot status-error"></span>Fehler: <?= $server_stats['error'] ?></span>
                            <span class="stat-item muted"><span class="status-dot status-suspended"></span>Gespert: <?= $server_stats['suspended'] ?></span>
                            <span class="stat-item info"><span class="status-dot status-idle"></span>Idle: <?= $server_stats['idle_shutdown'] ?></span>
                        </div>
                    </div>

                    <!-- Customer Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Kunden</span>
                            <span class="badge badge-secondary"><?= $user_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= $user_stats['active'] ?> aktiv</div>
                        <div class="stat-breakdown">
                            <span class="stat-item success">Aktiv: <?= $user_stats['active'] ?></span>
                            <span class="stat-item primary">Admins: <?= $user_stats['admins'] ?></span>
                            <span class="stat-item neutral">Kunden: <?= $user_stats['customers'] ?></span>
                        </div>
                    </div>

                    <!-- Node Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Hosting Nodes</span>
                            <span class="badge badge-success"><?= $node_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= $node_stats['online'] ?> / <?= $node_stats['total'] ?> Online</div>
                        <div class="stat-breakdown">
                            <span class="stat-item success">Online: <?= $node_stats['online'] ?></span>
                            <span class="stat-item muted">Offline: <?= $node_stats['offline'] ?></span>
                        </div>
                    </div>

                    <!-- Ticket Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Support Tickets</span>
                            <span class="badge badge-warning"><?= $ticket_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= $ticket_stats['open'] + $ticket_stats['in_progress'] ?> offen</div>
                        <div class="stat-breakdown">
                            <span class="stat-item error">Offen: <?= $ticket_stats['open'] ?></span>
                            <span class="stat-item warning">In Arbeit: <?= $ticket_stats['in_progress'] ?></span>
                            <span class="stat-item success">Geschlossen: <?= $ticket_stats['closed'] ?></span>
                        </div>
                    </div>

                    <!-- Order Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Bestellungen</span>
                            <span class="badge badge-info"><?= $order_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= number_format($order_stats['revenue'] / 100, 2) ?> € Umsatz</div>
                        <div class="stat-breakdown">
                            <span class="stat-item warning">Offen: <?= $order_stats['pending'] ?></span>
                            <span class="stat-item info">Bearbeitung: <?= $order_stats['processing'] ?></span>
                            <span class="stat-item success">Abgeschlossen: <?= $order_stats['completed'] ?></span>
                        </div>
                    </div>

                    <!-- Backup Stats -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Backups</span>
                            <span class="badge badge-neutral"><?= $backup_stats['total'] ?></span>
                        </div>
                        <div class="stat-value"><?= $backup_stats['completed'] ?> fertiggestellt</div>
                        <div class="stat-breakdown">
                            <span class="stat-item success">Erfolgreich: <?= $backup_stats['completed'] ?></span>
                            <span class="stat-item error">Fehlgeschlagen: <?= $backup_stats['failed'] ?></span>
                            <span class="stat-item neutral">Größe: <?= formatBytes($backup_stats['total_size']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- DL580 Resources -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">HP ProLiant DL580 - Ressourcen</h2>
                        <div class="card-actions">
                            <a href="/owner/resources" class="btn btn-ghost btn-sm">Details</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($node_stats['resources'])): 
                            $res = $node_stats['resources'];
                            $cpuPct = $res['total_cores'] ? round(($res['total_cpu_usage'] ?? 0) / $res['total_cores'] * 100, 1) : 0;
                            $ramPct = $res['total_ram'] ? round(($res['total_ram_used'] ?? 0) / $res['total_ram'] * 100, 1) : 0;
                            $diskPct = $res['total_disk'] ? round(($res['total_disk_used'] ?? 0) / $res['total_disk'] * 100, 1) : 0;
                        ?>
                        <div class="resource-grid">
                            <div class="resource-item">
                                <div class="resource-label">
                                    <span>CPU</span>
                                    <span><?= $cpuPct ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $cpuPct ?>%; background: <?= $cpuPct > 80 ? 'var(--color-error)' : ($cpuPct > 60 ? 'var(--color-warning)' : 'var(--gradient-primary)') ?>"></div>
                                </div>
                                <div class="resource-detail"><?= $res['total_cpu_usage'] ?? 0 ?> / <?= $res['total_cores'] ?? 0 ?> Kerne</div>
                            </div>
                            <div class="resource-item">
                                <div class="resource-label">
                                    <span>RAM</span>
                                    <span><?= $ramPct ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $ramPct ?>%; background: <?= $ramPct > 80 ? 'var(--color-error)' : ($ramPct > 60 ? 'var(--color-warning)' : 'var(--gradient-secondary)') ?>"></div>
                                </div>
                                <div class="resource-detail"><?= formatBytes($res['total_ram_used'] ?? 0) ?> / <?= formatBytes($res['total_ram'] ?? 0) ?></div>
                            </div>
                            <div class="resource-item">
                                <div class="resource-label">
                                    <span>Speicher</span>
                                    <span><?= $diskPct ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $diskPct ?>%; background: <?= $diskPct > 80 ? 'var(--color-error)' : ($diskPct > 60 ? 'var(--color-warning)' : 'var(--gradient-accent)') ?>"></div>
                                </div>
                                <div class="resource-detail"><?= formatBytes($res['total_disk_used'] ?? 0) ?> / <?= formatBytes($res['total_disk'] ?? 0) ?></div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg>
                            <p>Keine Node-Daten verfügbar. Der DL580 ist möglicherweise offline.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions & Recent Activity -->
                <div class="dashboard-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Schnellzugriff</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="/owner/servers" class="quick-action">
                                    <div class="quick-action-icon primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">Server verwalten</span>
                                        <span class="quick-action-desc"><?= $server_stats['total'] ?> Server</span>
                                    </div>
                                </a>
                                <a href="/owner/admins" class="quick-action">
                                    <div class="quick-action-icon secondary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">Administratoren</span>
                                        <span class="quick-action-desc"><?= $user_stats['admins'] ?> Admins</span>
                                    </div>
                                </a>
                                <a href="/owner/maintenance" class="quick-action">
                                    <div class="quick-action-icon warning"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">Wartungsmodus</span>
                                        <span class="quick-action-desc">Website steuern</span>
                                    </div>
                                </a>
                                <a href="/owner/email" class="quick-action">
                                    <div class="quick-action-icon info"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">E-Mail Config</span>
                                        <span class="quick-action-desc">SMTP testen</span>
                                    </div>
                                </a>
                                <a href="/owner/nodes" class="quick-action">
                                    <div class="quick-action-icon success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">Nodes verwalten</span>
                                        <span class="quick-action-desc"><?= $node_stats['online'] ?>/<?= $node_stats['total'] ?> online</span>
                                    </div>
                                </a>
                                <a href="/owner/packages" class="quick-action">
                                    <div class="quick-action-icon accent"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/></svg></div>
                                    <div class="quick-action-content">
                                        <span class="quick-action-title">Pakete</span>
                                        <span class="quick-action-desc">Hosting-Angebote</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Letzte Server</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container" style="border: none;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Server</th>
                                            <th>Kunde</th>
                                            <th>Node</th>
                                            <th>Status</th>
                                            <th>Erstellt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recent_servers['data'])): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Keine Server vorhanden</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($recent_servers['data'] as $server): ?>
                                            <tr>
                                                <td>
                                                    <div class="server-name-cell">
                                                        <span class="server-name"><?= htmlspecialchars($server['name']) ?></span>
                                                        <span class="server-id"><?= substr($server['uuid'], 0, 8) ?></span>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($server['owner_name'] ?? 'Unbekannt') ?></td>
                                                <td><?= htmlspecialchars($server['node_name'] ?? 'Keine Node') ?></td>
                                                <td>
                                                    <span class="badge badge-<?= match($server['status']) {
                                                        'online' => 'success',
                                                        'offline', 'suspended', 'idle_shutdown' => 'neutral',
                                                        'starting', 'stopping', 'restarting', 'installing' => 'warning',
                                                        'error' => 'error',
                                                        default => 'neutral',
                                                    } ?>">
                                                        <span class="status-dot status-<?= $server['status'] ?>"></span>
                                                        <?= ucfirst(str_replace('_', ' ', $server['status'])) ?>
                                                    </span>
                                                </td>
                                                <td><?= formatDateTime($server['created_at']) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer" style="border-top: 1px solid var(--color-border);">
                                <a href="/owner/servers" class="btn btn-ghost btn-sm">Alle Server anzeigen</a>
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
        // Initialize sidebar toggle
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (toggle && sidebar) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                });
            }

            // Update timers every second
            function updateTimers() {
                const offlineTimer = document.getElementById('offlineTimer');
                const plannedEndTimer = document.getElementById('plannedEndTimer');
                
                if (offlineTimer) {
                    const start = <?= $offline_timer ?? 0 ?>;
                    const elapsed = start + (Date.now() / 1000 - <?= time() ?>);
                    offlineTimer.textContent = formatDuration(Math.max(0, elapsed));
                }
                
                if (plannedEndTimer) {
                    const remaining = <?= $planned_end_countdown ?? 0 ?> - (Date.now() / 1000 - <?= time() ?>);
                    if (remaining > 0) {
                        plannedEndTimer.textContent = formatDuration(remaining);
                    } else {
                        plannedEndTimer.textContent = '0s';
                    }
                }
            }
            
            setInterval(updateTimers, 1000);
            
            // Format duration helper
            function formatDuration(seconds) {
                if (seconds < 60) return Math.floor(seconds) + 's';
                const m = Math.floor(seconds / 60);
                if (m < 60) return m + 'm ' + Math.floor(seconds % 60) + 's';
                const h = Math.floor(m / 60);
                if (h < 24) return h + 'h ' + (m % 60) + 'm';
                const d = Math.floor(h / 24);
                return d + 'd ' + (h % 24) + 'h';
            }
        });
    </script>
</body>
</html>
