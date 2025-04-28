<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: subject.php");
    exit();
}

$subject_code = mysqli_real_escape_string($connection, $_POST["subject_code"]);
$subject_name = mysqli_real_escape_string($connection, $_POST["subject_name"]);
$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]);

$check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
$rows = mysqli_num_rows($check_subject);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_subject (subject_code, subject_name, department_code) 
            VALUES ('$subject_code', '$subject_name', '$department_code')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_subject SET 
            subject_code='$subject_code', subject_name='$subject_name', department_code='$department_code' WHERE subject_code='$subject_code'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: subject.php");
    exit();
}

$subject_code = mysqli_real_escape_string($connection, $_POST["subject_code"]);
$subject_name = mysqli_real_escape_string($connection, $_POST["subject_name"]);
$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]);

$check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
$rows = mysqli_num_rows($check_subject);

if ($rows == "0") {
    // Insert New Record
    $sql = "INSERT INTO tbl_subject (subject_code, subject_name, department_code) 
            VALUES ('$subject_code', '$subject_name', '$department_code')";
} else {
    // Update Existing Record
    $sql = "UPDATE tbl_subject SET 
            subject_code='$subject_code', subject_name='$subject_name', department_code='$department_code' WHERE subject_code='$subject_code'";
}

if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}
?>
