<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginsignup-style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login-process.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="signup-btn">Login</button>
        </form>
    </div>
</body>
</html>
