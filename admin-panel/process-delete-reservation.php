<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bid = $_POST['bid'];
    $uid = $_POST['uid'];
    $refund = $_POST['refund'];

    // Refund saldo ke user
    $conn->query("UPDATE users SET account_balance = account_balance + $refund WHERE uid = $uid");

    // Hapus booking
    $conn->query("DELETE FROM booked_room WHERE bid = $bid");

    echo "Reservation deleted & refunded successfully!";
    $conn->close();
}
?>