<?php
session_start();
if(!isset($_POST['total_days']) || !isset($_GET['r'])) { header("Location: payment.php?err=invaliddata"); exit; }
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
        <form action="payment-success.php?r=<?php echo $_GET['r']?>&paymethod=cc" method="POST">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Card Number:</label>
            <input type="text" name="card_number" maxlength="16" required>

            <label>Expiration Date:</label>
            <input type="month" name="exp_date" required>

            <label>CVV:</label>
            <input type="text" name="cvv" maxlength="3" required>
            
            <button type="submit" class="pay-now">Continue</button>
        </form>
    </div>
    <script>
     document.querySelector('.pay-now').addEventListener('click', function (e) {
    e.preventDefault(); // Biar gak langsung submit sebelum ditambahin data

    let form = document.querySelector('form'); // Ambil form utama
    
    // Tambahin hidden input biar data dari URL kepost juga
    let hiddenInputs = {
        r: "<?php echo $_GET['r'] ?>",
        total_days: "<?php echo $_POST['total_days'] ?>",
        total_price: "<?php echo $_POST['total_price'] ?>",
        adult: "<?php echo $_POST['adult'] ?>",
        child: "<?php echo $_POST['child'] ?>",
        checkin_fw: "<?php echo $_POST['checkin'] ?>",
        checkout_fw: "<?php echo $_POST['checkout'] ?>"
    };

    for (let key in hiddenInputs) {
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = hiddenInputs[key];
        form.appendChild(input);
    }

    form.submit(); // Submit form yang udah ada
});
    </script>
</body>
</html>
