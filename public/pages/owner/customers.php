<?php
// Owner Dashboard - Customer Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunden - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/customers" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Kunden</span></a></li>
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
                <h1 class="page-title">Kundenverwaltung</h1>
                <div class="top-bar-actions">
                    <button class="btn btn-primary" onclick="openCreateCustomerModal()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Neuer Kunde
                    </button>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="filter-form">
                            <div class="filter-row">
                                <div class="form-group">
                                    <label for="search">Suche</label>
                                    <input type="text" id="search" name="search" class="form-input" placeholder="Benutzername, E-Mail..." value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="role">Rolle</label>
                                    <select id="role" name="role" class="form-select">
                                        <option value="">Alle Rollen</option>
                                        <option value="customer" <?php echo ($filters['role'] ?? '') === 'customer' ? 'selected' : ''; ?>>Kunde</option>
                                        <option value="admin" <?php echo ($filters['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="support" <?php echo ($filters['role'] ?? '') === 'support' ? 'selected' : ''; ?>>Support</option>
                                        <option value="owner" <?php echo ($filters['role'] ?? '') === 'owner' ? 'selected' : ''; ?>>Owner</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Alle Status</option>
                                        <option value="active" <?php echo ($filters['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Aktiv</option>
                                        <option value="inactive" <?php echo ($filters['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inaktiv</option>
                                        <option value="banned" <?php echo ($filters['status'] ?? '') === 'banned' ? 'selected' : ''; ?>>Gesperrt</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filtern</button>
                                    <a href="/owner/customers" class="btn btn-secondary">Zurücksetzen</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Kunden (<?php echo $pagination['total']; ?>)</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Benutzer</th>
                                        <th>E-Mail</th>
                                        <th>Rolle</th>
                                        <th>Status</th>
                                        <th>Server</th>
                                        <th>Registriert</th>
                                        <th>Letzter Login</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($customers['data'])): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Keine Kunden gefunden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($customers['data'] as $customer): ?>
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <div class="user-avatar"><?php echo strtoupper($customer['username'][0]); ?></div>
                                                    <div>
                                                        <span class="user-name"><?php echo htmlspecialchars($customer['username']); ?></span>
                                                        <span class="user-id">#<?php echo $customer['id']; ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo match($customer['role']) {
                                                    'owner' => 'primary',
                                                    'admin' => 'error',
                                                    'support' => 'warning',
                                                    default => 'success',
                                                } ?>">
                                                    <?php echo ucfirst($customer['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo match($customer['status']) {
                                                    'active' => 'success',
                                                    'inactive' => 'neutral',
                                                    'banned' => 'error',
                                                    default => 'neutral',
                                                } ?>">
                                                    <span class="status-dot status-<?php echo $customer['status']; ?>"></span>
                                                    <?php echo ucfirst($customer['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $customer['servers_count'] ?? 0; ?></td>
                                            <td><?php echo formatDateTime($customer['created_at']); ?></td>
                                            <td><?php echo $customer['last_login'] ? formatDateTime($customer['last_login']) : '<span class="text-muted">Nie</span>'; ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="viewCustomer(<?php echo $customer['id']; ?>)" title="Details"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                                                    <?php if ($customer['role'] === 'customer'): ?>
                                                    <button class="btn btn-ghost btn-sm" onclick="editCustomer(<?php echo $customer['id']; ?>)" title="Bearbeiten"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm text-error" onclick="toggleCustomerStatus(<?php echo $customer['id']; ?>, '<?php echo $customer['status'] === 'active' ? 'inactive' : 'active'; ?>')" title="<?php echo $customer['status'] === 'active' ? 'Deaktivieren' : 'Aktivieren'; ?>"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></button>
                                                    <?php endif; ?>
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
                                    <a href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($filters)); ?>" class="pagination-link <?php echo $i === $pagination['page'] ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                <?php endfor; ?>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="customerModal" style="display: none;">
        <div class="modal-overlay" onclick="closeCustomerModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="customerModalTitle">Neuer Kunde</h3>
                <button class="modal-close" onclick="closeCustomerModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <form id="customerForm" class="modal-body">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="id" id="customerId">
                <div class="form-group">
                    <label for="username">Benutzername</label>
                    <input type="text" id="username" name="username" class="form-input" required minlength="3" maxlength="32" pattern="[a-zA-Z0-9_-]+">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="email" class="form-input" required maxlength="255">
                </div>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" id="password" name="password" class="form-input" minlength="8" id="passwordField">
                    <small class="form-hint" id="passwordHint">Bei Erstellung erforderlich</small>
                </div>
                <div class="form-group">
                    <label for="role">Rolle</label>
                    <select id="role" name="role" class="form-select">
                        <option value="customer">Kunde</option>
                        <option value="admin">Administrator</option>
                        <option value="support">Support</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="active">Aktiv</option>
                        <option value="inactive">Inaktiv</option>
                        <option value="banned">Gesperrt</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeCustomerModal()">Abbrechen</button>
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
            const form = document.getElementById('customerForm');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);
                    const id = data.id;
                    delete data.id;
                    delete data.csrf_token;
                    try {
                        const url = id ? '/api/v1/users/' + id : '/api/v1/users';
                        const method = id ? 'PUT' : 'POST';
                        const response = await api.request(url, { method, body: JSON.stringify(data) });
                        showToast('Kunde ' + (id ? 'aktualisiert' : 'erstellt'), 'success');
                        closeCustomerModal();
                        setTimeout(() => location.reload(), 500);
                    } catch (err) {
                        showToast(err.message, 'error');
                    }
                });
            }
        });
        function openCreateCustomerModal() {
            document.getElementById('customerModalTitle').textContent = 'Neuer Kunde';
            document.getElementById('customerForm').reset();
            document.getElementById('customerId').value = '';
            document.getElementById('passwordField').required = true;
            document.getElementById('passwordHint').textContent = 'Mindestens 8 Zeichen';
            document.getElementById('username').readOnly = false;
            document.getElementById('customerModal').style.display = 'flex';
        }
        function closeCustomerModal() {
            document.getElementById('customerModal').style.display = 'none';
        }
        async function viewCustomer(id) {
            try {
                const user = await api.get('/api/v1/users/' + id);
                const userData = user.data || user;
                document.getElementById('customerModalTitle').textContent = 'Kunden Details';
                document.getElementById('customerId').value = userData.id;
                document.getElementById('username').value = userData.username;
                document.getElementById('username').readOnly = true;
                document.getElementById('email').value = userData.email;
                document.getElementById('role').value = userData.role;
                document.getElementById('status').value = userData.status;
                document.getElementById('passwordField').required = false;
                document.getElementById('passwordHint').textContent = 'Leer lassen um beizubehalten';
                document.getElementById('passwordField').value = '';
                document.getElementById('customerModal').style.display = 'flex';
            } catch (err) {
                showToast('Fehler beim Laden', 'error');
            }
        }
        function editCustomer(id) { viewCustomer(id); }
        async function toggleCustomerStatus(id, newStatus) {
            if (!confirm('Status wirklich ändern?')) return;
            try {
                await api.put('/api/v1/users/' + id, { status: newStatus });
                showToast('Status aktualisiert', 'success');
                setTimeout(() => location.reload(), 500);
            } catch (err) { showToast(err.message, 'error'); }
        }
    </script>
</body>
</html>
