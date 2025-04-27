<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit();
}

$user_id = $_POST["user_id"];
$password = isset($_POST["password"]) ? $_POST["password"] : null;
$account_type = $_POST["account_type"];
$status = $_POST["status"];
$edit_mode = isset($_POST["edit_mode"]) && $_POST["edit_mode"] === "true";

if ($edit_mode) {
    // Update existing user
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = md5($password);
        $sql = "UPDATE tbl_users SET password=?, account_type=?, status=? WHERE user_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $hashed_password, $account_type, $status, $user_id);
    } else {
        // Update without changing password
        $sql = "UPDATE tbl_users SET account_type=?, status=? WHERE user_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $account_type, $status, $user_id);
    }
} else {
    // Check if the user ID already exists
    $check_stmt = $connection->prepare("SELECT user_id FROM tbl_users WHERE user_id = ?");
    $check_stmt->bind_param("s", $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Error: User ID already exists!";
        exit();
    }

    // Insert new user with hashed password
    $hashed_password = md5($password);
    $sql = "INSERT INTO tbl_users (user_id, password, account_type, status) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss", $user_id, $hashed_password, $account_type, $status);
}

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
