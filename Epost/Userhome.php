<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard - E-post</title>
    <style>

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

/*Center the content within the dashboard */
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

    <!-- Dashboard Content -->
    <div class="dashboard-content">
      <h1>Welcome to E-Post Dashboard</h1>
    </div>
  </div>
</body>
</html>
