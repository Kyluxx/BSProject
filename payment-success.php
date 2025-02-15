<?php
session_start();
include 'conn.php';
if(!isset($_GET['r'])) { header("Location: index.php"); exit; }
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
    <title>Payment Successful</title>
    <link rel="stylesheet" href="css/payment-success.css">
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <h2 class="success-message">Payment Successful!</h2>
        <p >Thank you for your booking!</p>
        
        <div class="details">
            <img src="assets/rooms/<?php echo $roomimage?>" alt="Room Image">
            <p><strong>Room:</strong> <?php echo $room['room_name']?></p>
            <p><strong>Check-in:</strong> 2025-02-20</p>
            <p><strong>Check-out:</strong> 2025-02-22</p>
            <p><strong>Total Nights:</strong> <?php echo $_POST['total_days']?></p>
            <p><strong>Guests:</strong> <?php echo $_POST['adult']?> Adults, <?php echo $_POST['child']?> Child</p>
            <p><strong>Payment Method:</strong> <?php if($_GET['paymethod'] == "cc"){
            echo htmlspecialchars("Credit Card");
            }else{
              echo htmlspecialchars("Account Balance");
            }?></p>
            <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($_POST['total_price'])?></p>
        </div>
        
        <a href="index.php" class="back-home">Back to Home</a>
    </div>
</body>
</html>
