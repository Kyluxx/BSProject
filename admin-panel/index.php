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
    <link rel="stylesheet" href="../css/admin-style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Admin Panel</div>
        <a href="../logout.php" class="btn logout">Logout</a>
    </nav>
    <main class="container">
        <h1>Admin Dashboard</h1>
        <div class="grid">
            <section class="card">
                <h2>Rooms Management</h2>
                <ul>
<!--                    <li><a href="add-room.php" class="btn">➕ Add Room</a></li> -->
                    <li><a href="view-rooms.php" class="btn">📋 View Rooms</a></li>
                    <li><a href="modify-room.php" class="btn">✏️ Modify Room</a></li>
                <!--     <li><a href="delete-room.php" class="btn danger">🗑 Remove Room</a></li>  -->
                </ul>
            </section>
            <section class="card">
                <h2>User Management</h2>
                <ul>
                    <li><a href="add-user.php" class="btn">➕ Add User</a></li>
                    <li><a href="view-users.php" class="btn">📋 View Users</a></li>
                    <li><a href="modify-user.php" class="btn">✏️ Modify User</a></li>
                    <li><a href="delete-user.php" class="btn danger">🗑 Remove User</a></li>
                </ul>
            </section>
            <section class="card">
                <h2>Reservations</h2>
                <ul>
                    <!--<li><a href="accept-topup.php" class="btn">✅ Accept Top-up</a></li>-->
                    <li><a href="delete-reservation.php" class="btn danger">🗑 Delete Reservation</a></li>
                </ul>
            </section>
        </div>
    </main>
</body>
</html>
