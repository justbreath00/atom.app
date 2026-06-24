<?php
    session_start();
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header('Location: login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dash board</title>
</head>
<body>
    <h1>Dashboard</h1>`
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <span><?php echo $_SESSION['success'] ?? ''; ?></span>
    

</body>
</html>