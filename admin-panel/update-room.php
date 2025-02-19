<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $adult_mcap = $_POST['adult_mcap'];
    $child_mcap = $_POST['child_mcap'];

    $stmt = $conn->prepare("UPDATE rooms SET price=?, adult_mcap=?, child_mcap=? WHERE rid=?");
    $stmt->bind_param("iiii", $price, $adult_mcap, $child_mcap, $id);

    if ($stmt->execute()) {
        echo "Room updated successfully!";
    } else {
        echo "Error updating room.";
    }

    $stmt->close();
    $conn->close();
}
?>