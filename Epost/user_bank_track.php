<?php
require 'config.php';

if (isset($_POST['track'])) {
    $transaction_id = $_POST['transaction_id'];

    $transaction_result = mysqli_query($conn, "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'");
    $transaction_row = mysqli_fetch_assoc($transaction_result);

    if ($transaction_row) {
        $sender_result = mysqli_query($conn, "SELECT * FROM accounts WHERE id = {$transaction_row['account_id']}");
        $sender_row = mysqli_fetch_assoc($sender_result);

        $receiver_result = mysqli_query($conn, "SELECT * FROM accounts WHERE account_number = '{$sender_row['account_number']}' AND bank_name = '{$sender_row['bank_name']}' AND ifsc_code = '{$sender_row['ifsc_code']}'");
        $receiver_row = mysqli_fetch_assoc($receiver_result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Page</title>
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

p {
    margin-bottom: 10px;
}

strong {
    font-weight: bold;
}

form {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"] {
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #4CAF50;
}

button a{
    text-decoration: none;

    color: #fff;
}
h2 {
    margin-top: 20px;
}

p.no-result {
    text-align: center;
    color: #ff0000;
    font-weight: bold;
}


    /* Dashboard Styles */
        /* Dashboard Styles */
        .dashboard {
  display: flex;
}

.dashboard-menu {
  width: 200px;
  background-color: #f5f5f5;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.dashboard-menu ul {
  list-style: none;
  padding: 0;
}

.dashboard-menu li {
  margin-bottom: 10px;
}

.dashboard-menu a {
  text-decoration: none;
  color: #333;
  display: block;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s, color 0.3s;
  font-size: 16px;
}

.dashboard-menu a:hover {
  background-color: #4CAF50;
  color: #fff;
}

.dashboard-menu a.active {
  background-color: #ff5722;
  color: #fff;
}

.dashboard-content {
  flex: 1;
  padding: 20px;
}

.dashboard-content h1 {
  margin-bottom: 20px;
}

.dashboard-content p {
  font-size: 18px;
  line-height: 1.6;
}

/* Optional: Center the content within the dashboard */
.dashboard-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}


    </style>
</head>
<body>
     <!-- Dashboard -->
  <div class="dashboard">
    <!-- Dashboard Menu -->
    <div class="dashboard-menu">
      <ul>
        <li><a href="userpost.php">Post</a></li>
        <li><a href="user_bank_dashboard.php">Money Transfer</a></li>
        <li><a href="track.php">Tracking</a></li>
      </ul>
      <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h1>Tracking Page</h1>

        <form action="user_bank_track.php" method="post">
            <label for="transaction_id">Enter Transaction ID:</label>
            <input type="text" id="transaction_id" name="transaction_id" required>
            <button type="submit" name="track">Track</button>
        </form>

       <?php
        if (isset($transaction_row)) {
            if ($transaction_row) {
                echo '<h2>Transaction Details</h2>';
                echo '<p><strong>Transaction ID:</strong> ' . $transaction_row['transaction_id'] . '</p>';
                echo '<p><strong>Transaction Type:</strong> ' . $transaction_row['transaction_type'] . '</p>';
                echo '<p><strong>Amount:</strong> ' . $transaction_row['amount'] . '</p>';
                echo '<p><strong>Date and Time:</strong> ' . $transaction_row['date_time'] . '</p>';
                echo '<p><strong>Status:</strong> ' . $transaction_row['status'] . '</p>';

                if ($sender_row && $receiver_row) {
                    echo '<h2>Sender Details</h2>';
                    echo '<p><strong>Account Holder Name:</strong> ' . $sender_row['account_holder_name'] . '</p>';
                    echo '<p><strong>Account Number:</strong> ' . $sender_row['account_number'] . '</p>';
                    echo '<p><strong>Bank Name:</strong> ' . $sender_row['bank_name'] . '</p>';
                    echo '<p><strong>IFSC Code:</strong> ' . $sender_row['ifsc_code'] . '</p>';

                    echo '<h2>Receiver Details</h2>';
                    echo '<p><strong>Account Holder Name:</strong> ' . $receiver_row['account_holder_name'] . '</p>';
                    echo '<p><strong>Account Number:</strong> ' . $receiver_row['account_number'] . '</p>';
                    echo '<p><strong>Bank Name:</strong> ' . $receiver_row['bank_name'] . '</p>';
                    echo '<p><strong>IFSC Code:</strong> ' . $receiver_row['ifsc_code'] . '</p>';
                }
            } else {
                echo '<p>No transaction found with the provided Transaction ID.</p>';
            }
        }
        ?>

        <form action="user_bank_dashboard.php" method="post">
            <button type="submit" name="track">Back To Bank</button>
        </form>


    </div>
</body>
</html>
