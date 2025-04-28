<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: students.php");
    exit();
}

$student_no = mysqli_real_escape_string($connection, $_POST["student_no"]);
$last_name = mysqli_real_escape_string($connection, $_POST["last_name"]);
$first_name = mysqli_real_escape_string($connection, $_POST["first_name"]);
$middle_name = mysqli_real_escape_string($connection, $_POST["middle_name"]);
$course_code = mysqli_real_escape_string($connection, $_POST["course_code"]);
$year_level = mysqli_real_escape_string($connection, $_POST["year_level"]);
$password = mysqli_real_escape_string($connection, $_POST['password']);
$hashed_password = md5($password);

$check_student = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
$rows = mysqli_num_rows($check_student);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_student_info (student_no, last_name, first_name, middle_name, course_code, year_level, password) 
            VALUES ('$student_no', '$last_name', '$first_name', '$middle_name', '$course_code', '$year_level', '$hashed_password')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_student_info SET 
            last_name='$last_name', first_name='$first_name', middle_name='$middle_name', 
            course_code='$course_code', year_level='$year_level', password='$password' WHERE student_no='$student_no'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
