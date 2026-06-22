<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="/assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div>
        <h1>Register</h1>
        <form action="/register" method="post" id="login-form">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Full Name:</label>
            <input type="text" id="username" name="username" placeholder="Last Name, First Name, Middle Initial" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" placeholder="Enter your course" required>

            <label for="year">Year:</label>
            <input type="text" id="year" name="year" placeholder="Enter your year" required>

            <label for="block">Block:</label>
            <input type="text" id="block" name="block" placeholder="Enter your block" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="terms">
                <input type="checkbox" id="terms" name="terms" required>
                I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>
            </label>

            <div id="error-message" role="alert" style="display: none;"></div>

            <input type="submit" value="Register">
        </form>

        <span>Already have an account? <a href="login.php">Login here</a>.</span>
        
    </div>
    <script src="/assets/js/register.js"></script>
</body>
</html>