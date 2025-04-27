<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: school_years.php");
    exit();
}

// Sanitize input data
$school_year_code = mysqli_real_escape_string($connection, $_POST["school_year_code"]);
$school_year = mysqli_real_escape_string($connection, $_POST["school_year"]);
$semester = mysqli_real_escape_string($connection, $_POST["semester"]);
$status = mysqli_real_escape_string($connection, $_POST["status"]);

// Check if school_year_code exists
$check_school_year = mysqli_query($connection, "SELECT school_year_code FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
$rows = mysqli_num_rows($check_school_year);

if ($rows == 0) {
    // Insert new record
    $sql = "INSERT INTO tbl_school_year (school_year_code, school_year, semester, status) 
            VALUES ('$school_year_code', '$school_year', '$semester', '$status')";
} else {
    // Update existing record
    $sql = "UPDATE tbl_school_year 
            SET school_year = '$school_year', semester = '$semester', status = '$status' 
            WHERE school_year_code = '$school_year_code'";
}

// Execute query
if (mysqli_query($connection, $sql)) {
    echo "success"; // ✅ Matches the response format in your sample
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>
