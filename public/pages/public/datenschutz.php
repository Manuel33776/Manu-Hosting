<?php
/**
 * Datenschutzerklärung - Privacy Policy
 */

$csrf_token = $csrf_token ?? "";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>Datenschutzerklärung - Manu Hosting</title>
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
                <a href="/datenschutz" class="active">Datenschutz</a>
                <a href="/agb">AGB</a>
                <a href="/widerruf">Widerrufsrecht</a>
                <a href="/cookie">Cookie-Richtlinie</a>
            </nav>
            
            <article class="legal-content">
                <header class="legal-header-content">
                    <h1>Datenschutzerklärung</h1>
                    <p class="legal-meta">Stand: <?= date("d.m.Y") ?> | Version 1.0</p>
                </header>
                
                <section class="legal-section">
                    <h2>1. Verantwortlicher</h2>
                    <p>
                        Verantwortlich für die Datenverarbeitung auf dieser Website im Sinne der Datenschutz-Grundverordnung (DSGVO) ist:
                    </p>
                    <address>
                        <strong>Manu Hosting</strong><br>
                        Inhaber: Emanuel<br>
                        [PLATZHALTER: Straße Hausnummer]<br>
                        [PLATZHALTER: PLZ Stadt]<br>
                        Deutschland<br>
                        E-Mail: <a href="mailto:[PLATZHALTER: email@manu-hosting.de]">[PLATZHALTER: email@manu-hosting.de]</a>
                    </address>
                </section>
                
                <section class="legal-section">
                    <h2>2. Allgemeine Hinweise zur Datenverarbeitung</h2>
                    <h3>Rechtsgrundlagen</h3>
                    <p>Wir verarbeiten personenbezogene Daten nur, soweit dies zur Bereitstellung einer funktionsfähigen Website sowie unserer Inhalte und Leistungen erforderlich ist. Die Verarbeitung personenbezogener Daten unserer Nutzer erfolgt regelmäßig nur nach Einwilligung des Nutzers. Ausnahmen gelten in den Fällen, in denen eine vorherige Einwilligung aus tatsächlichen Gründen nicht möglich ist und die Verarbeitung der Daten durch gesetzliche Vorschriften gestattet ist.</p>
                    <p>Rechtsgrundlagen für die Verarbeitung personenbezogener Daten sind:</p>
                    <ul>
                        <li><strong>Art. 6 Abs. 1 lit. a DSGVO:</strong> Einwilligung</li>
                        <li><strong>Art. 6 Abs. 1 lit. b DSGVO:</strong> Vertragserfüllung und vorvertragliche Maßnahmen</li>
                        <li><strong>Art. 6 Abs. 1 lit. c DSGVO:</strong> Rechtliche Verpflichtung</li>
                        <li><strong>Art. 6 Abs. 1 lit. f DSGVO:</strong> Berechtigte Interessen</li>
                    </ul>
                    
                    <h3>Datenlöschung und Speicherdauer</h3>
                    <p>Die personenbezogenen Daten des Nutzers werden gelöscht oder gesperrt, sobald der Zweck der Speicherung entfällt. Eine Speicherung kann darüber hinaus erfolgen, wenn dies durch den europäischen oder nationalen Gesetzgeber in unionsrechtlichen Verordnungen, Gesetzen oder sonstigen Vorschriften, denen der Verantwortliche unterliegt, vorgesehen wurde. Eine Sperrung oder Löschung der Daten erfolgt auch dann, wenn eine durch die genannten Normen vorgeschriebene Speicherfrist abläuft, es sei denn, dass eine Erforderlichkeit zur weiteren Speicherung der Daten für einen Vertragsabschluss oder eine Vertragserfüllung besteht.</p>
                </section>
                
                <section class="legal-section">
                    <h2>3. Bereitstellung der Website und Erstellung von Logfiles</h2>
                    <h3>Beschreibung und Umfang der Datenverarbeitung</h3>
                    <p>Bei jedem Aufruf unserer Website erfasst unser System automatisiert Daten und Informationen vom Computersystem des aufrufenden Rechners. Folgende Daten werden hierbei erhoben:</p>
                    <ul>
                        <li>IP-Adresse des anfragenden Rechners</li>
                        <li>Datum und Uhrzeit des Zugriffs</li>
                        <li>Name und URL der abgerufenen Datei</li>
                        <li>Website, von der aus der Zugriff erfolgt (Referrer-URL)</li>
                        <li>Verwendeter Browser und ggf. das Betriebssystem Ihres Rechners sowie der Name Ihres Access-Providers</li>
                        <li>HTTP-Statuscode</li>
                        <li>Übertragene Datenmenge</li>
                    </ul>
                    <p>Die Daten werden ebenfalls in den Logfiles unseres Systems gespeichert. Eine Speicherung dieser Daten zusammen mit anderen personenbezogenen Daten des Nutzers findet nicht statt.</p>
                    
                    <h3>Rechtsgrundlage</h3>
                    <p>Rechtsgrundlage für die vorübergehende Speicherung der Daten und der Logfiles ist Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse).</p>
                    
                    <h3>Zweck der Datenverarbeitung</h3>
                    <p>Die vorübergehende Speicherung der IP-Adresse durch das System ist notwendig, um eine Auslieferung der Website an den Rechner des Nutzers zu ermöglichen. Hierfür muss die IP-Adresse des Nutzers für die Dauer der Sitzung gespeichert bleiben. Die Speicherung in Logfiles erfolgt, um die Funktionsfähigkeit der Website sicherzustellen. Zudem dienen uns die Daten zur Optimierung der Website und zur Sicherstellung der Sicherheit unserer informationstechnischen Systeme. Eine Auswertung der Daten zu Marketingzwecken findet in diesem Zusammenhang nicht statt.</p>
                    
                    <h3>Dauer der Speicherung</h3>
                    <p>Die Daten werden gelöscht, sobald sie für die Erreichung des Zweckes ihrer Erhebung nicht mehr erforderlich sind. Im Falle der Bereitstellung der Website ist dies der Fall, wenn die jeweilige Sitzung beendet ist. Im Falle der Speicherung der Daten in Logfiles ist dies nach spätestens 30 Tagen der Fall. Eine darüber hinausgehende Speicherung ist möglich. In diesem Fall werden die IP-Adressen der Nutzer gelöscht oder verfremdet, sodass eine Zuordnung des aufrufenden Clients nicht mehr möglich ist.</p>
                </section>
                
                <section class="legal-section">
                    <h2>4. Benutzerkonten und Kundenportal</h2>
                    <h3>Beschreibung und Umfang der Datenverarbeitung</h3>
                    <p>Bei der Registrierung für ein Benutzerkonto werden folgende Daten erhoben:</p>
                    <ul>
                        <li>Vorname, Nachname</li>
                        <li>Benutzername</li>
                        <li>E-Mail-Adresse</li>
                        <li>Passwort (als Argon2id-Hash gespeichert)</li>
                        <li>IP-Adresse bei Registrierung (zur Missbrauchsprävention)</li>
                        <li>Zeitpunkt der Registrierung</li>
                    </ul>
                    <p>Im Kundenportal werden zusätzlich folgende Daten verarbeitet:</p>
                    <ul>
                        <li>Server-Konfigurationen (Namen, Versionen, Einstellungen)</li>
                        <li>Server-Logs und Konsolen-Ausgaben</li>
                        <li>Spieler-Daten (Namen, UUIDs, Join/Quit-Zeitpunkte, Inventar-Daten bei aktivierter Live-Inventory-Funktion)</li>
                        <li>Anti-Cheat-Warnungen und Beweisdaten</li>
                        <li>Backup-Metadaten</li>
                        <li>Support-Tickets und Kommunikation</li>
                        <li>Bestellhistorie und Rechnungsdaten</li>
                    </ul>
                    
                    <h3>Rechtsgrundlage</h3>
                    <p>Art. 6 Abs. 1 lit. b DSGVO (Vertragserfüllung) und Art. 6 Abs. 1 lit. a DSGVO (Einwilligung für optionale Funktionen wie Live-Inventory).</p>
                    
                    <h3>Zweck</h3>
                    <p>Bereitstellung des Hosting-Dienstes, Serververwaltung, Support, Abrechnung, Sicherheitsüberwachung (Anti-Cheat).</p>
                    
                    <h3>Speicherdauer</h3>
                    <p>Benutzerkontodaten: Während der Vertragslaufzeit plus gesetzliche Aufbewahrungsfristen (6-10 Jahre für Rechnungsdaten).<br>
                    Server-Logs: 30 Tage.<br>
                    Spieler-Inventar-Daten: 90 Tage (danach automatische Löschung).<br>
                    Anti-Cheat-Daten: 1 Jahr für Beweiszwecke.<br>
                    Support-Tickets: 3 Jahre nach Schließung.</p>
                </section>
                
                <section class="legal-section">
                    <h2>5. Live-Inventory und Anti-Cheat Monitoring</h2>
                    <p>Unser System bietet optionale Funktionen zur Überwachung von Spielerinventaren (Live-Inventory) und zur Erkennung von Cheating-Versuchen (Anti-Cheat). Diese Funktionen verarbeiten folgende Daten:</p>
                    <ul>
                        <li>Spielername und UUID</li>
                        <li>Inventarinhalte (Item-IDs, Mengen, Verzauberungen, NBT-Daten)</li>
                        <li>Enderchest-Inhalte</li>
                        <li>Position, Welt, Ping</li>
                        <li>Bewegungsdaten für Anti-Cheat-Analyse</li>
                        <li>Erkannte Auffälligkeiten mit Beweissicherung</li>
                    </ul>
                    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. a DSGVO (Einwilligung des Server-Inhabers) und Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an Server-Sicherheit).</p>
                    <p>Die Daten werden nur verarbeitet, wenn der Server-Inhaber diese Funktionen aktiviert hat. Spieler werden durch den Server-Inhaber über die Überwachung informiert (Informationspflicht gemäß Art. 13 DSGVO obliegt dem Server-Inhaber als Verantwortlichem für die Spieler-Daten).</p>
                </section>
                
                <section class="legal-section">
                    <h2>6. Minecraft-Server und Spieler-Daten</h2>
                    <p>Bei der Nutzung der gehosteten Minecraft-Server werden folgende Daten verarbeitet:</p>
                    <ul>
                        <li>Spielername, UUID, IP-Adresse der Spieler</li>
                        <li>Chat-Nachrichten, Befehle</li>
                        <li>Position, Inventar, Statistiken, Fortschritte</li>
                        <li>Plugin/Mod-Daten (abhängig von installierten Erweiterungen)</li>
                    </ul>
                    <p><strong>Verantwortlichkeit:</strong> Für die Verarbeitung von Spieler-Daten auf den Minecraft-Servern ist der jeweilige Server-Inhaber (unser Kunde) als Verantwortlicher im Sinne der DSGVO verantwortlich. Wir agieren als Auftragsverarbeiter gemäß Art. 28 DSGVO. Ein Auftragsverarbeitungsvertrag (AVV) wird auf Anfrage bereitgestellt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>7. E-Mail-Kommunikation und Newsletter</h2>
                    <p>Bei der Kontaktaufnahme per E-Mail oder über das Support-System werden die mitgeteilten Daten (E-Mail-Adresse, Name, Nachricht) zum Zwecke der Bearbeitung der Anfrage verarbeitet.</p>
                    <p>Für den Newsletter-Versand nutzen wir das Double-Opt-In-Verfahren. Die Einwilligung kann jederzeit widerrufen werden.</p>
                    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. a DSGVO (Einwilligung) bzw. Art. 6 Abs. 1 lit. b DSGVO (Vertragserfüllung bei Support-Anfragen).</p>
                </section>
                
                <section class="legal-section">
                    <h2>8. Cookies und Tracking</h2>
                    <h3>Notwendige Cookies</h3>
                    <p>Unsere Website verwendet technisch notwendige Cookies (Session-Cookies, CSRF-Token-Cookies), die für den Betrieb der Website und des Kundenportals unerlässlich sind. Diese Cookies speichern keine personenbezogenen Daten über die Sitzung hinaus.</p>
                    
                    <h3>Optionale Cookies</h3>
                    <p>Wir verwenden keine Marketing- oder Tracking-Cookies von Drittanbietern (Google Analytics, Facebook Pixel, etc.).</p>
                    
                    <h3>Cookie-Verwaltung</h3>
                    <p>Sie können Cookies in den Browsereinstellungen verwalten und löschen. Bei Deaktivierung notwendiger Cookies kann die Funktionalität der Website eingeschränkt sein.</p>
                </section>
                
                <section class="legal-section">
                    <h2>9. Sicherheit der Verarbeitung</h2>
                    <p>Wir treffen gemäß Art. 32 DSGVO geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten, unter anderem:</p>
                    <ul>
                        <li>Verschlüsselung der Datenübertragung (TLS 1.2/1.3)</li>
                        <li>Argon2id-Hashing für Passwörter</li>
                        <li>Verschlüsselte Datenbank-Backups</li>
                        <li>Zugriffskontrollen und Rollenbasierte Berechtigungen (RBAC)</li>
                        <li>Audit-Logging aller sensiblen Aktionen</li>
                        <li>Rate-Limiting und Brute-Force-Schutz</li>
                        <li>Regelmäßige Sicherheitsupdates</li>
                        <li>Getrennte Datenhaltung pro Kunde (Datenbank-Ebene)</li>
                    </ul>
                </section>
                
                <section class="legal-section">
                    <h2>10. Empfänger personenbezogener Daten</h2>
                    <p>Eine Übermittlung personenbezogener Daten an Dritte erfolgt nur, soweit dies gesetzlich vorgeschrieben ist (z. B. an Strafverfolgungsbehörden bei Vorliegen eines richterlichen Beschlusses), zur Vertragserfüllung erforderlich ist (z. B. Zahlungsdienstleister) oder Sie eingewilligt haben.</p>
                    <p>Eingesetzte Auftragsverarbeiter (Hosting, E-Mail-Versand, Monitoring) werden sorgfältig ausgewählt und vertraglich gemäß Art. 28 DSGVO gebunden.</p>
                </section>
                
                <section class="legal-section">
                    <h2>11. Übermittlung in Drittländer</h2>
                    <p>Eine Übermittlung personenbezogener Daten in Länder außerhalb der EU/des EWR (Drittländer) findet nicht statt, sofern nicht explizit angegeben und mit geeigneten Garantien (Standardvertragsklauseln, Angemessenheitsbeschluss) versehen.</p>
                </section>
                
                <section class="legal-section">
                    <h2>12. Rechte der betroffenen Person</h2>
                    <p>Ihnen stehen als betroffener Person folgende Rechte zu:</p>
                    <ul>
                        <li><strong>Auskunftsrecht (Art. 15 DSGVO):</strong> Auskunft über Ihre verarbeiteten Daten</li>
                        <li><strong>Recht auf Berichtigung (Art. 16 DSGVO):</strong> Korrektur unrichtiger Daten</li>
                        <li><strong>Recht auf Löschung (Art. 17 DSGVO):</strong> "Recht auf Vergessenwerden"</li>
                        <li><strong>Recht auf Einschränkung (Art. 18 DSGVO):</strong> Einschränkung der Verarbeitung</li>
                        <li><strong>Recht auf Datenübertragbarkeit (Art. 20 DSGVO):</strong> Erhalt der Daten in strukturiertem Format</li>
                        <li><strong>Widerspruchsrecht (Art. 21 DSGVO):</strong> Widerspruch gegen Verarbeitung aus berechtigtem Interesse</li>
                        <li><strong>Widerrufsrecht (Art. 7 Abs. 3 DSGVO):</strong> Widerruf erteilter Einwilligungen</li>
                        <li><strong>Beschwerderecht (Art. 77 DSGVO):</strong> Beschwerde bei Aufsichtsbehörde</li>
                    </ul>
                    <p>Zur Ausübung Ihrer Rechte wenden Sie sich bitte an die oben genannte verantwortliche Stelle.</p>
                </section>
                
                <section class="legal-section">
                    <h2>13. Automatisierte Entscheidungsfindung</h2>
                    <p>Wir setzen keine ausschließlich automatisierten Entscheidungsfindungen einschließlich Profiling im Sinne von Art. 22 DSGVO ein.</p>
                </section>
                
                <section class="legal-section">
                    <h2>14. Änderungen dieser Datenschutzerklärung</h2>
                    <p>Wir behalten uns vor, diese Datenschutzerklärung anzupassen, damit sie stets den aktuellen rechtlichen Anforderungen entspricht oder um Änderungen unserer Leistungen in der Datenschutzerklärung umzusetzen. Für Ihren erneuten Besuch gilt dann die neue Datenschutzerklärung.</p>
                </section>
                
                <section class="legal-section">
                    <h2>15. Kontakt zum Datenschutz</h2>
                    <p>Bei Fragen zum Datenschutz wenden Sie sich bitte an:</p>
                    <address>
                        <strong>Manu Hosting - Datenschutz</strong><br>
                        E-Mail: <a href="mailto:[PLATZHALTER: datenschutz@manu-hosting.de]">[PLATZHALTER: datenschutz@manu-hosting.de]</a>
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