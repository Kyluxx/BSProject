<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $balance = $_POST['balance'];
    $isadmin = $_POST['isadmin'];

    // Cek saldo > 0
    if ($balance > 0) {
        echo "Error: Cannot delete user with balance > 0!";
        exit;
    }

    // Cek admin status
    if ($isadmin == 1) {
        echo "Error: Cannot delete an admin user!";
        exit;
    }

    // Cek apakah user masih punya reservasi di booked_room
    $checkReservation = $conn->query("SELECT COUNT(*) as count FROM booked_room WHERE uid = $uid");
    $resData = $checkReservation->fetch_assoc();
    if ($resData['count'] > 0) {
        echo "Error: Cannot delete user with active reservations!";
        exit;
    }

    // Hapus user
    $conn->query("DELETE FROM users WHERE id = $uid");
    echo "User deleted successfully!";
    $conn->close();
}
?>