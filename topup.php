<?php
session_start();
//if(!isset($_POST['total_days']) || !isset($_GET['r'])) { header("Location: payment.php?err=invaliddata"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balance Top-up</title>
    <link rel="stylesheet" href="css/cc-payment.css">
</head>
<body>
    <div class="container">
<?php if (isset($_GET['err']) && $_GET['err'] == 'failed'): ?>
    <p style="color: red; font-weight: bold;">Failed to process, please try again</p>
<?php endif; ?>

        <h2>Enter Credit Card Details</h2>
        <form action="topup-process.php" method="POST">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Card Number:</label>
            <input type="text" name="card_number" maxlength="16" required>

            <label>Expiration Date:</label>
            <input type="month" name="exp_date" required>

            <label>CVV:</label>
            <input type="text" name="cvv" maxlength="3" required>

            <label>Amount: </label>
            <input type="number" name="amount" min="1" required>
            
            <button type="submit" class="pay-now" id="butt">Continue</button>
        </form>
    </div>
    
</body>
</html>

