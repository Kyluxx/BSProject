<?php include '../conn.php';
session_start();
if($_SESSION['isadmin'] != true ) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background: white;
            padding: 20px;
            width: 300px;
            margin: 10% auto;
            border-radius: 8px;
            
        }
                .modal input {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .cancel {
            background: #dc3545;
        }
    </style>
</head>
<body>

    <h2>Modify Users</h2>
<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Is Admin</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT uid, name, email, isadmin FROM users");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['uid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>" . ($row['isadmin'] ? "<span style='color:green;'>YES</span>" : "<span style='color:red;'>NO</span>") . "</td>
                        <td><button onclick='openModal({$row['uid']}, \"{$row['name']}\", \"{$row['email']}\", {$row['isadmin']})'>Modify</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit User</h3>
        <input type="hidden" id="user_id">
        <label>Name:</label>
        <input type="text" id="edit_name" required>
        <label>Email:</label>
        <input type="email" id="edit_email" required>
        <label>Is Admin:</label>
        <select id="edit_is_admin">
            <option value="1">YES</option>
            <option value="0">NO</option>
        </select>
        <div class="buttons">
            <button class="cancel" onclick="closeModal()">Cancel</button>
            <button onclick="saveUser()">Save</button>
        </div>
    </div>
</div>

<script>
    function openModal(id, name, email, isAdmin) {
        document.getElementById('user_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_is_admin').value = isAdmin;
        document.getElementById('editModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('editModal').style.display = "none";
    }

    function saveUser() {
        let formData = new FormData();
        formData.append("id", document.getElementById('user_id').value);
        formData.append("name", document.getElementById('edit_name').value);
        formData.append("email", document.getElementById('edit_email').value);
        formData.append("is_admin", document.getElementById('edit_is_admin').value);

        fetch("process-modify-user.php", {
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