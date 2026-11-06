<?php
// Owner - Admin Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administratoren - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/admins" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg><span>Administratoren</span></a></li>
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
                <h1 class="page-title">Administratoren</h1>
                <div class="top-bar-actions">
                    <button class="btn btn-primary btn-sm" id="createAdminBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Administrator erstellen
                    </button>
                </div>
            </header>

            <div class="page-content">
                <!-- Admin Table -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table" id="adminsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Benutzername</th>
                                        <th>E-Mail</th>
                                        <th>Rolle</th>
                                        <th>Status</th>
                                        <th>Berechtigungen</th>
                                        <th>Letzte Anmeldung</th>
                                        <th>Erstellt</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($admins['data'])): ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Keine Administratoren vorhanden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($admins['data'] as $admin): ?>
                                        <tr data-admin-id="<?= $admin['id'] ?>">
                                            <td><code class="server-id"><?= $admin['id'] ?></code></td>
                                            <td>
                                                <div class="server-name-cell">
                                                    <span class="server-name"><?= htmlspecialchars($admin['username']) ?></span>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($admin['email']) ?></td>
                                            <td>
                                                <span class="badge badge-<?= $admin['role'] === 'admin' ? 'primary' : 'secondary' ?>">
                                                    <?= ucfirst($admin['role']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $admin['status'] === 'active' ? 'success' : 'neutral' ?>">
                                                    <span class="status-dot status-<?= $admin['status'] ?>"></span>
                                                    <?= ucfirst($admin['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="permission-tags">
                                                    <?php 
                                                    $perms = json_decode($admin['permissions'] ?? '[]', true);
                                                    if (!empty($perms)):
                                                        foreach (array_slice($perms, 0, 3) as $perm):
                                                    ?>
                                                    <span class="badge badge-neutral" style="font-size: 10px;"><?= htmlspecialchars($perm) ?></span>
                                                    <?php endforeach; ?>
                                                    <?php if (count($perms) > 3): ?>
                                                    <span class="badge badge-neutral" style="font-size: 10px;">+<?= count($perms) - 3 ?> mehr</span>
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    <span class="text-muted" style="font-size: 12px;">Keine</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?= $admin['last_login_at'] ? formatDateTime($admin['last_login_at']) : 'Nie' ?></td>
                                            <td><?= formatDateTime($admin['created_at']) ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm btn-icon" data-action="edit" data-admin-id="<?= $admin['id'] ?>" title="Bearbeiten">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm btn-icon" data-action="reset-password" data-admin-id="<?= $admin['id'] ?>" data-admin-name="<?= htmlspecialchars($admin['username']) ?>" title="Passwort zurücksetzen">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm btn-icon" data-action="delete" data-admin-id="<?= $admin['id'] ?>" data-admin-name="<?= htmlspecialchars($admin['username']) ?>" title="Löschen">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if (($admins['last_page'] ?? 1) > 1): ?>
                        <div class="card-footer">
                            <div class="pagination">
                                <?php if (($admins['page'] ?? 1) > 1): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $admins['page'] - 1])) ?>" class="pagination-btn">&laquo; Zurück</a>
                                <?php endif; ?>
                                
                                <?php 
                                $start = max(1, ($admins['page'] ?? 1) - 2);
                                $end = min($admins['last_page'], $start + 4);
                                for ($i = $start; $i <= $end; $i++): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="pagination-btn <?= ($admins['page'] ?? 1) == $i ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                                
                                <?php if (($admins['page'] ?? 1) < ($admins['last_page'] ?? 1)): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => ($admins['page'] ?? 1) + 1])) ?>" class="pagination-btn">Weiter &raquo;</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Create/Edit Admin Modal -->
    <div class="modal-overlay" id="adminModal" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title" id="adminModalTitle">Administrator erstellen</h3>
                <button class="modal-close" id="adminModalClose">&times;</button>
            </div>
            <form id="adminForm" method="POST" data-ajax>
                <input type="hidden" name="admin_id" id="adminId">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Benutzername</label>
                        <input type="text" name="username" id="adminUsername" class="form-input" required minlength="3" maxlength="32" pattern="[a-zA-Z0-9_-]+">
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-Mail</label>
                        <input type="email" name="email" id="adminEmail" class="form-input" required>
                    </div>
                    <div class="form-group" id="passwordGroup">
                        <label class="form-label">Passwort</label>
                        <input type="password" name="password" id="adminPassword" class="form-input" required minlength="12" autocomplete="new-password">
                        <div class="form-hint">Mindestens 12 Zeichen, Groß-/Kleinschreibung, Zahl, Sonderzeichen</div>
                    </div>
                    <div class="form-group" id="passwordConfirmGroup">
                        <label class="form-label">Passwort bestätigen</label>
                        <input type="password" name="password_confirmation" id="adminPasswordConfirm" class="form-input" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rolle</label>
                        <select name="role" id="adminRole" class="form-select form-input" required>
                            <option value="admin">Administrator</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" id="adminStatus" class="form-select form-input">
                            <option value="active">Aktiv</option>
                            <option value="inactive">Inaktiv</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Berechtigungen</label>
                        <div class="permission-grid" id="permissionGrid">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="adminModalCancel">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
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

            // Permission definitions
            const allPermissions = <?= json_encode($permissions) ?>;
            const rolePermissions = {
                admin: allPermissions.admin || [],
                support: allPermissions.support || [],
            };

            // Render permission grid
            function renderPermissionGrid(selectedRole = 'admin', selectedPerms = []) {
                const container = document.getElementById('permissionGrid');
                if (!container) return;
                
                const perms = rolePermissions[selectedRole] || [];
                container.innerHTML = perms.map(perm => `
                    <label class="permission-checkbox">
                        <input type="checkbox" name="permissions[]" value="${perm}" ${selectedPerms.includes(perm) ? 'checked' : ''}>
                        <span>${perm}</span>
                    </label>
                `).join('');
            }

            // Modal elements
            const modal = document.getElementById('adminModal');
            const form = document.getElementById('adminForm');
            const title = document.getElementById('adminModalTitle');
            const adminId = document.getElementById('adminId');
            const usernameInput = document.getElementById('adminUsername');
            const emailInput = document.getElementById('adminEmail');
            const passwordGroup = document.getElementById('passwordGroup');
            const passwordConfirmGroup = document.getElementById('passwordConfirmGroup');
            const roleSelect = document.getElementById('adminRole');
            const statusSelect = document.getElementById('adminStatus');

            // Open create modal
            document.getElementById('createAdminBtn').addEventListener('click', () => {
                form.reset();
                adminId.value = '';
                title.textContent = 'Administrator erstellen';
                passwordGroup.style.display = '';
                passwordConfirmGroup.style.display = '';
                usernameInput.disabled = false;
                roleSelect.value = 'admin';
                statusSelect.value = 'active';
                renderPermissionGrid('admin');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Close modal
            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
            document.getElementById('adminModalClose').addEventListener('click', closeModal);
            document.getElementById('adminModalCancel').addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // Role change updates permissions
            roleSelect.addEventListener('change', () => {
                renderPermissionGrid(roleSelect.value);
            });

            // Edit admin
            document.querySelectorAll('[data-action="edit"]').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.stopPropagation();
                    const adminId = btn.dataset.adminId;
                    
                    try {
                        const response = await api.get(`/api/v1/admins/${adminId}`);
                        const admin = response;
                        
                        form.reset();
                        title.textContent = 'Administrator bearbeiten';
                        adminId.value = admin.id;
                        usernameInput.value = admin.username;
                        usernameInput.disabled = true;
                        emailInput.value = admin.email;
                        roleSelect.value = admin.role;
                        statusSelect.value = admin.status || 'active';
                        
                        passwordGroup.style.display = 'none';
                        passwordConfirmGroup.style.display = 'none';
                        document.getElementById('adminPassword').required = false;
                        document.getElementById('adminPasswordConfirm').required = false;
                        
                        const perms = JSON.parse(admin.permissions || '[]');
                        renderPermissionGrid(admin.role, perms);
                        
                        modal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    } catch (error) {
                        toast.error('Fehler beim Laden: ' + error.message);
                    }
                });
            });

            // Reset password
            document.querySelectorAll('[data-action="reset-password"]').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.stopPropagation();
                    const adminId = btn.dataset.adminId;
                    const adminName = btn.dataset.adminName;
                    
                    const confirmed = await confirmAction(
                        `Möchtest du das Passwort für "${adminName}" zurücksetzen? Ein temporäres Passwort wird generiert.`,
                        { title: 'Passwort zurücksetzen', danger: true }
                    );
                    if (!confirmed) return;

                    setLoading(btn, true);
                    try {
                        const response = await api.post(`/owner/admins/${adminId}/reset-password`);
                        if (response.temp_password) {
                            toast.success(`Temporäres Passwort: ${response.temp_password}`);
                            await copyToClipboard(response.temp_password, 'Passwort in Zwischenablage kopiert');
                        } else {
                            toast.success('Passwort zurückgesetzt');
                        }
                    } catch (error) {
                        toast.error(error.message);
                    } finally {
                        setLoading(btn, false);
                    }
                });
            });

            // Delete admin
            document.querySelectorAll('[data-action="delete"]').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.stopPropagation();
                    const adminId = btn.dataset.adminId;
                    const adminName = btn.dataset.adminName;
                    
                    const confirmed = await confirmAction(
                        `Möchtest du den Administrator "${adminName}" wirklich löschen?<br><br><strong>Zur Bestätigung gib den Benutzernamen ein:</strong>`,
                        { title: 'Administrator löschen', danger: true }
                    );
                    if (!confirmed) return;
                    
                    const nameConfirm = prompt(`Bitte bestätige durch Eingabe des Benutzernamens: ${adminName}`);
                    if (nameConfirm !== adminName) {
                        toast.error('Name stimmt nicht überein. Löschung abgebrochen.');
                        return;
                    }

                    setLoading(btn, true);
                    try {
                        await api.post(`/owner/admins/${adminId}/delete`);
                        toast.success('Administrator gelöscht');
                        setTimeout(() => window.location.reload(), 1000);
                    } catch (error) {
                        toast.error(error.message);
                    } finally {
                        setLoading(btn, false);
                    }
                });
            });

            // Form submit
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const submitBtn = form.querySelector('[type="submit"]');
                const isEdit = adminId.value !== '';
                const url = isEdit ? `/owner/admins/${adminId.value}` : '/owner/admins';
                const method = isEdit ? 'POST' : 'POST';
                
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                data.permissions = formData.getAll('permissions[]');
                
                setLoading(submitBtn, true);
                
                try {
                    await api.post(url, data);
                    toast.success(isEdit ? 'Administrator aktualisiert' : 'Administrator erstellt');
                    closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } catch (error) {
                    toast.error(error.message);
                } finally {
                    setLoading(submitBtn, false);
                }
            });

            // Initialize permission grid
            renderPermissionGrid('admin');
        });
    </script>
</body>
</html>
