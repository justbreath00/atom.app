<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div>
        <h1>Login</h1>
        <form action="/login" method="post">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
            <div id="error-message" role="alert" style="display: none;"></div>
        </form>

        <span>Don't have an account? <a href="register.php">Register here</a>.</span>
        <span><a href="resetpassword.php">Forgot password?</a></span>
    </div>

    <script src="/assets/js/login.js"></script>
    
</body>
</html>