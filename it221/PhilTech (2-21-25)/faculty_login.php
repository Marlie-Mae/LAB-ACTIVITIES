<?php
    include("cn.php");
    session_start();
    if (isset($_SESSION['faculty_code'])) {
        header("location: faculty_profile.php");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);
        $validate = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code' AND password = '$hashed_password'");
        $rows = mysqli_num_rows($validate);
        if ($rows == 1) {
            $_SESSION['faculty_code'] = $faculty_code;
            header("location: faculty_profile.php");
        } else {
            $display = "Invalid Faculty ID or Password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhilTech Faculty Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <img src="images/philtech_logo.png" alt="PhilTech Logo" class="logo">
        <h2>Hi, Technovators!</h2>
        <p class="subtitle">Please enter your credentials to continue.</p>

        <?php if (isset($display)) { echo "<p class='error-message'>$display</p>"; } ?>

        <form action="" method="POST">
            <div class="input-group">
                <label for="faculty_code">Faculty Code</label>
                <input type="text" name="faculty_code" placeholder="Enter Faculty Code" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>

        <p class="terms">By using this service, you agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>
    </div>
</div>

</body>
</html>
