<?php
   require_once '../app/utils/session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

    <!-- ========================================================
         AUTH WRAPPER — centers card on screen
    ======================================================== -->
    <div class="auth-wrapper">
        <div class="auth-card auth-card--register" id="auth-card">

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
                    <h2>Join Us</h2>
                    <p>Create your account and get started.</p>
                </div>
            </div>

            <!-- ================================================
                 RIGHT PANEL — Register form
            ================================================ -->
            <div class="auth-right">
                <div class="form-header">
                    <h1 class="form-title">Create Account</h1>
                    <p class="form-subtitle">Fill in the details below to register</p>
                </div>

                <!-- ── PRESERVED: action /register, method post, id login-form, all names/ids ── -->
                <form action="register_controller.php" method="POST" id="login-form" class="auth-form" novalidate>

                    <!-- Full Name -->
                    <div class="field-group">
                        <label for="username" class="field-label">Full Name</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <!-- user icon -->
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input type="text" id="username" name="username" class="field-input"
                                   placeholder="Last Name, First Name, Middle Initial" required autocomplete="name">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="field-group">
                        <label for="email" class="field-label">Email</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <polyline points="2,4 12,13 22,4"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" class="field-input"
                                   placeholder="you@example.com" required autocomplete="email">
                        </div>
                    </div>
                    <!-- Course -->
                     <div class="field-group">
                        <label for="course" class="field-label">Course</label>

                        <div class="input-wrap course-container">
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 14L3 9l9-5 9 5-9 5z"></path>
                                    <path d="M3 9v6"></path>
                                    <path d="M21 9v6"></path>
                                    <path d="M7 11.5v3.5c0 1.7 2.2 3 5 3s5-1.3 5-3v-3.5"></path>
                                </svg>
                            </span>

                            <input
                                type="text" id="course" name="course" class="field-input"
                                placeholder="BSIT"autocomplete="off" > 

                            <div id="courseSuggestions" class="suggestions"></div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <label for="password" class="field-label">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7,11V7a5,5 0 0,1 10,0v4"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" class="field-input"
                                   placeholder="Create a password" required autocomplete="new-password">
                            <button type="button" class="toggle-pw" data-target="password" aria-label="Show password">
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

                    <!-- Confirm Password -->
                    <div class="field-group">
                        <label for="confirm_password" class="field-label">Confirm Password</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </span>
                            <input type="password" id="confirm_password" name="confirm_password" class="field-input"
                                   placeholder="Repeat your password" required autocomplete="new-password">
                            <button type="button" class="toggle-pw" data-target="confirm_password" aria-label="Show confirm password">
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

                    <!-- Terms — PRESERVED id, name, href -->
                    <div class="field-group field-group--checkbox">
                        <label class="checkbox-label" for="terms">
                            <input type="checkbox" id="terms" name="terms" required class="checkbox-input">
                            <span class="checkbox-custom" aria-hidden="true"></span>
                            I agree to the
                            <a href="terms.php" target="_blank" class="link-accent">Terms and Conditions</a>
                        </label>
                    </div>

                    <!-- Error message — PRESERVED id and role -->
                    <div id="error-message" role="alert" class="error-msg" style="display:none;"></div>
                    
                    <span><?php if(!empty($_SESSION['msg'])){echo $_SESSION['msg'];} ?></span>
                    

                    <!-- Submit — PRESERVED original value -->
                    <button type="submit" class="btn-primary">Create Account</button>

                </form>

                <p class="auth-switch">
                    Already have an account?
                    <a href="login.php" class="link-accent">Login here</a>
                </p>
            </div>

        </div><!-- /auth-card -->
    </div><!-- /auth-wrapper -->

    <script src="assets/js/ghosty.js"></script>
    <script src="assets/js/register.js"></script>
    <script src="assets/js/toggle.js"></script>
</body>
</html>