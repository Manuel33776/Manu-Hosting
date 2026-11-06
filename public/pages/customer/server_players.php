<?php
/**
 * Server Players Page
 */

$server = $server ?? [];
$players = $players ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Players: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">Manage online players</p>
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
        <h3 class="card-title">Online Players (<?= $server["players_online"] ?? 0 ?>/<?= $server["players_max"] ?? 0 ?>)</h3>
    </div>
    <div class="card-body">
        <?php if (empty($players)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                <h4>No Players Online</h4>
                <p>There are currently no players on this server.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Player</th>
                            <th>UUID</th>
                            <th>Ping</th>
                            <th>World</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($players as $player): ?>
                            <tr>
                                <td>
                                    <div class="player-info">
                                        <span class="player-name"><?= htmlspecialchars($player["name"] ?? "") ?></span>
                                        <?php if (!empty($player["op"])): ?>
                                            <span class="badge badge-primary">OP</span>
                                        <?php endif; ?>
                                        <?php if (!empty($player["whitelisted"])): ?>
                                            <span class="badge badge-secondary">Whitelisted</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><code><?= htmlspecialchars($player["uuid"] ?? "") ?></code></td>
                                <td><?= $player["ping"] ?? "N/A" ?> ms</td>
                                <td><?= htmlspecialchars($player["world"] ?? "world") ?></td>
                                <td><?= $player["joined_at"] ? date("Y-m-d H:i:s", strtotime($player["joined_at"])) : "Unknown" ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline kick-player" data-player="<?= htmlspecialchars($player["name"] ?? "") ?>" data-uuid="<?= htmlspecialchars($player["uuid"] ?? "") ?>" title="Kick Player">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                                <polyline points="10 17 15 12 10 7"/>
                                                <line x1="15" y1="12" x2="3" y2="12"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-error ban-player" data-player="<?= htmlspecialchars($player["name"] ?? "") ?>" data-uuid="<?= htmlspecialchars($player["uuid"] ?? "") ?>" title="Ban Player">
                                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                                            </svg>
                                        </button>
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

<!-- OP Management -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">OP Management</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/players/op/add" class="inline-form">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="form-group">
                    <label for="op_player" class="form-label">Add OP</label>
                    <input type="text" name="player" id="op_player" class="form-input" placeholder="Player name or UUID" required>
                </div>
                <button type="submit" class="btn btn-primary">Add OP</button>
            </form>
            
            <form method="POST" action="/dashboard/servers/<?= $server["id"] ?>/players/op/remove" class="inline-form">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="form-group">
                    <label for="deop_player" class="form-label">Remove OP</label>
                    <input type="text" name="player" id="deop_player" class="form-input" placeholder="Player name or UUID" required>
                </div>
                <button type="submit" class="btn btn-error">Remove OP</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".kick-player").forEach(btn => {
        btn.addEventListener("click", function() {
            const player = this.dataset.player;
            const uuid = this.dataset.uuid;
            const reason = prompt(`Kick ${player}? Enter reason:`);
            if (reason !== null) {
                fetch(`/api/v1/servers/<?= $server["id"] ?>/command`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ command: `kick ${player} ${reason}` })
                }).then(() => location.reload());
            }
        });
    });
    
    document.querySelectorAll(".ban-player").forEach(btn => {
        btn.addEventListener("click", function() {
            const player = this.dataset.player;
            const uuid = this.dataset.uuid;
            const reason = prompt(`Ban ${player}? Enter reason:`);
            if (reason !== null) {
                fetch(`/api/v1/servers/<?= $server["id"] ?>/command`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ command: `ban ${player} ${reason}` })
                }).then(() => location.reload());
            }
        });
    });
});
</script>

<style>
.player-info {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    flex-wrap: wrap;
}

.player-name {
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: var(--space-1);
}
</style>