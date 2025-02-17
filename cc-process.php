<?php
include 'conn.php';
session_start();
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
        $stmt->bind_param("iissiisii", $uid, $rid, $checkin, $checkout, $total_days, $total_price, $pay_method, $adult, $child);
        if($stmt->execute()) header("Location: payment-success.php?r=$rid&total_days=$total_days&adult=$adult&child=$child&total_price=$total_price&paymethod=cc");
        $stmt->close();
    }
    ?>