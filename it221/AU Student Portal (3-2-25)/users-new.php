<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);
        $account_type = mysqli_real_escape_string($connection, $_POST['account_type']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $check_users = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id'");
        $rows = mysqli_num_rows($check_users);
        if ($rows == 1) {
            $display = "<div class='message error'>User ID already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_users VALUES ('$user_id', '$hashed_password', '$account_type', '$status')");
            $display = "<div class='message success'>Record was saved successfully.</div>";
        } 
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>Add Users</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New User</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>

            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" placeholder="User ID" required> <br>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required> <br>

            <label for="account_type">Account Type:</label>
            <select name="account_type" required>
                <option value="" disabled selected>Select Account Type</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select> <br>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="" disabled selected>Select Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select> <br>
            
            <input type="submit" name="" value="Insert">
            <a href="users.php" class="back-btn">Back</a>
        </form>
    </body>
</html>
