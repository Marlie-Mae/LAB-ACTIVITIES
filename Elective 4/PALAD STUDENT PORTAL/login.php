<?php
session_start();
include("cn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve and sanitize user inputs
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $account_type = mysqli_real_escape_string($connection, $_POST['account_type']);
    $hashed_password = md5($password); // Note: Consider using password_hash for better security

    // Query the database for the user with matching credentials and role
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$user_id' AND password = '$hashed_password' AND role = '$account_type' LIMIT 1");

    if (mysqli_num_rows($query) == 1) {
        // Successful login: fetch user details
        $row = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $row['username'];
        $_SESSION['role'] = $row['role'];  // Use for access control

        // Redirect based on role:
        if ($row['role'] == 'User') {
            header("Location: profile.php"); // Redirect for normal users
            exit();
        } else {  // Admin or any other role
            header("Location: home.php"); // Redirect for admins
            exit();
        }
    } else {
        // Invalid login credentials or role mismatch
        $error = "Invalid User ID, Password, or Account Type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AU User Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Poppins', sans-serif; 
        }
        body { 
            background: skyblue;
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            overflow: hidden;
        }
        .wrapper {
            display: flex;
            width: 90%;
            max-width: 985px;
            height: 50%; /* Adjusted for shorter height */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }
        .left-section {
            flex: 1;
            background: #2C3E50; /* Dark background for contrast */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .left-section img {
            width: 100%;
            height: auto; 
            object-fit: contain;
        }
        .login-section {
            flex: 1;
            background: rgba(255, 255, 255, 1); 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        h2 { 
            margin-bottom: 20px; 
            font-size: 1.8rem; 
            color: #333; 
        }
        .input-group { 
            text-align: left; 
            margin-bottom: 15px; 
        }
        .input-group label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 5px; 
            font-size: 1rem; 
        }
        .input-group input, .input-group select { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 8px; 
            font-size: 1rem; 
        }
        .btn-submit { 
            width: 100%; 
            background: #5C9EA8; 
            color: white; 
            border: none; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 1.1rem; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .btn-submit:hover { 
            background: #4682B4; 
        }
        .error { 
            color: red; 
            margin-top: 10px; 
            font-size: 1rem; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Left Section -->
        <div class="left-section">
            <img src="images/aulogo.png" alt="AU Logo">
        </div>
        <!-- Login Section -->
        <div class="login-section">
            <div class="container">
                <h2>Login</h2>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                <form method="post">
                    <div class="input-group">
                        <label for="user_id">User ID</label>
                        <input type="text" name="user_id" id="user_id" placeholder="User ID" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <label for="account_type">Account Type</label>
                        <select name="account_type" id="account_type" required>
                            <option value="" disabled selected>Account Type</option>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
