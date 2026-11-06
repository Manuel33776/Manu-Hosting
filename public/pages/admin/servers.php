<?php
// Admin Dashboard - Server Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server - Admin Dashboard - Manu Hosting</title>
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
                    <li><a href="/admin/servers" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2"/><path d="M2 14h20"/><path d="M2 22h20"/></svg><span>Server</span></a></li>
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
                <h1 class="page-title">Server-Verwaltung</h1>
                <div class="top-bar-actions">
                    <span class="badge badge-primary"><?php echo $pagination['total'] ?? 0; ?> Server</span>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Alle Server</h2>
                    </div>
                    <div class="card-body p-0">
                        <form method="GET" class="filter-form" style="padding: 1rem; border-bottom: 1px solid var(--border-color);">
                            <div class="filter-row">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Status</option>
                                        <option value="online" <?php echo ($filters['status'] ?? '') === 'online' ? 'selected' : ''; ?>>Online</option>
                                        <option value="offline" <?php echo ($filters['status'] ?? '') === 'offline' ? 'selected' : ''; ?>>Offline</option>
                                        <option value="starting" <?php echo ($filters['status'] ?? '') === 'starting' ? 'selected' : ''; ?>>Startet</option>
                                        <option value="stopping" <?php echo ($filters['status'] ?? '') === 'stopping' ? 'selected' : ''; ?>>Stoppt</option>
                                        <option value="error" <?php echo ($filters['status'] ?? '') === 'error' ? 'selected' : ''; ?>>Fehler</option>
                                        <option value="installing" <?php echo ($filters['status'] ?? '') === 'installing' ? 'selected' : ''; ?>>Installation</option>
                                        <option value="suspended" <?php echo ($filters['status'] ?? '') === 'suspended' ? 'selected' : ''; ?>>Gesperrt</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="node_id">Node</label>
                                    <select id="node_id" name="node_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Nodes</option>
                                        <?php foreach ($nodes as $node): ?>
                                            <option value="<?php echo $node['id']; ?>" <?php echo ($filters['node_id'] ?? '') == $node['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($node['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="software">Software</label>
                                    <select id="software" name="software" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle</option>
                                        <option value="paper" <?php echo ($filters['software'] ?? '') === 'paper' ? 'selected' : ''; ?>>Paper</option>
                                        <option value="purpur" <?php echo ($filters['software'] ?? '') === 'purpur' ? 'selected' : ''; ?>>Purpur</option>
                                        <option value="spigot" <?php echo ($filters['software'] ?? '') === 'spigot' ? 'selected' : ''; ?>>Spigot</option>
                                        <option value="vanilla" <?php echo ($filters['software'] ?? '') === 'vanilla' ? 'selected' : ''; ?>>Vanilla</option>
                                        <option value="fabric" <?php echo ($filters['software'] ?? '') === 'fabric' ? 'selected' : ''; ?>>Fabric</option>
                                        <option value="forge" <?php echo ($filters['software'] ?? '') === 'forge' ? 'selected' : ''; ?>>Forge</option>
                                        <option value="neoforge" <?php echo ($filters['software'] ?? '') === 'neoforge' ? 'selected' : ''; ?>>NeoForge</option>
                                        <option value="velocity" <?php echo ($filters['software'] ?? '') === 'velocity' ? 'selected' : ''; ?>>Velocity</option>
                                        <option value="bungeecord" <?php echo ($filters['software'] ?? '') === 'bungeecord' ? 'selected' : ''; ?>>BungeeCord</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="search">Suche</label>
                                    <input type="text" id="search" name="search" class="form-input" placeholder="Name, UUID, Kunde..." value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                                </div>
                            </div>
                        </form>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Server</th>
                                        <th>Kunde</th>
                                        <th>Node</th>
                                        <th>Version</th>
                                        <th>Software</th>
                                        <th>Status</th>
                                        <th>Spieler</th>
                                        <th>RAM</th>
                                        <th>CPU</th>
                                        <th>Erstellt</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($servers)): ?>
                                    <tr>
                                        <td colspan="11" class="text-center py-4 text-muted">Keine Server gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($servers as $server): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($server['name']); ?></span>
                                                    <span class="user-id"><?php echo htmlspecialchars($server['uuid']); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($server['username'] ?? 'Unbekannt'); ?></td>
                                            <td><?php echo htmlspecialchars($server['node_name'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($server['minecraft_version'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($server['software'] ?? '-'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo getStatusBadge($server['status'] ?? 'offline'); ?>">
                                                    <?php echo ucfirst($server['status'] ?? 'offline'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $server['players_online'] ?? 0; ?> / <?php echo $server['players_max'] ?? 0; ?></td>
                                            <td><?php echo $server['ram_usage'] ?? 0; ?>%</td>
                                            <td><?php echo $server['cpu_usage'] ?? 0; ?>%</td>
                                            <td><?php echo date('d.m.Y', strtotime($server['created_at'])); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="sendServerCommand(<?php echo $server['id']; ?>, 'start')" title="Starten" <?php echo ($server['status'] ?? '') === 'online' ? 'disabled' : ''; ?>><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm" onclick="sendServerCommand(<?php echo $server['id']; ?>, 'stop')" title="Stoppen" <?php echo ($server['status'] ?? '') === 'offline' ? 'disabled' : ''; ?>><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="6" width="12" height="12"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm" onclick="sendServerCommand(<?php echo $server['id']; ?>, 'restart')" title="Neustarten" <?php echo ($server['status'] ?? '') === 'offline' ? 'disabled' : ''; ?>><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 1-9 9"/><path d="M3 12V3h12"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm" onclick="viewServerConsole(<?php echo $server['id']; ?>)" title="Konsole"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (($pagination['last_page'] ?? 1) > 1): ?>
                        <div class="pagination" style="padding: 1rem; display: flex; justify-content: center; gap: 0.5rem;">
                            <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                                <a href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($filters)); ?>" class="btn btn-<?php echo $pagination['page'] == $i ? 'primary' : 'ghost'; ?> btn-sm"><?php echo $i; ?></a>
                            <?php endfor; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="consoleModal" style="display: none;">
        <div class="modal-overlay" onclick="closeConsoleModal()"></div>
        <div class="modal-content" style="max-width: 900px; max-height: 90vh;">
            <div class="modal-header">
                <h3 id="consoleTitle">Server-Konsole</h3>
                <div class="console-status">
                    <span class="status-indicator" id="consoleStatus"></span>
                    <span id="consoleStatusText">Verbinde...</span>
                </div>
                <button class="modal-close" onclick="closeConsoleModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body" style="padding: 0; height: 60vh; display: flex; flex-direction: column;">
                <div id="consoleOutput" class="console-output" style="flex: 1; overflow-y: auto; padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 13px; background: var(--bg-primary);"></div>
                <div style="padding: 1rem; border-top: 1px solid var(--border-color); display: flex; gap: 0.5rem;">
                    <input type="text" id="consoleInput" class="form-input" placeholder="Befehl eingeben..." style="flex: 1;" onkeydown="if(event.key==='Enter') sendConsoleCommand()">
                    <button class="btn btn-primary" onclick="sendConsoleCommand()">Senden</button>
                </div>
            </div>
        </div>
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

        function getStatusBadge(status) {
            const map = { 'online': 'success', 'offline': 'neutral', 'starting': 'warning', 'stopping': 'warning', 'error': 'error', 'installing': 'info', 'suspended': 'warning' };
            return map[status] || 'neutral';
        }

        async function sendServerCommand(id, command) {
            try {
                await api.post('/api/v1/servers/' + id + '/command', { command });
                showToast('Befehl gesendet: ' + command, 'success');
                setTimeout(() => location.reload(), 2000);
            } catch (err) {
                showToast(err.message, 'error');
            }
        }

        let consoleWs = null;
        let currentServerId = null;

        function viewServerConsole(id) {
            currentServerId = id;
            const modal = document.getElementById('consoleModal');
            modal.style.display = 'flex';
            
            document.getElementById('consoleTitle').textContent = 'Server-Konsole (ID: ' + id + ')';
            document.getElementById('consoleOutput').innerHTML = '<div class="text-muted">Verbinde mit Konsole...</div>';
            
            // Connect to WebSocket
            const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
            consoleWs = new WebSocket(`${protocol}//${window.location.host}/api/v1/servers/${id}/console`);
            
            consoleWs.onopen = () => {
                document.getElementById('consoleStatus').className = 'status-indicator status-online';
                document.getElementById('consoleStatusText').textContent = 'Verbunden';
            };
            
            consoleWs.onmessage = (event) => {
                const output = document.getElementById('consoleOutput');
                const line = document.createElement('div');
                line.textContent = event.data;
                output.appendChild(line);
                output.scrollTop = output.scrollHeight;
            };
            
            consoleWs.onclose = () => {
                document.getElementById('consoleStatus').className = 'status-indicator status-offline';
                document.getElementById('consoleStatusText').textContent = 'Getrennt';
            };
            
            consoleWs.onerror = () => {
                document.getElementById('consoleStatus').className = 'status-indicator status-offline';
                document.getElementById('consoleStatusText').textContent = 'Fehler';
            };
        }

        function closeConsoleModal() {
            if (consoleWs) {
                consoleWs.close();
                consoleWs = null;
            }
            currentServerId = null;
            document.getElementById('consoleModal').style.display = 'none';
        }

        function sendConsoleCommand() {
            const input = document.getElementById('consoleInput');
            const command = input.value.trim();
            if (!command || !consoleWs) return;
            
            consoleWs.send(command);
            input.value = '';
        }
    </script>
</body>
</html>
