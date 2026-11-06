<?php
// Admin Dashboard - Audit Logs
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit-Logs - Admin Dashboard - Manu Hosting</title>
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
                    <li><a href="/admin/platform" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Plattform</span></a></li>
                    <li><a href="/admin/audit-logs" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg><span>Audit-Logs</span></a></li>
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
                <h1 class="page-title">Audit-Logs</h1>
                <div class="top-bar-actions">
                    <span class="badge badge-primary"><?php echo $pagination['total'] ?? 0; ?> Einträge</span>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">System Audit-Logs</h2>
                    </div>
                    <div class="card-body p-0">
                        <form method="GET" class="filter-form" style="padding: 1rem; border-bottom: 1px solid var(--border-color);">
                            <div class="filter-row">
                                <div class="form-group">
                                    <label for="user_id">Benutzer</label>
                                    <select id="user_id" name="user_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Benutzer</option>
                                        <?php 
                                            $users = $this->app->db()->query("SELECT id, username FROM users ORDER BY username");
                                            foreach ($users as $u): 
                                        ?>
                                            <option value="<?php echo $u['id']; ?>" <?php echo ($filters['user_id'] ?? '') == $u['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($u['username']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="action">Aktion</label>
                                    <select id="action" name="action" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Aktionen</option>
                                        <?php 
                                            $actions = $this->app->db()->query("SELECT DISTINCT action FROM audit_logs ORDER BY action");
                                            foreach ($actions as $a): 
                                        ?>
                                            <option value="<?php echo htmlspecialchars($a['action']); ?>" <?php echo ($filters['action'] ?? '') === $a['action'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($a['action']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_from">Von</label>
                                    <input type="date" id="date_from" name="date_from" class="form-input" value="<?php echo htmlspecialchars($filters['date_from'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="date_to">Bis</label>
                                    <input type="date" id="date_to" name="date_to" class="form-input" value="<?php echo htmlspecialchars($filters['date_to'] ?? ''); ?>">
                                </div>
                            </div>
                        </form>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Zeitpunkt</th>
                                        <th>Benutzer</th>
                                        <th>Aktion</th>
                                        <th>Ressource</th>
                                        <th>Ressourcen-ID</th>
                                        <th>IP-Adresse</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($logs)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Keine Audit-Logs gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?php echo date('d.m.Y H:i:s', strtotime($log['created_at'])); ?></td>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($log['username'] ?? 'System'); ?></span>
                                                    <span class="user-id">ID: <?php echo $log['user_id'] ?? '-'; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo getActionBadgeClass($log['action']); ?>">
                                                    <?php echo htmlspecialchars($log['action']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($log['resource_type'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($log['resource_id'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($log['ip_address'] ?? '-'); ?></td>
                                            <td>
                                                <button class="btn btn-ghost btn-sm" onclick="viewLogDetails(<?php echo htmlspecialchars(json_encode($log), ENT_QUOTES, 'UTF-8'); ?>)" title="Details"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
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

    <div class="modal" id="logModal" style="display: none;">
        <div class="modal-overlay" onclick="closeLogModal()"></div>
        <div class="modal-content" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h3>Log-Details</h3>
                <button class="modal-close" onclick="closeLogModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body" id="logModalBody">
                <div class="loading">Lade Details...</div>
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

        function getActionBadgeClass(action) {
            if (!action) return 'neutral';
            const actionLower = action.toLowerCase();
            if (actionLower.includes('create') || actionLower.includes('add')) return 'success';
            if (actionLower.includes('update') || actionLower.includes('edit') || actionLower.includes('modify') || actionLower.includes('change')) return 'warning';
            if (actionLower.includes('delete') || actionLower.includes('remove') || actionLower.includes('destroy')) return 'error';
            if (actionLower.includes('login') || actionLower.includes('auth')) return 'info';
            if (actionLower.includes('suspend') || actionLower.includes('ban') || actionLower.includes('block')) return 'error';
            if (actionLower.includes('activate') || actionLower.includes('enable') || actionLower.includes('start')) return 'success';
            if (actionLower.includes('deactivate') || actionLower.includes('disable') || actionLower.includes('stop')) return 'warning';
            return 'primary';
        }

        function viewLogDetails(log) {
            const modal = document.getElementById('logModal');
            const body = document.getElementById('logModalBody');
            modal.style.display = 'flex';
            
            body.innerHTML = `
                <div class="detail-grid">
                    <div class="detail-group">
                        <label>ID</label>
                        <span class="user-id">${log.id}</span>
                    </div>
                    <div class="detail-group">
                        <label>Zeitpunkt</label>
                        <span>${new Date(log.created_at).toLocaleString('de-DE')}</span>
                    </div>
                    <div class="detail-group">
                        <label>Benutzer</label>
                        <span>${log.username || 'System'} (ID: ${log.user_id || '-'})</span>
                    </div>
                    <div class="detail-group">
                        <label>Aktion</label>
                        <span><span class="badge badge-${getActionBadgeClass(log.action)}">${log.action}</span></span>
                    </div>
                    <div class="detail-group">
                        <label>Ressource</label>
                        <span>${log.resource_type || '-'}</span>
                    </div>
                    <div class="detail-group">
                        <label>Ressourcen-ID</label>
                        <span class="user-id">${log.resource_id || '-'}</span>
                    </div>
                    <div class="detail-group">
                        <label>IP-Adresse</label>
                        <span>${log.ip_address || '-'}</span>
                    </div>
                    <div class="detail-group">
                        <label>User Agent</label>
                        <span class="user-id" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${log.user_agent || '-'}</span>
                    </div>
                    ${log.old_values ? `
                    <div class="detail-group" style="grid-column: 1 / -1;">
                        <label>Alte Werte</label>
                        <pre class="json-preview">${JSON.stringify(log.old_values, null, 2)}</pre>
                    </div>
                    ` : ''}
                    ${log.new_values ? `
                    <div class="detail-group" style="grid-column: 1 / -1;">
                        <label>Neue Werte</label>
                        <pre class="json-preview">${JSON.stringify(log.new_values, null, 2)}</pre>
                    </div>
                    ` : ''}
                    ${log.metadata ? `
                    <div class="detail-group" style="grid-column: 1 / -1;">
                        <label>Metadaten</label>
                        <pre class="json-preview">${JSON.stringify(log.metadata, null, 2)}</pre>
                    </div>
                    ` : ''}
                </div>
            `;
        }

        function closeLogModal() {
            document.getElementById('logModal').style.display = 'none';
        }
    </script>
</body>
</html>
