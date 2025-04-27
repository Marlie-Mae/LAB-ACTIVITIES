<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit();
}

if (!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
    echo json_encode(["error" => "User ID is required!"]);
    exit();
}

$user_id = mysqli_real_escape_string($connection, $_POST["user_id"]); 
$query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id='$user_id'");

if (!$query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($connection)]);
    exit();
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo json_encode(["error" => "No user found."]);
    exit();
}

echo json_encode($data);
?>
