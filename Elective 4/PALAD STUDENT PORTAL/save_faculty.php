<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: faculty.php");
    exit();
}

$faculty_code = mysqli_real_escape_string($connection, $_POST["faculty_code"]);
$faculty_name = mysqli_real_escape_string($connection, $_POST["faculty_name"]);
$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]);

$check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
$rows = mysqli_num_rows($check_faculty);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_faculty (faculty_code, faculty_name, department_code) 
            VALUES ('$faculty_code', '$faculty_name','$department_code')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_faculty SET 
            faculty_code='$faculty_code', faculty_name='$faculty_name', department_code='$department_code' WHERE faculty_code='$faculty_code'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
