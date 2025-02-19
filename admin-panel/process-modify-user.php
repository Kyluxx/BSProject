<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $is_admin = $_POST['is_admin'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, isadmin=? WHERE uid=?");
    $stmt->bind_param("ssii", $name, $email, $is_admin, $id);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user.";
    }

    $stmt->close();
    $conn->close();
}
?>