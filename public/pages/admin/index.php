<?php
// Admin Dashboard - Main Overview
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manu Hosting</title>
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
                    <li><a href="/admin" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg><span>Dashboard</span></a></li>
                    <li class="nav-section">Verwaltung</li>
                    <li><a href="/admin/users" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Benutzer</span></a></li>
                    <li><a href="/admin/servers" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg><span>Server</span></a></li>
                    <li><a href="/admin/nodes" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Nodes</span></a></li>
                    <li><a href="/admin/packages" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg><span>Pakete</span></a></li>
                    <li><a href="/admin/tickets" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Tickets</span></a></li>
                    <li class="nav-section">System</li>
                    <li><a href="/admin/platform" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Plattform</span></a></li>
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
                <h1 class="page-title">Admin Dashboard</h1>
            </header>

            <div class="page-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $serverStats['total'] ?? 0; ?></span>
                            <span class="stat-label">Server gesamt</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14l2 2 4-4"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $serverStats['online'] ?? 0; ?></span>
                            <span class="stat-label">Online</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $serverStats['offline'] ?? 0; ?></span>
                            <span class="stat-label">Offline</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $userStats['total'] ?? 0; ?></span>
                            <span class="stat-label">Kunden</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $ticketStats['open'] ?? 0; ?></span>
                            <span class="stat-label">Offene Tickets</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-neutral">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value"><?php echo $nodeStats['online'] ?? 0; ?> / <?php echo $nodeStats['total'] ?? 0; ?></span>
                            <span class="stat-label">Nodes Online</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Server-Status</h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Server</th>
                                            <th>Kunde</th>
                                            <th>Node</th>
                                            <th>Status</th>
                                            <th>Spieler</th>
                                            <th>RAM</th>
                                            <th>CPU</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentServers)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Keine Server</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($recentServers as $server): ?>
                                            <tr>
                                                <td>
                                                    <span class="user-name"><?php echo htmlspecialchars($server['name']); ?></span>
                                                    <span class="user-id"><?php echo htmlspecialchars($server['uuid']); ?></span>
                                                </td>
                                                <td><?php echo htmlspecialchars($server['username'] ?? 'Unbekannt'); ?></td>
                                                <td><?php echo htmlspecialchars($server['node_name'] ?? '-'); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo getStatusBadge($server['status'] ?? 'offline'); ?>">
                                                        <?php echo ucfirst($server['status'] ?? 'offline'); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $server['players_online'] ?? 0; ?> / <?php echo $server['players_max'] ?? 0; ?></td>
                                                <td><?php echo $server['ram_usage'] ?? 0; ?>%</td>
                                                <td><?php echo $server['cpu_usage'] ?? 0; ?>%</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer" style="padding: 1rem; text-align: center;">
                                <a href="/admin/servers" class="btn btn-primary btn-sm">Alle Server anzeigen</a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Offene Tickets</h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Betreff</th>
                                            <th>Kunde</th>
                                            <th>Priorität</th>
                                            <th>Status</th>
                                            <th>Erstellt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentTickets)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Keine offenen Tickets</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($recentTickets as $ticket): ?>
                                            <tr>
                                                <td><?php echo $ticket['id']; ?></td>
                                                <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                                <td><?php echo htmlspecialchars($ticket['username'] ?? 'Unbekannt'); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo getPriorityBadge($ticket['priority'] ?? 'normal'); ?>">
                                                        <?php echo ucfirst($ticket['priority'] ?? 'normal'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo getTicketStatusBadge($ticket['status'] ?? 'open'); ?>">
                                                        <?php echo ucfirst($ticket['status'] ?? 'open'); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d.m.Y H:i', strtotime($ticket['created_at'])); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer" style="padding: 1rem; text-align: center;">
                                <a href="/admin/tickets" class="btn btn-primary btn-sm">Alle Tickets anzeigen</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Node-Status</h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Typ</th>
                                            <th>Status</th>
                                            <th>CPU</th>
                                            <th>RAM</th>
                                            <th>Server</th>
                                            <th>Letzter Heartbeat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($nodes)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Keine Nodes</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($nodes as $node): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($node['name']); ?></td>
                                                <td><?php echo htmlspecialchars($node['type'] ?? 'Windows'); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo $node['status'] === 'online' ? 'success' : 'error'; ?>">
                                                        <?php echo ucfirst($node['status'] ?? 'offline'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="progress-bar" style="width: 100px;">
                                                        <div class="progress-fill" style="width: <?php echo $node['cpu_usage'] ?? 0; ?>%;"></div>
                                                    </div>
                                                    <span class="text-sm"><?php echo $node['cpu_usage'] ?? 0; ?>%</span>
                                                </td>
                                                <td>
                                                    <div class="progress-bar" style="width: 100px;">
                                                        <div class="progress-fill" style="width: <?php echo $node['ram_usage_pct'] ?? 0; ?>%;"></div>
                                                    </div>
                                                    <span class="text-sm"><?php echo $node['ram_usage_pct'] ?? 0; ?>%</span>
                                                </td>
                                                <td><?php echo $node['servers_online'] ?? 0; ?> / <?php echo $node['servers_total'] ?? 0; ?></td>
                                                <td><?php echo $node['last_heartbeat'] ? date('d.m.Y H:i:s', strtotime($node['last_heartbeat'])) : 'Nie'; ?></td>
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
                            <h2 class="card-title">System-Informationen</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-grid">
                                <div class="detail-group">
                                    <label>Debian Status</label>
                                    <span><span class="badge badge-success">Online</span></span>
                                </div>
                                <div class="detail-group">
                                    <label>PHP Version</label>
                                    <span><?php echo PHP_VERSION; ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>MariaDB</label>
                                    <span><?php 
                                        try {
                                            $db = $this->app->db();
                                            $v = $db->queryOne("SELECT VERSION() as v");
                                            echo $v['v'] ?? 'Unbekannt';
                                        } catch (Exception $e) { echo 'Fehler'; }
                                    ?></span>
                                </div>
                                <div class="detail-group">
                                    <label>Speicher</label>
                                    <span><?php echo ini_get('memory_limit'); ?></span>
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

        function getStatusBadge(status) {
            const map = { 'online': 'success', 'offline': 'neutral', 'starting': 'warning', 'stopping': 'warning', 'error': 'error', 'installing': 'info', 'suspended': 'warning' };
            return map[status] || 'neutral';
        }

        function getPriorityBadge(priority) {
            const map = { 'low': 'success', 'normal': 'info', 'high': 'warning', 'urgent': 'error' };
            return map[priority] || 'neutral';
        }

        function getTicketStatusBadge(status) {
            const map = { 'open': 'info', 'in_progress': 'warning', 'waiting_customer': 'primary', 'waiting_support': 'warning', 'closed': 'success' };
            return map[status] || 'neutral';
        }
    </script>
</body>
</html>
