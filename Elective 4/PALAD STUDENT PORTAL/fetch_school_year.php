<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: school-year.php");
    exit();
}

if (isset($_POST["school_year_code"])) {
    $school_year_code = $_POST["school_year_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code='$school_year_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
