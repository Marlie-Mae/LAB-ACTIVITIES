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
    <title>Login</title>
</head>
<body>
    <?php
        if(isset($display)) {
            echo $display;
        }
    ?>
    <form action="" method="POST">
        <input type="text" name="student_no" required> <br>
        <input type="password" name="password" required> <br>
        <input type="submit" name="login" value="LOGIN">
    </form>
</body>
</html>