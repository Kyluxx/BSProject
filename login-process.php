<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT uid, name, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($uid, $name, $hashed_password);
        $stmt->fetch(); // Ambil data

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $uid;
            $_SESSION['name'] = $name;
            header("Location: index.php");
            exit;
        } else {
            echo "window.location.href='login.php?err=wrongpassword';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php?nouser';</script>";
    }

    $stmt->close();
}
?>