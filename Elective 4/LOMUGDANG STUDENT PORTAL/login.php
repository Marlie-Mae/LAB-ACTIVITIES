<?php 
include("cn.php"); 
session_start(); 

$display = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") { 
    $user_id = trim($_POST['user_id']); 
    $password = md5(trim($_POST['password']));

    $stmt = $connection->prepare("SELECT user_id, account_type, status, password FROM tbl_users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();


        if ($password === $row['password']) {  
            if (strtolower($row['status']) !== 'active') {
                $display = "Your account is INACTIVE. Please contact the administrator.";
            } else {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['account_type'] = strtolower($row['account_type']);

                if ($row['account_type'] === "Admin") {
    header("Location: user.php");
} elseif ($row['account_type'] === "User") {
    header("Location: USER/users.php");
}
exit();

            }
        } else {
            $display = "Invalid User ID or Password!";
        }
    } else {
        $display = "Invalid User ID or Password!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #A6D6D6 ;
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
    <form action="" method="POST">
        <?php if (!empty($display)) { ?>
            <div class="error"><?php echo $display; ?></div>
        <?php } ?>
        <input type="text" placeholder="User ID" name="user_id" required><br>
        <input type="password" placeholder="Password" name="password" required><br><br>
        <input type="submit" name="login" value="LOGIN">
    </form>
</body>
</html>
