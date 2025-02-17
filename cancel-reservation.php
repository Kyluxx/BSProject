<?php
include 'conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $bid = $input['bid'];

    // Check if the reservation belongs to the user
    $checkQuery = "SELECT * FROM booked_room WHERE bid = ? AND uid = ? AND isactive = 1";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $bid, $_SESSION['user_id']);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Set the reservation as inactive
        $deleteQuery = "UPDATE booked_room SET isactive = 0 WHERE bid = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $bid);
        if ($deleteStmt->execute()) {
            //echo json_encode(["message" => "Reservation cancelled successfully."]);
        } else {
            echo json_encode(["message" => "Failed to cancel reservation."]);
            exit;
        }
        $deleteStmt->close();
    } else {
        echo json_encode(["message" => "Reservation not found or access denied."]);
        exit;
    }

        $checkResultRow = $checkResult->fetch_assoc();
        $total_price = $checkResultRow['total_price'];

        // Refund the money
        $refundQuery = "UPDATE users SET account_balance = account_balance + ? WHERE uid = ?";
        $refundStmt = $conn->prepare($refundQuery);
        $refundStmt->bind_param("ii", $total_price, $_SESSION['user_id']);
        if ($refundStmt->execute()) {
           echo json_encode(["message" => "Reservation cancelled successfully."]);
        } else {
            echo json_encode(["message" => "Failed to cancel reservation."]);
            exit;
        }
        $refundStmt->close();

    $checkStmt->close();
    $conn->close();
    exit;
}

echo json_encode(["message" => "Invalid request."]);
?>

