<?php
/**
 * Server Backups Page
 */

$server = $server ?? [];
$backups = $backups ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
            </svg>
            Backups: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">Manage server backups</p>
    </div>
    <div class="page-actions">
        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/backups" class="inline-form">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <button type="submit" class="btn btn-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Create Backup
            </button>
        </form>
        <a href="/dashboard/servers/<?= $server["id"] ?>" class="btn btn-secondary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Backups</h3>
    </div>
    <div class="card-body">
        <?php if (empty($backups)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                    <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
                </svg>
                <h4>No Backups</h4>
                <p>Create your first backup to protect your server data.</p>
                <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/backups" class="mt-4">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Create First Backup
                    </button>
                </form>
            </div>
        <?php else: ?>
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
                        <?php foreach ($backups as $backup): ?>
                            <tr>
                                <td><?= htmlspecialchars($backup["name"] ?? "Backup") ?></td>
                                <td>
                                    <span class="badge badge-<?= $backup["type"] === "manual" ? "primary" : "secondary" ?>">
                                        <?= ucfirst($backup["type"] ?? "auto") ?>
                                    </span>
                                </td>
                                <td><?= $backup["size"] ? formatBytes($backup["size"]) : "N/A" ?></td>
                                <td>
                                    <span class="status-badge status-<?= $backup["status"] ?>">
                                        <?= ucfirst($backup["status"]) ?>
                                    </span>
                                </td>
                                <td><?= date("Y-m-d H:i:s", strtotime($backup["created_at"])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($backup["status"] === "completed"): ?>
                                            <a href="/dashboard/servers/<?= $server["id"] ?>/backups/<?= $backup["id"] ?>/download" class="btn btn-sm btn-outline" title="Download">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                    <polyline points="7 10 12 15 17 10"/>
                                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/backups/<?= $backup["id"] ?>/restore" class="inline-form" onsubmit="return confirm(\'Are you sure you want to restore this backup? This will overwrite current server files.\')">
                                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                <button type="submit" class="btn btn-sm btn-warning" title="Restore">
                                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M23 4v6h-6"/>
                                                        <path d="M1 20v-6h6"/>
                                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/backups/<?= $backup["id"] ?>/delete" class="inline-form" onsubmit="return confirm(\'Are you sure you want to delete this backup?\')">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-sm btn-error" title="Delete">
                                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
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