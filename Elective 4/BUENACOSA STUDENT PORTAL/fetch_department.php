<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["department_code"]) || empty($_POST["department_code"])) {
    echo json_encode(["error" => "Department code is required!"]);
    exit();
}

$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]); // Prevent SQL Injection
$query = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code='$department_code'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No department found."]);
    exit();
}

echo json_encode($data);
?>
