<?php
session_start();
//if(!isset($_POST['total_days']) || !isset($_GET['r'])) { header("Location: payment.php?err=invaliddata"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
    <link rel="stylesheet" href="css/cc-payment.css">
</head>
<body>
    <div class="container">
        <h2>Enter Credit Card Details</h2>
        
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Card Number:</label>
            <input type="text" name="card_number" maxlength="16" required>

            <label>Expiration Date:</label>
            <input type="month" name="exp_date" required>

            <label>CVV:</label>
            <input type="text" name="cvv" maxlength="3" required>
            
            <button type="submit" class="pay-now">Continue</button>

    </div>
    <script>
     document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.pay-now').addEventListener('click', function () {
   // e.preventDefault(); // Biar gak langsung submit sebelum ditambahin data

    let form = document.createElement("form");
    form.method = "POST";
    form.action = "payment-success.php?paymethod=cc&r=<?php echo $_GET['r']; ?>&total_days=<?php echo $_POST['total_days']; ?>&total_price=<?php echo $_POST['total_price']; ?>&adult=<?php echo $_POST['adult']; ?>&child=<?php echo $_POST['child']; ?>";
    
    // Tambahin hidden input biar data dari URL kepost juga
    let hiddenInputs = {
        r: "<?php echo $_GET['r'] ?>",
        total_days: "<?php echo $_POST['total_days'] ?>",
        total_price: "<?php echo $_POST['total_price'] ?>",
        adult: "<?php echo $_POST['adult'] ?>",
        child: "<?php echo $_POST['child'] ?>",
        checkin_fw: "<?php echo $_POST['checkin_fw'] ?>",
        checkout_fw: "<?php echo $_POST['checkout_fw'] ?>"
    };

    for (let key in hiddenInputs) {
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = hiddenInputs[key];
        form.appendChild(input);
    }

    // When the button is clicked, run this function
    <?php
    if (true) {
        
        // Decrease account balance
        /*
        $query = "UPDATE users SET account_balance = account_balance - ? WHERE uid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $_POST['total_price'], $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
        */

        // Insert to database
        $query = "INSERT INTO booked_room (uid, rid, check_in, check_out, total_day, total_price, pay_method, adult, child) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $uid = $_SESSION['user_id'];
        $rid = $_POST['r'];
        $checkin = $_POST['checkin_fw'];
        $checkout = $_POST['checkout_fw'];
        $total_days = $_POST['total_days'];
        $total_price = $_POST['total_price'];
        $pay_method = "Credit Card";
        $adult = $_POST['adult'];
        $child = $_POST['child'];
        $stmt->bind_param("iissiisi", $uid, $rid, $checkin, $checkout, $total_days, $total_price, $pay_method, $adult, $child);
        $stmt->execute();
        $stmt->close();
    }
    ?>

    document.body.appendChild(form);
    form.submit(); // Submit form yang udah ada
});
     });
    </script>
</body>
</html>

