<?php
    include("cn.php");
    session_start();
    if (isset($_SESSION['student_no'])) {
        header("location: student_profile.php");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);
        $validate = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no' AND password = '$hashed_password'");
        $rows = mysqli_num_rows($validate);
        if ($rows == 1) {
            $_SESSION['student_no'] = $student_no;
            header("location: student_profile.php");
        } else {
            $display = "Invalid Student No. or Password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhilTech Student Login</title>
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
                <label for="student_no">Student No.</label>
                <input type="text" name="student_no" placeholder="Enter Student No." required>
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
