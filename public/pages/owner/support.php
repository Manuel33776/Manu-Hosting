<?php
// Owner Dashboard - Support Tickets
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/maintenance" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="18"/><line x1="6" y1="12" x2="18" y2="12"/></svg><span>Wartung & Offline</span></a></li>
                    <li><a href="/owner/email" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span>E-Mail Config</span></a></li>
                    <li><a href="/owner/inventory" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L12 2L4 6L4 18L12 22L20 18L20 6Z"/></svg><span>Live Inventory</span></a></li>
                    <li><a href="/owner/anticheat" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/><path d="M12 6V12L16 14"/></svg><span>Anti-Cheat</span></a></li>
                    <li><a href="/owner/backups" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg><span>Backups</span></a></li>
                    <li><a href="/owner/support" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Support</span></a></li>
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
                <h1 class="page-title">Support Tickets</h1>
                <div class="top-bar-actions">
                    <div class="filter-group">
                        <select id="statusFilter" class="form-select" style="width: auto;">
                            <option value="">Alle Status</option>
                            <option value="open">Offen</option>
                            <option value="in_progress">In Bearbeitung</option>
                            <option value="waiting_customer">Wartet auf Kunde</option>
                            <option value="waiting_support">Wartet auf Support</option>
                            <option value="closed">Geschlossen</option>
                        </select>
                        <select id="priorityFilter" class="form-select" style="width: auto;">
                            <option value="">Alle Prioritäten</option>
                            <option value="low">Niedrig</option>
                            <option value="normal">Normal</option>
                            <option value="high">Hoch</option>
                            <option value="urgent">Dringend</option>
                        </select>
                        <button class="btn btn-secondary" onclick="loadTickets()">Aktualisieren</button>
                    </div>
                </div>
            </header>

            <div class="page-content">
                <!-- Stats -->
                <div class="stats-grid" style="margin-bottom: 24px;">
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-label">Gesamt Tickets</span></div>
                        <div class="stat-value" id="totalTickets"><?php echo $pagination['total']; ?></div>
                    </div>
                    <div class="stat-card error">
                        <div class="stat-header"><span class="stat-label">Offen</span></div>
                        <div class="stat-value" id="openTickets"><?php echo $ticket_stats['open'] ?? 0; ?></div>
                    </div>
                    <div class="stat-card warning">
                        <div class="stat-header"><span class="stat-label">In Bearbeitung</span></div>
                        <div class="stat-value" id="inProgressTickets"><?php echo $ticket_stats['in_progress'] ?? 0; ?></div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-header"><span class="stat-label">Geschlossen</span></div>
                        <div class="stat-value" id="closedTickets"><?php echo $ticket_stats['closed'] ?? 0; ?></div>
                    </div>
                </div>

                <!-- Tickets Table -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Alle Tickets</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Betreff</th>
                                        <th>Kunde</th>
                                        <th>Server</th>
                                        <th>Priorität</th>
                                        <th>Status</th>
                                        <th>Erstellt</th>
                                        <th>Letzte Aktualisierung</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody id="ticketsTableBody">
                                    <?php if (empty($tickets['data'])): ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Keine Tickets vorhanden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($tickets['data'] as $ticket): ?>
                                        <tr>
                                            <td><code class="text-sm">#<?php echo $ticket['id']; ?></code></td>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($ticket['subject']); ?></span>
                                                    <span class="user-id"><?php echo substr($ticket['message'], 0, 50) . '...'; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="user-cell">
                                                    <div class="user-avatar"><?php echo strtoupper($ticket['user_name'][0]); ?></div>
                                                    <span class="user-name"><?php echo htmlspecialchars($ticket['user_name']); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($ticket['server_name'] ?? '-'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo match($ticket['priority']) {
                                                    'low' => 'success',
                                                    'normal' => 'info',
                                                    'high' => 'warning',
                                                    'urgent' => 'error',
                                                    default => 'neutral',
                                                } ?>">
                                                    <?php echo ucfirst($ticket['priority']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo match($ticket['status']) {
                                                    'open' => 'error',
                                                    'in_progress' => 'warning',
                                                    'waiting_customer' => 'info',
                                                    'waiting_support' => 'primary',
                                                    'closed' => 'success',
                                                    default => 'neutral',
                                                } ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $ticket['status'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatDateTime($ticket['created_at']); ?></td>
                                            <td><?php echo formatDateTime($ticket['updated_at']); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="viewTicket(<?php echo $ticket['id']; ?>)" title="Anzeigen">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($pagination['last_page'] > 1): ?>
                        <div class="card-footer">
                            <nav class="pagination">
                                <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                                    <a href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($filters ?? [])); ?>" class="pagination-link <?php echo $i === $pagination['page'] ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                <?php endfor; ?>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Ticket Detail Modal -->
    <div class="modal" id="ticketDetailModal" style="display: none;">
        <div class="modal-overlay" onclick="closeTicketDetail()"></div>
        <div class="modal-content" style="max-width: 900px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h3 id="ticketDetailTitle">Ticket Details</h3>
                <button class="modal-close" onclick="closeTicketDetail()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body" id="ticketDetailContent"></div>
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

        async function viewTicket(id) {
            try {
                const response = await api.get('/api/v1/tickets/' + id);
                const ticket = response.data || response;
                document.getElementById('ticketDetailTitle').textContent = 'Ticket #' + id + ' - ' + ticket.subject;
                let html = `
                    <div class="ticket-detail">
                        <div class="ticket-header">
                            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="badge badge-${ticket.status === 'closed' ? 'success' : (ticket.status === 'open' ? 'error' : 'warning')}">${ticket.status}</span></span></div>
                            <div class="detail-row"><span class="detail-label">Priorität</span><span class="detail-value"><span class="badge badge-${ticket.priority === 'urgent' ? 'error' : (ticket.priority === 'high' ? 'warning' : 'info')}">${ticket.priority}</span></span></div>
                            <div class="detail-row"><span class="detail-label">Kunde</span><span class="detail-value">${ticket.user_name} (${ticket.user_email})</span></div>
                            <div class="detail-row"><span class="detail-label">Server</span><span class="detail-value">${ticket.server_name || '-'}</span></div>
                            <div class="detail-row"><span class="detail-label">Erstellt</span><span class="detail-value">${formatDateTime(ticket.created_at)}</span></div>
                            <div class="detail-row"><span class="detail-label">Aktualisiert</span><span class="detail-value">${formatDateTime(ticket.updated_at)}</span></div>
                        </div>
                        <div class="ticket-messages">
                            <h4>Nachrichten</h4>
                            ${(ticket.messages || []).map(m => `
                                <div class="message ${m.is_staff ? 'staff' : 'customer'}">
                                    <div class="message-header">
                                        <span class="message-author">${m.author_name} (${m.is_staff ? 'Support' : 'Kunde'})</span>
                                        <span class="message-time">${formatDateTime(m.created_at)}</span>
                                    </div>
                                    <div class="message-content">${m.message}</div>
                                </div>
                            `).join('')}
                        </div>
                        <div class="ticket-reply">
                            <h4>Antworten</h4>
                            <form onsubmit="replyTicket(event, ${id})">
                                <div class="form-group">
                                    <textarea name="message" class="form-input" rows="4" required placeholder="Ihre Antwort..."></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="reply_status">Status ändern</label>
                                        <select name="status" class="form-select">
                                            <option value="">Nicht ändern</option>
                                            <option value="in_progress">In Bearbeitung</option>
                                            <option value="waiting_customer">Wartet auf Kunde</option>
                                            <option value="waiting_support">Wartet auf Support</option>
                                            <option value="closed">Geschlossen</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Antwort senden</button>
                            </form>
                        </div>
                    </div>
                `;
                document.getElementById('ticketDetailContent').innerHTML = html;
                document.getElementById('ticketDetailModal').style.display = 'flex';
            } catch (err) {
                showToast('Fehler: ' + err.message, 'error');
            }
        }

        async function replyTicket(event, id) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            try {
                await api.post('/api/v1/tickets/' + id + '/reply', data);
                showToast('Antwort gesendet', 'success');
                closeTicketDetail();
            } catch (err) {
                showToast('Fehler: ' + err.message, 'error');
            }
        }

        function closeTicketDetail() {
            document.getElementById('ticketDetailModal').style.display = 'none';
        }
    </script>
</body>
</html>
