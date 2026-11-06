<?php
/**
 * Server Settings Page
 */

$server = $server ?? [];
$idle_config = $idle_config ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Settings: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">Configure server settings and options</p>
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

<div class="grid grid-2">
    <!-- Idle Shutdown Settings -->
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
                    <p class="form-help">When enabled, the server will automatically shut down after the specified timeout when no players are online.</p>
                </div>
                
                <div class="form-group">
                    <label for="idle_shutdown_timeout" class="form-label">Idle Timeout (seconds)</label>
                    <input type="number" name="idle_shutdown_timeout" id="idle_shutdown_timeout" class="form-input" min="10" max="3600" value="<?= $idle_config["timeout"] ?? 60 ?>">
                    <p class="form-help">Time to wait before shutting down an empty server. Default: 60 seconds. Minimum: 10 seconds. Maximum: 3600 seconds (1 hour).</p>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Idle Settings</button>
            </form>
        </div>
    </div>
    
    <!-- Server Properties -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Server Properties</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/settings">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="form-group">
                    <label for="motd" class="form-label">MOTD (Message of the Day)</label>
                    <input type="text" name="motd" id="motd" class="form-input" value="<?= htmlspecialchars($server["motd"] ?? "A Minecraft Server") ?>" placeholder="Welcome to my server!">
                </div>
                
                <div class="form-group">
                    <label for="max_players" class="form-label">Max Players</label>
                    <input type="number" name="max_players" id="max_players" class="form-input" min="1" max="1000" value="<?= $server["players_max"] ?? 20 ?>">
                </div>
                
                <div class="form-group">
                    <label for="difficulty" class="form-label">Difficulty</label>
                    <select name="difficulty" id="difficulty" class="form-select">
                        <option value="peaceful" <?= ($server["difficulty"] ?? "") === "peaceful" ? "selected" : "" ?>>Peaceful</option>
                        <option value="easy" <?= ($server["difficulty"] ?? "") === "easy" ? "selected" : "" ?>>Easy</option>
                        <option value="normal" <?= ($server["difficulty"] ?? "") === "normal" ? "selected" : "" ?>>Normal</option>
                        <option value="hard" <?= ($server["difficulty"] ?? "") === "hard" ? "selected" : "" ?>>Hard</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="gamemode" class="form-label">Default Gamemode</label>
                    <select name="gamemode" id="gamemode" class="form-select">
                        <option value="survival" <?= ($server["gamemode"] ?? "") === "survival" ? "selected" : "" ?>>Survival</option>
                        <option value="creative" <?= ($server["gamemode"] ?? "") === "creative" ? "selected" : "" ?>>Creative</option>
                        <option value="adventure" <?= ($server["gamemode"] ?? "") === "adventure" ? "selected" : "" ?>>Adventure</option>
                        <option value="spectator" <?= ($server["gamemode"] ?? "") === "spectator" ? "selected" : "" ?>>Spectator</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="pvp" value="1" <?= ($server["pvp"] ?? true) ? "checked" : "" ?>> PvP Enabled
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="allow_nether" value="1" <?= ($server["allow_nether"] ?? true) ? "checked" : "" ?>> Allow Nether
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="enable_command_block" value="1" <?= ($server["enable_command_block"] ?? false) ? "checked" : "" ?>> Enable Command Blocks
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="force_gamemode" value="1" <?= ($server["force_gamemode"] ?? false) ? "checked" : "" ?>> Force Gamemode
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Properties</button>
            </form>
        </div>
    </div>
    
    <!-- Resource Limits -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resource Limits</h3>
        </div>
        <div class="card-body">
            <div class="info-box">
                <p>Resource limits are determined by your hosting package. To change these limits, you need to upgrade your package.</p>
            </div>
            
            <div class="resource-limits">
                <div class="limit-item">
                    <div class="limit-info">
                        <span class="limit-name">RAM</span>
                        <span class="limit-value"><?= $server["ram"] ?? 0 ?> MB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= min(100, (($server["ram"] ?? 0) / 8192) * 100) ?>%"></div>
                    </div>
                </div>
                
                <div class="limit-item">
                    <div class="limit-info">
                        <span class="limit-name">CPU</span>
                        <span class="limit-value"><?= $server["cpu"] ?? 0 ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= $server["cpu"] ?? 0 ?>%"></div>
                    </div>
                </div>
                
                <div class="limit-item">
                    <div class="limit-info">
                        <span class="limit-name">Disk Space</span>
                        <span class="limit-value"><?= $server["disk"] ?? 0 ?> GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= min(100, (($server["disk"] ?? 0) / 100) * 100) ?>%"></div>
                    </div>
                </div>
                
                <div class="limit-item">
                    <div class="limit-info">
                        <span class="limit-name">Player Slots</span>
                        <span class="limit-value"><?= $server["players_max"] ?? 0 ?></span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= min(100, (($server["players_max"] ?? 0) / 100) * 100) ?>%"></div>
                    </div>
                </div>
            </div>
            
            <a href="/dashboard/servers/<?= $server["id"] ?>/upgrade" class="btn btn-primary mt-4">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 15l-6-6-6 6"/>
                </svg>
                Upgrade Package
            </a>
        </div>
    </div>
    
    <!-- Danger Zone -->
    <div class="card border-error">
        <div class="card-header">
            <h3 class="card-title text-error">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Danger Zone
            </h3>
        </div>
        <div class="card-body">
            <div class="danger-actions">
                <div class="danger-item">
                    <div class="danger-info">
                        <h4>Suspend Server</h4>
                        <p>Temporarily disable the server. The server will be stopped and cannot be started until unsuspended.</p>
                    </div>
                    <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/suspend" class="inline-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <button type="submit" class="btn btn-warning" onclick="return confirm(\'Are you sure you want to suspend this server?\')">Suspend</button>
                    </form>
                </div>
                
                <div class="danger-item">
                    <div class="danger-info">
                        <h4>Delete Server</h4>
                        <p>Permanently delete this server and all its data. This action cannot be undone!</p>
                    </div>
                    <a href="/dashboard/servers/<?= $server["id"] ?>/delete" class="btn btn-error">Delete Server</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
}

.info-box {
    padding: var(--space-4);
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: var(--radius-md);
    color: var(--color-info);
    margin-bottom: var(--space-5);
}

.resource-limits {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
}

.limit-item {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.limit-info {
    display: flex;
    justify-content: space-between;
    font-size: var(--text-sm);
    font-weight: 500;
}

.limit-value {
    color: var(--color-text-muted);
    font-family: var(--font-mono);
}

.border-error {
    border-color: rgba(239, 68, 68, 0.3);
}

.text-error { color: var(--color-error); }

.danger-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-5);
}

.danger-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4);
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
}

.danger-info h4 {
    font-size: var(--text-base);
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: var(--space-1);
}

.danger-info p {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
    
    .danger-item {
        flex-direction: column;
        gap: var(--space-3);
        align-items: flex-start;
    }
}
</style>