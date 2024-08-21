<?php
    // Include the database connection
    require_once "config.php";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // Additional server-side validation can be added here
    
        // You should hash the passwords in a real-world scenario for security.
        // This example uses plain text passwords, which is not recommended.
    
        // Replace 'users' with your table name where user registrations will be stored.
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    
        if (mysqli_query($conn, $query)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>