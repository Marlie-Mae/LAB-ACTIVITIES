<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: course.php");
    exit();
}

$course_code = mysqli_real_escape_string($connection, $_POST["course_code"]);
$course_description = mysqli_real_escape_string($connection, $_POST["course_description"]);

$check_course = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
$rows = mysqli_num_rows($check_course);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_course (course_code, course_description) 
            VALUES ('$course_code', '$course_description')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_course SET 
            course_code='$course_code', course_description='$course_description' WHERE course_code='$course_code'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
