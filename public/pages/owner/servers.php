<?php
// Owner - Server Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Verwaltung - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/servers" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg><span>Server</span></a></li>
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

        <main class="main-content">
            <header class="top-bar">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Sidebar umschalten">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="page-title">Server Verwaltung</h1>
                <div class="top-bar-actions">
                    <a href="/owner/servers/create" class="btn btn-primary btn-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Neuer Server
                    </a>
                </div>
            </header>

            <div class="page-content">
                <!-- Filter Bar -->
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="filter-form">
                            <div class="filter-row">
                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label">Suchen</label>
                                    <input type="text" name="search" class="form-input" placeholder="Name, UUID..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select form-input">
                                        <option value="">Alle</option>
                                        <option value="online" <?= ($filters['status'] ?? '') === 'online' ? 'selected' : '' ?>>Online</option>
                                        <option value="offline" <?= ($filters['status'] ?? '') === 'offline' ? 'selected' : '' ?>>Offline</option>
                                        <option value="starting" <?= ($filters['status'] ?? '') === 'starting' ? 'selected' : '' ?>>Startet</option>
                                        <option value="stopping" <?= ($filters['status'] ?? '') === 'stopping' ? 'selected' : '' ?>>Stoppt</option>
                                        <option value="error" <?= ($filters['status'] ?? '') === 'error' ? 'selected' : '' ?>>Fehler</option>
                                        <option value="suspended" <?= ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' ?>>Gespert</option>
                                        <option value="idle_shutdown" <?= ($filters['status'] ?? '') === 'idle_shutdown' ? 'selected' : '' ?>>Idle Shutdown</option>
                                        <option value="installing" <?= ($filters['status'] ?? '') === 'installing' ? 'selected' : '' ?>>Installation</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label">Node</label>
                                    <select name="node_id" class="form-select form-input">
                                        <option value="">Alle Nodes</option>
                                        <?php foreach ($nodes as $node): ?>
                                        <option value="<?= $node['id'] ?>" <?= ($filters['node_id'] ?? '') == $node['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($node['name']) ?> (<?= $node['status'] ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label class="form-label">Software</label>
                                    <select name="software" class="form-select form-input">
                                        <option value="">Alle</option>
                                        <option value="paper" <?= ($filters['software'] ?? '') === 'paper' ? 'selected' : '' ?>>Paper</option>
                                        <option value="purpur" <?= ($filters['software'] ?? '') === 'purpur' ? 'selected' : '' ?>>Purpur</option>
                                        <option value="spigot" <?= ($filters['software'] ?? '') === 'spigot' ? 'selected' : '' ?>>Spigot</option>
                                        <option value="vanilla" <?= ($filters['software'] ?? '') === 'vanilla' ? 'selected' : '' ?>>Vanilla</option>
                                        <option value="fabric" <?= ($filters['software'] ?? '') === 'fabric' ? 'selected' : '' ?>>Fabric</option>
                                        <option value="forge" <?= ($filters['software'] ?? '') === 'forge' ? 'selected' : '' ?>>Forge</option>
                                        <option value="neoforge" <?= ($filters['software'] ?? '') === 'neoforge' ? 'selected' : '' ?>>NeoForge</option>
                                        <option value="velocity" <?= ($filters['software'] ?? '') === 'velocity' ? 'selected' : '' ?>>Velocity</option>
                                        <option value="bungeecord" <?= ($filters['software'] ?? '') === 'bungeecord' ? 'selected' : '' ?>>BungeeCord</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin: 0; align-self: flex-end;">
                                    <button type="submit" class="btn btn-primary btn-sm">Filtern</button>
                                    <a href="/owner/servers" class="btn btn-secondary btn-sm">Zurücksetzen</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Server Table -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table" id="serversTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Kunde</th>
                                        <th>Version</th>
                                        <th>Software</th>
                                        <th>Node</th>
                                        <th>Status</th>
                                        <th>Spieler</th>
                                        <th>RAM</th>
                                        <th>CPU</th>
                                        <th>Erstellt</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($servers['data'])): ?>
                                    <tr>
                                        <td colspan="12" class="text-center py-4 text-muted">Keine Server gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($servers['data'] as $server): ?>
                                        <tr data-server-id="<?= $server['id'] ?>" data-server-uuid="<?= $server['uuid'] ?>">
                                            <td><code class="server-id"><?= $server['id'] ?></code></td>
                                            <td>
                                                <div class="server-name-cell">
                                                    <span class="server-name"><?= htmlspecialchars($server['name']) ?></span>
                                                    <span class="server-uuid"><?= substr($server['uuid'], 0, 8) ?></span>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($server['owner_name'] ?? 'Unbekannt') ?></td>
                                            <td><?= htmlspecialchars($server['version']) ?></td>
                                            <td>
                                                <span class="badge badge-neutral"><?= strtoupper($server['software']) ?></span>
                                            </td>
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
                                            <td><?= $server['players_online'] ?? 0 ?> / <?= $server['players_max'] ?? 20 ?></td>
                                            <td><?= $server['ram'] ?? 0 ?> MB</td>
                                            <td><?= $server['cpu'] ?? 0 ?>%</td>
                                            <td><?= formatDateTime($server['created_at']) ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <?php if ($server['status'] !== 'online' && $server['status'] !== 'starting'): ?>
                                                    <button class="btn btn-primary btn-sm btn-icon" data-action="start" data-server-id="<?= $server['id'] ?>" data-server-uuid="<?= $server['uuid'] ?>" title="Starten">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                                    </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($server['status'] === 'online'): ?>
                                                    <button class="btn btn-warning btn-sm btn-icon" data-action="restart" data-server-id="<?= $server['id'] ?>" data-server-uuid="<?= $server['uuid'] ?>" title="Neustarten">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                                    </button>
                                                    <button class="btn btn-secondary btn-sm btn-icon" data-action="stop" data-server-id="<?= $server['id'] ?>" data-server-uuid="<?= $server['uuid'] ?>" title="Stoppen">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="4" width="12" height="16" rx="2"/></svg>
                                                    </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($server['status'] !== 'suspended'): ?>
                                                    <button class="btn btn-warning btn-sm btn-icon" data-action="suspend" data-server-id="<?= $server['id'] ?>" title="Sperren">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                                    </button>
                                                    <?php else: ?>
                                                    <button class="btn btn-success btn-sm btn-icon" data-action="unsuspend" data-server-id="<?= $server['id'] ?>" title="Entsperren">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                    </button>
                                                    <?php endif; ?>
                                                    
                                                    <button class="btn btn-ghost btn-sm btn-icon" data-action="console" data-server-id="<?= $server['id'] ?>" data-server-uuid="<?= $server['uuid'] ?>" title="Konsole">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>
                                                    </button>
                                                    
                                                    <div class="dropdown">
                                                        <button class="btn btn-ghost btn-sm btn-icon dropdown-toggle" title="Mehr">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="/owner/servers/<?= $server['id'] ?>/logs">Logs</a>
                                                            <a class="dropdown-item" href="/owner/servers/<?= $server['id'] ?>/players">Spieler</a>
                                                            <a class="dropdown-item" href="/owner/servers/<?= $server['id'] ?>/files">Dateien</a>
                                                            <a class="dropdown-item" href="/owner/servers/<?= $server['id'] ?>/backups">Backups</a>
                                                            <a class="dropdown-item" href="/owner/servers/<?= $server['id'] ?>/settings">Einstellungen</a>
                                                            <div class="dropdown-divider"></div>
                                                            <button class="dropdown-item danger" data-action="delete" data-server-id="<?= $server['id'] ?>" data-server-name="<?= htmlspecialchars($server['name']) ?>">Löschen</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if (($servers['last_page'] ?? 1) > 1): ?>
                        <div class="card-footer">
                            <div class="pagination">
                                <?php if (($servers['page'] ?? 1) > 1): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $servers['page'] - 1])) ?>" class="pagination-btn">&laquo; Zurück</a>
                                <?php endif; ?>
                                
                                <?php 
                                $start = max(1, ($servers['page'] ?? 1) - 2);
                                $end = min($servers['last_page'], $start + 4);
                                for ($i = $start; $i <= $end; $i++): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="pagination-btn <?= ($servers['page'] ?? 1) == $i ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                                
                                <?php if (($servers['page'] ?? 1) < ($servers['last_page'] ?? 1)): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => ($servers['page'] ?? 1) + 1])) ?>" class="pagination-btn">Weiter &raquo;</a>
                                <?php endif; ?>
                            </div>
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
            // Sidebar toggle
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            if (toggle && sidebar) {
                toggle.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
            }

            // Dropdowns
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                if (toggle && menu) {
                    toggle.addEventListener('click', (e) => {
                        e.stopPropagation();
                        document.querySelectorAll('.dropdown-menu').forEach(m => {
                            if (m !== menu) m.style.display = 'none';
                        });
                        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                    });
                }
            });
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
            });

            // Action buttons
            document.querySelectorAll('[data-action]').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.stopPropagation();
                    const action = btn.dataset.action;
                    const serverId = btn.dataset.serverId;
                    const serverUuid = btn.dataset.serverUuid;
                    const serverName = btn.dataset.serverName;

                    if (action === 'delete') {
                        const confirmed = await confirmAction(
                            `Möchtest du den Server "${serverName}" wirklich löschen?<br><br><strong>Zur Bestätigung gib den Servernamen ein:</strong>`,
                            { title: 'Server löschen', danger: true, confirmText: 'Löschen' }
                        );
                        if (!confirmed) return;
                        
                        // Show input for confirmation
                        const nameConfirm = prompt(`Bitte bestätige durch Eingabe des Servernamens: ${serverName}`);
                        if (nameConfirm !== serverName) {
                            toast.error('Name stimmt nicht überein. Löschung abgebrochen.');
                            return;
                        }
                    }

                    setLoading(btn, true);
                    
                    try {
                        const response = await api.post(`/owner/servers/${serverId}/${action}`);
                        toast.success('Aktion erfolgreich');
                        setTimeout(() => window.location.reload(), 1000);
                    } catch (error) {
                        toast.error(error.message);
                    } finally {
                        setLoading(btn, false);
                    }
                });
            });
        });
    </script>
</body>
</html>
