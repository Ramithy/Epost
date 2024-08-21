<?php
require 'config.php';



if (isset($_POST["debit_account"])) {
    $account_number = $_POST["account_number"];
    $amount = $_POST["amount"];

    // Fetch the user's current balance
    $fetch_balance_query = "SELECT * FROM accounts WHERE account_number = '$account_number'";
    $fetch_balance_result = mysqli_query($conn, $fetch_balance_query);
    $user_row = mysqli_fetch_assoc($fetch_balance_result);

    if ($user_row) {
        // Check if the user has sufficient balance
        if ($amount <= $user_row['balance_amount']) {
            // Deduct the amount from the user's balance
            $new_balance = $user_row['balance_amount'] - $amount;
            $update_balance_query = "UPDATE accounts SET balance_amount = $new_balance WHERE account_number = '$account_number'";
            mysqli_query($conn, $update_balance_query);

            // Generate a unique transaction ID
            $transaction_id = uniqid();

            // Insert a record into the transactions table for the debit transaction
            $transaction_type = 'Debit';
            $date_time = date('Y-m-d H:i:s');
            $status = 'Success';

            $insert_transaction_query = "INSERT INTO transactions (account_id, transaction_id, transaction_type, amount, date_time, status)
                                        VALUES ({$user_row['id']}, '$transaction_id', '$transaction_type', $amount, '$date_time', '$status')";
            mysqli_query($conn, $insert_transaction_query);

            echo "<script>alert('Debit successful. Transaction ID: $transaction_id');</script>";
        } else {
            echo "<script>alert('Insufficient balance to debit.');</script>";
        }
    } else {
        echo "<script>alert('User with the provided account number not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Account</title>
    <link rel="stylesheet" href="admin_bank_styles.css">
</head>
<body>
    <div class="container">
        <h1>Debit Account</h1>
        <form method="post" action="admin_debit_money.php">
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" required>

            <label for="amount">Amount:</label>
            <input type="number" name="amount" step="0.01" required>

            <button type="submit" name="debit_account">Debit Account</button>
        </form>

        <a href="admin_bank_track.php">Back to Manage Bank</a>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
