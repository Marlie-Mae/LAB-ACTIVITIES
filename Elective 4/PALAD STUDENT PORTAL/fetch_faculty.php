<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: faculty.php");
    exit();
}

if (isset($_POST["faculty_code"])) {
    $faculty_code = $_POST["faculty_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code='$faculty_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
