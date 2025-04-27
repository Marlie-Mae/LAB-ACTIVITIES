<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: subjects.php");
    exit();
}

// Sanitize input data
$subject_code = mysqli_real_escape_string($connection, $_POST["subject_code"]);
$subject_name = mysqli_real_escape_string($connection, $_POST["subject_name"]);
$department_code = mysqli_real_escape_string($connection, $_POST["department_code"]);

// Check if subject_code exists
$check_subject = mysqli_query($connection, "SELECT subject_code FROM tbl_subject WHERE subject_code = '$subject_code'");
$rows = mysqli_num_rows($check_subject);

if ($rows == 0) {
    // Insert new record
    $sql = "INSERT INTO tbl_subject (subject_code, subject_name, department_code) 
            VALUES ('$subject_code', '$subject_name', '$department_code')";
} else {
    // Update existing record
    $sql = "UPDATE tbl_subject 
            SET subject_name = '$subject_name', department_code = '$department_code' 
            WHERE subject_code = '$subject_code'";
}

// Execute query
if (mysqli_query($connection, $sql)) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>
