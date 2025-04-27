<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["school_year_code"]) || empty($_POST["school_year_code"])) {
    echo json_encode(["error" => "School year code is required!"]);
    exit();
}

$school_year_code = mysqli_real_escape_string($connection, $_POST["school_year_code"]); // Prevent SQL Injection
$query = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code='$school_year_code'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No school year found."]);
    exit();
}

echo json_encode($data);
?>
