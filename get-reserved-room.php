<?php
include 'conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $bid = $input['bid'];
    
    $bookedQuery = "SELECT * FROM booked_room WHERE bid = ? AND isactive = 1";
    $bookedStmt = $conn->prepare($bookedQuery);
    $bookedStmt->bind_param("i", $bid);
    $bookedStmt->execute();
    $bookedResult = $bookedStmt->get_result();
    $booked = $bookedResult->fetch_assoc();

    $roomQuery = "SELECT room_name, price FROM rooms WHERE rid = ?";
    $roomStmt = $conn->prepare($roomQuery);
    $rid = $booked['rid'];
    $roomStmt->bind_param("i", $rid);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    $room = $roomResult->fetch_assoc();

    $combined = array_merge($room, $booked);

    echo json_encode($combined);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "User not logged in"]));
}

$query = "SELECT * FROM booked_room WHERE uid = ? AND isactive = 1";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die(json_encode(["error" => "Prepare failed: " . $conn->error]));
}

$stmt->bind_param("i", $_SESSION['user_id']);

if (!$stmt->execute()) {
    die(json_encode(["error" => "Execution failed: " . $stmt->error]));
}

$result = $stmt->get_result();
$reservations = [];

while ($row = $result->fetch_assoc()) {
    $roomQuery = "SELECT room_name FROM rooms WHERE rid = ?";
    $roomStmt = $conn->prepare($roomQuery);

    if (!$roomStmt) {
        die(json_encode(["error" => "Prepare failed (rooms): " . $conn->error]));
    }

    $therid = $row['rid'];
    $roomStmt->bind_param("i", $therid);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    $room = $roomResult->fetch_assoc();
    $row['room_name'] = $room['room_name'];
    $reservations[] = $row;
    $roomStmt->close();
}

$stmt->close();
echo json_encode($reservations);
?>
