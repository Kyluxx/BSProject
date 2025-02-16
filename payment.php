<?php
session_start();
include 'conn.php';
if(!isset($_GET['r'])) { header("Location: index.php"); exit; }
$rid = $_GET['r'];
$roomimage = 'r' . $rid . '.jpg';
$query = "SELECT * from rooms WHERE rid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $rid);
$stmt->execute();
$result = $stmt->get_result(); 
$room = $result->fetch_assoc(); 
$stmt->close();

    //var_dump($_POST); // Debugging
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["checkin"], $_POST["checkout"], $_POST["adults"], $_POST["children"])) {
        $checkin_fw = $_POST['checkin'];
        $checkout_fw = $_POST['checkout'];
        $checkin = new DateTime($_POST["checkin"]);
        $checkout = new DateTime($_POST["checkout"]);
        $interval = $checkin->diff($checkout);
        $total_days = $interval->days; // Total hari menginap
        //$price_per_night = 120;
        if($total_days <= 0) header("Location: booking.php?r=$rid&err=totaldays");
        $total_price = $total_days * $room['price'];
        $adults = $_POST["adults"];
        $children = $_POST["children"];
            if($adults <= 0) { header("Location: booking.php?r=$rid&err=noadult"); exit; }
            if($children < 0) { header("Location: booking.php?r=$rid&err=invalidchild"); exit; }
        if($adults > $room['adult_mcap'] || $children > $room['child_mcap']) { header("Location: booking.php?r=$rid&err=capexceed"); exit; }
        // Bisa lanjut proses booking atau simpan ke database di sini
    } else {
        header("Location: index.php");
        exit;
    }
} else {
  header("Location: index.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment-style.css">
</head>
<body>
    <div class="container">
        
        <h2>Payment</h2>
        
        <!-- Booking Summary -->
        <div class="booking-summary">
            <h3>Booking Summary</h3>
            <img src="assets/rooms/<?php echo $roomimage?>" alt="Room Image">
            <p><strong>Room:</strong> <?php echo htmlspecialchars($room['room_name'])?></p>
            <p><strong>Price per Night:</strong> $<?php echo htmlspecialchars($room['price'])?></p>
            <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($total_price)?> (<?php echo htmlspecialchars($total_days)?> Nights)</p>
        </div>

        <!-- Payment Method -->
        <div class="payment-method">
            <h3>Choose Payment Method</h3>
            <select>
                <option value="cc">Credit Card</option>
                <option value="ac">Account Balance</option>
            </select>
        </div>

        <!-- Billing Information -->
        <!--
        <div class="billing-info">
            <h3>Billing Information</h3>
            <input type="text" placeholder="Full Name">
            <input type="email" placeholder="Email">
            <input type="tel" placeholder="Phone Number">
        </div>
        -->
        
        <button class="pay-now">Pay Now</button>
    </div>
    <script>
      document.querySelector('.pay-now').addEventListener('click', function () {
    let paymentMethod = document.querySelector('select').value;

    // Buat form baru
    let form = document.createElement("form");
    form.method = "POST";
    form.action = paymentMethod == "cc" ? "cc-payment.php?r=<?php echo $rid?>" : "ac-payment.php?r=<?php echo $rid?>";

    // Tambahin input hidden buat data yang mau dikirim
    let inputs = {
        r: "<?php echo $rid ?>",
        total_days: "<?php echo $total_days ?>",
        total_price: "<?php echo $total_price ?>",
        adult: "<?php echo $adults ?>",
        child: "<?php echo $children ?>"
    };

    if (!inputs.total_days || !inputs.total_price || !inputs.adult || !inputs.child) {
        alert("Invalid booking details.");
        window.location.href = "index.php";
    }
    for (let key in inputs) {
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = inputs[key];
        form.appendChild(input);
    }

    // Tambah form ke body dan submit
    document.body.appendChild(form);
    form.submit();
});
    </script>
</body>
</html>
