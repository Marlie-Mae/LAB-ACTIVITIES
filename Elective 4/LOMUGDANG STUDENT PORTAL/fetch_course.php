<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["course_code"]) || empty($_POST["course_code"])) {
    echo json_encode(["error" => "Course code is required!"]);
    exit();
}

$course_code = mysqli_real_escape_string($connection, $_POST["course_code"]); // Prevent SQL Injection
$query = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code='$course_code'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No course found."]);
    exit();
}

echo json_encode($data);
?>
