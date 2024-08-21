<?php
session_start();
// Function to fetch all tracking data from the database
function getAllTrackingData() {
      //responsible for establishing a connection to the database 
      require 'config.php';
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch all data from the database
    $sql = "SELECT * FROM tracking_data";
    $result = $conn->query($sql);

    // Store the data in an array
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    mysqli_close($conn);
    return $data;
}

// Function to update the status for a specific tracking ID
function updateStatus($tracking_id, $status) {
    //responsible for establishing a connection to the database 
    require 'config.php';

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update the status in the database for the given tracking ID
    $sql = "UPDATE tracking_data SET status = '$status' WHERE tracking_id = '$tracking_id'";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $result;
}

// Function to delete a specific tracking ID from the database
function deleteTrackingData($tracking_id) {
    //responsible for establishing a connection to the database 
    require 'config.php';

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Delete the data from the database for the given tracking ID
    $sql = "DELETE FROM tracking_data WHERE tracking_id = '$tracking_id'";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $result;
}

// Check if the admin is logged in (you can implement actual login logic here)
$adminLoggedIn = true;

// If not logged in, redirect to the login page or take appropriate action
if (!$adminLoggedIn) {
    header("Location: login.php");
    exit();
}

// If the form is submitted to update the status
if (isset($_POST['update_status'])) {
    $tracking_id = $_POST['tracking_id'];
    $status = $_POST['status'];

    // Update the status in the database
    updateStatus($tracking_id, $status);
}

// If the form is submitted to delete a record
if (isset($_POST['delete'])) {
    $tracking_id = $_POST['tracking_id'];

    // Delete the data from the database
    deleteTrackingData($tracking_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tracking Page</title>
    <style>
        body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.container {
  max-width: 100%;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

table th,
table td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ccc;
}

table th {
  background-color: #f5f5f5;
}

table td form {
  display: inline-block;
}

table td select {
  padding: 5px;
}

/* Update button */
table td button[name="update_status"] {
  padding: 5px 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* Update button hover effect */
table td button[name="update_status"]:hover {
  background-color: #45a049;
}

/* Delete button */
table td button[name="delete"] {
  padding: 5px 10px;
  background-color: #ff0000;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* Delete button hover effect */
table td button[name="delete"]:hover {
  background-color: #e53935;
}

p {
  text-align: center;
}

/* Back to Dashboard */
button[name="back"] {
  padding: 8px 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 45%;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Tracking Page</h1>

        <?php
        // Display the tracking data in a table
        $trackingData = getAllTrackingData();

        if (!empty($trackingData)) {
            ?>
            <table>
                <tr>
                    <th>Tracking ID</th>
                    <th>Sent Date</th>
                    <th>Sender's Name</th>
                    <th>From Address</th>
                    <th>Receiver's Name</th>
                    <th>To Address</th>
                    <th>Mobile Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
                <?php foreach ($trackingData as $data) { ?>
                    <!-----Display the data from the database------>
                    <tr>
                        <td><?php echo $data['tracking_id']; ?></td>
                        <td><?php echo $data['present_date']; ?></td>
                        <td><?php echo $data['sender_name']; ?></td>
                        <td><?php echo $data['from_address']; ?></td>
                        <td><?php echo $data['receiver_name']; ?></td>
                        <td><?php echo $data['to_address']; ?></td>
                        <td><?php echo $data['mobile_number']; ?></td>
                        <td><?php echo $data['postal_code']; ?></td>
                        <td>
                            <!-----Status Upadation from ------>
                            <form action="admin_track.php" method="post">
                                <input type="hidden" name="tracking_id" value="<?php echo $data['tracking_id']; ?>">
                                <select name="status">
                                    <option value="On Going" <?php if ($data['status'] === 'On Going') echo 'selected'; ?>>On Going</option>
                                    <option value="Delivered" <?php if ($data['status'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Returned" <?php if ($data['status'] === 'Returned') echo 'selected'; ?>>Returned</option>
                                </select>
                                <button type="submit" name="update_status">Update</button>
                            </form>
                        </td>
                        <td>
                          <!-----Delete the Data from the data base from------>
                            <form action="admin_track.php" method="post">
                                <input type="hidden" name="tracking_id" value="<?php echo $data['tracking_id']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "<p>No tracking data available.</p>";
        }
        ?>
    </div>
    <br><br>
    <!-----Back for Admin Bashboard Form------>
    <form action="admin_dashboard.php" method="post">
         <button type="submit" name="back">Back to Dashboard</button>
    </form>
</body>
</html>
