<?php include '../conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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
        .yes {
            color: green;
            font-weight: bold;
        }
        .no {
            color: red;
            font-weight: bold;
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

    <h2>Delete User</h2>
<div class="container">
    <table>
        <tr>
            <th>UID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Balance</th>
            <th>Is Admin</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT uid, name, email, account_balance, isadmin FROM users");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $isAdminText = $row['isadmin'] ? "<span class='yes'>Yes</span>" : "<span class='no'>No</span>";
                echo "<tr>
                        <td>{$row['uid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>\${$row['account_balance']}</td>
                        <td>{$isAdminText}</td>
                        <td><button onclick='openModal({$row['uid']}, {$row['account_balance']}, {$row['isadmin']})'>Delete</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this user?</p>
        <input type="hidden" id="del_uid">
        <input type="hidden" id="del_balance">
        <input type="hidden" id="del_isadmin">
        <div class="buttons">
            <button onclick="deleteUser()">Yes, Delete</button>
            <button onclick="closeModal()"style="background-color: green;" >Cancel</button>
        </div>
    </div>
</div>

<script>
    function openModal(uid, balance, isAdmin) {
        document.getElementById('del_uid').value = uid;
        document.getElementById('del_balance').value = balance;
        document.getElementById('del_isadmin').value = isAdmin;
        document.getElementById('deleteModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = "none";
    }

    function deleteUser() {
        let formData = new FormData();
        formData.append("uid", document.getElementById('del_uid').value);
        formData.append("balance", document.getElementById('del_balance').value);
        formData.append("isadmin", document.getElementById('del_isadmin').value);

        fetch("process-delete-user.php", {
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