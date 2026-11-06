<?php
// Admin Dashboard - Node Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nodes - Admin Dashboard - Manu Hosting</title>
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
                    <li><a href="/admin/nodes" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Nodes</span></a></li>
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
                <h1 class="page-title">Node-Verwaltung</h1>
                <div class="top-bar-actions">
                    <button class="btn btn-primary" onclick="openCreateNodeModal()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Node hinzufügen
                    </button>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Hosting-Nodes</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Host</th>
                                        <th>Typ</th>
                                        <th>Status</th>
                                        <th>CPU</th>
                                        <th>RAM</th>
                                        <th>Speicher</th>
                                        <th>Server</th>
                                        <th>Letzter Heartbeat</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($nodes)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">Keine Nodes konfiguriert</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($nodes as $node): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($node['name']); ?></span>
                                                    <span class="user-id">ID: <?php echo $node['id']; ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($node['host'] . ':' . ($node['port'] ?? 8443)); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo ($node['type'] ?? 'windows') === 'windows' ? 'info' : 'primary'; ?>">
                                                    <?php echo ucfirst($node['type'] ?? 'Windows'); ?>
                                                </span>
                                            </td>
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
                                            <td>
                                                <div class="progress-bar" style="width: 100px;">
                                                    <div class="progress-fill" style="width: <?php echo $node['disk_usage_pct'] ?? 0; ?>%;"></div>
                                                </div>
                                                <span class="text-sm"><?php echo $node['disk_usage_pct'] ?? 0; ?>%</span>
                                            </td>
                                            <td><?php echo $node['servers_online'] ?? 0; ?> / <?php echo $node['servers_total'] ?? 0; ?></td>
                                            <td><?php echo $node['last_heartbeat'] ? date('d.m.Y H:i:s', strtotime($node['last_heartbeat'])) : 'Nie'; ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="editNode(<?php echo $node['id']; ?>)" title="Bearbeiten"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm" onclick="testNodeConnection(<?php echo $node['id']; ?>)" title="Verbindung testen"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10"/><path d="M12 6v6l4 2"/></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="nodeModal" style="display: none;">
        <div class="modal-overlay" onclick="closeNodeModal()"></div>
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 id="nodeModalTitle">Node hinzufügen</h3>
                <button class="modal-close" onclick="closeNodeModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <form id="nodeForm" class="modal-body">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="id" id="nodeId">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-input" required maxlength="100">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="host">Host / IP</label>
                        <input type="text" id="host" name="host" class="form-input" required placeholder="z.B. 192.168.1.100">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="number" id="port" name="port" class="form-input" required min="1" max="65535" value="8443">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type">Typ</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="windows">Windows (DL580)</option>
                        <option value="linux">Linux</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="token">Node Token</label>
                    <input type="text" id="token" name="token" class="form-input" required placeholder="Wird automatisch generiert, wenn leer">
                    <small class="text-muted">Bei neuem Node: Leer lassen für automatische Generierung</small>
                </div>
                <div class="form-group">
                    <label class="checkbox-label"><input type="checkbox" name="is_active" value="1" id="is_active" checked> Aktiv</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeNodeModal()">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
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

            const form = document.getElementById('nodeForm');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);
                    const id = data.id;
                    delete data.id;
                    delete data.csrf_token;
                    data.is_active = !!data.is_active;
                    try {
                        const url = id ? '/api/v1/admin/nodes/' + id : '/api/v1/admin/nodes';
                        const method = id ? 'PUT' : 'POST';
                        await api.request(url, { method, body: JSON.stringify(data) });
                        showToast('Node ' + (id ? 'aktualisiert' : 'erstellt'), 'success');
                        closeNodeModal();
                        setTimeout(() => location.reload(), 500);
                    } catch (err) { showToast(err.message, 'error'); }
                });
            }
        });

        function openCreateNodeModal() {
            document.getElementById('nodeModalTitle').textContent = 'Node hinzufügen';
            document.getElementById('nodeForm').reset();
            document.getElementById('nodeId').value = '';
            document.getElementById('is_active').checked = true;
            document.getElementById('port').value = 8443;
            document.getElementById('nodeModal').style.display = 'flex';
        }

        function closeNodeModal() { document.getElementById('nodeModal').style.display = 'none'; }

        async function editNode(id) {
            try {
                const node = await api.get('/api/v1/admin/nodes/' + id);
                const data = node.data || node;
                document.getElementById('nodeModalTitle').textContent = 'Node bearbeiten';
                document.getElementById('nodeId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('host').value = data.host;
                document.getElementById('port').value = data.port || 8443;
                document.getElementById('type').value = data.type || 'windows';
                document.getElementById('token').value = data.token || '';
                document.getElementById('is_active').checked = !!data.is_active;
                document.getElementById('nodeModal').style.display = 'flex';
            } catch (err) { showToast('Fehler beim Laden', 'error'); }
        }

        async function testNodeConnection(id) {
            try {
                await api.post('/api/v1/admin/nodes/' + id + '/test', {});
                showToast('Verbindung erfolgreich', 'success');
            } catch (err) { showToast(err.message, 'error'); }
        }
    </script>
</body>
</html>
