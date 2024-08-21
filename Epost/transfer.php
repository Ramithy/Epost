<?php   
require 'config.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST["transfer"])) {
    $recipient_account_number = $_POST["recipient_account_number"];
    $bank_name = $_POST["bank_name"];
    $ifsc_code = $_POST["ifsc_code"];
    $amount = $_POST["amount"];

    $user_id = $_SESSION["id"];
    $user_result = mysqli_query($conn, "SELECT * FROM accounts WHERE id = $user_id");
    $user_row = mysqli_fetch_assoc($user_result);

    // Check if the recipient account exists in the database
    $recipient_result = mysqli_query($conn, "SELECT * FROM accounts WHERE account_number = '$recipient_account_number' AND bank_name = '$bank_name' AND ifsc_code = '$ifsc_code'");
    $recipient_row = mysqli_fetch_assoc($recipient_result);

    if (mysqli_num_rows($recipient_result) > 0) {
        if ($recipient_row['id'] === $user_id) {
            echo "<script>alert('You cannot transfer money to your own account.');</script>";
        } else {
            // Check if the user has sufficient balance to transfer
            if ($amount <= $user_row['balance_amount']) {
                // Deduct the amount from the user's balance
                $new_user_balance = $user_row['balance_amount'] - $amount;
                $update_user_query = "UPDATE accounts SET balance_amount = $new_user_balance WHERE id = $user_id";
                mysqli_query($conn, $update_user_query);

                // Add the amount to the recipient's balance
                $new_recipient_balance = $recipient_row['balance_amount'] + $amount;
                $update_recipient_query = "UPDATE accounts SET balance_amount = $new_recipient_balance WHERE id = {$recipient_row['id']}";
                mysqli_query($conn, $update_recipient_query);

                // Generate a unique transaction ID
                $transaction_id = uniqid();

                // Insert a record into the transactions table for the transfer
                $transaction_type = 'Transfer';
                $date_time = date('Y-m-d H:i:s');
                $status = 'Success';

                $insert_transaction_query = "INSERT INTO transactions (account_id, transaction_id, transaction_type, amount, date_time, status)
                                            VALUES ($user_id, '$transaction_id', '$transaction_type', $amount, '$date_time', '$status')";
                mysqli_query($conn, $insert_transaction_query);

                // After successful transfer or withdrawal
                $_SESSION['transaction_id'] = $transaction_id; // Set the transaction ID to the session


                echo "<script>alert('Transfer of $amount to {$recipient_row['account_holder_name']} ($recipient_account_number) at $bank_name ($ifsc_code) successful. Transaction ID: $transaction_id');</script>";
            } else {
                echo "<script>alert('Insufficient balance to transfer.');</script>";
            }
        }
    } else {
        echo "<script>alert('Recipient account not found or invalid bank details.');</script>";
    }
}

header("Location: User_bank_dashboard.php");
exit();
?>
