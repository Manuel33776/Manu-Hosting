<?php
/**
 * Server Delete Confirmation Page
 */

$server = $server ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title text-error">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Delete Server
        </h1>
        <p class="page-subtitle">Confirm server deletion</p>
    </div>
    <div class="page-actions">
        <a href="/dashboard/servers/<?= $server["id"] ?>" class="btn btn-secondary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Cancel
        </a>
    </div>
</div>

<div class="card border-error" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title text-error">⚠️ This action cannot be undone!</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-error">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Warning:</strong> Deleting this server will permanently remove:
            </div>
        </div>
        
        <ul class="delete-list">
            <li><strong>All server files</strong> (world, plugins, configs, mods)</li>
            <li><strong>All backups</strong> associated with this server</li>
            <li><strong>Player data</strong> (inventories, stats, advancements)</li>
            <li><strong>Server logs</strong> and history</li>
            <li><strong>Scheduled tasks</strong> and configurations</li>
        </ul>
        
        <div class="confirmation-box">
            <p>To confirm deletion, please type the exact server name:</p>
            <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/delete">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="form-group">
                    <label for="confirm_delete" class="form-label">Server Name</label>
                    <input type="text" name="confirm_delete" id="confirm_delete" class="form-input" placeholder="Type server name to confirm" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="confirm_backups" value="1" required>
                        I understand that all backups will also be deleted
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="confirm_irreversible" value="1" required>
                        I understand this action is irreversible
                    </label>
                </div>
                
                <div class="action-buttons">
                    <a href="/dashboard/servers/<?= $server["id"] ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-error" disabled id="deleteBtn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Delete Server Permanently
                    </button>
                </div>
            </form>
        </div>
        
        <div class="server-summary">
            <h4>Server Details</h4>
            <dl class="info-list">
                <dt>Name</dt>
                <dd><?= htmlspecialchars($server["name"] ?? "") ?></dd>
                
                <dt>UUID</dt>
                <dd><code><?= htmlspecialchars($server["uuid"] ?? "") ?></code></dd>
                
                <dt>Status</dt>
                <dd><span class="status-badge status-<?= $server["status"] ?>"><?= ucfirst($server["status"]) ?></span></dd>
                
                <dt>Node</dt>
                <dd><?= htmlspecialchars($server["node_name"] ?? "Unknown") ?></dd>
                
                <dt>Created</dt>
                <dd><?= date("Y-m-d H:i:s", strtotime($server["created_at"] ?? "now")) ?></dd>
            </dl>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const confirmInput = document.getElementById("confirm_delete");
    const deleteBtn = document.getElementById("deleteBtn");
    const serverName = "<?= htmlspecialchars($server["name"] ?? "", ENT_QUOTES) ?>";
    
    confirmInput?.addEventListener("input", function() {
        deleteBtn.disabled = this.value !== serverName;
    });
});
</script>

<style>
.alert {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    padding: var(--space-4);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-5);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: var(--color-error);
}

.alert .icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    margin-top: 2px;
}

.delete-list {
    list-style: none;
    padding: 0;
    margin: 0 0 var(--space-6) var(--space-4);
}

.delete-list li {
    padding: var(--space-2) 0;
    padding-left: var(--space-4);
    position: relative;
    color: var(--color-text);
}

.delete-list li::before {
    content: "";
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--color-error);
}

.delete-list strong {
    color: var(--color-text);
}

.confirmation-box {
    padding: var(--space-5);
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-6);
}

.confirmation-box p {
    margin-bottom: var(--space-4);
    color: var(--color-text-muted);
}

.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: var(--space-3);
    margin-top: var(--space-5);
}

.server-summary {
    margin-top: var(--space-6);
    padding-top: var(--space-5);
    border-top: 1px solid var(--color-border);
}

.server-summary h4 {
    margin-bottom: var(--space-4);
    color: var(--color-text);
}

.info-list {
    display: grid;
    grid-template-columns: 120px 1fr;
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
</style>