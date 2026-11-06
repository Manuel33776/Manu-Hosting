<?php
/**
 * Server Logs Page
 */

$server = $server ?? [];
$logs = $logs ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            Logs: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">Server console output and logs</p>
    </div>
    <div class="page-actions">
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
        <h3 class="card-title">Server Logs</h3>
        <div class="card-actions">
            <button class="btn btn-sm btn-outline" id="refreshLogs">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 4 23 10 17 10"/>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                </svg>
                Refresh
            </button>
            <button class="btn btn-sm btn-outline" id="clearLogs">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
                Clear
            </button>
            <a href="/dashboard/servers/<?= $server["id"] ?>/console" class="btn btn-sm btn-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="M6 8h12M6 12h12M6 16h8"/>
                </svg>
                Live Console
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="logs-container" id="logsContainer">
            <?php if (empty($logs)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <h4>No Logs Available</h4>
                    <p>Logs will appear here once the server is running.</p>
                </div>
            <?php else: ?>
                <pre class="logs-output"><?php foreach ($logs as $log): ?><?= htmlspecialchars($log) ?><?php endforeach; ?></pre>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("logsContainer");
    const refreshBtn = document.getElementById("refreshLogs");
    const clearBtn = document.getElementById("clearLogs");
    
    refreshBtn?.addEventListener("click", function() {
        location.reload();
    });
    
    clearBtn?.addEventListener("click", function() {
        const output = container.querySelector(".logs-output");
        if (output) output.textContent = "";
    });
    
    // Auto-scroll to bottom
    container.scrollTop = container.scrollHeight;
});
</script>

<style>
.logs-container {
    height: 600px;
    overflow-y: auto;
    background: #0d1117;
    border-radius: var(--radius-md);
    padding: var(--space-4);
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    line-height: 1.6;
    color: #e6edf3;
}

.logs-output {
    white-space: pre-wrap;
    word-break: break-word;
    margin: 0;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    color: var(--color-text-muted);
}

.empty-state svg {
    width: 64px;
    height: 64px;
    margin-bottom: var(--space-4);
}

.empty-state h4 {
    color: var(--color-text);
    margin-bottom: var(--space-2);
}
</style>