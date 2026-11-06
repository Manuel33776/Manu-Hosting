<?php
/**
 * Server Detail Page
 * Shows detailed information about a specific server
 */

$server = $server ?? [];
$backups = $backups ?? [];
$idle_config = $idle_config ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
            </svg>
            <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">
            Server ID: <?= $server["id"] ?> | 
            UUID: <?= htmlspecialchars($server["uuid"] ?? "") ?> |
            Node: <?= htmlspecialchars($server["node_name"] ?? "Unknown") ?>
        </p>
    </div>
    <div class="page-actions">
        <a href="/dashboard/servers" class="btn btn-secondary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Servers
        </a>
    </div>
</div>

<!-- Server Status & Quick Stats -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-icon bg-<?= $server["status"] === "online" ? "success" : ($server["status"] === "starting" ? "primary" : "text-muted") ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <?php if ($server["status"] === "online"): ?>
                    <path d="M12 6v6l4 2"/>
                <?php elseif ($server["status"] === "starting"): ?>
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                <?php else: ?>
                    <path d="M15 9l-6 6M9 9l6 6"/>
                <?php endif; ?>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= ucfirst($server["status"] ?? "unknown") ?></span>
            <span class="stat-label">Server Status</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon bg-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $server["players_online"] ?? 0 ?>/<?= $server["players_max"] ?? 0 ?></span>
            <span class="stat-label">Players Online</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon bg-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $server["ram"] ?? 0 ?> MB</span>
            <span class="stat-label">Allocated RAM</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon bg-info">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="stat-content">
            <span class="stat-value"><?= $server["cpu"] ?? 0 ?>%</span>
            <span class="stat-label">CPU Limit</span>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<nav class="tabs" role="tablist">
    <a href="/dashboard/servers/<?= $server["id"] ?>" class="tab <?= basename($_SERVER["REQUEST_URI"]) === "" || strpos($_SERVER["REQUEST_URI"], "/servers/") !== false && strpos($_SERVER["REQUEST_URI"], "/servers/") === strlen($_SERVER["REQUEST_URI"]) - 1 ? "active" : "" ?>" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="M6 8h12M6 12h12M6 16h8"/>
        </svg>
        Overview
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/console" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="M6 8h12M6 12h12M6 16h8"/>
        </svg>
        Console
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/logs" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        Logs
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/players" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Players
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/files" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
            <polyline points="13 2 13 9 20 9"/>
        </svg>
        Files
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/backups" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
            <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
        </svg>
        Backups
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/schedule" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        Schedule
    </a>
    <a href="/dashboard/servers/<?= $server["id"] ?>/settings" class="tab" role="tab">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
        Settings
    </a>
</nav>

<!-- Overview Content -->
<div class="tab-content active">
    <div class="grid grid-2">
        <!-- Server Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Server Information</h3>
            </div>
            <div class="card-body">
                <dl class="info-list">
                    <dt>Server Name</dt>
                    <dd><?= htmlspecialchars($server["name"] ?? "") ?></dd>
                    
                    <dt>Server UUID</dt>
                    <dd><code><?= htmlspecialchars($server["uuid"] ?? "") ?></code></dd>
                    
                    <dt>Minecraft Version</dt>
                    <dd><?= htmlspecialchars($server["version"] ?? "") ?></dd>
                    
                    <dt>Server Software</dt>
                    <dd>
                        <span class="badge badge-<?= strtolower($server["software"]) === "paper" ? "primary" : (strtolower($server["software"]) === "purpur" ? "purple" : "secondary") ?>">
                            <?= htmlspecialchars($server["software"]) ?>
                        </span>
                    </dd>
                    
                    <dt>Java Version</dt>
                    <dd><?= htmlspecialchars($server["java_version"] ?? "") ?></dd>
                    
                    <dt>Port</dt>
                    <dd><?= $server["port"] ?? "N/A" ?></dd>
                    
                    <dt>Node</dt>
                    <dd><?= htmlspecialchars($server["node_name"] ?? "Unknown") ?></dd>
                    
                    <dt>Created</dt>
                    <dd><?= date("Y-m-d H:i:s", strtotime($server["created_at"] ?? "now")) ?></dd>
                    
                    <dt>Last Seen</dt>
                    <dd><?= $server["last_seen"] ? date("Y-m-d H:i:s", strtotime($server["last_seen"])) : "Never" ?></dd>
                </dl>
            </div>
        </div>
        
        <!-- Resource Allocation -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resource Allocation</h3>
            </div>
            <div class="card-body">
                <div class="resource-bars">
                    <div class="resource-bar">
                        <div class="resource-label">
                            <span>RAM</span>
                            <span><?= $server["ram"] ?? 0 ?> MB</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= min(100, (($server["ram"] ?? 0) / 8192) * 100) ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="resource-bar">
                        <div class="resource-label">
                            <span>CPU</span>
                            <span><?= $server["cpu"] ?? 0 ?>%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= $server["cpu"] ?? 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="resource-bar">
                        <div class="resource-label">
                            <span>Disk</span>
                            <span><?= $server["disk"] ?? 0 ?> GB</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= min(100, (($server["disk"] ?? 0) / 100) * 100) ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="resource-bar">
                        <div class="resource-label">
                            <span>Player Slots</span>
                            <span><?= $server["players_max"] ?? 0 ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= min(100, (($server["players_max"] ?? 0) / 100) * 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Idle Shutdown Config -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Idle Shutdown</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/settings">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" name="idle_shutdown_enabled" value="1" <?= ($idle_config["enabled"] ?? false) ? "checked" : "" ?>>
                            Enable automatic shutdown when server is empty
                        </label>
                        <p class="form-help">Server will shut down after the specified timeout when no players are online.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="idle_shutdown_timeout" class="form-label">Idle Timeout (seconds)</label>
                        <input type="number" name="idle_shutdown_timeout" id="idle_shutdown_timeout" class="form-input" min="10" max="3600" value="<?= $idle_config["timeout"] ?? 60 ?>">
                        <p class="form-help">Default: 60 seconds. Minimum: 10 seconds. Maximum: 3600 seconds (1 hour).</p>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="action-grid">
                    <?php if (in_array($server["status"], ["offline", "stopped"])): ?>
                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/start">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <button type="submit" class="btn btn-success btn-block">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"/>
                                </svg>
                                Start Server
                            </button>
                        </form>
                    <?php elseif ($server["status"] === "online"): ?>
                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/restart">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <button type="submit" class="btn btn-warning btn-block">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M23 4v6h-6"/>
                                    <path d="M1 20v-6h6"/>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                                </svg>
                                Restart Server
                            </button>
                        </form>
                        
                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/stop" class="mt-3">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <button type="submit" class="btn btn-error btn-block">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="6" y="4" width="12" height="16" rx="2"/>
                                </svg>
                                Stop Server
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            Server is currently <?= $server["status"] ?>. Please wait...
                        </div>
                    <?php endif; ?>
                    
                    <a href="/dashboard/servers/<?= $server["id"] ?>/console" class="btn btn-primary btn-block">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M6 8h12M6 12h12M6 16h8"/>
                        </svg>
                        Open Console
                    </a>
                    
                    <a href="/dashboard/servers/<?= $server["id"] ?>/files" class="btn btn-secondary btn-block">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                            <polyline points="13 2 13 9 20 9"/>
                        </svg>
                        File Manager
                    </a>
                    
                    <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/backups" class="mt-3">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <button type="submit" class="btn btn-outline btn-block">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                                <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
                            </svg>
                            Create Backup
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Backups -->
    <?php if (!empty($backups)): ?>
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">Recent Backups</h3>
                <a href="/dashboard/servers/<?= $server["id"] ?>/backups" class="btn btn-sm btn-outline">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($backups, 0, 5) as $backup): ?>
                                <tr>
                                    <td><?= htmlspecialchars($backup["name"] ?? "Backup") ?></td>
                                    <td><span class="badge badge-<?= $backup["type"] === "manual" ? "primary" : "secondary" ?>"><?= ucfirst($backup["type"] ?? "auto") ?></span></td>
                                    <td><?= $backup["size"] ? formatBytes($backup["size"]) : "N/A" ?></td>
                                    <td>
                                        <span class="status-badge status-<?= $backup["status"] ?>">
                                            <?= ucfirst($backup["status"]) ?>
                                        </span>
                                    </td>
                                    <td><?= date("Y-m-d H:i:s", strtotime($backup["created_at"])) ?></td>
                                    <td>
                                        <?php if ($backup["status"] === "completed"): ?>
                                            <a href="/dashboard/servers/<?= $server["id"] ?>/backups/<?= $backup["id"] ?>/download" class="btn btn-sm btn-outline">Download</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
