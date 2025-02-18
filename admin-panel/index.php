<?php
session_start();
include '../conn.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['isadmin']) || $_SESSION['isadmin'] !== true) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <a href="logout.php">Logout</a>
    </nav>
    <main>
        <h1>Admin Panel</h1>
        <section>
            <h2>Rooms</h2>
            <ul>
                <li><a href="add-room.php">Add a new room</a></li>
                <li><a href="view-rooms.php">Check details of all rooms</a></li>
                <li><a href="modify-room.php">Modify room details</a></li>
                <li><a href="delete-room.php">Remove an existing room</a></li>
            </ul>
        </section>
        <section>
            <h2>Users</h2>
            <ul>
                <li><a href="add-user.php">Create a new user</a></li>
                <li><a href="view-users.php">Check details of all users</a></li>
                <li><a href="modify-user.php">Modify user details (excluding Balance)</a></li>
                <li><a href="delete-user.php">Remove an existing user</a></li>
            </ul>
        </section>
        <section>
            <h2>Reservations</h2>
            <ul>
                <li><a href="accept-topup.php">Accept Top-up process from users</a></li>
                <li><a href="delete-reservation.php">Delete an existing reservation from a user</a></li>
            </ul>
        </section>
    </main>
    
    <script src="js/script.js"></script>
</body>
</html>
