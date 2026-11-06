<?php
/**
 * Server Schedule Page
 */

$server = $server ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            Schedule: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">Automated tasks and scheduled commands</p>
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
    <!-- Scheduled Tasks -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Scheduled Tasks</h3>
            <button class="btn btn-sm btn-primary" id="addTaskBtn">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>
        </div>
        <div class="card-body">
            <div class="empty-state" style="height: 300px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <h4>No Scheduled Tasks</h4>
                <p>Add scheduled tasks for automatic restarts, backups, or commands.</p>
            </div>
        </div>
    </div>
    
    <!-- Task Templates -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quick Setup</h3>
        </div>
        <div class="card-body">
            <div class="template-grid">
                <div class="template-card" data-template="daily-restart">
                    <div class="template-icon bg-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 4v6h-6"/>
                            <path d="M1 20v-6h6"/>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                        </svg>
                    </div>
                    <h4>Daily Restart</h4>
                    <p>Restart server daily at a specific time</p>
                    <button class="btn btn-sm btn-primary w-full mt-3">Configure</button>
                </div>
                
                <div class="template-card" data-template="auto-backup">
                    <div class="template-icon bg-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                            <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
                        </svg>
                    </div>
                    <h4>Auto Backup</h4>
                    <p>Create automatic backups on schedule</p>
                    <button class="btn btn-sm btn-primary w-full mt-3">Configure</button>
                </div>
                
                <div class="template-card" data-template="scheduled-command">
                    <div class="template-icon bg-warning">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M6 8h12M6 12h12M6 16h8"/>
                        </svg>
                    </div>
                    <h4>Scheduled Command</h4>
                    <p>Run a command at specific intervals</p>
                    <button class="btn btn-sm btn-primary w-full mt-3">Configure</button>
                </div>
                
                <div class="template-card" data-template="maintenance">
                    <div class="template-icon bg-info">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                    </div>
                    <h4>Maintenance Window</h4>
                    <p>Schedule maintenance with player warnings</p>
                    <button class="btn btn-sm btn-primary w-full mt-3">Configure</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal" id="taskModal" style="display: none;">
    <div class="modal-backdrop" onclick="closeTaskModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add Scheduled Task</h3>
            <button class="modal-close" onclick="closeTaskModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form id="taskForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="taskName" class="form-label">Task Name</label>
                    <input type="text" id="taskName" name="name" class="form-input" placeholder="e.g., Daily Restart" required>
                </div>
                
                <div class="form-group">
                    <label for="taskType" class="form-label">Task Type</label>
                    <select id="taskType" name="type" class="form-select" required>
                        <option value="restart">Restart Server</option>
                        <option value="backup">Create Backup</option>
                        <option value="command">Run Command</option>
                        <option value="start">Start Server</option>
                        <option value="stop">Stop Server</option>
                    </select>
                </div>
                
                <div class="form-group" id="commandGroup" style="display: none;">
                    <label for="taskCommand" class="form-label">Command</label>
                    <input type="text" id="taskCommand" name="command" class="form-input" placeholder="e.g., say Server restarting in 1 minute">
                </div>
                
                <div class="form-group">
                    <label for="taskSchedule" class="form-label">Schedule (Cron Expression)</label>
                    <input type="text" id="taskSchedule" name="schedule" class="form-input" placeholder="0 4 * * * (daily at 4 AM)" required>
                    <p class="form-help">Cron format: minute hour day month weekday. <a href="https://crontab.guru" target="_blank">Crontab Guru</a></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="enabled" value="1" checked>
                        Enabled
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeTaskModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Task</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const addTaskBtn = document.getElementById("addTaskBtn");
    const taskModal = document.getElementById("taskModal");
    const taskForm = document.getElementById("taskForm");
    const taskType = document.getElementById("taskType");
    const commandGroup = document.getElementById("commandGroup");
    
    addTaskBtn?.addEventListener("click", () => taskModal.style.display = "flex");
    
    taskType?.addEventListener("change", function() {
        commandGroup.style.display = this.value === "command" ? "block" : "none";
    });
    
    window.closeTaskModal = function() {
        taskModal.style.display = "none";
        taskForm.reset();
    };
    
    taskForm?.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        data.enabled = !!data.enabled;
        data.server_id = "<?= $server["id"] ?>";
        
        fetch(`/api/v1/servers/<?= $server["id"] ?>/schedule`, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
            body: JSON.stringify(data)
        }).then(() => {
            closeTaskModal();
            location.reload();
        });
    });
    
    document.querySelectorAll(".template-card").forEach(card => {
        card.addEventListener("click", function() {
            const template = this.dataset.template;
            // Pre-fill form based on template
            taskForm.reset();
            switch(template) {
                case "daily-restart":
                    document.getElementById("taskName").value = "Daily Restart";
                    document.getElementById("taskType").value = "restart";
                    document.getElementById("taskSchedule").value = "0 4 * * *";
                    break;
                case "auto-backup":
                    document.getElementById("taskName").value = "Auto Backup";
                    document.getElementById("taskType").value = "backup";
                    document.getElementById("taskSchedule").value = "0 */6 * * *";
                    break;
                case "scheduled-command":
                    document.getElementById("taskName").value = "Scheduled Command";
                    document.getElementById("taskType").value = "command";
                    document.getElementById("taskSchedule").value = "0 * * * *";
                    break;
                case "maintenance":
                    document.getElementById("taskName").value = "Maintenance Window";
                    document.getElementById("taskType").value = "command";
                    document.getElementById("taskSchedule").value = "0 3 * * 0";
                    break;
            }
            taskModal.style.display = "flex";
        });
    });
});
</script>

<style>
.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-4);
}

.template-card {
    display: flex;
    flex-direction: column;
    padding: var(--space-5);
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    transition: transform var(--transition-fast), box-shadow var(--transition-fast), border-color var(--transition-fast);
}

.template-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--color-primary);
    cursor: pointer;
}

.template-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-3);
}

.template-icon svg { width: 24px; height: 24px; }

.template-icon.bg-primary { background: rgba(139, 92, 246, 0.15); color: var(--color-primary); }
.template-icon.bg-success { background: rgba(34, 197, 94, 0.15); color: var(--color-success); }
.template-icon.bg-warning { background: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
.template-icon.bg-info { background: rgba(59, 130, 246, 0.15); color: var(--color-info); }

.template-card h4 {
    font-size: var(--text-lg);
    font-weight: 600;
    margin-bottom: var(--space-2);
}

.template-card p {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    flex: 1;
    margin-bottom: var(--space-3);
}

.w-full { width: 100%; }
</style>