<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit();
}

$user_id = $_POST["user_id"];
$new_password = $_POST["new_password"];

// Hash the new password using MD5
$hashed_password = md5($new_password);

// Update the user's password in the database
$sql = "UPDATE tbl_users SET password=? WHERE user_id=?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $hashed_password, $user_id);

if ($stmt->execute()) {
    echo "Password changed successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
