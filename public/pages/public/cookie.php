<?php
/**
 * Cookie-Richtlinie - Cookie Policy
 */

$csrf_token = $csrf_token ?? "";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>Cookie-Richtlinie - Manu Hosting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
</head>
<body class="legal-page">
    <header class="legal-header">
        <div class="container">
            <a href="/" class="legal-logo">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="url(#legalGradient)"/>
                    <path d="M8 12h16M8 16h16M8 20h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="legalGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#8B5CF6"/>
                            <stop offset="100%" stop-color="#3B82F6"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>Manu Hosting</span>
            </a>
        </div>
    </header>
    
    <main class="legal-main">
        <div class="container">
            <nav class="legal-nav" aria-label="Legal navigation">
                <a href="/impressum">Impressum</a>
                <a href="/datenschutz">Datenschutz</a>
                <a href="/agb">AGB</a>
                <a href="/widerruf">Widerrufsrecht</a>
                <a href="/cookie" class="active">Cookie-Richtlinie</a>
            </nav>
            
            <article class="legal-content">
                <header class="legal-header-content">
                    <h1>Cookie-Richtlinie</h1>
                    <p class="legal-meta">Stand: <?= date("d.m.Y") ?> | Version 1.0</p>
                </header>
                
                <section class="legal-section">
                    <h2>1. Was sind Cookies?</h2>
                    <p>Cookies sind kleine Textdateien, die beim Besuch einer Website auf Ihrem Endgerät (Computer, Smartphone, Tablet) gespeichert werden. Sie enthalten Informationen, die der Website-Betreiber beim erneuten Besuch der Seite auslesen kann. Cookies dienen dazu, die Website funktionsfähig zu machen, die Nutzererfahrung zu verbessern und Informationen über die Nutzung der Website zu sammeln.</p>
                </section>
                
                <section class="legal-section">
                    <h2>2. Welche Cookies verwenden wir?</h2>
                    <p>Wir unterteilen Cookies in folgende Kategorien:</p>
                    
                    <h3>Unbedingt notwendige Cookies (Technisch erforderlich)</h3>
                    <p>Diese Cookies sind für den Betrieb der Website und des Kundenportals zwingend erforderlich. Ohne diese Cookies können grundlegende Funktionen wie Anmeldung, Warenkorb, Sitzungsverwaltung und Sicherheit nicht bereitgestellt werden. Eine Deaktivierung ist nicht möglich, da die Website sonst nicht funktioniert.</p>
                    <table class="cookie-table">
                        <thead>
                            <tr>
                                <th>Cookie-Name</th>
                                <th>Zweck</th>
                                <th>Speicherdauer</th>
                                <th>Art</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PHPSESSID</td>
                                <td>Sitzungs-ID für Benutzeranmeldung</td>
                                <td>Sitzung (bis Browser geschlossen)</td>
                                <td>Session-Cookie</td>
                            </tr>
                            <tr>
                                <td>csrf_token</td>
                                <td>CSRF-Schutz für Formulare</td>
                                <td>Sitzung</td>
                                <td>Session-Cookie</td>
                            </tr>
                            <tr>
                                <td>remember_token</td>
                                <td>"Angemeldet bleiben" Funktion</td>
                                <td>30 Tage</td>
                                <td>Persistent Cookie</td>
                            </tr>
                            <tr>
                                <td>cookie_consent</td>
                                <td>Speicherung der Cookie-Einwilligung</td>
                                <td>1 Jahr</td>
                                <td>Persistent Cookie</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h3>Funktionale Cookies</h3>
                    <p>Wir verwenden derzeit keine rein funktionalen Cookies (z. B. für Spracheinstellungen, Theme-Präferenzen), da diese Einstellungen serverseitig im Benutzerprofil gespeichert werden.</p>
                    
                    <h3>Analyse- und Statistik-Cookies</h3>
                    <p><strong>Wir verwenden keine Analyse-Cookies von Drittanbietern</strong> (wie Google Analytics, Matomo, etc.). Wir tracken kein Nutzerverhalten über Cookies. Statistische Auswertungen erfolgen ausschließlich serverseitig und anonymisiert über unsere eigenen Logfiles (siehe Datenschutzerklärung).</p>
                    
                    <h3>Marketing- und Tracking-Cookies</h3>
                    <p><strong>Wir verwenden keine Marketing-Cookies</strong> (wie Facebook Pixel, Google Ads, TikTok Pixel, etc.). Es erfolgt keine personalisierte Werbung und kein Cross-Site-Tracking.</p>
                    
                    <h3>Social-Media-Cookies</h3>
                    <p>Wir binden keine Social-Media-Plugins (Facebook Like, Twitter Tweet, etc.) ein, die Cookies setzen würden. Die Links zu unseren Social-Media-Profilen im Footer sind einfache Hyperlinks ohne Tracking.</p>
                </section>
                
                <section class="legal-section">
                    <h2>3. Rechtsgrundlagen</h2>
                    <p>Die Verarbeitung personenbezogener Daten durch technisch notwendige Cookies erfolgt auf Grundlage von <strong>Art. 6 Abs. 1 lit. f DSGVO</strong> (berechtigtes Interesse an der Bereitstellung einer funktionsfähigen, sicheren Website).</p>
                    <p>Soweit wir in Zukunft optionale Cookies einsetzen würden, holen wir Ihre Einwilligung gemäß <strong>Art. 6 Abs. 1 lit. a DSGVO</strong> und <strong>§ 25 Abs. 1 TTDSG</strong> ein.</p>
                </section>
                
                <section class="legal-section">
                    <h2>4. Cookie-Verwaltung und -Löschung</h2>
                    <p>Sie können Cookies in Ihrem Browser verwalten, blockieren oder löschen:</p>
                    <ul>
                        <li><strong>Chrome:</strong> Einstellungen → Datenschutz und Sicherheit → Cookies und andere Websitedaten</li>
                        <li><strong>Firefox:</strong> Einstellungen → Datenschutz & Sicherheit → Cookies und Websitedaten</li>
                        <li><strong>Safari:</strong> Einstellungen → Datenschutz → Websitedaten verwalten</li>
                        <li><strong>Edge:</strong> Einstellungen → Cookies und Websiteberechtigungen → Cookies und Websitedaten verwalten</li>
                    </ul>
                    <p><strong>Hinweis:</strong> Wenn Sie notwendige Cookies blockieren oder löschen, können Sie sich nicht anmelden, das Kundenportal nicht nutzen und Bestellungen nicht abschließen.</p>
                </section>
                
                <section class="legal-section">
                    <h2>5. Einwilligung und Widerruf</h2>
                    <p>Da wir derzeit ausschließlich technisch notwendige Cookies verwenden, ist keine aktive Einwilligung (Cookie-Banner) erforderlich. Sollten wir in Zukunft optionale Cookies einsetzen, werden wir ein Cookie-Consent-Tool implementieren, das Ihnen die granulare Kontrolle über alle Cookie-Kategorien ermöglicht. Eine erteilte Einwilligung können Sie jederzeit mit Wirkung für die Zukunft widerrufen.</p>
                </section>
                
                <section class="legal-section">
                    <h2>6. Drittanbieter-Cookies</h2>
                    <p>Wir setzen keine Cookies von Drittanbietern. Alle auf dieser Website verwendeten Cookies werden von uns (First-Party-Cookies) gesetzt. Es findet keine Datenübermittlung an Dritte über Cookies statt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>7. Speicherdauer</h2>
                    <ul>
                        <li><strong>Session-Cookies:</strong> Werden beim Schließen des Browsers automatisch gelöscht</li>
                        <li><strong>Persistent Cookies (remember_token):</strong> 30 Tage</li>
                        <li><strong>Persistent Cookies (cookie_consent):</strong> 1 Jahr</li>
                    </ul>
                </section>
                
                <section class="legal-section">
                    <h2>8. Änderungen dieser Cookie-Richtlinie</h2>
                    <p>Wir behalten uns vor, diese Cookie-Richtlinie anzupassen, z. B. bei Einführung neuer Funktionen oder gesetzlicher Änderungen. Die aktuelle Version ist stets auf dieser Seite abrufbar.</p>
                </section>
                
                <section class="legal-section">
                    <h2>9. Kontakt</h2>
                    <p>Bei Fragen zu dieser Cookie-Richtlinie wenden Sie sich bitte an:</p>
                    <address>
                        <strong>Manu Hosting</strong><br>
                        E-Mail: <a href="mailto:[PLATZHALTER: email@manu-hosting.de]">[PLATZHALTER: email@manu-hosting.de]</a>
                    </address>
                </section>
            </article>
        </div>
    </main>
    
    <footer class="legal-footer">
        <div class="container">
            <p>&copy; <?= date("Y") ?> Manu Hosting. Alle Rechte vorbehalten.</p>
        </div>
    </footer>
</body>
</html>