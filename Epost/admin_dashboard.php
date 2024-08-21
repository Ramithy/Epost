<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 30px;
}

p {
    text-align: center;
    font-size: 18px;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #008CBA;
    font-weight: bold;
}

a:hover {
    color: #005580;
}

.table-container {
    margin-top: 40px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ccc;
}

table th {
    background-color: #f2f2f2;
}

table td:last-child {
    text-align: center;
}

.error {
    color: #ff0000;
    text-align: center;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, Admin!</p>
        <p><a href="admin_track.php">View Tracking Data</a></p>
        <p><a href="admin_bank_track.php">Manage the Bank Details</a></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
