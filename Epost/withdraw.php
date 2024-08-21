<?php
require 'config.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST["withdraw"])) {
    $withdraw_amount = $_POST["withdraw_amount"];

    $user_id = $_SESSION["id"];
    $user_result = mysqli_query($conn, "SELECT * FROM accounts WHERE id = $user_id");
    $user_row = mysqli_fetch_assoc($user_result);

    // Check if the user has sufficient balance to withdraw
    if ($withdraw_amount <= $user_row['balance_amount']) {
        // Deduct the amount from the user's balance
        $new_user_balance = $user_row['balance_amount'] - $withdraw_amount;
        $update_user_query = "UPDATE accounts SET balance_amount = $new_user_balance WHERE id = $user_id";
        mysqli_query($conn, $update_user_query);

        // Generate a unique transaction ID
        $transaction_id = uniqid();

        // Insert a record into the transactions table for the withdrawal
        $transaction_type = 'Withdrawal';
        $date_time = date('Y-m-d H:i:s');
        $status = 'Success';

        $insert_transaction_query = "INSERT INTO transactions (account_id, transaction_id, transaction_type, amount, date_time, status)
                                    VALUES ($user_id, '$transaction_id', '$transaction_type', $withdraw_amount, '$date_time', '$status')";
        mysqli_query($conn, $insert_transaction_query);
        // After successful transfer or withdrawal
        $_SESSION['transaction_id'] = $transaction_id; // Set the transaction ID to the session

        $success_message = "Withdrawal of $withdraw_amount successful. Transaction ID: $transaction_id";
    } else {
        $error_message = "Insufficient balance to withdraw. <style>color:red<style>";
    }
}

header("Location: User_bank_dashboard.php?success_message=" . urlencode($success_message) . "&error_message=" . urlencode($error_message));
exit();
?>
