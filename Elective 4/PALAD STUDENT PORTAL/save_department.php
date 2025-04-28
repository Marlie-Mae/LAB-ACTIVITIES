<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: department.php");
    exit();
}

$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]);
$department_name = mysqli_real_escape_string($connection, $_POST["department_name"]);

$check_department = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
$rows = mysqli_num_rows($check_department);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_department (department_code, department_name) 
            VALUES ('$department_code', '$department_name')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_department SET 
            department_code='$department_code', department_name='$department_name' WHERE department_code='$department_code'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
