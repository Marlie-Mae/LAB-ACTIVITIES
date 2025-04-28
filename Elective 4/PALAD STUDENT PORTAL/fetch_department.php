<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: department.php");
    exit();
}

if (isset($_POST["department_code"])) {
    $department_code = $_POST["department_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code='$department_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: department.php");
    exit();
}

if (isset($_POST["department_code"])) {
    $department_code = $_POST["department_code"];
    $query = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code='$department_code'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>
