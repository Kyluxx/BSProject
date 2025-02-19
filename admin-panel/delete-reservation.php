<?php include '../conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: auto;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background: #b52b27;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background: white;
            padding: 20px;
            width: 300px;
            margin: 10% auto;
            border-radius: 8px;
            text-align: center;
        }
        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Delete Reservation</h2>
<div class="container">
    <table>
        <tr>
            <th>BID</th>
            <th>UID</th>
            <th>User Name</th>
            <th>Room Name</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT b.bid, b.uid, u.name, r.room_name, b.total_price 
                                FROM booked_room b
                                JOIN users u ON b.uid = u.uid
                                JOIN rooms r ON b.rid = r.rid");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['bid']}</td>
                        <td>{$row['uid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['room_name']}</td>
                        <td>\${$row['total_price']}</td>
                        <td><button onclick='openModal({$row['bid']}, {$row['uid']}, {$row['total_price']})'>Delete</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No reservations found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this reservation?</p>
        <input type="hidden" id="del_bid">
        <input type="hidden" id="del_uid">
        <input type="hidden" id="refund_amount">
        <div class="buttons">
            <button onclick="deleteReservation()">Yes, Delete</button>
            <button style="background-color: green;" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openModal(bid, uid, totalPrice) {
        document.getElementById('del_bid').value = bid;
        document.getElementById('del_uid').value = uid;
        document.getElementById('refund_amount').value = totalPrice;
        document.getElementById('deleteModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = "none";
    }

    function deleteReservation() {
        let formData = new FormData();
        formData.append("bid", document.getElementById('del_bid').value);
        formData.append("uid", document.getElementById('del_uid').value);
        formData.append("refund", document.getElementById('refund_amount').value);

        fetch("process-delete-reservation.php", {
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