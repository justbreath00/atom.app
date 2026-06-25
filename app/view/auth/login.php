<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

    <!-- ========================================================
         AUTH WRAPPER — centers card on screen
    ======================================================== -->
    <div class="auth-wrapper">
        <div class="auth-card" id="auth-card">

            <!-- ================================================
                 LEFT PANEL — Ghost + decorative gradient
            ================================================ -->
            <div class="auth-left">
                <!-- Floating decorative circles -->
                <div class="deco-circle deco-circle--1"></div>
                <div class="deco-circle deco-circle--2"></div>
                <div class="deco-circle deco-circle--3"></div>

                <!-- Ghost SVG — inline so JS can manipulate pupils -->
                <div class="ghost-wrap">
                    <img src="assets/images/ghostybase.png" alt="Ghosty the ghost mascot" class="ghosty-base" id="ghosty-base">
                    <div class="ghosty-eyes" id="eyes">
                        <img src="assets/images/eyeleft.png" alt="Ghostyeye" class="eye" id="eye-left">
                        <img src="assets/images/eyeright.png" alt="Ghostyeye" class="eye" id="eye-right">

                        <img src="assets/images/eyeleft-closed.png" alt="Ghostyeye" class="eye-closed" id="eye-left-closed">
                        <img src="assets/images/eyeright-closed.png" alt="Ghostyeye" class="eye-closed" id="eye-right-closed">

                        <img src="assets/images/ghostysmile.png" alt="Ghosty smiling" class="eye-closed" id="ghosty-smile">
                    </div>
                    
                </div>

                <!-- Left panel text -->
                <div class="auth-left__text">
                    <h2>Welcome Back</h2>
                    <p>Sign in to continue your journey.</p>
                </div>
            </div>

            <!-- ================================================
                 RIGHT PANEL — Login form
            ================================================ -->
            <div class="auth-right">
                <div class="form-header">
                    <h1 class="form-title">Sign In</h1>
                    <p class="form-subtitle">Enter your credentials to access your account</p>
                </div>

                <!-- ── PRESERVED: action, method, all names/ids ── -->
                <form action="login_controller.php" method="POST" class="auth-form" novalidate id="login-form">

                    <!-- Email -->
                    <div class="field-group">
                        <label for="email" class="field-label">Email</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <!-- envelope icon -->
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <polyline points="2,4 12,13 22,4"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" class="field-input"
                                   placeholder="you@example.com" required autocomplete="email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <div class="field-label-row">
                            <label for="password" class="field-label">Password</label>
                            <a href="resetpassword.php" class="link-subtle">Forgot password?</a>
                        </div>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <!-- lock icon -->
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7,11V7a5,5 0 0,1 10,0v4"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" class="field-input"
                                   placeholder="••••••••" required autocomplete="current-password">
                            <!-- Show/hide toggle — preserves original show/toggle intent -->
                            <button type="button" class="toggle-pw" id="toggle-pw" aria-label="Show password">
                                <svg class="icon-eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg class="icon-eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Error message — PRESERVED id and role -->
                    <div id="error-message" role="alert" class="error-msg" style="display:none;"></div>

                    <!-- Submit — PRESERVED name value -->
                    <button type="submit" class="btn-primary">Sign In</button>

                </form>

                <p class="auth-switch">
                    Don't have an account?
                    <a href="register.php" class="link-accent">Register here</a>
                </p>
            </div>

        </div><!-- /auth-card -->
    </div><!-- /auth-wrapper -->

    <script src="assets/js/ghosty.js"></script>
    <script src="assets/js/toggle.js"></script>
    <script src="assets/js/login.js"></script>

</body>
</html>