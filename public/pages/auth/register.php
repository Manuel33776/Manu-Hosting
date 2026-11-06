<?php
/**
 * Register Page
 */

$csrf_token = $csrf_token ?? "";
$error = $error ?? "";
$redirect = $_GET["redirect"] ?? "/dashboard";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren - Manu Hosting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="auth-logo">
                    <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="url(#authGradient)"/>
                        <path d="M8 12h16M8 16h16M8 20h10" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="authGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#8B5CF6"/>
                                <stop offset="100%" stop-color="#3B82F6"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span>Manu Hosting</span>
                </a>
                <h1>Konto erstellen</h1>
                <p>Starte jetzt mit deinem eigenen Minecraft Server</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error" role="alert">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/register" class="auth-form" id="registerForm">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">Vorname</label>
                        <input type="text" name="first_name" id="first_name" class="form-input" placeholder="Max" required autocomplete="given-name">
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Nachname</label>
                        <input type="text" name="last_name" id="last_name" class="form-input" placeholder="Mustermann" required autocomplete="family-name">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" name="username" id="username" class="form-input" placeholder="max_mustermann" required autocomplete="username" minlength="3" maxlength="32" pattern="[a-zA-Z0-9_-]+">
                    <p class="form-help">3-32 Zeichen, nur Buchstaben, Zahlen, _ und -</p>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="max@beispiel.de" required autocomplete="email">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Passwort</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Mindestens 8 Zeichen" required autocomplete="new-password" minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="form-label">Passwort bestätigen</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-input" placeholder="Passwort wiederholen" required autocomplete="new-password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="terms" id="terms" value="1" required>
                        <span>Ich akzeptiere die <a href="/agb" target="_blank">AGB</a> und die <a href="/datenschutz" target="_blank">Datenschutzerklärung</a></span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="newsletter" value="1">
                        <span>Ich möchte über Neuigkeiten und Angebote informiert werden</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <span class="btn-text">Konto erstellen</span>
                    <span class="btn-loading" style="display: none;">
                        <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                            <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/>
                        </svg>
                        Erstellung...
                    </span>
                </button>
            </form>
            
            <div class="auth-divider">
                <span>bereits ein Konto?</span>
            </div>
            
            <div class="auth-actions">
                <a href="/login" class="btn btn-outline btn-block">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Anmelden
                </a>
            </div>
            
            <p class="auth-footer">
                <a href="/impressum">Impressum</a> • 
                <a href="/datenschutz">Datenschutz</a> • 
                <a href="/agb">AGB</a>
            </p>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("registerForm");
        const submitBtn = form.querySelector("button[type=submit]");
        const btnText = submitBtn.querySelector(".btn-text");
        const btnLoading = submitBtn.querySelector(".btn-loading");
        const password = document.getElementById("password");
        const passwordConfirm = document.getElementById("password_confirm");
        
        // Password match validation
        passwordConfirm.addEventListener("input", function() {
            if (this.value !== password.value) {
                this.setCustomValidity("Passwörter stimmen nicht überein");
            } else {
                this.setCustomValidity("");
            }
        });
        
        password.addEventListener("input", function() {
            if (passwordConfirm.value && this.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity("Passwörter stimmen nicht überein");
            } else {
                passwordConfirm.setCustomValidity("");
            }
        });
        
        form.addEventListener("submit", function() {
            submitBtn.disabled = true;
            btnText.style.display = "none";
            btnLoading.style.display = "inline-flex";
        });
    });
    </script>
</body>
</html>