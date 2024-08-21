<?php
require 'config.php';

// Function to fetch all bank details
function getAllBankDetails($conn) {
    $query = "SELECT * FROM accounts";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    return $result;
}

// Function to fetch all transaction details
function getAllTransactionDetails($conn) {
    $query = "SELECT * FROM transactions";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to update transaction status
function updateTransactionStatus($conn, $transaction_id, $status) {
    $query = "UPDATE transactions SET status = '$status' WHERE transaction_id = '$transaction_id'";
    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Add your CSS styles here */

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ccc;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

th, td {
    text-align: left;
}

a {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

a:hover {
    background-color: #4CAF50;
}

.alert {
    padding: 12px;
    margin-top: 20px;
    background-color: #f44336;
    color: #fff;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
}


    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin</h1>

        <h2>Bank Details</h2>
        <table>
            <tr>
                <th>Account Holder Name</th>
                <th>Account Number</th>
                <th>Bank Name</th>
                <th>IFSC Code</th>
                <th>Balance Amount</th>
            </tr>
            <?php
            $bank_details = getAllBankDetails($conn);
            while ($row = mysqli_fetch_assoc($bank_details)) {
                echo "<tr>";
                echo "<td>{$row['account_holder_name']}</td>";
                echo "<td>{$row['account_number']}</td>";
                echo "<td>{$row['bank_name']}</td>";
                echo "<td>{$row['ifsc_code']}</td>";
                echo "<td>{$row['balance_amount']}</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Transaction Details</h2>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Account ID</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Date and Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $transaction_details = getAllTransactionDetails($conn);
            while ($row = mysqli_fetch_assoc($transaction_details)) {
                echo "<tr>";
                echo "<td>{$row['transaction_id']}</td>";
                echo "<td>{$row['account_id']}</td>";
                echo "<td>{$row['transaction_type']}</td>";
                echo "<td>{$row['amount']}</td>";
                echo "<td>{$row['date_time']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td><a href='admin_update_status.php?transaction_id={$row['transaction_id']}&status=Success'>Success</a> | <a href='admin_update_status.php?transaction_id={$row['transaction_id']}&status=Failed'style='background-color:red'>Failed</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <a href="admin_add_money.php">Add Money</a>
        <a href="admin_debit_money.php">Debit Money</a>
        <a href="admin_create_new_bank_user.php">Create a New Account</a>
        <a href="admin_dashboard.php">Back to Dashboard</a>
        <a href="adminlogout.php" id='logout'>Logout</a>
    </div>
</body>
</html>
