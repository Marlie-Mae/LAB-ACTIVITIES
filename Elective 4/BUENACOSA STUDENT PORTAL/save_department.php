<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit();
}

$department_code = $_POST["department_code"];
$department_name = $_POST["department_name"];
$edit_mode = isset($_POST["edit_mode"]) && $_POST["edit_mode"] === "true";

if ($edit_mode) {
    // Update existing department
    $sql = "UPDATE tbl_department SET department_name=? WHERE department_code=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $department_name, $department_code);
} else {
    // Check if the department code already exists
    $check_stmt = $connection->prepare("SELECT department_code FROM tbl_department WHERE department_code = ?");
    $check_stmt->bind_param("s", $department_code);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Error: Department code already exists!";
        exit();
    }

    // Insert new department
    $sql = "INSERT INTO tbl_department (department_code, department_name) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $department_code, $department_name);
}

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
