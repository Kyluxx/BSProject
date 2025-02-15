<?php
session_start();
include 'conn.php';
var_dump($_POST);
exit;
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Session expired, please login again.'); window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = "SELECT account_balance FROM user WHERE uid = ?";
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
            header("Location: payment-success.php?paymethod=ac&r=" . $_GET['r'] . "&total_days=" . $_POST['total_days'] . "&adult=" . $_POST['adult'] . "&child=" . $_POST['child'] . "&total_price=" . $_POST['total_price']);
            exit;
        }else{
            header("Location: payment.php?err=balance");
            exit;
       }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
?>