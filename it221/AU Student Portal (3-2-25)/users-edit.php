<?php
    include("cn.php");
    if (isset($_GET['user_id'])) {
        $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "User ID not found";
        }
    } else {
        header("location: users.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
        $account_type = mysqli_real_escape_string($connection, $_POST['account_type']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $check_users = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id'");
        $rows = mysqli_num_rows($check_users);
        if ($rows == 1) {
            $sql = "UPDATE tbl_users SET account_type = '$account_type', status = '$status' WHERE user_id = '$user_id'";
            if (mysqli_query($connection,$sql)) {
                header("location: users.php");
            } else {
                $display = "Failed to update records.";
            }
        } else {
            $display = "User ID not found.";
        }
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>Edit Users</title>
    </head>
    <body>
        <?php if(isset($status)) {echo $status; } ?>
        <?php if(isset($display)) {echo $display; } ?>
        <form action="" method="POST">
            <h1>Edit Users</h1>

            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" placeholder="User ID" required value="<?php if(isset($user_id)) { echo $user_id;} ?>"> <br>
            
            <label for="account_type">Account Type:</label>
            <select name="account_type" required>
                <option value="" disabled selected>Select Account Type</option>
                <option value="admin" <?php echo (isset($data['account_type']) && $data['account_type'] == "admin") ? "selected" : ""; ?>>Admin</option>
                <option value="user" <?php echo (isset($data['account_type']) && $data['account_type'] == "user") ? "selected" : ""; ?>>User</option>
            </select> 
            <br>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="" disabled selected>Select Status</option>
                <option value="active" <?php echo (isset($data['status']) && $data['status'] == "active") ? "selected" : ""; ?>>Active</option>
                <option value="inactive" <?php echo (isset($data['status']) && $data['status'] == "inactive") ? "selected" : ""; ?>>Inactive</option>
            </select> 
            <br>

            <input type="submit" name="" value="Update">
            <a href="users.php" class="back-btn">Back</a>
        </form>
    </body>
</html>