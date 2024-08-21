<?php
require 'config.php';

if (isset($_POST["create_user"])) {
    $account_holder_name = $_POST["account_holder_name"];
    $account_number = $_POST["account_number"];
    $bank_name = $_POST["bank_name"];
    $ifsc_code = $_POST["ifsc_code"];
    $balance_amount = $_POST["balance_amount"];

    // Check if the user with the provided account number already exists
    $check_user_query = "SELECT * FROM accounts WHERE account_number = '$account_number' AND bank_name = '$bank_name' AND ifsc_code = '$ifsc_code'";
    $check_user_result = mysqli_query($conn, $check_user_query);
    $user_row = mysqli_fetch_assoc($check_user_result);

    if (!$user_row) {
        // Insert a record into the accounts table for the new user
        $insert_user_query = "INSERT INTO accounts (account_holder_name, account_number, bank_name, ifsc_code, balance_amount)
                              VALUES ('$account_holder_name', '$account_number', '$bank_name', '$ifsc_code', $balance_amount)";
        mysqli_query($conn, $insert_user_query);

        echo "<script>alert('New user account created successfully.');</script>";
    } else {
        echo "<script>alert('User with the provided account number already exists.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="admin_bank_styles.css">
</head>
<body>
    <div class="container">
        <h1>Create User</h1>
        <form method="post" action="admin_create_new_bank_user.php">
            <label for="account_holder_name">Account Holder's Name:</label>
            <input type="text" name="account_holder_name" required>

            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" required>

            <label for="bank_name">Bank Name:</label>
            <input type="text" name="bank_name" required>

            <label for="ifsc_code">IFSC Code:</label>
            <input type="text" name="ifsc_code" required>

            <label for="balance_amount">Balance Amount:</label>
            <input type="number" name="balance_amount" step="0.01" required>

            <button type="submit" name="create_user">Create User</button>
        </form>

        <a href="admin_bank_track.php">Back to Manage Bank</a>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
