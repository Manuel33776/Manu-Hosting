<?php
/**
 * AGB - Allgemeine Geschäftsbedingungen
 */

$csrf_token = $csrf_token ?? "";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>AGB - Manu Hosting</title>
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
                <a href="/agb" class="active">AGB</a>
                <a href="/widerruf">Widerrufsrecht</a>
                <a href="/cookie">Cookie-Richtlinie</a>
            </nav>
            
            <article class="legal-content">
                <header class="legal-header-content">
                    <h1>Allgemeine Geschäftsbedingungen (AGB)</h1>
                    <p class="legal-meta">Stand: <?= date("d.m.Y") ?> | Version 1.0</p>
                </header>
                
                <section class="legal-section">
                    <h2>§ 1 Geltungsbereich</h2>
                    <p>(1) Diese Allgemeinen Geschäftsbedingungen (nachfolgend "AGB") der Manu Hosting (nachfolgend "Anbieter") gelten für alle Verträge über die Bereitstellung von Minecraft-Server-Hosting-Dienstleistungen, die ein Verbraucher oder Unternehmer (nachfolgend "Kunde") mit dem Anbieter abschließt.</p>
                    <p>(2) Verbraucher im Sinne dieser AGB ist jede natürliche Person, die ein Rechtsgeschäft zu Zwecken abschließt, die überwiegend weder ihrer gewerblichen noch ihrer selbständigen beruflichen Tätigkeit zugerechnet werden können. Unternehmer ist eine natürliche oder juristische Person oder eine rechtsfähige Personengesellschaft, die bei Abschluss eines Rechtsgeschäfts in Ausübung ihrer gewerblichen oder selbständigen beruflichen Tätigkeit handelt.</p>
                    <p>(3) Abweichende, entgegenstehende oder ergänzende Allgemeine Geschäftsbedingungen des Kunden werden nicht Vertragsbestandteil, es sei denn, ihrer Geltung wird ausdrücklich schriftlich zugestimmt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 2 Vertragsgegenstand</h2>
                    <p>(1) Der Anbieter stellt dem Kunden Minecraft-Server-Hosting-Dienstleistungen gemäß der gewählten Paketbeschreibung auf der Website zur Verfügung. Dies umfasst insbesondere:</p>
                    <ul>
                        <li>Bereitstellung von Server-Ressourcen (CPU, RAM, Speicherplatz, Netzwerk)</li>
                        <li>Installation und Verwaltung von Minecraft-Server-Software (Paper, Purpur, Spigot, Vanilla, Fabric, Forge, NeoForge, Quilt, Velocity, BungeeCord)</li>
                        <li>Webbasiertes Verwaltungsinterface (Kundenportal)</li>
                        <li>Automatische Backups gemäß Paketbeschreibung</li>
                        <li>DDoS-Schutz</li>
                        <li>Technischer Support per Ticket-System</li>
                    </ul>
                    <p>(2) Der genaue Leistungsumfang richtet sich nach der zum Vertragsschluss gültigen Beschreibung des gewählten Hosting-Pakets auf der Website des Anbieters.</p>
                    <p>(3) Der Anbieter ist berechtigt, die Leistungen zu ändern, soweit dies zur Verbesserung der Servicequalität, aus technischen Gründen oder aufgrund gesetzlicher Vorgaben erforderlich ist und dem Kunden zumutbar ist. Wesentliche Änderungen werden dem Kunden rechtzeitig angekündigt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 3 Vertragsschluss</h2>
                    <p>(1) Die Darstellung der Hosting-Pakete auf der Website stellt kein rechtlich bindendes Angebot dar, sondern eine Aufforderung zur Abgabe einer Bestellung.</p>
                    <p>(2) Der Kunde gibt durch Absenden des Bestellformulars ein verbindliches Angebot zum Abschluss eines Vertrages ab. Der Anbieter bestätigt den Eingang der Bestellung unverzüglich per E-Mail (Bestellbestätigung). Diese Bestätigung stellt noch keine Annahme des Angebots dar.</p>
                    <p>(3) Der Vertrag kommt zustande, wenn der Anbieter die Bestellung durch eine ausdrückliche Annahmeerklärung (Auftragsbestätigung) oder durch Freischaltung des Servers annimmt.</p>
                    <p>(4) Bei Paketen mit kostenloser Testphase beginnt die kostenpflichtige Laufzeit erst nach Ablauf der Testphase, sofern der Kunde nicht vorab kündigt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 4 Preise und Zahlung</h2>
                    <p>(1) Alle Preise verstehen sich in Euro und enthalten die gesetzliche Umsatzsteuer, sofern nicht anders angegeben.</p>
                    <p>(2) Die Zahlung erfolgt monatlich im Voraus per den angebotenen Zahlungsmethoden (z. B. SEPA-Lastschrift, Kreditkarte, PayPal, Banküberweisung).</p>
                    <p>(3) Bei Zahlungsverzug ist der Anbieter berechtigt, den Server vorübergehend zu sperren, bis der Zahlungsausgleich erfolgt. Die Sperrung erfolgt unter Einhaltung einer angemessenen Frist und vorheriger Ankündigung.</p>
                    <p>(4) Der Anbieter ist berechtigt, die Preise mit einer Ankündigungsfrist von 30 Tagen zu ändern. Preiserhöhungen während der Mindestvertragslaufzeit sind nur bei Vorliegen eines wichtigen Grundes (z. B. gestiegene Energie- oder Hardwarekosten) zulässig. Dem Kunden steht in diesem Fall ein Sonderkündigungsrecht zu.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 5 Laufzeit und Kündigung</h2>
                    <p>(1) Der Vertrag wird für die gewählte Laufzeit (monatlich, quartalsweise, halbjährlich, jährlich) geschlossen und verlängert sich jeweils um die gleiche Laufzeit, sofern er nicht mit einer Frist von 14 Tagen zum Ende der Laufzeit gekündigt wird.</p>
                    <p>(2) Das Recht zur außerordentlichen Kündigung aus wichtigem Grund bleibt unberührt. Ein wichtiger Grund liegt für den Anbieter insbesondere vor bei:</p>
                    <ul>
                        <li>Zahlungsverzug von mehr als 14 Tagen nach Mahnung</li>
                        <li>Schwerwiegende Verletzung der Pflichten aus § 6</li>
                        <li>Einstellung des Geschäftsbetriebs</li>
                    </ul>
                    <p>(3) Die Kündigung bedarf der Textform (E-Mail, Brief, Ticket-System).</p>
                    <p>(4) Nach Vertragsende werden die Serverdaten für 14 Tage aufbewahrt und anschließend unwiderruflich gelöscht, sofern der Kunde nicht rechtzeitig einen Datenexport beantragt.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 6 Pflichten des Kunden</h2>
                    <p>(1) Der Kunde ist verpflichtet, die Zugangsdaten zum Kundenportal geheim zu halten und vor unbefugtem Zugriff Dritter zu schützen. Bei Verdacht auf Missbrauch hat der Kunde den Anbieter unverzüglich zu informieren.</p>
                    <p>(2) Der Kunde darf die gehosteten Server ausschließlich für zulässige Zwecke nutzen. Folgendes ist untersagt:</p>
                    <ul>
                        <li>Verbreitung von illegalen Inhalten, Malware, Viren</li>
                        <li>Durchführung von DDoS-Angriffen oder anderen Angriffen</li>
                        <li>Spamming, Phishing, Betrug</li>
                        <li>Urheberrechtsverletzungen (Cracked-Server, illegale Plugins/Mods)</li>
                        <li>Extremistische, gewaltverherrlichende oder jugendgefährdende Inhalte</li>
                        <li>Kryptowährungs-Mining</li>
                        <li>Übermäßige Ressourcennutzung über die gebuchten Limits hinaus</li>
                    </ul>
                    <p>(3) Der Kunde ist für die Einhaltung der Minecraft EULA und der Richtlinien von Mojang/Microsoft verantwortlich. Der Anbieter übernimmt keine Haftung für Verstöße des Kunden.</p>
                    <p>(4) Der Kunde ist für die Sicherung seiner eigenen Daten (Backups) verantwortlich. Obwohl der Anbieter automatische Backups anbietet, übernimmt er keine Garantie für Vollständigkeit und Wiederherstellbarkeit. Der Kunde wird angehalten, eigene Backups zu erstellen.</p>
                    <p>(5) Der Kunde stellt den Anbieter von allen Ansprüchen Dritter frei, die aufgrund einer Verletzung der vorgenannten Pflichten geltend gemacht werden.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 7 Verfügbarkeit und Wartung</h2>
                    <p>(1) Der Anbieter strebt eine Verfügbarkeit von 99,9 % im Jahresmittel an. Geplante Wartungsarbeiten werden, soweit möglich, außerhalb der Hauptnutzungszeiten durchgeführt und mindestens 48 Stunden vorher angekündigt.</p>
                    <p>(2) Der Anbieter ist berechtigt, Notfallwartungen ohne vorherige Ankündigung durchzuführen, wenn dies zur Aufrechterhaltung der Sicherheit oder Stabilität der Infrastruktur erforderlich ist.</p>
                    <p>(3) Bei Ausfallzeiten, die vom Anbieter zu vertreten sind und die garantierte Verfügbarkeit unterschreiten, hat der Kunde Anspruch auf eine Gutschrift gemäß der jeweils gültigen SLA (Service Level Agreement).</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 8 Haftung</h2>
                    <p>(1) Der Anbieter haftet unbeschränkt für Vorsatz und grobe Fahrlässigkeit. Bei einfacher Fahrlässigkeit haftet der Anbieter nur bei Verletzung wesentlicher Vertragspflichten (Kardinalpflichten), deren Erfüllung die ordnungsgemäße Durchführung des Vertrages erst ermöglicht und auf deren Einhaltung der Kunde regelmäßig vertrauen darf. In diesem Fall ist die Haftung auf den vertragstypischen, vorhersehbaren Schaden begrenzt.</p>
                    <p>(2) Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben, Körper und Gesundheit, bei Übernahme einer Garantie, bei arglistigem Verschweigen eines Mangels und bei Ansprüchen nach dem Produkthaftungsgesetz.</p>
                    <p>(3) Der Anbieter haftet nicht für Datenverlust, sofern der Kunde seiner Backup-Pflicht gemäß § 6 Abs. 4 nicht nachgekommen ist.</p>
                    <p>(4) Der Anbieter haftet nicht für Schäden, die durch höhere Gewalt, Naturkatastrophen, Stromausfälle, Internetstörungen Dritter oder behördliche Anordnungen verursacht werden.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 9 Datenschutz</h2>
                    <p>(1) Die Verarbeitung personenbezogener Daten erfolgt gemäß der Datenschutzerklärung des Anbieters, die auf der Website abrufbar ist.</p>
                    <p>(2) Der Kunde sichert zu, dass er bei der Verarbeitung von Spieler-Daten auf seinen Servern die datenschutzrechtlichen Vorgaben einhält und gegebenenfalls erforderliche Einwilligungen der Spieler einholt. Der Anbieter stellt auf Anfrage einen Auftragsverarbeitungsvertrag (AVV) gemäß Art. 28 DSGVO zur Verfügung.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 10 Geistige Eigentumsrechte</h2>
                    <p>(1) Alle Rechte an der Website, dem Kundenportal, der Software, den Marken, Logos und sonstigen Inhalten des Anbieters verbleiben beim Anbieter. Dem Kunden wird ein nicht ausschließliches, nicht übertragbares Nutzungsrecht für die Dauer des Vertrages eingeräumt.</p>
                    <p>(2) Der Kunde gewährt dem Anbieter das Recht, Serverdaten (Konfigurationen, Logs, Metriken) zum Zwecke der Vertragserfüllung, Wartung und Sicherheitsüberwachung zu verarbeiten.</p>
                    <p>(3) Der Kunde stellt sicher, dass hochgeladene Inhalte (Welten, Plugins, Mods, Ressourcenpakete) keine Rechte Dritter verletzen.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 11 Änderungen der AGB</h2>
                    <p>(1) Der Anbieter ist berechtigt, diese AGB zu ändern, soweit dies aufgrund gesetzlicher Änderungen, Rechtsprechung oder technischer Weiterentwicklung erforderlich ist. Änderungen werden dem Kunden mindestens 30 Tage vor Inkrafttreten per E-Mail mitgeteilt.</p>
                    <p>(2) Widerspricht der Kunde der Änderung nicht innerhalb von 30 Tagen nach Zugang der Mitteilung, gelten die geänderten AGB als angenommen. Auf das Widerspruchsrecht und die Frist wird in der Mitteilung hingewiesen.</p>
                    <p>(3) Bei Widerspruch ist der Anbieter berechtigt, den Vertrag zum Zeitpunkt des Inkrafttretens der Änderungen ordentlich zu kündigen.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 12 Schlussbestimmungen</h2>
                    <p>(1) Es gilt das Recht der Bundesrepublik Deutschland unter Ausschluss des UN-Kaufrechts. Bei Verbrauchern bleibt die Geltung zwingender Verbraucherschutzvorschriften des Wohnsitzstaates unberührt.</p>
                    <p>(2) Ausschließlicher Gerichtsstand für alle Streitigkeiten aus diesem Vertrag ist der Sitz des Anbieters, sofern der Kunde Kaufmann, juristische Person des öffentlichen Rechts oder öffentlich-rechtliches Sondervermögen ist.</p>
                    <p>(3) Sollten einzelne Bestimmungen dieser AGB unwirksam sein oder werden, bleibt die Wirksamkeit der übrigen Bestimmungen unberührt (Salvatorische Klausel). An die Stelle der unwirksamen Bestimmung tritt die gesetzliche Regelung.</p>
                    <p>(4) Mündliche Nebenabreden bestehen nicht. Änderungen und Ergänzungen bedürfen der Textform.</p>
                </section>
                
                <section class="legal-section">
                    <h2>§ 13 Widerrufsrecht für Verbraucher</h2>
                    <p>Verbrauchern steht bei Fernabsatzverträgen ein gesetzliches Widerrufsrecht zu. Über das Widerrufsrecht informieren wir gemäß gesetzlicher Vorgabe gesondert auf der Seite <a href="/widerruf">Widerrufsrecht</a>.</p>
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