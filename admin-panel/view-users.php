<?php include '../conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
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
        .admin-yes {
            color: green;
            font-weight: bold;
        }
        .admin-no {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
  
<h2>Users List</h2>
<div class="container">
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Balance</th>
            <th>Is Admin</th>
        </tr>
        <?php
        $result = $conn->query("SELECT uid, name, email, account_balance, isadmin FROM users");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['uid']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>$" . number_format($row['account_balance'], 2) . "</td>
                        <td class='" . ($row['isadmin'] ? "admin-yes'>YES" : "admin-no'>NO") . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

</body>
</html>