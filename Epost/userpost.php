<?php
//responsible for establishing a connection to the database 
require_once 'config.php';
//selecting the SQL tanle
$sql = "SELECT * FROM tracking_data";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Data and Generate Tracking ID</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    margin: 50px auto;
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


    /* Dashboard Styles */
        /* Dashboard Styles */
        .dashboard {
  display: flex;
}

.dashboard-menu {
  width: 200px;
  background-color: #f5f5f5;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.dashboard-menu ul {
  list-style: none;
  padding: 0;
}

.dashboard-menu li {
  margin-bottom: 10px;
}

.dashboard-menu a {
  text-decoration: none;
  color: #333;
  display: block;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s, color 0.3s;
  font-size: 16px;
}

.dashboard-menu a:hover {
  background-color: #4CAF50;
  color: #fff;
}

.dashboard-menu a.active {
  background-color: #ff5722;
  color: #fff;
}

.dashboard-content {
  flex: 1;
  padding: 20px;
}

.dashboard-content h1 {
  margin-bottom: 20px;
}

.dashboard-content p {
  font-size: 18px;
  line-height: 1.6;
}

/* Optional: Center the content within the dashboard */
.dashboard-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}


    </style>
</head>
<body>
     <!-- Dashboard -->
  <div class="dashboard">
    <!-- Dashboard Menu -->
    <div class="dashboard-menu">
      <ul>
        <li><a href="userpost.php">Post</a></li>
        <li><a href="user_bank_dashboard.php">Money Transfer</a></li>
        <li><a href="track.php">Tracking</a></li>
      </ul>
      <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h1>Post Data and Generate Tracking ID</h1>
        <form action="userpost.php" method="post" enctype="multipart/form-data">
            <label for="s_name">Sender's Name:</label>
            <input type="text" id="s_name" name="s_name" required>

            <label for="from_address">From Address:</label>
            <input type="text" id="from_address" name="from_address" required>

            <label for="r_name">Receiver's Name:</label>
            <input type="text" id="r_name" name="r_name" required>

            <label for="to_address">To Address:</label>
            <input type="text" id="to_address" name="to_address" required>

            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" required>

            <label for="postal_code">Zip/Postal code:</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="present_date">Present Date:</label>
            <input type="date" id="present_date" name="present_date" required>

            <label for="document">Attach Document:</label>
            <input type="file" id="document" name="document" accept=".pdf, .doc, .docx" required>

            <button type="submit" name="submit">Post</button>
        </form>
 

    <?php
    //Extracting the data from the below HTML form 
if (isset($_POST['submit']) && !isset($_SESSION['data_displayed'])) {
  $s_name = $_POST['s_name'];
  $from_address = $_POST['from_address'];
  $r_name = $_POST['r_name'];
  $to_address = $_POST['to_address'];
  $mobile_number = $_POST['mobile_number'];
  $postal_code = $_POST['postal_code'];
  $present_date = $_POST['present_date'];
  $document_name = $_FILES['document']['name'];

  // Generate tracking ID
  $tracking_id = "TR-" . time() . "-" . mt_rand(1000, 9999);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Insert the data into the database
  $sql = "INSERT INTO tracking_data (sender_name, from_address, receiver_name, to_address, mobile_number, postal_code, present_date, document_name, tracking_id)
          VALUES ('$s_name', '$from_address', '$r_name', '$to_address', '$mobile_number', '$postal_code', '$present_date', '$document_name', '$tracking_id')";

  if (mysqli_query($conn, $sql)) {
      // Data inserted successfully
      mysqli_close($conn);
      $_SESSION['data_displayed'] = true; // Set session variable to indicate data displayed
      echo "<h2>Data Submitted Successfully:</h2>";
      echo "<p><strong>Sender's Name:</strong> $s_name</p>";
      echo "<p><strong>From Address:</strong> $from_address</p>";
      echo "<p><strong>Receiver's Name:</strong> $r_name</p>";
      echo "<p><strong>To Address:</strong> $to_address</p>";
      echo "<p><strong>Mobile Number:</strong> $mobile_number</p>";
      echo "<p><strong>Zip / Postal Code:</strong> $postal_code</p>";
      echo "<p><strong>Present Date:</strong> $present_date</p>";
      echo "<p><strong>Document Name:</strong> $document_name</p>";
      echo "<p><strong>Tracking ID:</strong> $tracking_id</p>";
  } else {
      // Error occurred while inserting data
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  $_SESSION['data_displayed'] = true;
}

// Clear the session variable when the page is reloaded
unset($_SESSION['data_displayed']);
?>

</div>
<script>
        // Clear form data on page reload
        window.onload = function() {
            var form = document.querySelector('form');
            form.reset();
        };
    </script>

</body>
</html>
