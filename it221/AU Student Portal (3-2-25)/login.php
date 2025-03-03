<?php
include("cn.php");
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($connection, "SELECT account_type FROM tbl_users WHERE user_id = '$user_id'");
    $result = mysqli_fetch_assoc($query);
    
    if ($result) {
        header("location: " . ($result['account_type'] == "admin" ? "admin-profile.php" : "users-profile.php"));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $account_type = mysqli_real_escape_string($connection, $_POST['account_type']);

    $hashed_password = md5($password);

    $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id' AND password = '$hashed_password' AND account_type = '$account_type'");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        if ($row['status'] != "active") {
            $display = "Your account is inactive. Please contact the administrator.";
        } else {
            $_SESSION['user_id'] = $user_id;
            header("location: " . ($account_type == "admin" ? "admin-profile.php" : "users-profile.php"));
            exit();
        }
    } else {
        $display = "Invalid credentials. Please check your User ID, Password, and Account Type.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arellano University | Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <img src="images/au_logo.png" alt="Arellano University Logo" class="logo">
        <h2>Login</h2>
        <p class="subtitle">Please enter your credentials to continue.</p>

        <?php if (isset($display)) { echo "<p class='error-message'>$display</p>"; } ?>

        <form action="" method="POST">
            <div class="input-group">
                <input type="text" name="user_id" placeholder="User ID" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <select name="account_type" required>
                    <option value="" disabled selected>Account Type</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
</div>

</body>
</html>
