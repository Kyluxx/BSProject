<?php
session_start();
include 'conn.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Delete user data
    $deleteQuery = "DELETE FROM users WHERE uid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);

        // Check account balance
        $balanceQuery = "SELECT account_balance FROM users WHERE uid = ?";
        $stmt = $conn->prepare($balanceQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($accountBalance);
        $stmt->fetch();
        $stmt->close();
    
        if ($accountBalance > 0) {
            echo "<script>alert('Cannot delete account, still have a balance.'); window.location.href='index.php';</script>";
            exit;
        }
    
    if ($stmt->execute()) {
        // Destroy session
        session_unset();
        session_destroy();
        
        // Redirect to index.php
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to delete account.";
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "No user session found.";
}
?>

