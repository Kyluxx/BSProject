<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Session expired, please login again.'); window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = "SELECT account_balance FROM users WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($account_balance);
        $stmt->fetch(); // Ambil data

        if ($account_balance >= $_POST['total_price']) {
            $query = "UPDATE user SET account_balance = account_balance - ? WHERE uid = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $_POST['total_price'], $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();
            $query = "INSERT into booked_room (uid, rid, check_in, check_out, total_day, total_price, pay_method, adult, child) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iissiisii", $_SESSION['user_id'], $_POST['r'], $_POST['checkin_fw'], $_POST['checkout_fw'], $_POST['total_days'], $_POST['total_price'], "Account Balance", $_POST['adult'], $_POST['child']);
            $stmt->execute();
            $stmt->close();
            header("Location: payment-success.php?paymethod=ac&r=" . $_POST['r'] . "&total_days=" . $_POST['total_days'] . "&adult=" . $_POST['adult'] . "&child=" . $_POST['child'] . "&total_price=" . $_POST['total_price']);
            exit;
        }else{
            header("Location: booking.php?r=" . $_POST['r'] . "&err=balance");
            exit;
       }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

}
?>