function formatBytes($bytes, $precision = 2) {
    $units = ["B", "KB", "MB", "GB", "TB"];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . " " . $units[$pow];
}
?>

<style>
/* Server Show Page Styles */
.tabs {
    display: flex;
    gap: var(--space-1);
    padding: var(--space-1);
    background: var(--color-bg-secondary);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-6);
    overflow-x: auto;
    border: 1px solid var(--color-border);
}

.tab {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-md);
    color: var(--color-text-muted);
    text-decoration: none;
    font-size: var(--text-sm);
    font-weight: 500;
    white-space: nowrap;
    transition: all var(--transition-fast);
}

.tab:hover {
    color: var(--color-text);
    background: var(--color-bg-tertiary);
}

.tab.active {
    color: var(--color-primary);
    background: rgba(139, 92, 246, 0.1);
}

.tab .icon {
    width: 18px;
    height: 18px;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

.grid {
    display: grid;
    gap: var(--space-5);
}

.grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
}

.info-list {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: var(--space-3) var(--space-6);
}

.info-list dt {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    font-weight: 500;
}

.info-list dd {
    font-size: var(--text-sm);
    color: var(--color-text);
    margin: 0;
    font-family: var(--font-mono);
}

.info-list code {
    background: var(--color-bg-tertiary);
    padding: 2px 6px;
    border-radius: var(--radius-sm);
    font-size: var(--text-xs);
}

.resource-bars {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
}

.resource-bar {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.resource-label {
    display: flex;
    justify-content: space-between;
    font-size: var(--text-sm);
    font-weight: 500;
}

.resource-label span:last-child {
    color: var(--color-text-muted);
    font-family: var(--font-mono);
}

.progress-bar {
    height: 8px;
    background: var(--color-bg-tertiary);
    border-radius: var(--radius-full);
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--color-primary), var(--color-primary-light));
    border-radius: var(--radius-full);
    transition: width 0.3s ease;
}

.action-grid {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.btn-block {
    width: 100%;
    justify-content: center;
}

.mt-3 { margin-top: var(--space-3); }
.mt-4 { margin-top: var(--space-4); }
.mt-6 { margin-top: var(--space-6); }
.mb-6 { margin-bottom: var(--space-6); }

.form-help {
    font-size: var(--text-xs);
    color: var(--color-text-muted);
    margin-top: var(--space-1);
}

/* Card adjustments */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4) var(--space-5);
    border-bottom: 1px solid var(--color-border);
}

.card-title {
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--color-text);
}

.card-body {
    padding: var(--space-5);
}

/* Responsive */
@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
    
    .info-list {
        grid-template-columns: 1fr;
        gap: var(--space-1) var(--space-0);
    }
    
    .tabs {
        flex-wrap: nowrap;
    }
}
</style>