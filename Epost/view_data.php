<?php
// view_data.php
require_once 'config.php';

if (isset($_GET['tracking_id'])) {
    $tracking_id = $_GET['tracking_id'];

    // Retrieve data from the database based on the tracking ID
    $sql = "SELECT * FROM tracking_data WHERE tracking_id='$tracking_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>View Data</h1>
    <?php if (isset($row)): ?>
        <h2>Tracking ID: <?php echo $row['tracking_id']; ?></h2>
        <p>Name: <?php echo $row['name']; ?></p>
        <p>From Address: <?php echo $row['from_address']; ?></p>
        <p>To Address: <?php echo $row['to_address']; ?></p>
        <p>Town/City: <?php echo $row['town_city']; ?></p>
        <p>State: <?php echo $row['state']; ?></p>
        <p>Status: <?php echo $row['status']; ?></p>
    <?php else: ?>
        <p>Invalid tracking ID</p>
    <?php endif; ?>
</body>
</html>
