<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_name = $_POST['account_name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $email = $_POST['email'];
    $is_admin = $_POST['is_admin'];

    $stmt = $conn->prepare("INSERT INTO users (name, password, email, isadmin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $account_name, $password, $email, $is_admin);

    if ($stmt->execute()) {
        echo "User added successfully!";
    } else {
        echo "Error adding user.";
    }

    $stmt->close();
    $conn->close();
}
?>