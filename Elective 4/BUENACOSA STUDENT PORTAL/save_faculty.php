<?php
include("cn.php");

// Check if the form is for adding or updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['faculty_code']) && isset($_POST['faculty_name']) && isset($_POST['department_code'])) {
        // Escape input to prevent SQL injection
        $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
        $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
        $password = isset($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;

        // Check if we are adding or editing
        if (!empty($password)) {
            // Adding new faculty
            // Hash the password using MD5
            $hashed_password = md5($password);

            // Check if the faculty code already exists
            $checkQuery = "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'";
            $checkResult = mysqli_query($connection, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                // Faculty code already exists
                echo "Error: Faculty with this code already exists!";
            } else {
                // Add new faculty (with hashed password)
                $query = "INSERT INTO tbl_faculty (faculty_code, faculty_name, department_code, password) 
                          VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')";
                if (mysqli_query($connection, $query)) {
                    echo "success";  // Respond with success if query was executed successfully
                } else {
                    echo "Error: " . mysqli_error($connection);  // Show error message
                }
            }
        } else {
            // Editing existing faculty (without changing password)
            $query = "UPDATE tbl_faculty 
                      SET faculty_name = '$faculty_name', department_code = '$department_code' 
                      WHERE faculty_code = '$faculty_code'";

            if (mysqli_query($connection, $query)) {
                echo "success";  // Respond with success if query was executed successfully
            } else {
                echo "Error: " . mysqli_error($connection);  // Show error message
            }
        }
    } else {
        echo "Error: Missing required fields!";
    }
}
?>
