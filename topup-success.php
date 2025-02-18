<?php
session_start();
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
        <h2 class="success-message">Top-up Successful!</h2>
        
        <div class="details">
        <p><strong>Added Balance:</strong> $<?php echo $_GET['amount']?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_GET['fullname'])?></p>
            <p><strong>Card Number:</strong> <?php echo htmlspecialchars($_GET['card_number'])?></p>
            <p><strong>Expiration Date:</strong> <?php echo htmlspecialchars($_GET['exp_date'])?></p>
            <p><strong>CVV:</strong> <?php echo htmlspecialchars($_GET['cvv'])?></p>
        </div>
        
        <a href="index.php" class="back-home">Back to Home</a>
    </div>
</body>
</html>