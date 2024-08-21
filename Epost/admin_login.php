<?php
session_start();

// Replace the following credentials with your actual admin username and password
$admin_username = 'admin';
$admin_password = 'admin123';
//Extracting the data from the below HTML form
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // If Checking The data From the above $admin_username,$admin_password 
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;  // If true redirect To Admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password."; // If User Name or Password inncorrect send a error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /*-----Style for Body-------*/
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            align-items: center;
            height: 100vh;
        }

                /*----------------- Header---------*/
                header{
                    height: 80px;
                    background: black;
                    width: 100%;
                    position: relative;
                    z-index: 15;
                    height: 130px;
                }
                nav{
                    display: flex;
                    width: 100%;
                    padding: 5px 0;
                    align-items: center;
                    flex-wrap: wrap;
                    font-weight: bold;
                }
                .logo{
                    width: 155px;
                    cursor: pointer;
                    margin-left: 20px;
                    margin-top: 10px;
                }
                nav ul{
                    flex: 1;
                    text-align: right;
                    padding-right: 30px;
                }
                nav ul li{
                    list-style: none;
                    display: inline-block;
                    margin: 10px 30px;
                }
                nav ul li a{
                    color: #fff;
                    text-decoration: none;
                    position: relative;
                }
                nav ul li a::after{
                    content: '';
                    width: 0;
                    height: 3px;
                    position: absolute;
                    bottom: -5px;
                    left: 50%;
                    background: red;
                    transform: translateX(-50%);
                    transition: width 0.3s;
                }
                nav ul li a:hover::after{
                    width: 50%;
                }

        /*Style for Admin Box/Container*/
        .form-container {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            margin: auto;
            margin-top: 150px;
        }
        /*-------User Admin Login headline---------- */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #66afe9;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: #f00;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>    
    </style>
</head>
<body>
    <!-------------------Header------------------>
    <section class="container">
            <header>
            <nav>
               <a href="Home.html"><img src="epost_logo.png"  class="logo"></a>
                  <ul>
                     <li><a href="Home.html">Home</a></li>
                     <li><a href="user_login.php">Login</a></li>
                     <li><a href="admin_login.php">Admin Login</a></li>
                  </ul>
            </nav>
            </header>           
         </section>


      <!-------------------Adminn Login------------------>  
    <div class="form-container">
        <h1>Admin Login</h1>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>

            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
