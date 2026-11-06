<?php
/**
 * Customer Servers Dashboard
 * Lists all servers for the current customer
 */

$servers = $servers ?? [];
$pagination = $pagination ?? [];
$stats = $stats ?? [];
$nodes = $nodes ?? [];
$filters = $filters ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
            </svg>
            My Servers
        </h1>
        <p class="page-subtitle">Manage your Minecraft servers</p>
    </div>
    <a href="/dashboard/servers/create" class="btn btn-primary">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Create Server
    </a>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $stats["total"] ?? 0 ?></span>
            <span class="stat-label">Total Servers</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $stats["online"] ?? 0 ?></span>
            <span class="stat-label">Online</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $stats["offline"] ?? 0 ?></span>
            <span class="stat-label">Offline</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $stats["error"] ?? 0 ?></span>
            <span class="stat-label">Errors</span>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filters</h3>
    </div>
    <form method="GET" class="filters-form">
        <div class="filters-row">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="online" <?= ($filters["status"] ?? "") === "online" ? "selected" : "" ?>>Online</option>
                    <option value="offline" <?= ($filters["status"] ?? "") === "offline" ? "selected" : "" ?>>Offline</option>
                    <option value="starting" <?= ($filters["status"] ?? "") === "starting" ? "selected" : "" ?>>Starting</option>
                    <option value="stopping" <?= ($filters["status"] ?? "") === "stopping" ? "selected" : "" ?>>Stopping</option>
                    <option value="creating" <?= ($filters["status"] ?? "") === "creating" ? "selected" : "" ?>>Creating</option>
                    <option value="error" <?= ($filters["status"] ?? "") === "error" ? "selected" : "" ?>>Error</option>
                    <option value="suspended" <?= ($filters["status"] ?? "") === "suspended" ? "selected" : "" ?>>Suspended</option>
                </select>
            </div>
            <div class="form-group">
                <label for="node_id">Node</label>
                <select name="node_id" id="node_id" class="form-select">
                    <option value="">All Nodes</option>
                    <?php foreach ($nodes as $node): ?>
                        <option value="<?= $node["id"] ?>" <?= ($filters["node_id"] ?? "") == $node["id"] ? "selected" : "" ?>>
                            <?= htmlspecialchars($node["name"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Server name..." value="<?= htmlspecialchars($filters["search"] ?? "") ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/dashboard/servers" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<!-- Servers Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Your Servers</h3>
    </div>
    
    <?php if (empty($servers)): ?>
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
            </svg>
            <h4>No Servers Yet</h4>
            <p>You haven\'t created any servers yet. Get started by creating your first Minecraft server.</p>
            <a href="/dashboard/servers/create" class="btn btn-primary mt-4">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Create Your First Server
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Server</th>
                        <th>Node</th>
                        <th>Version</th>
                        <th>Software</th>
                        <th>Resources</th>
                        <th>Status</th>
                        <th>Players</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servers as $server): ?>
                        <tr>
                            <td>
                                <div class="server-info">
                                    <div class="server-name"><?= htmlspecialchars($server["name"]) ?></div>
                                    <div class="server-uuid"><?= htmlspecialchars(substr($server["uuid"], 0, 8)) ?>...</div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($server["node_name"] ?? "Unknown") ?></td>
                            <td><?= htmlspecialchars($server["version"]) ?></td>
                            <td>
                                <span class="badge badge-<?= strtolower($server["software"]) === "paper" ? "primary" : (strtolower($server["software"]) === "purpur" ? "purple" : "secondary") ?>">
                                    <?= htmlspecialchars($server["software"]) ?>
                                </span>
                            </td>
                            <td>
                                <div class="resource-info">
                                    <span><?= $server["ram"] ?> MB RAM</span>
                                    <span><?= $server["cpu"] ?>% CPU</span>
                                    <span><?= $server["disk"] ?> GB Disk</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $server["status"] ?>">
                                    <span class="status-dot"></span>
                                    <?= ucfirst($server["status"]) ?>
                                </span>
                            </td>
                            <td>
                                <span class="player-count"><?= $server["players_online"] ?? 0 ?>/<?= $server["players_max"] ?? 0 ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/dashboard/servers/<?= $server["id"] ?>" class="btn btn-sm btn-outline" title="Manage">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                                        </svg>
                                    </a>
                                    <?php if (in_array($server["status"], ["online", "offline", "stopped"])): ?>
                                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/start" class="inline-form" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-sm btn-success" title="Start">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polygon points="5 3 19 12 5 21 5 3"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($server["status"] === "online"): ?>
                                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/stop" class="inline-form" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-sm btn-error" title="Stop">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="6" y="4" width="12" height="16" rx="2"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/restart" class="inline-form" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-sm btn-warning" title="Restart">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M23 4v6h-6"/>
                                                    <path d="M1 20v-6h6"/>
                                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if (($pagination["total_pages"] ?? 1) > 1): ?>
            <nav class="pagination" aria-label="Server pagination">
                <?php 
                    $page = $pagination["current_page"] ?? 1;
                    $total = $pagination["total_pages"] ?? 1;
                    $baseUrl = "/dashboard/servers?" . http_build_query(array_filter($filters, function($k) { return $k !== "page"; }, ARRAY_FILTER_USE_KEY));
                ?>
                <?php if ($page > 1): ?>
                    <a href="<?= $baseUrl ?>&page=<?= $page - 1 ?>" class="btn btn-sm btn-outline">Previous</a>
                <?php endif; ?>
                
                <span class="pagination-info">Page <?= $page ?> of <?= $total ?></span>
                
                <?php if ($page < $total): ?>
                    <a href="<?= $baseUrl ?>&page=<?= $page + 1 ?>" class="btn btn-sm btn-outline">Next</a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
/* Servers Page Specific Styles */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

.stat-card {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-5);
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    transition: transform var(--transition-fast), box-shadow var(--transition-fast);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: var(--radius-lg);
}

