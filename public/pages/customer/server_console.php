<?php
/**
 * Server Console Page
 * Real-time WebSocket console for Minecraft server management
 */

$server = $server ?? [];
$csrf_token = $csrf_token ?? "";
?>

<div class="page-header">
    <h1 class="page-title">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="M6 8h12M6 12h12M6 16h8"/>
        </svg>
        Console: <?= htmlspecialchars($server["name"] ?? "") ?>
    </h1>
    <div class="page-actions">
        <a href="/dashboard/servers/<?= $server["id"] ?>" class="btn btn-secondary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Server
        </a>
    </div>
</div>

<div class="console-container">
    <div class="console-header">
        <div class="console-status">
            <span class="status-indicator" id="connectionStatus">
                <span class="status-dot"></span>
                <span class="status-text">Connecting...</span>
            </span>
            <span class="server-info">
                <?= htmlspecialchars($server["name"] ?? "") ?> 
                (<?= htmlspecialchars($server["uuid"] ?? "") ?>)
            </span>
        </div>
        <div class="console-actions">
            <button class="btn btn-sm btn-outline" id="clearConsole" title="Clear console">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
                Clear
            </button>
            <button class="btn btn-sm btn-outline" id="sendCtrlC" title="Send Ctrl+C">
                <kbd>Ctrl+C</kbd>
            </button>
        </div>
    </div>
    
    <div class="console-output" id="consoleOutput" role="log" aria-live="polite"></div>
    
    <div class="console-input-container">
        <div class="console-input-wrapper">
            <span class="console-prompt">root@manu-hosting:~$</span>
            <input type="text" 
                   class="console-input" 
                   id="consoleInput" 
                   placeholder="Type a command..." 
                   autocomplete="off"
                   spellcheck="false"
                   disabled>
        </div>
        <button class="btn btn-primary console-send" id="sendCommand" disabled>
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>
</div>

<script>
// Console state
let ws = null;
let token = "";
let serverUuid = "<?= htmlspecialchars($server["uuid"] ?? "") ?>";
let serverId = "<?= htmlspecialchars($server["id"] ?? "") ?>";
let reconnectAttempts = 0;
let maxReconnectAttempts = 5;
let commandHistory = [];
let historyIndex = -1;
let isConnected = false;

// DOM elements
const consoleOutput = document.getElementById("consoleOutput");
const consoleInput = document.getElementById("consoleInput");
const sendButton = document.getElementById("sendCommand");
const connectionStatus = document.getElementById("connectionStatus");
const clearButton = document.getElementById("clearConsole");
const ctrlCButton = document.getElementById("sendCtrlC");

// Initialize console
document.addEventListener("DOMContentLoaded", function() {
    fetchTokenAndConnect();
    
    // Event listeners
    consoleInput.addEventListener("keydown", handleKeyDown);
    sendButton.addEventListener("click", sendCommand);
    clearButton.addEventListener("click", clearConsole);
    ctrlCButton.addEventListener("click", sendCtrlC);
    
    // Focus input on click
    consoleOutput.addEventListener("click", () => consoleInput.focus());
});

// Fetch token and connect to WebSocket
async function fetchTokenAndConnect() {
    try {
        const response = await fetch(`/api/v1/servers/${serverId}/console/token`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.token) {
            token = data.token;
            connectWebSocket();
        } else {
            showError("Failed to get console token: " + (data.error || "Unknown error"));
        }
    } catch (error) {
        showError("Error fetching token: " + error.message);
    }
}

