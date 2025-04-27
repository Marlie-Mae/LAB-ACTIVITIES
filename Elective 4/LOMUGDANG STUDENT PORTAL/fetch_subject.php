<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["subject_code"]) || empty($_POST["subject_code"])) {
    echo json_encode(["error" => "Subject code is required!"]);
    exit();
}

$subject_code = mysqli_real_escape_string($connection, $_POST["subject_code"]); // Prevent SQL Injection
$query = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code='$subject_code'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No subject found."]);
    exit();
}

echo json_encode($data);
?>
