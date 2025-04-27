<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit();
}

$student_no = $_POST["student_no"];
$new_password = $_POST["new_password"];

// Hash the new password using MD5
$hashed_password = md5($new_password);

// Update the user's password in the database
$sql = "UPDATE tbl_student_info SET password=? WHERE student_no=?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $hashed_password, $student_no);

if ($stmt->execute()) {
    echo "Password changed successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
