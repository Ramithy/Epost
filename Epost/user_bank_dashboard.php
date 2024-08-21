<?php
require 'config.php';



$user_id = $_SESSION["id"];
$user_result = mysqli_query($conn, "SELECT * FROM accounts WHERE id = $user_id");
$user_row = mysqli_fetch_assoc($user_result);

        // Check for success or error messages from the transaction
        $success_message = isset($_GET['success_message']) ? $_GET['success_message'] : '';
        $error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Dashboard</title>
    <style>
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
    margin-top: 10px;
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="number"] {
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
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #4CAF50;
}
div button{
    padding: 10px;
    width: 100%;
    background-color: #4CAF50;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}

.error-message{
    color: red;
}
.success-message{
    color: green;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Bank Dashboard, <?php echo $user_row['account_holder_name']; ?></h1>

        <p><strong>Account Holder Name:</strong> <?php echo $user_row['account_holder_name']; ?></p>
        <p><strong>Account Number:</strong> <?php echo $user_row['account_number']; ?></p>
        <p><strong>Bank Name:</strong> <?php echo $user_row['bank_name']; ?></p>
        <p><strong>IFSC Code:</strong> <?php echo $user_row['ifsc_code']; ?></p>
        <p><strong>Balance:</strong> <?php echo $user_row['balance_amount']; ?></p>

        <h2>Transfer Money</h2>
        <form action="transfer.php" method="post">
            <!-- Transfer form fields -->
            <label for="recipient_account_holder">Recipient Account Holder's Name:</label>
            <input type="text" id="recipient_account_holder" name="recipient_account_holder" required>

            <label for="recipient_account_number">Recipient Account Number:</label>
            <input type="text" id="recipient_account_number" name="recipient_account_number" required>

            <label for="bank_name">Bank Name:</label>
            <input type="text" id="bank_name" name="bank_name" required>

            <label for="ifsc_code">IFSC Code:</label>
            <input type="text" id="ifsc_code" name="ifsc_code" required>

            <label for="amount">Amount to Transfer:</label>
            <input type="number" id="amount" name="amount" required min="1" max="10000">

            <button type="submit" name="transfer">Transfer</button>
        </form>


        <h2>Withdraw Money</h2>
        <form action="withdraw.php" method="post">
            <!-- Withdraw form fields -->
            <label for="withdraw_amount">Amount to Withdraw:</label>
            <input type="number" id="withdraw_amount" name="withdraw_amount" required min="1" max="<?php echo $row['balance_amount']; ?>">

            <button type="submit" name="withdraw">Withdraw</button>
        </form>


        <!-- Track the Details form -->
        <form action="user_bank_track.php" method="post">
        <button type="submit" name="track">Track the Details</button>
        </form>

        <a href="logout.php">Logout</a>
        <a href="Userhome.php">Home</a>

        <br>
        <br>
        <!-- Display success or error messages -->
        <?php if (!empty($success_message)) : ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php
        if (isset($_SESSION['transaction_id'])) {
            $transaction_id = $_SESSION['transaction_id'];
            $transaction_result = mysqli_query($conn, "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'");
            $transaction_row = mysqli_fetch_assoc($transaction_result);

            if ($transaction_row) {
                echo '<h2>Latest Transaction Details</h2>';
                echo '<p><strong>Transaction ID:</strong> ' . $transaction_row['transaction_id'] . '</p>';
                echo '<p><strong>Transaction Type:</strong> ' . $transaction_row['transaction_type'] . '</p>';
                echo '<p><strong>Amount:</strong> ' . $transaction_row['amount'] . '</p>';
                echo '<p><strong>Date and Time:</strong> ' . $transaction_row['date_time'] . '</p>';
                echo '<p><strong>Status:</strong> ' . $transaction_row['status'] . '</p>';
            }

            unset($_SESSION['transaction_id']); // Clear the transaction ID from the session
        }
        ?>
    </div>
</body>
</html>
