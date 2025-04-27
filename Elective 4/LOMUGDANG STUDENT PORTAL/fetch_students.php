<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["student_no"]) || empty($_POST["student_no"])) {
    echo json_encode(["error" => "Student number is required!"]);
    exit();
}

$student_no = mysqli_real_escape_string($connection, $_POST["student_no"]); // Prevent SQL Injection
$query = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no='$student_no'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No student found."]);
    exit();
}

echo json_encode($data);
?>
