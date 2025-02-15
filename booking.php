<?php
session_start();
include 'conn.php';
if(!isset($_SESSION['user_id'])) {  
  header("Location: login.php");
  exit;
}
date_default_timezone_set('Asia/Jakarta');
if(!isset($_GET['r'])) {
  header("Location: index.php"); 
  exit;
}
$rid = $_GET['r'];
$roomimage = 'r' . $rid . '.jpg';
$query = "SELECT * FROM room WHERE rid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $rid);
$stmt->execute();
$result = $stmt->get_result(); 
$room = $result->fetch_assoc(); 
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="css/booking-style.css">
</head>
<body>

    <!-- Booking Details -->
    <div class="booking-container">
        <div class="room-preview">
          <?php 
          if(isset($_GET['err'])){
          if($_GET['err'] == 'totaldays'){
            echo "<p style='color: red; font-weight: bold;'>Invalid Check in / Check out date!</p>";
          }
          if($_GET['err'] == 'noadult'){
            echo "<p style='color: red; font-weight: bold;'>Atleast 1 adult is needed!</p>";
          }
          if($_GET['err'] == 'capexceed'){
            echo "<p style='color: red; font-weight: bold;'>Maximum Capacity Exceeded!</p>";
          }
          }?>
            <img src="assets/rooms/<?php echo $roomimage;?>" alt="Room Preview">
            <h2><?php echo htmlspecialchars($room['room_name']); ?></h2>
            <p><?php echo htmlspecialchars($room['details']); ?></p>
            <p><strong>Max:</strong> <?php echo htmlspecialchars($room['adult_mcap']); ?> Adults, <?php echo htmlspecialchars($room['child_mcap']); ?> Child</p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($room['price']); ?>/night</p>
        </div>

        <!-- Booking Form -->
        <form action="payment.php?r=<?php echo $rid?>" method="POST" enctype="application/x-www-form-urlencoded">
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
