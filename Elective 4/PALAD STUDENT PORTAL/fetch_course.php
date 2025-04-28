<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: course.php");
    exit();
}

if (isset($_POST["course_code"])) {
    $course_code = $_POST["course_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code='$course_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