// Connect to WebSocket console server
function connectWebSocket() {
    const wsProtocol = window.location.protocol === "https:" ? "wss:" : "ws:";
    const wsHost = "<?= getenv("CONSOLE_WS_HOST") ?: "localhost" ?>";
    const wsPort = "<?= getenv("CONSOLE_WS_PORT") ?: "8080" ?>";
    const wsUrl = `${wsProtocol}//${wsHost}:${wsPort}/?token=${token}&server=${serverUuid}`;
    
    updateStatus("connecting", "Connecting...");
    
    ws = new WebSocket(wsUrl);
    
    ws.onopen = function() {
        isConnected = true;
        reconnectAttempts = 0;
        updateStatus("connected", "Connected");
        consoleInput.disabled = false;
        sendButton.disabled = false;
        consoleInput.focus();
        appendOutput("[System] Connected to console server\n", "system");
    };
    
    ws.onmessage = function(event) {
        try {
            const data = JSON.parse(event.data);
            handleWebSocketMessage(data);
        } catch (e) {
            console.error("Failed to parse WebSocket message:", e);
        }
    };
    
    ws.onclose = function(event) {
        isConnected = false;
        consoleInput.disabled = true;
        sendButton.disabled = true;
        updateStatus("disconnected", "Disconnected");
        appendOutput("[System] Disconnected from console server\n", "system");
        
        // Attempt reconnect
        if (reconnectAttempts < maxReconnectAttempts) {
            reconnectAttempts++;
            appendOutput(`[System] Reconnecting... (attempt ${reconnectAttempts}/${maxReconnectAttempts})\n`, "system");
            setTimeout(() => {
                fetchTokenAndConnect();
            }, 2000 * reconnectAttempts);
        } else {
            appendOutput("[System] Max reconnect attempts reached. Please refresh the page.\n", "error");
        }
    };
    
    ws.onerror = function(error) {
        appendOutput("[System] WebSocket error: " + error.message + "\n", "error");
    };
}

// Handle incoming WebSocket messages
function handleWebSocketMessage(data) {
    switch (data.type) {
        case "connected":
            appendOutput(data.message + "\n", "system");
            break;
            
        case "output":
            if (data.data) {
                appendOutput(data.data, "output");
            }
            break;
            
        case "pong":
            // Heartbeat response
            break;
            
        case "error":
            appendOutput("[Error] " + data.message + "\n", "error");
            break;
            
        default:
            console.log("Unknown message type:", data);
    }
}

// Send command to server
function sendCommand() {
    const command = consoleInput.value.trim();
    if (!command || !isConnected) return;
    
    // Add to history
    commandHistory.push(command);
    historyIndex = commandHistory.length;
    
    // Send via WebSocket
    ws.send(JSON.stringify({
        action: "command",
        command: command + "\n"
    }));
    
    // Echo command locally
    appendOutput("root@manu-hosting:~$ " + command + "\n", "command");
    consoleInput.value = "";
}

// Handle keyboard input
function handleKeyDown(event) {
    switch (event.key) {
        case "Enter":
            event.preventDefault();
            sendCommand();
            break;
            
        case "ArrowUp":
            event.preventDefault();
            if (historyIndex > 0) {
                historyIndex--;
                consoleInput.value = commandHistory[historyIndex];
            }
            break;
            
        case "ArrowDown":
            event.preventDefault();
            if (historyIndex < commandHistory.length - 1) {
                historyIndex++;
                consoleInput.value = commandHistory[historyIndex];
            } else {
                historyIndex = commandHistory.length;
                consoleInput.value = "";
            }
            break;
            
        case "Tab":
            // Prevent default tab behavior, could implement tab completion
            event.preventDefault();
            break;
    }
}

// Send Ctrl+C
function sendCtrlC() {
    if (!isConnected) return;
    
    ws.send(JSON.stringify({
        action: "command",
        command: "\x03"  // Ctrl+C
    }));
    
    appendOutput("^C\n", "command");
}

// Clear console output
function clearConsole() {
    consoleOutput.innerHTML = "";
}

// Update connection status indicator
function updateStatus(status, text) {
    const dot = connectionStatus.querySelector(".status-dot");
    const statusText = connectionStatus.querySelector(".status-text");
    
    connectionStatus.className = "status-indicator " + status;
    dot.className = "status-dot " + status;
    statusText.textContent = text;
}

