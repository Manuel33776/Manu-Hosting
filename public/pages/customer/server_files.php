<?php
/**
 * Server Files Page - File Manager
 */

$server = $server ?? [];
$files = $files ?? [];
$current_path = $current_path ?? "/";
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                <polyline points="13 2 13 9 20 9"/>
            </svg>
            Files: <?= htmlspecialchars($server["name"] ?? "") ?>
        </h1>
        <p class="page-subtitle">File manager for server files</p>
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

<!-- Path Navigation -->
<div class="card mb-6">
    <div class="card-body p-4">
        <div class="path-nav">
            <a href="/dashboard/servers/<?= $server["id"] ?>/files?path=/" class="path-segment">Root</a>
            <?php 
            $parts = array_filter(explode("/", trim($current_path, "/")));
            $buildPath = "";
            foreach ($parts as $part): 
                $buildPath .= "/" . $part;
            ?>
                <span class="path-separator">/</span>
                <a href="/dashboard/servers/<?= $server["id"] ?>/files?path=<?= urlencode($buildPath) ?>" class="path-segment"><?= htmlspecialchars($part) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- File Toolbar -->
<div class="card mb-6">
    <div class="card-body p-4">
        <div class="toolbar">
            <div class="toolbar-group">
                <button class="btn btn-primary" id="newFileBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    New File
                </button>
                <button class="btn btn-primary" id="newFolderBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    New Folder
                </button>
                <button class="btn btn-secondary" id="uploadBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Upload
                </button>
                <input type="file" id="fileUpload" multiple style="display: none;">
            </div>
            <div class="toolbar-group">
                <button class="btn btn-outline" id="downloadBtn" disabled>
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Download
                </button>
                <button class="btn btn-error" id="deleteBtn" disabled>
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- File List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Files in <?= htmlspecialchars($current_path) ?></h3>
    </div>
    <div class="card-body p-0">
        <?php if (empty($files)): ?>
            <div class="empty-state" style="height: 300px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                    <polyline points="13 2 13 9 20 9"/>
                </svg>
                <h4>Directory Empty</h4>
                <p>No files or folders in this directory.</p>
            </div>
        <?php else: ?>
            <div class="file-list" id="fileList">
                <?php foreach ($files as $file): ?>
                    <div class="file-item" data-name="<?= htmlspecialchars($file["name"]) ?>" data-type="<?= $file["type"] ?>" data-path="<?= htmlspecialchars($file["path"]) ?>">
                        <input type="checkbox" class="file-checkbox" value="<?= htmlspecialchars($file["name"]) ?>">
                        <div class="file-icon">
                            <?php if ($file["type"] === "dir"): ?>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                                </svg>
                            <?php else: ?>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="file-info">
                            <span class="file-name"><?= htmlspecialchars($file["name"]) ?></span>
                            <span class="file-meta">
                                <?php if ($file["type"] === "file"): ?>
                                    <?= $file["size"] ? formatBytes($file["size"]) : "0 B" ?>
                                    <?php if (!empty($file["modified"])): ?>
                                        | Modified: <?= date("Y-m-d H:i", strtotime($file["modified"])) ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    Folder
                                    <?php if (!empty($file["modified"])): ?>
                                        | Modified: <?= date("Y-m-d H:i", strtotime($file["modified"])) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ($file["type"] === "file" && in_array(pathinfo($file["name"], PATHINFO_EXTENSION), ["properties", "yml", "yaml", "json", "txt", "log"])): ?>
                            <button class="btn btn-sm btn-outline edit-file" data-path="<?= htmlspecialchars($file["path"]) ?>" title="Edit">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit File Modal -->
<div class="modal" id="editModal" style="display: none;">
    <div class="modal-backdrop" onclick="closeEditModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit File: <span id="editFileName"></span></h3>
            <button class="modal-close" onclick="closeEditModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <textarea id="editContent" class="code-editor" spellcheck="false"></textarea>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
            <button class="btn btn-primary" onclick="saveFile()">Save</button>
        </div>
    </div>
</div>

<script>
let currentEditPath = "";
let selectedFiles = [];

