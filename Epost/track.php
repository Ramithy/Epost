<?php
//responsible for establishing a connection to the database 
require 'config.php';
// Check if the user has clicked the "Check" button
if (isset($_POST['check']) && !empty($_POST['tracking_id'])) {
    $tracking_id = $_POST['tracking_id'];

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch data from the database for the given tracking_id
    $sql = "SELECT * FROM tracking_data WHERE tracking_id = '$tracking_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Store the data in session variables
        $_SESSION['tracking_data'] = $row;
    } else {
        // If no data found, clear the session variable
        unset($_SESSION['tracking_data']);
    }

    mysqli_close($conn);

    // Redirect back to the same page after processing the form
    header("Location: track.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    max-width: 500px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

h1 {
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label, input {
    margin-bottom: 10px;
}

button {
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <!--------Tracking form----------->
    <div class="container">
        <h1>Tracking Page</h1>
        <form action="track.php" method="post">
            <label for="tracking_id">Enter Tracking ID:</label>
            <input type="text" id="tracking_id" name="tracking_id" required>
            <button type="submit" name="check">Check</button>
        </form>
        <form action="Userhome.php" method="post">
        <button type="submit" name="check">Back to dashboard</button>
        </form>
        <?php
    // Check if there's data in the session variable
    if (isset($_SESSION['tracking_data'])) {
        $data = $_SESSION['tracking_data'];
        ?>
        <h2>Tracking Details</h2>
        <p><strong>Tracking ID:</strong> <?php echo $data['tracking_id']; ?></p>
        <p><strong>Sender's Name:</strong> <?php echo $data['sender_name']; ?></p>
        <p><strong>From Address:</strong> <?php echo $data['from_address']; ?></p>
        <p><strong>Receiver's Name:</strong> <?php echo $data['receiver_name']; ?></p>
        <p><strong>To Address:</strong> <?php echo $data['to_address']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $data['mobile_number']; ?></p>
        <p><strong>Zip/Postal Code:</strong> <?php echo $data['postal_code']; ?></p>
        <p><strong>Sent Date:</strong> <?php echo $data['present_date']; ?></p>         
        <p><strong>Status:</strong> <?php echo $data['status']; ?></p>
        <?php
        // Clear the session variable after displaying the data
        unset($_SESSION['tracking_data']);
    }
    ?>
    </div>
</body>
</html>
