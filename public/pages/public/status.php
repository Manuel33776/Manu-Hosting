<?php
/**
 * Public Status Page
 */

$csrf_token = $csrf_token ?? "";
$status = $status ?? [];
$wip = $wip ?? false;
$wip_message = $wip_message ?? "";
$servers_offline = $servers_offline ?? false;
$servers_offline_message = $servers_offline_message ?? "";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status - Manu Hosting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
</head>
<body class="status-page">
    <header class="status-header">
        <div class="container">
            <a href="/" class="status-logo">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="url(#statusGradient)"/>
                    <path d="M8 12h16M8 16h16M8 20h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="statusGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#8B5CF6"/>
                            <stop offset="100%" stop-color="#3B82F6"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>Manu Hosting Status</span>
            </a>
            <div class="status-update-info">
                <span id="lastUpdate">Zuletzt aktualisiert: <span id="lastUpdateTime">-</span></span>
                <button class="btn btn-ghost btn-sm" id="refreshBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <?php if ($wip): ?>
        <div class="announcement-bar announcement-wip" role="alert">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span><strong>WORK IN PROGRESS:</strong> <?= htmlspecialchars($wip_message) ?></span>
        </div>
    <?php endif; ?>
    
    <?php if ($servers_offline): ?>
        <div class="announcement-bar announcement-offline" role="alert">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M6 8h12M6 12h12M6 16h8"/>
                <line x1="6" y1="8" x2="18" y2="20"/>
            </svg>
            <span><strong>SERVER OFFLINE:</strong> <?= htmlspecialchars($servers_offline_message) ?></span>
        </div>
    <?php endif; ?>

    <main class="status-main">
        <div class="container">
            <!-- Overall Status -->
            <section class="status-overview">
                <div class="status-card overall-<?= $status["overall"] ?? "unknown" ?>">
                    <div class="status-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <?php if (($status["overall"] ?? "") === "operational"): ?>
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            <?php elseif (($status["overall"] ?? "") === "degraded"): ?>
                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                            <?php else: ?>
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            <?php endif; ?>
                        </svg>
                    </div>
                    <div class="status-info">
                        <h2 class="status-title"><?= ucfirst($status["overall"] ?? "Unbekannt") ?></h2>
                        <p class="status-description">
                            <?php 
                                switch ($status["overall"] ?? "") {
                                    case "operational":
                                        echo "Alle Systeme sind voll funktionsfähig.";
                                        break;
                                    case "degraded":
                                        echo "Einige Systeme sind beeinträchtigt. Details unten.";
                                        break;
                                    case "major_outage":
                                        echo "Größere Störung. Unsere Teams arbeiten an der Behebung.";
                                        break;
                                    default:
                                        echo "Status konnte nicht ermittelt werden.";
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Component Status -->
            <section class="status-components" aria-labelledby="components-heading">
                <h2 id="components-heading" class="section-title">System-Komponenten</h2>
                
                <div class="components-grid">
                    <!-- Website -->
                    <article class="component-card <?= $status["website"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="2" y1="12" x2="22" y2="12"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                            </div>
                            <div>
                                <h3>Website & Portal</h3>
                                <span class="component-status status-<?= $status["website"] ?? "unknown" ?>"><?= ucfirst($status["website"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>Debian 13 Control Plane</span>
                            <span id="websiteLatency">Latenz: -</span>
                        </div>
                    </article>

                    <!-- API -->
                    <article class="component-card <?= $status["api"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                    <path d="M2 17l10 5 10-5"/>
                                    <path d="M2 12l10 5 10-5"/>
                                </svg>
                            </div>
                            <div>
                                <h3>REST API</h3>
                                <span class="component-status status-<?= $status["api"] ?? "unknown" ?>"><?= ucfirst($status["api"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>API v1 Endpoints</span>
                            <span id="apiLatency">Latenz: -</span>
                        </div>
                    </article>

                    <!-- Database -->
                    <article class="component-card <?= $status["database"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                                </svg>
                            </div>
                            <div>
                                <h3>MariaDB Datenbank</h3>
                                <span class="component-status status-<?= $status["database"] ?? "unknown" ?>"><?= ucfirst($status["database"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>Zentrale Datenspeicherung</span>
                        </div>
                    </article>

                    <!-- Minecraft Nodes -->
                    <article class="component-card <?= $status["nodes"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="M6 8h12M6 12h12M6 16h8"/>
                                </svg>
                            </div>
                            <div>
                                <h3>Minecraft Nodes (DL580)</h3>
                                <span class="component-status status-<?= $status["nodes"] ?? "unknown" ?>"><?= ucfirst($status["nodes"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>Windows Hosting-Nodes</span>
                            <span id="nodesCount">Online: <span id="nodesOnline">-</span>/<span id="nodesTotal">-</span></span>
                        </div>
                    </article>

                    <!-- Email -->
                    <article class="component-card <?= $status["email"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div>
                                <h3>E-Mail-System</h3>
                                <span class="component-status status-<?= $status["email"] ?? "unknown" ?>"><?= ucfirst($status["email"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>SMTP Benachrichtigungen</span>
                        </div>
                    </article>

                    <!-- Backups -->
                    <article class="component-card <?= $status["backups"] ?? "unknown" ?>">
                        <div class="component-header">
                            <div class="component-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                                    <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
                                </svg>
                            </div>
                            <div>
                                <h3>Backup-System</h3>
                                <span class="component-status status-<?= $status["backups"] ?? "unknown" ?>"><?= ucfirst($status["backups"] ?? "Unbekannt") ?></span>
                            </div>
                        </div>
                        <div class="component-meta">
                            <span>Automatische & manuelle Backups</span>
                            <span id="lastBackup">Letztes: -</span>
                        </div>
                    </article>
                </div>
            </section>

            <!-- Incident History -->
            <section class="status-incidents" aria-labelledby="incidents-heading">
                <h2 id="incidents-heading" class="section-title">Vorfall-Historie</h2>
                <div class="incidents-list" id="incidentsList">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        <h4>Keine Vorfälle</h4>
                        <p>Alle Systeme laufen stabil.</p>
                    </div>
                </div>
            </section>

            <!-- Maintenance Schedule -->
            <section class="status-maintenance" aria-labelledby="maintenance-heading">
                <h2 id="maintenance-heading" class="section-title">Geplante Wartungen</h2>
                <div class="maintenance-list" id="maintenanceList">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <h4>Keine geplanten Wartungen</h4>
                        <p>Es sind derzeit keine Wartungsarbeiten geplant.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="status-footer">
        <div class="container">
            <p>&copy; <?= date("Y") ?> Manu Hosting. Alle Rechte vorbehalten.</p>
            <p><a href="/impressum">Impressum</a> • <a href="/datenschutz">Datenschutz</a> • <a href="/api/v1/status">API Status</a></p>
        </div>
    </footer>

    <script>
    // Auto-refresh every 60 seconds
    let refreshInterval = 60000;
    let lastFetch = 0;

    async function fetchStatus() {
        try {
            const response = await fetch("/api/v1/status");
            const data = await response.json();
            updateStatusDisplay(data);
            lastFetch = Date.now();
            document.getElementById("lastUpdateTime").textContent = new Date().toLocaleTimeString("de-DE");
        } catch (e) {
            console.error("Failed to fetch status:", e);
        }
    }

    function updateStatusDisplay(data) {
        // Update overall status card
        const overallCard = document.querySelector(".status-card");
        if (overallCard && data.overall) {
            overallCard.className = "status-card overall-" + data.overall;
            const title = overallCard.querySelector(".status-title");
            const desc = overallCard.querySelector(".status-description");
            if (title) title.textContent = capitalize(data.overall);
            if (desc) {
                switch(data.overall) {
                    case "operational": desc.textContent = "Alle Systeme sind voll funktionsfähig."; break;
                    case "degraded": desc.textContent = "Einige Systeme sind beeinträchtigt. Details unten."; break;
                    case "major_outage": desc.textContent = "Größere Störung. Unsere Teams arbeiten an der Behebung."; break;
                }
            }
        }

        // Update component cards
        const components = ["website", "api", "database", "nodes", "email", "backups"];
        components.forEach(comp => {
            const card = document.querySelector(`.component-card.${comp}`);
            if (card && data[comp]) {
                card.className = `component-card ${data[comp]}`;
                const statusEl = card.querySelector(".component-status");
                if (statusEl) {
                    statusEl.className = `component-status status-${data[comp]}`;
                    statusEl.textContent = capitalize(data[comp]);
                }
            }
        });

        // Update node counts
        if (data.nodes_online !== undefined && data.nodes_total !== undefined) {
            const onlineEl = document.getElementById("nodesOnline");
            const totalEl = document.getElementById("nodesTotal");
            if (onlineEl) onlineEl.textContent = data.nodes_online;
            if (totalEl) totalEl.textContent = data.nodes_total;
        }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).replace("_", " ");
    }

    // Initial fetch
    document.addEventListener("DOMContentLoaded", function() {
        fetchStatus();
        
        // Refresh button
        document.getElementById("refreshBtn")?.addEventListener("click", fetchStatus);
        
        // Auto-refresh
        setInterval(fetchStatus, refreshInterval);
        
        // Update timestamps
        setInterval(() => {
            document.getElementById("lastUpdateTime").textContent = new Date().toLocaleTimeString("de-DE");
        }, 1000);
    });
    </script>

    <style>
    .status-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-4) var(--space-6);
        background: var(--color-bg-secondary);
        border-bottom: 1px solid var(--color-border);
    }

    .status-logo {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        text-decoration: none;
        color: var(--color-text);
    }

    .status-logo svg { width: 32px; height: 32px; }

    .status-update-info {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        font-size: var(--text-sm);
        color: var(--color-text-muted);
    }

    .status-main {
        flex: 1;
        padding: var(--space-8) var(--space-6);
    }

    .status-overview {
        margin-bottom: var(--space-10);
    }

    .status-card {
        display: flex;
        align-items: center;
        gap: var(--space-6);
        padding: var(--space-6) var(--space-8);
        border-radius: var(--radius-xl);
        border: 1px solid var(--color-border);
        max-width: 800px;
    }

    .status-card.overall-operational {
        background: rgba(34, 197, 94, 0.08);
        border-color: rgba(34, 197, 94, 0.3);
    }

    .status-card.overall-degraded {
        background: rgba(245, 158, 11, 0.08);
        border-color: rgba(245, 158, 11, 0.3);
    }

    .status-card.overall-major_outage {
        background: rgba(239, 68, 68, 0.08);
        border-color: rgba(239, 68, 68, 0.3);
    }

    .status-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: var(--radius-lg);
        flex-shrink: 0;
    }

    .status-card.overall-operational .status-icon { background: rgba(34, 197, 94, 0.15); color: var(--color-success); }
    .status-card.overall-degraded .status-icon { background: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
    .status-card.overall-major_outage .status-icon { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }

    .status-icon svg { width: 32px; height: 32px; }

    .status-title { font-size: var(--text-2xl); font-weight: 700; color: var(--color-text); margin-bottom: var(--space-1); }
    .status-description { color: var(--color-text-muted); font-size: var(--text-base); }

    .section-title {
        font-size: var(--text-xl);
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: var(--space-5);
    }

    .components-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: var(--space-5);
        margin-bottom: var(--space-10);
    }

    .component-card {
        background: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: var(--space-5);
        transition: transform var(--transition-fast), box-shadow var(--transition-fast);
    }

    .component-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .component-card.operational { border-left: 4px solid var(--color-success); }
    .component-card.degraded { border-left: 4px solid var(--color-warning); }
    .component-card.major_outage { border-left: 4px solid var(--color-error); }
    .component-card.maintenance { border-left: 4px solid var(--color-info); }
    .component-card.unknown { border-left: 4px solid var(--color-text-muted); }

    .component-header {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        margin-bottom: var(--space-3);
    }

    .component-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: var(--radius-lg);
        background: var(--color-bg-tertiary);
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .component-icon svg { width: 24px; height: 24px; }

    .component-header h3 {
        font-size: var(--text-lg);
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: var(--space-1);
    }

    .component-status {
        display: inline-block;
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-full);
        font-size: var(--text-xs);
        font-weight: 600;
        text-transform: capitalize;
    }

    .component-status.status-operational { background: rgba(34, 197, 94, 0.15); color: var(--color-success); }
    .component-status.status-degraded { background: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
    .component-status.status-major_outage { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }
    .component-status.status-maintenance { background: rgba(59, 130, 246, 0.15); color: var(--color-info); }
    .component-status.status-unknown { background: rgba(113, 113, 122, 0.15); color: var(--color-text-muted); }

    .component-meta {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-4);
        font-size: var(--text-sm);
        color: var(--color-text-muted);
    }

    .incidents-list, .maintenance-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .incident-card, .maintenance-card {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-5);
        background: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
    }

    .incident-icon, .maintenance-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        flex-shrink: 0;
    }

    .incident-icon { background: rgba(239, 68, 68, 0.15); color: var(--color-error); }
    .maintenance-icon { background: rgba(59, 130, 246, 0.15); color: var(--color-info); }

    .incident-content, .maintenance-content { flex: 1; }

    .incident-title, .maintenance-title {
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: var(--space-1);
    }

    .incident-meta, .maintenance-meta {
        font-size: var(--text-sm);
        color: var(--color-text-muted);
    }

    .status-footer {
        padding: var(--space-6);
        background: var(--color-bg-secondary);
        border-top: 1px solid var(--color-border);
        text-align: center;
        font-size: var(--text-sm);
        color: var(--color-text-muted);
    }

    .status-footer a { color: var(--color-primary); text-decoration: none; }
    .status-footer a:hover { text-decoration: underline; }

    .cookie-table {
        width: 100%;
        border-collapse: collapse;
        margin: var(--space-4) 0;
        font-size: var(--text-sm);
    }

    .cookie-table th, .cookie-table td {
        padding: var(--space-3);
        text-align: left;
        border-bottom: 1px solid var(--color-border);
    }

    .cookie-table th {
        font-weight: 600;
        color: var(--color-text);
    }

    .cookie-table td {
        color: var(--color-text-muted);
    }

    .cookie-table code {
        background: var(--color-bg-tertiary);
        padding: 2px 6px;
        border-radius: var(--radius-sm);
        font-family: var(--font-mono);
    }

    .form-template pre {
        background: var(--color-bg-tertiary);
        padding: var(--space-4);
        border-radius: var(--radius-md);
        overflow-x: auto;
        font-family: var(--font-mono);
        font-size: var(--text-sm);
        white-space: pre-wrap;
    }

    @media (max-width: 768px) {
        .status-card {
            flex-direction: column;
            text-align: center;
        }

        .components-grid {
            grid-template-columns: 1fr;
        }

        .status-header {
            flex-direction: column;
            gap: var(--space-3);
        }
    }
    </style>
</script>
</body>
</html>