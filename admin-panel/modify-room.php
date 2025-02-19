<?php
include '../conn.php';

session_start();
if($_SESSION['isadmin'] != true) header("Location: index.php");
// Fetch all rooms
$result = $conn->query("SELECT * FROM rooms");
$rooms = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .room-list {
            margin-top: 20px;
        }
        .room-item {
            display: flex;
            justify-content: space-between;
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background: #0056b3;
        }
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .modal input {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Modify Rooms</h2>
    <div class="room-list">
        <?php foreach ($rooms as $room): ?>
            <div class="room-item">
                <span><?php echo htmlspecialchars($room['room_name']); ?></span>
                <button onclick="openModal(<?php echo htmlspecialchars(json_encode($room)); ?>)">Modify</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="overlay" id="overlay"></div>
<div class="modal" id="modal">
    <h3 id="roomTitle"></h3>
    <label>New Price:</label>
    <input type="number" id="newPrice">
    <label>New Max Adult Cap:</label>
    <input type="number" id="newAdultCap">
    <label>New Max Child Cap:</label>
    <input type="number" id="newChildCap">
    <div class="modal-buttons">
        <button onclick="saveChanges()">Save</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>
    let currentRoomId = null;

    function openModal(room) {
        currentRoomId = room.rid;
        document.getElementById('roomTitle').innerText = room.room_name;
        document.getElementById('newPrice').value = room.price;
        document.getElementById('newAdultCap').value = room.adult_mcap;
        document.getElementById('newChildCap').value = room.child_mcap;
        document.getElementById('modal').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    function saveChanges() {
        let price = document.getElementById('newPrice').value;
        let adultCap = document.getElementById('newAdultCap').value;
        let childCap = document.getElementById('newChildCap').value;

        let formData = new FormData();
        formData.append("id", currentRoomId);
        formData.append("price", price);
        formData.append("adult_mcap", adultCap);
        formData.append("child_mcap", childCap);

        fetch("update-room.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    }
</script>

</body>
</html>