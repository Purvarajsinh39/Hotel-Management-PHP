<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="img/mainicon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("img/bg2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            /* backdrop-filter: blur(5px);  */
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* More defined shadow for depth */
            width: 350px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.05); /* Subtle zoom on hover */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        .input-box {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-box label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #34495e;
        }

        .input-box input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }

        .input-box input:focus {
            border-color: #3498db; /* Blue border on focus */
            outline: none;
        }

        .button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #3498db, #2ecc71); /* Gradient background */
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .button:hover {
            background: linear-gradient(45deg, #2ecc71, #3498db); /* Invert gradient on hover */
            transform: translateY(-2px); /* Slight upward movement on hover */
        }

        .new_account {
            display: inline-block;
            margin-top: 10px;
            font-size: small;
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s ease;
        }

        .new_account:hover {
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>User - Login</h2>
        <form action="" method="POST">
            <div class="input-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <br><br><a href="new_account.php" class="new_account">Don't Have Any Account?</a><br>
            </div>
            <input type="submit" value="Login" name="submit" class="button">
        </form>
    </div>

    <?php
    session_start(); // Start session

    $host = "localhost";  
    $user = "root";  
    $password = '';  
    $db_name = "hotel_management";  
    $con = mysqli_connect($host, $user, $password, $db_name);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to check the user
        $query = "SELECT * FROM user_login WHERE username = ? AND password = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $_SESSION['username'] = $username; // Store the username in session
            header("Location: home.php"); // Redirect to dashboard
        } else {
            echo "Invalid credentials";
        }
    }
    ?>
</body>
</html>
