<?php
    include("cn.php");
    session_start();
    if (isset($_SESSION['student_no'])) {
        header("location: profile.php");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);
        $validate = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no' AND password = '$hashed_password'");
        $rows = mysqli_num_rows($validate);
        if ($rows == 1) {
            session_start();
            $_SESSION['student_no'] = $student_no;
            header("location: profile.php");
        } else {
            $display = "Invalid Student No. or Password.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body>
    <!--
    <?php
            if(isset($display)) {
                echo "<p class='error-message'>$display</p>";
            }
    ?>
    -->
    <form action="" method="POST">
        <h1>Login Student</h1>

        <?php
            if(isset($display)) {
                echo "<p class='error-message'>$display</p>";
            }
        ?>

        <label for="student_no">Student No.</label>
        <input type="text" name="student_no" placeholder="Student no" required> <br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" required> <br>
        <input type="submit" name="login" value="LOGIN">
    </form>
</body>
</html>