.stat-icon.bg-primary { background: rgba(139, 92, 246, 0.15); color: var(--color-primary); }
.stat-icon.bg-success { background: rgba(34, 197, 94, 0.15); color: var(--color-success); }
.stat-icon.bg-warning { background: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
.stat-icon.bg-error { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }

.stat-icon svg { width: 24px; height: 24px; }

.stat-value {
    display: block;
    font-size: var(--text-2xl);
    font-weight: 700;
    color: var(--color-text);
    line-height: 1.2;
}

.stat-label {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}

.filters-form {
    padding: var(--space-4);
}

.filters-row {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-4);
    align-items: flex-end;
}

.filters-row .form-group {
    flex: 1;
    min-width: 180px;
}

.filters-row .form-group:last-child {
    min-width: auto;
    flex: 0 0 auto;
}

.server-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.server-name {
    font-weight: 500;
    color: var(--color-text);
}

.server-uuid {
    font-family: var(--font-mono);
    font-size: var(--text-xs);
    color: var(--color-text-muted);
}

.resource-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}

.player-count {
    font-family: var(--font-mono);
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: var(--space-2);
}

.inline-form {
    display: inline;
}

.empty-state {
    text-align: center;
    padding: var(--space-16) var(--space-8);
}

.empty-state svg {
    width: 80px;
    height: 80px;
    color: var(--color-text-muted);
    margin-bottom: var(--space-4);
}

.empty-state h4 {
    font-size: var(--text-xl);
    color: var(--color-text);
    margin-bottom: var(--space-2);
}

.empty-state p {
    color: var(--color-text-muted);
    margin-bottom: var(--space-6);
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    border-top: 1px solid var(--color-border);
}

.pagination-info {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    font-weight: 500;
    text-transform: capitalize;
}

.status-badge .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-online { background: rgba(34, 197, 94, 0.15); color: var(--color-success); }
.status-online .status-dot { background: var(--color-success); animation: pulse 2s ease-in-out infinite; }

.status-offline { background: rgba(113, 113, 122, 0.15); color: var(--color-text-muted); }
.status-offline .status-dot { background: var(--color-text-muted); }

.status-starting { background: rgba(139, 92, 246, 0.15); color: var(--color-primary); }
.status-starting .status-dot { background: var(--color-primary); animation: pulse 1s ease-in-out infinite; }

.status-stopping { background: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
.status-stopping .status-dot { background: var(--color-warning); animation: pulse 1s ease-in-out infinite; }

.status-creating { background: rgba(59, 130, 246, 0.15); color: var(--color-info); }
.status-creating .status-dot { background: var(--color-info); animation: pulse 1s ease-in-out infinite; }

.status-error { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }
.status-error .status-dot { background: var(--color-error); }

.status-suspended { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }
.status-suspended .status-dot { background: var(--color-error); }

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Table responsive */
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: var(--space-3) var(--space-4);
    text-align: left;
    border-bottom: 1px solid var(--color-border);
}

.table th {
    font-weight: 600;
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: var(--color-bg-secondary);
}

.table tbody tr:hover {
    background: var(--color-bg-secondary);
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
    font-size: var(--text-xs);
    font-weight: 500;
}

.badge-primary { background: rgba(139, 92, 246, 0.15); color: var(--color-primary); }
.badge-purple { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
.badge-secondary { background: rgba(113, 113, 122, 0.15); color: var(--color-text-muted); }

/* Responsive */
@media (max-width: 768px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filters-row .form-group {
        min-width: 0;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
}
</style>