// Append output to console
function appendOutput(text, type = "output") {
    const line = document.createElement("div");
    line.className = "console-line " + type;
    line.textContent = text;
    consoleOutput.appendChild(line);
    
    // Auto-scroll to bottom
    consoleOutput.scrollTop = consoleOutput.scrollHeight;
}

// Show error message
function showError(message) {
    appendOutput("[Error] " + message + "\n", "error");
    updateStatus("error", "Error");
}
</script>

<style>
/* Console Page Styles */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--color-border);
}

.page-title {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    font-size: var(--text-2xl);
    font-weight: 600;
    color: var(--color-text);
}

.page-title .icon {
    width: 28px;
    height: 28px;
    color: var(--color-primary);
}

.page-actions {
    display: flex;
    gap: var(--space-3);
}

.console-container {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 200px);
    min-height: 500px;
    background: var(--color-bg-tertiary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.console-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4) var(--space-5);
    background: var(--color-bg-secondary);
    border-bottom: 1px solid var(--color-border);
}

.console-status {
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-sm);
    font-weight: 500;
}

.status-indicator.connecting {
    background: rgba(245, 158, 11, 0.15);
    color: var(--color-warning);
}

.status-indicator.connected {
    background: rgba(34, 197, 94, 0.15);
    color: var(--color-success);
}

.status-indicator.disconnected,
.status-indicator.error {
    background: rgba(239, 68, 68, 0.15);
    color: var(--color-error);
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    transition: background-color var(--transition-fast);
}

.status-dot.connecting {
    background: var(--color-warning);
    animation: pulse 1.5s ease-in-out infinite;
}

.status-dot.connected {
    background: var(--color-success);
}

.status-dot.disconnected,
.status-dot.error {
    background: var(--color-error);
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.server-info {
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}

.console-actions {
    display: flex;
    gap: var(--space-2);
}

.console-output {
    flex: 1;
    overflow-y: auto;
    padding: var(--space-4);
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    line-height: 1.6;
    color: var(--color-text);
    background: var(--color-bg-tertiary);
}

.console-line {
    white-space: pre-wrap;
    word-break: break-word;
}

.console-line.system {
    color: var(--color-primary);
}

.console-line.command {
    color: var(--color-text-muted);
}

.console-line.output {
    color: var(--color-text);
}

.console-line.error {
    color: var(--color-error);
}

.console-input-container {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    background: var(--color-bg-secondary);
    border-top: 1px solid var(--color-border);
}

.console-input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.console-prompt {
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    color: var(--color-primary);
    white-space: nowrap;
}

.console-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--color-text);
    font-family: var(--font-mono);
    font-size: var(--text-sm);
    padding: var(--space-2) 0;
    min-width: 0;
}

.console-input:disabled {
    color: var(--color-text-muted);
    opacity: 0.5;
}

.console-input::placeholder {
    color: var(--color-text-muted);
}

.console-send {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    flex-shrink: 0;
}

.console-send .icon {
    width: 20px;
    height: 20px;
}

.console-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#sendCtrlC kbd {
    font-family: var(--font-mono);
    font-size: var(--text-xs);
    padding: var(--space-1) var(--space-2);
    background: var(--color-bg-tertiary);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    color: var(--color-text-muted);
}

/* Scrollbar styling */
.console-output::-webkit-scrollbar {
    width: 8px;
}

.console-output::-webkit-scrollbar-track {
    background: var(--color-bg-tertiary);
}

.console-output::-webkit-scrollbar-thumb {
    background: var(--color-border);
    border-radius: 4px;
}

.console-output::-webkit-scrollbar-thumb:hover {
    background: var(--color-text-muted);
}

/* Responsive */
@media (max-width: 768px) {
    .console-header {
        flex-direction: column;
        gap: var(--space-3);
        align-items: flex-start;
    }
    
    .console-input-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .console-send {
        width: 100%;
    }
}
</style>