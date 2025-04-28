<?php
include("cn.php");
session_start();
if (isset($_SESSION['student_no'])) {
    header("location: student-home.php");
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
        header("location: student-home.php");
        exit();
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
    <title>AU Student Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <link type="image/png" rel="icon" href="images/au_logo.png">
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
            height: 50%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }
        .left-section {
            flex: 1;
            background: #2C3E50;
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
        .input-group input { 
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
        .subtitle {
            margin-bottom: 20px;
            color: #555;
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
                <h2>Student Login</h2>
                <p class="subtitle">Please enter your credentials to continue.</p>

                <?php if (isset($display)) echo "<p class='error'>$display</p>"; ?>

                <form method="POST">
                    <div class="input-group">
                        <label for="student_no">Student No.</label>
                        <input type="text" name="student_no" id="student_no" placeholder="Enter Student No." required>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password" required>
                    </div>

                    <button type="submit" class="btn-submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
