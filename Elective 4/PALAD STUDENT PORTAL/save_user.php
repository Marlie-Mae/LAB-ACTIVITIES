<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: user.php");
    exit();
}

$user_id = mysqli_real_escape_string($connection, $_POST["user_id"]);
$password = mysqli_real_escape_string($connection, $_POST['password']);
$hashed_password = md5($password);
$account_type = mysqli_real_escape_string($connection, $_POST["account_type"]);
$status= mysqli_real_escape_string($connection, $_POST["status"]);

$check_user = mysqli_query($connection, "SELECT * FROM tbl_user WHERE user_id = '$user_id'");
$rows = mysqli_num_rows($check_user);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_user (user_id, password, account_type, status) 
            VALUES ('$user_id', '$hashed_password', '$account_type', '$status')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_user SET 
            user_id='$user_id', password='$password', account_type='$account_type', status='$status' WHERE user_id='$user_id'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
