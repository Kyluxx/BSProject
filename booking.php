<?php
date_default_timezone_set('Asia/Jakarta');
$rid = $_GET['r'];
$room = 'r' . $rid . '.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="booking-style.css">
</head>
<body>

    <!-- Booking Details -->
    <div class="booking-container">
        <div class="room-preview">
            <img src="assets/rooms/<?php echo $room; ?>" alt="Room Preview">
            <h2>Deluxe Room</h2>
            <p>Spacious room with sea view.</p>
            <p><strong>Max:</strong> 2 Adults, 1 Child</p>
            <p><strong>Price:</strong> $120/night</p>
        </div>

        <!-- Booking Form -->
        <form action="payment.php" method="POST">
            <label>Check-in Date:</label>
            <input type="date" name="checkin" required>

            <label>Check-out Date:</label>
            <input type="date" name="checkout" required>

            <label>Adults:</label>
            <input type="number" name="adults" min="1" required>

            <label>Children:</label>
            <input type="number" name="children" min="0" required>

            <button type="submit">Continue to Payment</button>
        </form>
    </div>

</body>
</html>
