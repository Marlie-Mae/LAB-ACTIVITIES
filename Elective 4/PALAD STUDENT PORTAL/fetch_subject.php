<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: subject.php");
    exit();
}

if (isset($_POST["subject_code"])) {
    $subject_code = $_POST["subject_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code='$subject_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
