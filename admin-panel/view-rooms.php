<?php
include '../conn.php';
session_start();
if($_SESSION['isadmin'] != true) header("Location: index.php");
$query = "SELECT * FROM rooms";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin-style.css">
    <title>List of Available Rooms</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Admin Panel</div>
        <a href="../logout.php" class="btn logout">Logout</a>
    </nav>
    <main class="container">
        <h1>View Rooms</h1>
        <div class="grid">
            <?php while($room = $result->fetch_assoc()): ?>
                <section class="card">
                    <h2><?php echo htmlspecialchars($room['room_name']); ?></h2>
                    <p><?php echo htmlspecialchars($room['details']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($room['price']); ?>/night</p>
                    <p>Max. Adults: <?php echo htmlspecialchars($room['adult_mcap']); ?></p>
                    <p>Max. Children: <?php echo htmlspecialchars($room['child_mcap']); ?></p>
                </section>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>
