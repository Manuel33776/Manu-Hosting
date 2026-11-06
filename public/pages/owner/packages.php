<?php
// Owner Dashboard - Package Management
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakete - Owner Dashboard - Manu Hosting</title>
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
                    <li><a href="/owner/packages" class="nav-link active"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg><span>Pakete</span></a></li>
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
                <h1 class="page-title">Hosting-Pakete</h1>
                <div class="top-bar-actions">
                    <button class="btn btn-primary" onclick="openCreatePackageModal()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Neues Paket
                    </button>
                </div>
            </header>

            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Hosting-Pakete</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>RAM</th>
                                        <th>CPU</th>
                                        <th>Speicher</th>
                                        <th>Spieler</th>
                                        <th>Preis</th>
                                        <th>Features</th>
                                        <th>Server</th>
                                        <th>Status</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($packages)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">Keine Pakete vorhanden</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($packages as $package): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <span class="user-name"><?php echo htmlspecialchars($package['name']); ?></span>
                                                    <span class="user-id"><?php echo htmlspecialchars($package['slug']); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo $package['ram_mb']; ?> MB</td>
                                            <td><?php echo $package['cpu_cores']; ?> Kerne</td>
                                            <td><?php echo $package['disk_mb']; ?> MB</td>
                                            <td><?php echo $package['max_players']; ?></td>
                                            <td><?php echo number_format($package['price_monthly'] / 100, 2); ?> €/Monat</td>
                                            <td>
                                                <div class="feature-tags">
                                                    <?php if ($package['feature_backups']): ?><span class="badge badge-neutral">Backups</span><?php endif; ?>
                                                    <?php if ($package['feature_mods']): ?><span class="badge badge-neutral">Mods</span><?php endif; ?>
                                                    <?php if ($package['feature_plugins']): ?><span class="badge badge-neutral">Plugins</span><?php endif; ?>
                                                    <?php if ($package['feature_priority']): ?><span class="badge badge-primary">Priority</span><?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo $package['servers_count'] ?? 0; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $package['is_active'] ? 'success' : 'neutral'; ?>">
                                                    <?php echo $package['is_active'] ? 'Aktiv' : 'Inaktiv'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-ghost btn-sm" onclick="editPackage(<?php echo $package['id']; ?>)" title="Bearbeiten"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                                                    <button class="btn btn-ghost btn-sm text-error" onclick="togglePackageStatus(<?php echo $package['id']; ?>, <?php echo $package['is_active'] ? '0' : '1'; ?>)" title="<?php echo $package['is_active'] ? 'Deaktivieren' : 'Aktivieren'; ?>"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></button>
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

    <div class="modal" id="packageModal" style="display: none;">
        <div class="modal-overlay" onclick="closePackageModal()"></div>
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 id="packageModalTitle">Neues Paket</h3>
                <button class="modal-close" onclick="closePackageModal()"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <form id="packageForm" class="modal-body">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="id" id="packageId">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-input" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-input" required maxlength="50" pattern="[a-z0-9_-]+">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ram_mb">RAM (MB)</label>
                        <input type="number" id="ram_mb" name="ram_mb" class="form-input" required min="512" max="131072" step="512">
                    </div>
                    <div class="form-group">
                        <label for="cpu_cores">CPU Kerne</label>
                        <input type="number" id="cpu_cores" name="cpu_cores" class="form-input" required min="1" max="64">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="disk_mb">Speicher (MB)</label>
                        <input type="number" id="disk_mb" name="disk_mb" class="form-input" required min="1024" max="1048576" step="1024">
                    </div>
                    <div class="form-group">
                        <label for="max_players">Max. Spieler</label>
                        <input type="number" id="max_players" name="max_players" class="form-input" required min="1" max="500">
                    </div>
                </div>
                <div class="form-group">
                    <label for="price_monthly">Preis monatlich (Cent)</label>
                    <input type="number" id="price_monthly" name="price_monthly" class="form-input" required min="0" step="1">
                </div>
                <div class="form-group">
                    <label for="description">Beschreibung</label>
                    <textarea id="description" name="description" class="form-input" rows="3"></textarea>
                </div>
                <div class="form-group checkbox-group">
                    <label class="checkbox-label"><input type="checkbox" name="feature_backups" value="1" id="feature_backups"> Backups inklusive</label>
                    <label class="checkbox-label"><input type="checkbox" name="feature_mods" value="1" id="feature_mods"> Mods erlaubt</label>
                    <label class="checkbox-label"><input type="checkbox" name="feature_plugins" value="1" id="feature_plugins"> Plugins erlaubt</label>
                    <label class="checkbox-label"><input type="checkbox" name="feature_priority" value="1" id="feature_priority"> Priority Support</label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label"><input type="checkbox" name="is_active" value="1" id="is_active" checked> Aktiv</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closePackageModal()">Abbrechen</button>
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
            const form = document.getElementById('packageForm');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);
                    const id = data.id;
                    delete data.id;
                    delete data.csrf_token;
                    data.feature_backups = !!data.feature_backups;
                    data.feature_mods = !!data.feature_mods;
                    data.feature_plugins = !!data.feature_plugins;
                    data.feature_priority = !!data.feature_priority;
                    data.is_active = !!data.is_active;
                    try {
                        const url = id ? '/api/v1/packages/' + id : '/api/v1/packages';
                        const method = id ? 'PUT' : 'POST';
                        await api.request(url, { method, body: JSON.stringify(data) });
                        showToast('Paket ' + (id ? 'aktualisiert' : 'erstellt'), 'success');
                        closePackageModal();
                        setTimeout(() => location.reload(), 500);
                    } catch (err) { showToast(err.message, 'error'); }
                });
            }
        });
        function openCreatePackageModal() {
            document.getElementById('packageModalTitle').textContent = 'Neues Paket';
            document.getElementById('packageForm').reset();
            document.getElementById('packageId').value = '';
            document.getElementById('is_active').checked = true;
            document.getElementById('packageModal').style.display = 'flex';
        }
        function closePackageModal() { document.getElementById('packageModal').style.display = 'none'; }
        async function editPackage(id) {
            try {
                const pkg = await api.get('/api/v1/packages/' + id);
                const data = pkg.data || pkg;
                document.getElementById('packageModalTitle').textContent = 'Paket bearbeiten';
                document.getElementById('packageId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('slug').value = data.slug;
                document.getElementById('ram_mb').value = data.ram_mb;
                document.getElementById('cpu_cores').value = data.cpu_cores;
                document.getElementById('disk_mb').value = data.disk_mb;
                document.getElementById('max_players').value = data.max_players;
                document.getElementById('price_monthly').value = data.price_monthly;
                document.getElementById('description').value = data.description || '';
                document.getElementById('feature_backups').checked = !!data.feature_backups;
                document.getElementById('feature_mods').checked = !!data.feature_mods;
                document.getElementById('feature_plugins').checked = !!data.feature_plugins;
                document.getElementById('feature_priority').checked = !!data.feature_priority;
                document.getElementById('is_active').checked = !!data.is_active;
                document.getElementById('packageModal').style.display = 'flex';
            } catch (err) { showToast('Fehler beim Laden', 'error'); }
        }
        async function togglePackageStatus(id, isActive) {
            if (!confirm('Status wirklich ändern?')) return;
            try {
                await api.put('/api/v1/packages/' + id, { is_active: isActive == '1' });
                showToast('Status aktualisiert', 'success');
                setTimeout(() => location.reload(), 500);
            } catch (err) { showToast(err.message, 'error'); }
        }
    </script>
</body>
</html>
