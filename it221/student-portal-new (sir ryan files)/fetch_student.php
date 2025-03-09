<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: students.php");
    exit();
}

if (isset($_POST["student_no"])) {
    $student_no = $_POST["student_no"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no='$student_no'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
