<?php
/**
 * Public Landing Page - Manu Hosting
 */

$csrf_token = $csrf_token ?? "";
$wip = $wip ?? false;
$wip_message = $wip_message ?? "Manu Hosting befindet sich aktuell noch in der Entwicklung. Wir arbeiten daran, dir bald eine vollständige Minecraft-Hosting-Plattform anbieten zu können.";
$servers_offline = $servers_offline ?? false;
$servers_offline_message = $servers_offline_message ?? "Wir arbeiten aktuell an unserer Hosting-Infrastruktur. Unsere Minecraft-Server sind momentan noch nicht verfügbar. Bitte schau später noch einmal vorbei.";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manu Hosting - Professionelles Minecraft Server Hosting mit hoher Performance, DDoS-Schutz und einfacher Verwaltung.">
    <title>Manu Hosting - Professionelles Minecraft Server Hosting</title>
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="container navbar-inner">
            <a href="/" class="navbar-brand" aria-label="Manu Hosting Home">
                <svg class="navbar-logo" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="url(#gradient)"/>
                    <path d="M8 12h16M8 16h16M8 20h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="gradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#8B5CF6"/>
                            <stop offset="100%" stop-color="#3B82F6"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span class="navbar-title">Manu Hosting</span>
            </a>
            
            <div class="navbar-menu" id="navbarMenu">
                <a href="#features" class="navbar-link">Features</a>
                <a href="#pricing" class="navbar-link">Preise</a>
                <a href="#about" class="navbar-link">Über uns</a>
                <a href="/login" class="btn btn-ghost navbar-login">Anmelden</a>
                <a href="/register" class="btn btn-primary navbar-register">Jetzt starten</a>
            </div>
            
            <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu" aria-expanded="false">
                <span class="hamburger"></span>
            </button>
        </div>
    </nav>

    <!-- Announcement Bars -->
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

    <!-- Hero Section -->
    <header class="hero" role="banner">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    <span>Professionelles Minecraft Hosting</span>
                </div>
                
                <h1 class="hero-title">
                    Dein Minecraft Server,<br>
                    <span class="gradient-text">performant & sicher</span>
                </h1>
                
                <p class="hero-description">
                    Hoste deinen eigenen Minecraft Server mit professioneller Hardware, 
                    DDoS-Schutz, automatischen Backups und einer intuitiven Verwaltungsoberfläche.
                    Keine technische Erfahrung nötig – wir kümmern uns um den Rest.
                </p>
                
                <div class="hero-actions">
                    <a href="/register" class="btn btn-primary btn-lg">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Server erstellen
                    </a>
                    <a href="#pricing" class="btn btn-secondary btn-lg">
                        Preise ansehen
                    </a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Uptime Garantie</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><5ms</span>
                        <span class="stat-label">Latenz</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Support</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">DDoS</span>
                        <span class="stat-label">Schutz inklusive</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-card">
                    <div class="card-header">
                        <div class="card-dots">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="terminal-lines">
                            <div class="line"><span class="prompt">root@manu-hosting:~$</span> <span class="command">./start-server.sh</span></div>
                            <div class="line success">[INFO] Starting Minecraft Server...</div>
                            <div class="line success">[INFO] Loading Paper 1.20.4...</div>
                            <div class="line success">[INFO] Loading plugins: 12 loaded</div>
                            <div class="line success">[INFO] World loaded: world</div>
                            <div class="line success">[INFO] Server running on port 25565</div>
                            <div class="line"><span class="prompt">root@manu-hosting:~$</span> <span class="command">_</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="section features-section" aria-labelledby="features-heading">
        <div class="container">
            <header class="section-header">
                <h2 id="features-heading" class="section-title">Alles was du brauchst</h2>
                <p class="section-description">Professionelle Features für dein bestes Minecraft-Erlebnis</p>
            </header>
            
            <div class="features-grid">
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M6 8h12M6 12h12M6 16h8"/>
                        </svg>
                    </div>
                    <h3>One-Click Installation</h3>
                    <p>Paper, Purpur, Spigot, Fabric, Forge, NeoForge, Quilt, Velocity, BungeeCord – alles mit einem Klick installiert.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3>DDoS-Schutz</h3>
                    <p>Enterprise-Grade DDoS-Schutz schützt deinen Server vor Angriffen – automatisch und ohne Konfiguration.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/>
                            <path d="M3 16a9 9 0 0 1 2.24-4.72"/>
                        </svg>
                    </div>
                    <h3>Automatische Backups</h3>
                    <p>Tägliche Backups mit einfacher Wiederherstellung. Deine Welten sind immer sicher.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M6 8h12M6 12h12M6 16h8"/>
                        </svg>
                    </div>
                    <h3>Live Console</h3>
                    <p>Echte Terminal-Konsole im Browser mit Farbunterstützung, Historie und Tab-Vervollständigung.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                            <polyline points="13 2 13 9 20 9"/>
                        </svg>
                    </div>
                    <h3>Dateimanager</h3>
                    <p>Vollständiger Web-Dateimanager mit Editor, Upload, Download, ZIP und mehr.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3>Zeitpläne & Tasks</h3>
                    <p>Automatische Neustarts, Backups, Befehle und Wartungsfenster nach Zeitplan.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3>Spieler-Management</h3>
                    <p>Kicken, bannen, OP-Rechte, Whitelist, Live-Inventar-Ansicht und Anti-Cheat-Monitoring.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <h3>Ressourcen-Monitoring</h3>
                    <p>Echtzeit-Graphen für CPU, RAM, Netzwerk und Disk I/O pro Server.</p>
                </article>
                
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3>Sicherheit First</h3>
                    <p>Argon2id Passwörter, 2FA, Rate-Limiting, Audit-Logs, getrennte Kundendaten.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section pricing-section" aria-labelledby="pricing-heading">
        <div class="container">
            <header class="section-header">
                <h2 id="pricing-heading" class="section-title">Faire Preise, keine Überraschungen</h2>
                <p class="section-description">Wähle das Paket, das zu dir passt. Alle Preise inkl. MwSt.</p>
            </header>
            
            <div class="pricing-toggle">
                <span>Monatlich</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="billingToggle">
                    <span class="toggle-slider"></span>
                </label>
                <span>Jährlich <span class="discount-badge">-20%</span></span>
            </div>
            
            <div class="pricing-grid" id="pricingGrid">
                <!-- Packages will be loaded via JavaScript -->
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section about-section" aria-labelledby="about-heading">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <header class="section-header">
                        <h2 id="about-heading" class="section-title">Über Manu Hosting</h2>
                        <p class="section-description">Wir sind Gamer, die Hosting besser machen wollen</p>
                    </header>
                    
                    <div class="about-text">
                        <p>Manu Hosting wurde aus der Frustration heraus geboren, dass gutes Minecraft-Hosting entweder teuer, kompliziert oder unzuverlässig ist. Wir wollten eine Plattform bauen, die wir selbst nutzen würden.</p>
                        
                        <p>Unser Ziel: Professionelles Hosting, das einfach funktioniert. Keine versteckten Kosten, keine künstlichen Limits, kein Vendor Lock-in. Du besitzt deine Daten, du kontrollierst deinen Server.</p>
                        
                        <ul class="about-values">
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <span>Transparenz bei Preisen & Performance</span>
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <span>Datenschutz & Sicherheit als Standard</span>
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <span>Community-First Entwicklung</span>
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <span>Open Source wo möglich</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="about-visual">
                    <div class="about-stats">
                        <div class="stat-large">
                            <span class="stat-number">2</span>
                            <span class="stat-label">Dedizierte Server</span>
                        </div>
                        <div class="stat-large">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Eigene Hardware</span>
                        </div>
                        <div class="stat-large">
                            <span class="stat-number">∞</span>
                            <span class="stat-label">Skalierbarkeit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section" aria-labelledby="cta-heading">
        <div class="container">
            <div class="cta-card">
                <h2 id="cta-heading" class="cta-title">Bereit für deinen eigenen Server?</h2>
                <p class="cta-description">Erstelle deinen Minecraft Server in Minuten. Keine Kreditkarte für Test erforderlich.</p>
                <a href="/register" class="btn btn-primary btn-xl">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Kostenlos testen
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/" class="footer-logo">
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="8" fill="url(#footerGradient)"/>
                            <path d="M8 12h16M8 16h16M8 20h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="footerGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#8B5CF6"/>
                                    <stop offset="100%" stop-color="#3B82F6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span>Manu Hosting</span>
                    </a>
                    <p>Professionelles Minecraft Server Hosting made in Germany.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Discord"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.443.747-.694 1.113a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.717-1.127.077.077 0 0 0-.125-.024.075.075 0 0 0-.042.027 19.736 19.736 0 0 0-4.743 1.494.068.068 0 0 0-.033.117l-.659 2.83a.216.216 0 0 0 .098.193.091.091 0 0 0 .11.027.117.117 0 0 0 .076-.051l1.289-2.842a.287.287 0 0 1 .27-.094.32.32 0 0 1 .301.164c1.563 1.572 3.7 2.89 6.084 3.718a.1.1 0 0 0 .089-.143l-.769-3.827a.12.12 0 0 0-.094-.182zm-6.621 18.847c-3.126-.428-5.815-1.767-7.952-3.834-.063-.06-.144-.09-.23-.072-.088.019-.15.089-.15.178v.277c0 1.088-.676 2.017-1.795 2.295a20.71 20.71 0 0 1-2.994.885.082.082 0 0 1-.07-.123c.13-1.32.724-2.55 1.878-3.298.088-.056.132-.168.105-.274-.046-.183-.458-.733-.652-1.065a13.783 13.783 0 0 0-1.79-.586.095.095 0 0 1-.042-.183c.067-.404.264-.797.525-1.17.205-.293.502-.538.804-.691a3.016 3.016 0 0 1 .513-.253c.309-.065.62-.095.93-.095.312 0 .623.03.93.095a2.83 2.83 0 0 1 1.036.736 10.322 10.322 0 0 0 .625 1.585c.209.28.343.61.412.955.028.143.005.29-.063.392a33.23 33.23 0 0 1-1.62 5.591.082.082 0 0 0 .027.13.07.07 0 0 0 .115.015c.57-.434 1.17-.826 1.777-1.195.05-.03.11-.045.164-.045.088 0 .158.035.21.09.05.054.085.122.1.193a11.78 11.78 0 0 1-.395 4.058.083.083 0 0 0 .064.14.074.074 0 0 0 .104-.015 17.558 17.558 0 0 0 3.207-.982c.062-.054.104-.133.104-.216v-.38c0-.106.07-.192.16-.218 1.504-.427 3.005-.94 4.446-1.536.07-.027.132.02.163.086.03.066.01.14-.048.185-2.126 1.593-4.576 2.745-7.126 3.395a.073.073 0 0 0 0 .107.067.067 0 0 0 .106 0c.576-.14 1.178-.192 1.74-.192.423 0 .876.028 1.295.098.06.01.115.05.144.103.047.088.02.186-.06.245z"/></svg></a>
                        <a href="#" aria-label="GitHub"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg></a>
                        <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                    </div>
                </div>
                
                <nav class="footer-nav" aria-label="Footer navigation">
                    <div class="footer-column">
                        <h4>Produkt</h4>
                        <ul>
                            <li><a href="#features">Features</a></li>
                            <li><a href="#pricing">Preise</a></li>
                            <li><a href="/status">Status</a></li>
                            <li><a href="/docs">Dokumentation</a></li>
                            <li><a href="/api">API</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Unternehmen</h4>
                        <ul>
                            <li><a href="#about">Über uns</a></li>
                            <li><a href="/karriere">Karriere</a></li>
                            <li><a href="/blog">Blog</a></li>
                            <li><a href="/presse">Presse</a></li>
                            <li><a href="/partner">Partner</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="/hilfe">Hilfezentrum</a></li>
                            <li><a href="/contact">Kontakt</a></li>
                            <li><a href="/tickets">Tickets</a></li>
                            <li><a href="/community">Community</a></li>
                            <li><a href="/faq">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Rechtliches</h4>
                        <ul>
                            <li><a href="/impressum">Impressum</a></li>
                            <li><a href="/datenschutz">Datenschutz</a></li>
                            <li><a href="/agb">AGB</a></li>
                            <li><a href="/widerruf">Widerrufsrecht</a></li>
                            <li><a href="/cookie">Cookie-Richtlinie</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date("Y") ?> Manu Hosting. Alle Rechte vorbehalten.</p>
                <p class="footer-made">Made with <span class="heart">♥</span> in Germany</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
    <script>
        // Load pricing packages dynamically
        document.addEventListener("DOMContentLoaded", async function() {
            try {
                const response = await fetch("/api/v1/packages");
                const packages = await response.json();
                renderPricing(packages);
            } catch (e) {
                console.error("Failed to load packages:", e);
            }
        });
        
        function renderPricing(packages) {
            const grid = document.getElementById("pricingGrid");
            const toggle = document.getElementById("billingToggle");
            let yearly = false;
            
            function render() {
                grid.innerHTML = packages.map(pkg => {
                    const price = yearly ? Math.round(pkg.price_monthly * 12 * 0.8) : pkg.price_monthly;
                    const period = yearly ? "/ Jahr" : "/ Monat";
                    const features = pkg.features || [];
                    
                    return `
                        <article class="pricing-card${pkg.popular ? " popular" : ""}">
                            ${pkg.popular ? '<div class="popular-badge">Beliebt</div>' : ""}
                            <header class="pricing-header">
                                <h3>${pkg.name}</h3>
                                <div class="pricing-price">
                                    <span class="amount">${price.toLocaleString("de-DE")} €</span>
                                    <span class="period">${period}</span>
                                </div>
                                <p class="pricing-desc">${pkg.description}</p>
                            </header>
                            <ul class="pricing-features">
                                ${features.map(f => `<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>${f}</li>`).join("")}
                            </ul>
                            <a href="/register?package=${pkg.id}" class="btn btn-${pkg.popular ? "primary" : "outline"} btn-block w-full">
                                Auswählen
                            </a>
                        </article>
                    `;
                }).join("");
            }
            
            toggle?.addEventListener("change", function() {
                yearly = this.checked;
                render();
            });
            
            render();
        }
        
        // Mobile menu toggle
        const toggle = document.getElementById("navbarToggle");
        const menu = document.getElementById("navbarMenu");
        toggle?.addEventListener("click", function() {
            const expanded = this.getAttribute("aria-expanded") === "true";
            this.setAttribute("aria-expanded", !expanded);
            menu.classList.toggle("active");
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function(e) {
                const target = document.querySelector(this.getAttribute("href"));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: "smooth", block: "start" });
                    menu.classList.remove("active");
                    toggle.setAttribute("aria-expanded", "false");
                }
            });
        });
    </script>
</body>
</html>