document.addEventListener("DOMContentLoaded", function() {
    const fileList = document.getElementById("fileList");
    const downloadBtn = document.getElementById("downloadBtn");
    const deleteBtn = document.getElementById("deleteBtn");
    const newFileBtn = document.getElementById("newFileBtn");
    const newFolderBtn = document.getElementById("newFolderBtn");
    const uploadBtn = document.getElementById("uploadBtn");
    const fileUpload = document.getElementById("fileUpload");
    
    // File selection
    fileList?.addEventListener("change", function(e) {
        if (e.target.classList.contains("file-checkbox")) {
            updateSelection();
        }
    });
    
    fileList?.addEventListener("dblclick", function(e) {
        const item = e.target.closest(".file-item");
        if (!item) return;
        
        const type = item.dataset.type;
        const name = item.dataset.name;
        const path = item.dataset.path;
        
        if (type === "dir") {
            window.location.href = `/dashboard/servers/<?= $server["id"] ?>/files?path=${encodeURIComponent(path)}`;
        } else if (type === "file" && ["properties", "yml", "yaml", "json", "txt", "log"].includes(name.split(".").pop())) {
            editFile(path, name);
        }
    });
    
    function updateSelection() {
        const checkboxes = fileList?.querySelectorAll(".file-checkbox:checked") || [];
        selectedFiles = Array.from(checkboxes).map(cb => cb.closest(".file-item").dataset);
        downloadBtn.disabled = selectedFiles.length === 0;
        deleteBtn.disabled = selectedFiles.length === 0;
    }
    
    // New file
    newFileBtn?.addEventListener("click", function() {
        const name = prompt("Enter file name:");
        if (name) {
            fetch(`/api/v1/servers/<?= $server["id"] ?>/files/create`, {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
                body: JSON.stringify({ path: "<?= htmlspecialchars($current_path) ?>", name: name, type: "file" })
            }).then(() => location.reload());
        }
    });
    
    // New folder
    newFolderBtn?.addEventListener("click", function() {
        const name = prompt("Enter folder name:");
        if (name) {
            fetch(`/api/v1/servers/<?= $server["id"] ?>/files/create`, {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
                body: JSON.stringify({ path: "<?= htmlspecialchars($current_path) ?>", name: name, type: "dir" })
            }).then(() => location.reload());
        }
    });
    
    // Upload
    uploadBtn?.addEventListener("click", () => fileUpload.click());
    fileUpload?.addEventListener("change", function() {
        const files = this.files;
        if (files.length === 0) return;
        
        const formData = new FormData();
        formData.append("path", "<?= htmlspecialchars($current_path) ?>");
        for (let file of files) {
            formData.append("files[]", file);
        }
        
        fetch(`/api/v1/servers/<?= $server["id"] ?>/files/upload`, {
            method: "POST",
            headers: { "X-Requested-With": "XMLHttpRequest" },
            body: formData
        }).then(() => location.reload());
    });
    
    // Download
    downloadBtn?.addEventListener("click", function() {
        selectedFiles.forEach(file => {
            if (file.type === "file") {
                window.open(`/dashboard/servers/<?= $server["id"] ?>/files/download?path=${encodeURIComponent(file.path)}`, "_blank");
            }
        });
    });
    
    // Delete
    deleteBtn?.addEventListener("click", function() {
        if (!confirm(`Delete ${selectedFiles.length} item(s)?`)) return;
        
        selectedFiles.forEach(file => {
            fetch(`/api/v1/servers/<?= $server["id"] ?>/files/delete`, {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
                body: JSON.stringify({ path: file.path })
            });
        });
        location.reload();
    });
    
    // Edit file
    window.editFile = function(path, name) {
        currentEditPath = path;
        document.getElementById("editFileName").textContent = name;
        document.getElementById("editContent").value = "Loading...";
        document.getElementById("editModal").style.display = "flex";
        
        fetch(`/dashboard/servers/<?= $server["id"] ?>/files/read?path=${encodeURIComponent(path)}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById("editContent").value = data.content || "";
            });
    };
    
    window.closeEditModal = function() {
        document.getElementById("editModal").style.display = "none";
        currentEditPath = "";
    };
    
    window.saveFile = function() {
        const content = document.getElementById("editContent").value;
        fetch(`/dashboard/servers/<?= $server["id"] ?>/files/write`, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
            body: JSON.stringify({ path: currentEditPath, content: content })
        }).then(() => {
            closeEditModal();
            location.reload();
        });
    };
}

function formatBytes(bytes) {
    if (!bytes) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}
</script>

<style>
.path-nav {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    flex-wrap: wrap;
    font-family: var(--font-mono);
    font-size: var(--text-sm);
}

.path-segment {
    color: var(--color-primary);
    text-decoration: none;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
    transition: background var(--transition-fast);
}

.path-segment:hover {
    background: rgba(139, 92, 246, 0.1);
}

.path-separator {
    color: var(--color-text-muted);
}

.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--space-3);
}

.toolbar-group {
    display: flex;
    gap: var(--space-2);
}

.file-list {
    max-height: 600px;
    overflow-y: auto;
}

.file-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-5);
    border-bottom: 1px solid var(--color-border);
    transition: background var(--transition-fast);
}

.file-item:last-child {
    border-bottom: none;
}

.file-item:hover {
    background: var(--color-bg-secondary);
}

.file-checkbox {
    width: 18px;
    height: 18px;
    accent-color: var(--color-primary);
}

.file-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    color: var(--color-warning);
}

.file-icon svg {
    width: 20px;
    height: 20px;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-name {
    display: block;
    font-weight: 500;
    color: var(--color-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-meta {
    display: block;
    font-size: var(--text-xs);
    color: var(--color-text-muted);
    font-family: var(--font-mono);
}

.edit-file {
    opacity: 0;
    transition: opacity var(--transition-fast);
}

.file-item:hover .edit-file {
    opacity: 1;
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--space-4);
}

.modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
}

.modal-content {
    position: relative;
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 800px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4) var(--space-5);
    border-bottom: 1px solid var(--color-border);
}

.modal-header h3 {
    font-size: var(--text-lg);
    font-weight: 600;
}

.modal-close {
    background: none;
    border: none;
    color: var(--color-text-muted);
    cursor: pointer;
    padding: var(--space-2);
    border-radius: var(--radius-md);
    transition: color var(--transition-fast), background var(--transition-fast);
}

.modal-close:hover {
    color: var(--color-text);
    background: var(--color-bg-tertiary);
}

.modal-close svg {
    width: 24px;
    height: 24px;
}

.modal-body {
    flex: 1;
    overflow: hidden;
    padding: var(--space-4);
}

.code-editor {
    width: 100%;
    height: 100%;
    min-height: 400px;
    background: #0d1117;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    color: #e6edf3;
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    line-height: 1.6;
    padding: var(--space-4);
    resize: none;
    outline: none;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: var(--space-3);
    padding: var(--space-4) var(--space-5);
    border-top: 1px solid var(--color-border);
}

/* Responsive */
@media (max-width: 768px) {
    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .toolbar-group {
        justify-content: center;
    }
}
</style>