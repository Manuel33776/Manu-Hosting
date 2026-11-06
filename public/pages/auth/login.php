<?php
/**
 * Login Page
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
    <title>Anmelden - Manu Hosting</title>
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
                <h1>Willkommen zurück</h1>
                <p>Melde dich an, um deine Server zu verwalten</p>
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
            
            <form method="POST" action="/login" class="auth-form" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
                
                <div class="form-group">
                    <label for="username" class="form-label">Benutzername oder E-Mail</label>
                    <input type="text" name="username" id="username" class="form-input" placeholder="Benutzername oder E-Mail" required autocomplete="username">
                </div>
                
                <div class="form-group">
                    <div class="form-label-row">
                        <label for="password" class="form-label">Passwort</label>
                        <a href="/forgot-password" class="forgot-link">Passwort vergessen?</a>
                    </div>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Passwort" required autocomplete="current-password">
                </div>
                
                <div class="form-group">
                    <label class="form-label checkbox-label">
                        <input type="checkbox" name="remember" value="1">
                        <span>Angemeldet bleiben</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <span class="btn-text">Anmelden</span>
                    <span class="btn-loading" style="display: none;">
                        <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                            <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/>
                        </svg>
                        Anmeldung...
                    </span>
                </button>
            </form>
            
            <div class="auth-divider">
                <span>oder</span>
            </div>
            
            <div class="auth-actions">
                <a href="/register" class="btn btn-outline btn-block">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Konto erstellen
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
        const form = document.getElementById("loginForm");
        const submitBtn = form.querySelector("button[type=submit]");
        const btnText = submitBtn.querySelector(".btn-text");
        const btnLoading = submitBtn.querySelector(".btn-loading");
        
        form.addEventListener("submit", function() {
            submitBtn.disabled = true;
            btnText.style.display = "none";
            btnLoading.style.display = "inline-flex";
        });
    });
    </script>
</body>
</html>