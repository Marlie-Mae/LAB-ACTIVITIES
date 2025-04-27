<?php
include("cn.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit();
}

$course_code = $_POST["course_code"];
$course_description = $_POST["course_description"];
$edit_mode = isset($_POST["edit_mode"]) && $_POST["edit_mode"] === "true"; // Check if it's edit mode

// Check if course description is provided (course_code is required in both add and edit modes)
if (empty($course_description)) {
    echo "Error: Course description is required!";
    exit();
}

// Separate logic for adding and editing
if ($edit_mode) {
    // Edit Mode: Update existing course details
    if (empty($course_code)) {
        echo "Error: Course code is required to edit!";
        exit();
    }

    // Edit the course description based on the provided course code
    $sql = "UPDATE tbl_course SET course_description=? WHERE course_code=?";
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $connection->error;
        exit();
    }
    $stmt->bind_param("ss", $course_description, $course_code); // Bind parameters for update

    if ($stmt->execute()) {
        echo "Course updated successfully!";
    } else {
        echo "Error updating course: " . $stmt->error;
    }
} else {
    // Add Mode: Insert new course into the database
    if (empty($course_code)) {
        echo "Error: Course code is required to add a new course!";
        exit();
    }

    // Check if the course code already exists in the database
    $sql_check = "SELECT COUNT(*) FROM tbl_course WHERE course_code=?";
    $stmt_check = $connection->prepare($sql_check);
    if ($stmt_check === false) {
        echo "Error preparing check statement: " . $connection->error;
        exit();
    }
    $stmt_check->bind_param("s", $course_code);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "Error: Course code already exists!";
        exit();
    }

    // Insert the new course
    $sql = "INSERT INTO tbl_course (course_code, course_description) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing insert statement: " . $connection->error;
        exit();
    }
    $stmt->bind_param("ss", $course_code, $course_description); // Bind course details

    if ($stmt->execute()) {
        echo "Course added successfully!";
    } else {
        echo "Error adding course: " . $stmt->error;
    }
}

$stmt->close();
$connection->close();
?>
