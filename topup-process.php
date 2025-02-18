<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';
    $amount = abs((int)$_POST['amount']);
    $amount = min($amount, 10000);
    $query = "UPDATE users SET account_balance = account_balance + ? WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $amount, $_SESSION['user_id']);
    if ($stmt->execute()) {
        header("Location: topup-success.php?amount=$amount&fullname=" . $_POST['fullname'] . "&card_number=" . $_POST['card_number'] . "&exp_date=" . $_POST['exp_date'] . "&cvv=" . $_POST['cvv']);
        exit;
    } else {
        header("Location: topup.php?err=failed");
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: topup.php");
    exit;
}
