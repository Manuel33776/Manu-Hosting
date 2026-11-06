<?php
/**
 * Server Create Page
 */

$packages = $packages ?? [];
$nodes = $nodes ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Create Server
        </h1>
        <p class="page-subtitle">Set up a new Minecraft server</p>
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

<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3 class="card-title">Server Configuration</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="/dashboard/servers/create" id="createForm">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <!-- Basic Information -->
            <fieldset class="form-section">
                <legend>Basic Information</legend>
                
                <div class="form-group">
                    <label for="name" class="form-label">Server Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-input" placeholder="My Awesome Server" required maxlength="64" minlength="3">
                    <p class="form-help">A descriptive name for your server (3-64 characters)</p>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="package_id" class="form-label">Hosting Package <span class="required">*</span></label>
                        <select name="package_id" id="package_id" class="form-select" required>
                            <option value="">Select a package</option>
                            <?php foreach ($packages as $package): ?>
                                <option value="<?= $package["id"] ?>" data-ram="<?= $package["ram"] ?>" data-cpu="<?= $package["cpu"] ?>" data-disk="<?= $package["disk"] ?>" data-players="<?= $package["players_max"] ?>">
                                    <?= htmlspecialchars($package["name"]) ?> - <?= $package["ram"] ?> MB RAM, <?= $package["cpu"] ?>% CPU, <?= $package["disk"] ?> GB Disk
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="node_id" class="form-label">Node <span class="required">*</span></label>
                        <select name="node_id" id="node_id" class="form-select" required>
                            <option value="">Select a node</option>
                            <?php foreach ($nodes as $node): ?>
                                <option value="<?= $node["id"] ?>" <?= ($node["status"] ?? "") !== "online" ? "disabled" : "" ?>>
                                    <?= htmlspecialchars($node["name"]) ?> (<?= $node["location"] ?? "Unknown" ?>) - <?= $node["status"] === "online" ? "Online" : "Offline" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            
            <!-- Minecraft Version & Software -->
            <fieldset class="form-section">
                <legend>Minecraft Version & Software</legend>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="software" class="form-label">Server Software <span class="required">*</span></label>
                        <select name="software" id="software" class="form-select" required>
                            <option value="">Select software</option>
                            <optgroup label="Vanilla & Optimized">
                                <option value="paper">Paper (Recommended)</option>
                                <option value="purpur">Purpur</option>
                                <option value="spigot">Spigot</option>
                                <option value="vanilla">Vanilla</option>
                            </optgroup>
                            <optgroup label="Modded">
                                <option value="fabric">Fabric</option>
                                <option value="forge">Forge</option>
                                <option value="neoforge">NeoForge</option>
                                <option value="quilt">Quilt</option>
                            </optgroup>
                            <optgroup label="Proxy">
                                <option value="velocity">Velocity</option>
                                <option value="bungeecord">BungeeCord</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="version" class="form-label">Minecraft Version <span class="required">*</span></label>
                        <select name="version" id="version" class="form-select" required disabled>
                            <option value="">Select software first</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="java_version" class="form-label">Java Version <span class="required">*</span></label>
                    <select name="java_version" id="java_version" class="form-select" required>
                        <option value="8">Java 8 (Legacy)</option>
                        <option value="11">Java 11</option>
                        <option value="17">Java 17 (Recommended for 1.18+)</option>
                        <option value="21">Java 21 (Latest LTS)</option>
                    </select>
                    <p class="form-help">Java 17+ required for Minecraft 1.18+, Java 21 for 1.20.5+</p>
                </div>
            </fieldset>
            
            <!-- Resource Allocation (Read-only from package) -->
            <fieldset class="form-section">
                <legend>Resource Allocation</legend>
                
                <div class="resource-preview" id="resourcePreview" style="display: none;">
                    <div class="resource-bars">
                        <div class="resource-bar">
                            <div class="resource-label">
                                <span>RAM</span>
                                <span id="previewRam">0 MB</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="ramBar" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="resource-bar">
                            <div class="resource-label">
                                <span>CPU</span>
                                <span id="previewCpu">0%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="cpuBar" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="resource-bar">
                            <div class="resource-label">
                                <span>Disk</span>
                                <span id="previewDisk">0 GB</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="diskBar" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="resource-bar">
                            <div class="resource-label">
                                <span>Player Slots</span>
                                <span id="previewPlayers">0</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="playersBar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="packageNotice" class="info-box" style="display: none;">
                    Resources will be shown after selecting a package.
                </div>
            </fieldset>
            
            <!-- Advanced Options -->
            <fieldset class="form-section">
                <legend>Advanced Options</legend>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="motd" class="form-label">MOTD</label>
                        <input type="text" name="motd" id="motd" class="form-input" placeholder="A Minecraft Server" value="A Minecraft Server">
                    </div>
                    
                    <div class="form-group">
                        <label for="max_players" class="form-label">Max Players</label>
                        <input type="number" name="max_players" id="max_players" class="form-input" min="1" max="1000" value="20">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="difficulty" class="form-label">Difficulty</label>
                        <select name="difficulty" id="difficulty" class="form-select">
                            <option value="peaceful">Peaceful</option>
                            <option value="easy">Easy</option>
                            <option value="normal" selected>Normal</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="gamemode" class="form-label">Gamemode</label>
                        <select name="gamemode" id="gamemode" class="form-select">
                            <option value="survival" selected>Survival</option>
                            <option value="creative">Creative</option>
                            <option value="adventure">Adventure</option>
                            <option value="spectator">Spectator</option>
                        </select>
                    </div>
                </div>
                
                <div class="checkbox-group">
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="pvp" value="1" checked>
                        <span>PvP Enabled</span>
                    </label>
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="allow_nether" value="1" checked>
                        <span>Allow Nether</span>
                    </label>
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="enable_command_block" value="1">
                        <span>Enable Command Blocks</span>
                    </label>
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="force_gamemode" value="1">
                        <span>Force Gamemode</span>
                    </label>
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="enable_whitelist" value="1">
                        <span>Enable Whitelist</span>
                    </label>
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="enable_rcon" value="1">
                        <span>Enable RCON</span>
                    </label>
                </div>
            </fieldset>
            
            <!-- Submit -->
            <div class="form-actions">
                <a href="/dashboard/servers" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create Server
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Version data for each software
const versionData = {
    paper: ["1.20.4", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16", "1.15.2", "1.15.1", "1.15", "1.14.4", "1.14.3", "1.14.2", "1.14.1", "1.14", "1.13.2", "1.13.1", "1.13", "1.12.2", "1.12.1", "1.12"],
    purpur: ["1.20.4", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16"],
    spigot: ["1.20.4", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16", "1.15.2", "1.15.1", "1.15", "1.14.4", "1.14.3", "1.14.2", "1.14.1", "1.14", "1.13.2", "1.13.1", "1.13", "1.12.2"],
    vanilla: ["1.20.4", "1.20.3", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16", "1.15.2", "1.15.1", "1.15", "1.14.4", "1.14.3", "1.14.2", "1.14.1", "1.14", "1.13.2", "1.13.1", "1.13", "1.12.2"],
    fabric: ["1.20.4", "1.20.3", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16", "1.15.2", "1.15.1", "1.15", "1.14.4", "1.14.3", "1.14.2", "1.14.1", "1.14"],
    forge: ["1.20.4", "1.20.3", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19", "1.18.2", "1.18.1", "1.18", "1.17.1", "1.17", "1.16.5", "1.16.4", "1.16.3", "1.16.2", "1.16.1", "1.16", "1.15.2", "1.15.1", "1.15", "1.14.4", "1.14.3", "1.14.2", "1.14.1", "1.14", "1.13.2", "1.13.1", "1.13", "1.12.2"],
    neoforge: ["1.20.4", "1.20.3", "1.20.2", "1.20.1", "1.20"],
    quilt: ["1.20.4", "1.20.3", "1.20.2", "1.20.1", "1.20", "1.19.4", "1.19.3", "1.19.2", "1.19.1", "1.19"],
    velocity: ["3.2.0", "3.1.2", "3.1.1", "3.1.0", "3.0.1", "3.0.0"],
    bungeecord: ["1.20", "1.19", "1.18", "1.17", "1.16", "1.15", "1.14", "1.13", "1.12"]
};

document.addEventListener("DOMContentLoaded", function() {
    const softwareSelect = document.getElementById("software");
    const versionSelect = document.getElementById("version");
    const packageSelect = document.getElementById("package_id");
    const resourcePreview = document.getElementById("resourcePreview");
    const packageNotice = document.getElementById("packageNotice");
    const submitBtn = document.getElementById("submitBtn");
    
    // Software change -> update versions
    softwareSelect?.addEventListener("change", function() {
        const software = this.value;
        versionSelect.innerHTML = "";
        
        if (software && versionData[software]) {
            versionData[software].forEach(v => {
                const opt = document.createElement("option");
                opt.value = v;
                opt.textContent = v;
                versionSelect.appendChild(opt);
            });
            versionSelect.disabled = false;
            versionSelect.value = versionData[software][0];
        } else {
            const opt = document.createElement("option");
            opt.value = "";
            opt.textContent = "Select software first";
            versionSelect.appendChild(opt);
            versionSelect.disabled = true;
        }
    });
    
    // Package change -> update resource preview
    packageSelect?.addEventListener("change", function() {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            const ram = parseInt(selected.dataset.ram) || 0;
            const cpu = parseInt(selected.dataset.cpu) || 0;
            const disk = parseInt(selected.dataset.disk) || 0;
            const players = parseInt(selected.dataset.players) || 0;
            
            document.getElementById("previewRam").textContent = ram + " MB";
            document.getElementById("previewCpu").textContent = cpu + "%";
            document.getElementById("previewDisk").textContent = disk + " GB";
            document.getElementById("previewPlayers").textContent = players;
            
            document.getElementById("ramBar").style.width = Math.min(100, (ram / 8192) * 100) + "%";
            document.getElementById("cpuBar").style.width = cpu + "%";
            document.getElementById("diskBar").style.width = Math.min(100, (disk / 100) * 100) + "%";
            document.getElementById("playersBar").style.width = Math.min(100, (players / 100) * 100) + "%";
            
            resourcePreview.style.display = "block";
            packageNotice.style.display = "none";
            
            // Update max_players field
            document.getElementById("max_players").max = players;
            document.getElementById("max_players").value = Math.min(20, players);
        } else {
            resourcePreview.style.display = "none";
            packageNotice.style.display = "block";
        }
    });
    
    // Auto-set java version based on minecraft version
    versionSelect?.addEventListener("change", function() {
        const version = this.value;
        const javaSelect = document.getElementById("java_version");
        if (version) {
            const major = parseFloat(version);
            if (major >= 1.205) {
                javaSelect.value = "21";
            } else if (major >= 1.18) {
                javaSelect.value = "17";
            } else if (major >= 1.17) {
                javaSelect.value = "16"; // Not in options, fallback to 17
            } else {
                javaSelect.value = "8";
            }
        }
    });
    
    // Form validation
    const form = document.getElementById("createForm");
    form?.addEventListener("submit", function(e) {
        const required = form.querySelectorAll("[required]");
        let valid = true;
        required.forEach(field => {
            if (!field.value) {
                field.style.borderColor = "var(--color-error)";
                valid = false;
            } else {
                field.style.borderColor = "";
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert("Please fill in all required fields.");
        }
    });
});
</script>

<style>
.form-section {
    margin-bottom: var(--space-8);
    padding-bottom: var(--space-6);
    border-bottom: 1px solid var(--color-border);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.form-section legend {
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: var(--space-5);
    padding-bottom: var(--space-3);
    border-bottom: 1px solid var(--color-border);
}

.required {
    color: var(--color-error);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
}

.form-group {
    margin-bottom: var(--space-5);
}

.form-label {
    display: block;
    font-size: var(--text-sm);
    font-weight: 500;
    color: var(--color-text);
    margin-bottom: var(--space-2);
}

.form-input,
.form-select {
    width: 100%;
    padding: var(--space-3) var(--space-4);
    background: var(--color-bg-tertiary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    color: var(--color-text);
    font-size: var(--text-base);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.form-input:disabled,
.form-select:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.form-help {
    font-size: var(--text-xs);
    color: var(--color-text-muted);
    margin-top: var(--space-1);
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-3);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    cursor: pointer;
    padding: var(--space-2) var(--space-3);
    background: var(--color-bg-tertiary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    transition: border-color var(--transition-fast), background var(--transition-fast);
}

.checkbox-label:hover {
    border-color: var(--color-primary);
}

.checkbox-label input {
    width: 18px;
    height: 18px;
    accent-color: var(--color-primary);
}

.resource-preview {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: var(--space-3);
    padding-top: var(--space-5);
    border-top: 1px solid var(--color-border);
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .checkbox-group {
        grid-template-columns: 1fr;
    }
}
</style>