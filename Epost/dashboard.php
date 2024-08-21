<?php
// Assuming you have already connected to the database here

// Fetch the current user's account details
$account_number = $_SESSION['account_number']; // Assuming you store the account number in a session after login
$sql = "SELECT account_holder_name, account_number, bank_name, ifsc_code, balance FROM users WHERE account_number = $account_number";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $account_holder_name = $row['account_holder_name'];
    $account_number = $row['account_number'];
    $bank_name = $row['bank_name'];
    $ifsc_code = $row['ifsc_code'];
    $balance = $row['balance'];

    // Display the account details
    echo "<h2>Account Details</h2>";
    echo "<p><strong>Account Holder's Name:</strong> $account_holder_name</p>";
    echo "<p><strong>Account Number:</strong> $account_number</p>";
    echo "<p><strong>Bank Name:</strong> $bank_name</p>";
    echo "<p><strong>IFSC Code:</strong> $ifsc_code</p>";
    echo "<p><strong>Balance:</strong> $balance</p>";
} else {
    echo "<p>No account details found.</p>";
}
?>
