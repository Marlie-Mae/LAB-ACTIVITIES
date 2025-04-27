<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["faculty_code"]) || empty($_POST["faculty_code"])) {
    echo json_encode(["error" => "Faculty code is required!"]);
    exit();
}

$faculty_code = mysqli_real_escape_string($connection, $_POST["faculty_code"]); // Prevent SQL Injection

$query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");

if (!$query) {
    // Improved error handling: Displaying error message for debugging
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No faculty found with the provided code."]);
    exit();
}

// Return the fetched data as JSON
echo json_encode($data);
?>
