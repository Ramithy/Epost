<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer System</title>
    <style>
        body {
    font-family: Arial, sans-serif;
}

.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
}

input[type="submit"] {
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Money Transfer</h1>
        <form action="transfer.php" method="post">
            <label for="account_holder_name">Account Holder Name:</label>
            <input type="text" id="account_holder_name" name="account_holder_name" required>

            <label for="account_number">Account Number:</label>
            <input type="number" id="account_number" name="account_number" required>

            <label for="bank_name">Bank Name:</label>
            <input type="text" id="bank_name" name="bank_name" required>

            <label for="ifsc_code">IFSC Code:</label>
            <input type="text" id="ifsc_code" name="ifsc_code" required>

            <label for="amount">Amount (max 10000 Rs per transaction):</label>
            <input type="number" id="amount" name="amount" min="1" max="10000" required>

            <input type="submit" value="Transfer">
        </form>
    </div>
</body>
</html>
