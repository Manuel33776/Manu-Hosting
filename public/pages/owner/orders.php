<?php
// Owner Dashboard - Order Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellungen - Owner Dashboard - Manu Hosting</title>
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
                    <li class="nav-section">Ãœbersicht</li>
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
                    <li><a href="/owner/support" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span>Support</span></a></li>
                    <li><a href="/owner/orders" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg><span>Bestellungen</span></a></li>
                    <li><a href="/owner/audit-logs" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg><span>Audit-Logs</span></a></li>
                    <li><a href="/owner/settings" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg><span>Einstellungen</span></a></li>
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
                <h1 class="page-title">Bestellungen</h1>
                <div class="top-bar-actions">
                    <span class="badge badge-primary"><?php echo $pagination['total'] ?? 0; ?> Bestellungen</span>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Alle Bestellungen</h2>
                    </div>
                    <div class="card-body p-0">
                        <form method="GET" class="filter-form" style="padding: 1rem; border-bottom: 1px solid var(--border-color);">
                            <div class="filter-row">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Status</option>
                                        <option value="pending" <?php echo ($filters['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Ausstehend</option>
                                        <option value="paid" <?php echo ($filters['status'] ?? '') === 'paid' ? 'selected' : ''; ?>>Bezahlt</option>
                                        <option value="provisioning" <?php echo ($filters['status'] ?? '') === 'provisioning' ? 'selected' : ''; ?>>In Bereitstellung</option>
                                        <option value="active" <?php echo ($filters['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Aktiv</option>
                                        <option value="cancelled" <?php echo ($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Storniert</option>
                                        <option value="refunded" <?php echo ($filters['status'] ?? '') === 'refunded' ? 'selected' : ''; ?>>Erstattet</option>
                                        <option value="expired" <?php echo ($filters['status'] ?? '') === 'expired' ? 'selected' : ''; ?>>Abgelaufen</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="package_id">Paket</label>
                                    <select id="package_id" name="package_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Alle Pakete</option>
                                        <?php 
                                            $packages = $this->app->db()->query("SELECT id, name FROM packages ORDER BY name");
                                            foreach ($packages as $pkg): 
                                        ?>
                                            <option value="<?php echo $pkg['id']; ?>" <?php echo ($filters['package_id'] ?? '') == $pkg['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($pkg['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="search">Suche</label>
                                    <input type="text" id="search" name="search" class="form-input" placeholder="Bestellnummer, Kunde..." value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                                </div>
                            </div>
                        </form>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bestellnummer</th>
                                        <th>Kunde</th>
                                        <th>Paket</th>
                                        <th>Laufzeit</th>
                                        <th>Preis</th>
                                        <th>Status</th>
                                        <th>Erstellt</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Keine Bestellungen gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                                <span class="user-id"><?php echo htmlspecialchars($order['order_number'] ?? 'ORD-' . $order['id']); ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($order['username'] ?? 'Unbekannt'); ?></span>
                                                    <span class="user-id"><?php echo htmlspecialchars($order['email'] ?? ''); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($order['package_name'] ?? 'Unbekannt'); ?></td>
                                            <td><?php echo $order['billing_cycle'] ?? 'monthly'; ?></td>
                                            <td><?php echo number_format(($order['amount'] ?? 0) / 100, 2); ?> €</td>
                                            <td>
                                                <span class="badge badge-<?php echo getStatusBadgeClass($order['status'] ?? 'pending'); ?>">
                                                    <?php echo getStatusLabel($order['status'] ?? 'pending'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="viewOrderDetails(<?php echo $order['id']; ?>)" title="Details"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                                                    <?php if (in_array($order['status'] ?? '', ['pending', 'paid'])): ?>
                                                    <button class="btn btn-ghost btn-sm text-success" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'provisioning')" title="In Bereitstellung"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></button>
                                                    <?php endif; ?>
                                                    <?php if (in_array($order['status'] ?? '', ['provisioning', 'active'])): ?>
                                                    <button class="btn btn-ghost btn-sm text-warning" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'cancelled')" title="Stornieren"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></button>
                                                    <?php endif; ?>
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

    <div class="modal" id="orderModal" style="display: none;">
        <div class="modal-overlay" onclick="closeOrderModal()"></div>
        <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h3 id="orderModalTitle">Bestelldetails</h3>
                <button class="modal-close" onclick="closeOrderModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <div class="loading">Lade Bestelldetails...</div>
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

        function getStatusBadgeClass(status) {
            const classes = {
                'pending': 'warning',
                'paid': 'info',
                'provisioning': 'primary',
                'active': 'success',
                'cancelled': 'neutral',
                'refunded': 'neutral',
                'expired': 'error'
            };
            return classes[status] || 'neutral';
        }

        function getStatusLabel(status) {
            const labels = {
                'pending': 'Ausstehend',
                'paid': 'Bezahlt',
                'provisioning': 'In Bereitstellung',
                'active': 'Aktiv',
                'cancelled': 'Storniert',
                'refunded': 'Erstattet',
                'expired': 'Abgelaufen'
            };
            return labels[status] || status;
        }

        async function viewOrderDetails(id) {
            const modal = document.getElementById('orderModal');
            const body = document.getElementById('orderModalBody');
            modal.style.display = 'flex';
            
            try {
                const response = await api.get('/api/v1/orders/' + id);
                const order = response.data || response;
                
                body.innerHTML = `
                    <div class="detail-grid">
                        <div class="detail-group">
                            <label>Bestellnummer</label>
                            <span>${order.order_number || 'ORD-' + order.id}</span>
                        </div>
                        <div class="detail-group">
                            <label>Status</label>
                            <span><span class="badge badge-${getStatusBadgeClass(order.status)}">${getStatusLabel(order.status)}</span></span>
                        </div>
                        <div class="detail-group">
                            <label>Kunde</label>
                            <span>${order.username || 'Unbekannt'} (${order.email || 'keine E-Mail'})</span>
                        </div>
                        <div class="detail-group">
                            <label>Paket</label>
                            <span>${order.package_name || 'Unbekannt'}</span>
                        </div>
                        <div class="detail-group">
                            <label>Laufzeit</label>
                            <span>${order.billing_cycle || 'monthly'}</span>
                        </div>
                        <div class="detail-group">
                            <label>Preis</label>
                            <span>${(order.amount / 100).toFixed(2)} €</span>
                        </div>
                        <div class="detail-group">
                            <label>Erstellt</label>
                            <span>${new Date(order.created_at).toLocaleString('de-DE')}</span>
                        </div>
                        <div class="detail-group">
                            <label>Aktualisiert</label>
                            <span>${order.updated_at ? new Date(order.updated_at).toLocaleString('de-DE') : '-'}</span>
                        </div>
                        ${order.server_uuid ? `
                        <div class="detail-group">
                            <label>Server UUID</label>
                            <span class="user-id">${order.server_uuid}</span>
                        </div>
                        ` : ''}
                        ${order.notes ? `
                        <div class="detail-group" style="grid-column: 1 / -1;">
                            <label>Notizen</label>
                            <span>${order.notes}</span>
                        </div>
                        ` : ''}
                    </div>
                    <div class="modal-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                        ${order.status === 'pending' || order.status === 'paid' ? `
                            <button class="btn btn-primary" onclick="updateOrderStatus(${order.id}, 'provisioning')">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                In Bereitstellung
                            </button>
                        ` : ''}
                        ${order.status === 'provisioning' || order.status === 'active' ? `
                            <button class="btn btn-warning" onclick="updateOrderStatus(${order.id}, 'cancelled')">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Stornieren
                            </button>
                        ` : ''}
                        <button class="btn btn-secondary" onclick="closeOrderModal()">Schließen</button>
                    </div>
                `;
            } catch (err) {
                body.innerHTML = '<div class="text-error">Fehler beim Laden der Details</div>';
            }
        }

        function closeOrderModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        async function updateOrderStatus(id, status) {
            if (!confirm('Status wirklich auf "' + getStatusLabel(status) + '" ändern?')) return;
            try {
                await api.put('/api/v1/orders/' + id, { status });
                showToast('Status aktualisiert', 'success');
                closeOrderModal();
                setTimeout(() => location.reload(), 500);
            } catch (err) {
                showToast(err.message, 'error');
            }
        }
    </script>
</body>
</html>
