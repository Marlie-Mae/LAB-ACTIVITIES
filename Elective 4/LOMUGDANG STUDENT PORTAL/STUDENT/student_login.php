<?php
session_start();
include("cn.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_no = $_POST['student_no'];
    $password = trim($_POST['password']);
    $query = "SELECT student_no, password FROM tbl_student_info WHERE student_no = ?";
    $stmt = $connection->prepare($query);
    
    if (!$stmt) {
        die("Database error: " . $connection->error);
    }

    $stmt->bind_param("s", $student_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($row['password'] === md5($password)) {
            $_SESSION['student_no'] = $student_no;
            header("Location: profile.php?");
            exit();
        } else {
            $_SESSION['error'] = "Invalid Student Number or Password.";
        }
    } else {
        $_SESSION['error'] = "Invalid Student Number or Password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #A6D6D6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #ffdddd;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        .error {
            background: #ffdddd;
            color: #d8000c;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: lightpink;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #8E7DBE;
        }
    </style>
</head>
<body>
    <form action="student_login.php" method="POST">
        <h2>Login</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']); // Remove error after displaying
        }
        ?>
        <input type="text" name="student_no" placeholder="Student Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="LOGIN">
    </form>
</body>
</html>
