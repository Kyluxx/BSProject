<?php include '../conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
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
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background: #0056b3;
        }
        .cancel {
            background: #dc3545;
        }
        .cancel:hover {
            background: #b02a37;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add User</h2>
    <form id="addUserForm">
        <label>Account Name:</label>
        <input type="text" id="account_name" required>

        <label>Password:</label>
        <input type="password" id="password" required>

        <label>Email:</label>
        <input type="email" id="email" required>

        <label>Is Admin:</label>
        <select id="is_admin">
            <option value="0">False</option>
            <option value="1">True</option>
        </select>

        <div class="buttons">
          <button type="button" class="cancel" onclick="window.location='index.php'">Cancel</button>
            <button type="button" onclick="addUser()">Add</button>
            
        </div>
    </form>
</div>

<script>
    function addUser() {
        let formData = new FormData();
        formData.append("account_name", document.getElementById('account_name').value);
        formData.append("password", document.getElementById('password').value);
        formData.append("email", document.getElementById('email').value);
        formData.append("is_admin", document.getElementById('is_admin').value);

        fetch("process-add-user.php", {
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