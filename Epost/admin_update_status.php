<?php
require 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update transaction status
function updateTransactionStatus($conn, $transaction_id, $status) {
    $query = "UPDATE transactions SET status = '$status' WHERE transaction_id = '$transaction_id'";
    mysqli_query($conn, $query);
}

if (isset($_GET["transaction_id"]) && isset($_GET["status"])) {
    $transaction_id = $_GET["transaction_id"];
    $status = $_GET["status"];

    
    // Check if the status is either "Success" or "Failed"
    if ($status === "Success" || $status === "Failed") {
        updateTransactionStatus($conn, $transaction_id, $status);
    }
}

header("Location: admin_bank_track.php");
exit();
?>
