<?php
// Admin Dashboard - Ticket Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets - Admin Dashboard - Manu Hosting</title>
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
                    <li><a href="/admin/tickets" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Tickets</span></a></li>
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
                <h1 class="page-title">Ticket-Verwaltung</h1>
                <div class="top-bar-actions">
                    <span class="badge badge-primary"><?php echo $pagination['total'] ?? 0; ?> Tickets</span>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Alle Tickets</h2>
                    </div>
                    <div class="card-body p-0">
                        <form method="GET" class="filter-form" style="padding: 1rem; border-bottom: 1px solid var(--border-color);">
                            <div class="filter-row">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Status</option>
                                        <option value="open" <?php echo ($filters['status'] ?? '') === 'open' ? 'selected' : ''; ?>>Offen</option>
                                        <option value="in_progress" <?php echo ($filters['status'] ?? '') === 'in_progress' ? 'selected' : ''; ?>>In Bearbeitung</option>
                                        <option value="waiting_customer" <?php echo ($filters['status'] ?? '') === 'waiting_customer' ? 'selected' : ''; ?>>Wartet auf Kunde</option>
                                        <option value="waiting_support" <?php echo ($filters['status'] ?? '') === 'waiting_support' ? 'selected' : ''; ?>>Wartet auf Support</option>
                                        <option value="closed" <?php echo ($filters['status'] ?? '') === 'closed' ? 'selected' : ''; ?>>Geschlossen</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="priority">Priorität</label>
                                    <select id="priority" name="priority" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Prioritäten</option>
                                        <option value="low" <?php echo ($filters['priority'] ?? '') === 'low' ? 'selected' : ''; ?>>Niedrig</option>
                                        <option value="normal" <?php echo ($filters['priority'] ?? '') === 'normal' ? 'selected' : ''; ?>>Normal</option>
                                        <option value="high" <?php echo ($filters['priority'] ?? '') === 'high' ? 'selected' : ''; ?>>Hoch</option>
                                        <option value="urgent" <?php echo ($filters['priority'] ?? '') === 'urgent' ? 'selected' : ''; ?>>Dringend</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="search">Suche</label>
                                    <input type="text" id="search" name="search" class="form-input" placeholder="Betreff, Kunde..." value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                                </div>
                            </div>
                        </form>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Betreff</th>
                                        <th>Kunde</th>
                                        <th>Priorität</th>
                                        <th>Status</th>
                                        <th>Zugewiesen</th>
                                        <th>Erstellt</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($tickets)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Keine Tickets gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($tickets as $ticket): ?>
                                        <tr>
                                            <td><?php echo $ticket['id']; ?></td>
                                            <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($ticket['username'] ?? 'Unbekannt'); ?></span>
                                                    <span class="user-id"><?php echo htmlspecialchars($ticket['email'] ?? ''); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo getPriorityBadge($ticket['priority'] ?? 'normal'); ?>">
                                                    <?php echo ucfirst($ticket['priority'] ?? 'normal'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo getTicketStatusBadge($ticket['status'] ?? 'open'); ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $ticket['status'] ?? 'open')); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($ticket['assigned_username'] ?? '-'); ?></td>
                                            <td><?php echo date('d.m.Y H:i', strtotime($ticket['created_at'])); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="viewTicket(<?php echo $ticket['id']; ?>)" title="Anzeigen"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
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

    <div class="modal" id="ticketModal" style="display: none;">
        <div class="modal-overlay" onclick="closeTicketModal()"></div>
        <div class="modal-content" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h3 id="ticketModalTitle">Ticket</h3>
                <button class="modal-close" onclick="closeTicketModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body" id="ticketModalBody">
                <div class="loading">Lade Ticket...</div>
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

        function getPriorityBadge(priority) {
            const map = { 'low': 'success', 'normal': 'info', 'high': 'warning', 'urgent': 'error' };
            return map[priority] || 'neutral';
        }

        function getTicketStatusBadge(status) {
            const map = { 'open': 'info', 'in_progress': 'warning', 'waiting_customer': 'primary', 'waiting_support': 'warning', 'closed': 'success' };
            return map[status] || 'neutral';
        }

        async function viewTicket(id) {
            const modal = document.getElementById('ticketModal');
            const body = document.getElementById('ticketModalBody');
            modal.style.display = 'flex';
            
            try {
                const response = await api.get('/api/v1/tickets/' + id);
                const ticket = response.data || response;
                
                body.innerHTML = `
                    <div class="detail-grid" style="margin-bottom: 1rem;">
                        <div class="detail-group">
                            <label>ID</label>
                            <span class="user-id">#${ticket.id}</span>
                        </div>
                        <div class="detail-group">
                            <label>Status</label>
                            <span><span class="badge badge-${getTicketStatusBadge(ticket.status)}">${ticket.status.replace('_', ' ')}</span></span>
                        </div>
                        <div class="detail-group">
                            <label>Priorität</label>
                            <span><span class="badge badge-${getPriorityBadge(ticket.priority)}">${ticket.priority}</span></span>
                        </div>
                        <div class="detail-group">
                            <label>Kunde</label>
                            <span>${ticket.username || 'Unbekannt'} (${ticket.email || 'keine E-Mail'})</span>
                        </div>
                        <div class="detail-group">
                            <label>Zugewiesen</label>
                            <span>${ticket.assigned_username || 'Nicht zugewiesen'}</span>
                        </div>
                        <div class="detail-group">
                            <label>Erstellt</label>
                            <span>${new Date(ticket.created_at).toLocaleString('de-DE')}</span>
                        </div>
                        <div class="detail-group">
                            <label>Aktualisiert</label>
                            <span>${ticket.updated_at ? new Date(ticket.updated_at).toLocaleString('de-DE') : '-'}</span>
                        </div>
                    </div>
                    
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1rem; margin-bottom: 1rem;">
                        <h4>Nachrichten</h4>
                        <div id="ticketMessages">
                            ${ticket.messages && ticket.messages.length > 0 ? ticket.messages.map(msg => `
                                <div class="ticket-message" style="padding: 1rem; margin-bottom: 0.5rem; background: var(--bg-secondary); border-radius: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                        <span class="user-name">${msg.username || 'Unbekannt'}</span>
                                        <span class="text-sm text-muted">${new Date(msg.created_at).toLocaleString('de-DE')}</span>
                                    </div>
                                    <div>${msg.message}</div>
                                </div>
                            `).join('') : '<p class="text-muted">Keine Nachrichten</p>'}
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                        <h4>Antworten</h4>
                        <form onsubmit="replyTicket(event, ${ticket.id})" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <textarea id="replyMessage" class="form-input" rows="3" placeholder="Ihre Antwort..." required></textarea>
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <select id="replyStatus" class="form-select" style="width: auto;">
                                    <option value="">Status nicht ändern</option>
                                    <option value="in_progress">In Bearbeitung</option>
                                    <option value="waiting_customer">Wartet auf Kunde</option>
                                    <option value="waiting_support">Wartet auf Support</option>
                                    <option value="closed">Geschlossen</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Senden</button>
                            </div>
                        </form>
                    </div>
                `;
            } catch (err) {
                body.innerHTML = '<div class="text-error">Fehler beim Laden des Tickets</div>';
            }
        }

        function closeTicketModal() {
            document.getElementById('ticketModal').style.display = 'none';
        }

        async function replyTicket(event, ticketId) {
            event.preventDefault();
            const message = document.getElementById('replyMessage').value.trim();
            const status = document.getElementById('replyStatus').value;
            if (!message) return;
            
            try {
                await api.post('/api/v1/tickets/' + ticketId + '/messages', { message, status });
                showToast('Antwort gesendet', 'success');
                viewTicket(ticketId); // Reload
            } catch (err) {
                showToast(err.message, 'error');
            }
        }
    </script>
</body>
</html>
