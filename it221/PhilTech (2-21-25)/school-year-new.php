<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $school_year_code = mysqli_real_escape_string($connection, $_POST['school_year_code']);
        $school_year = mysqli_real_escape_string($connection, $_POST['school_year']);
        $semester = mysqli_real_escape_string($connection, $_POST['semester']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $check_school_year_code = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
        $rows = mysqli_num_rows($check_school_year_code);
        if ($rows == 1) {
            $display = "<div class='message error'>School Year Code already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_school_year VALUES ('$school_year_code', '$school_year', '$semester', '$status')");
            $display = "<div class='message success'>Record was saved successfully.</div>";
        } 
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>Add School Year</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New School Year</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>
            
            <label for="school_year_code">School Year Code:</label>
            <input type="text" name="school_year_code" placeholder="School year code" required> <br>

            <label for="school_year">School Year:</label>
            <input type="text" name="school_year" placeholder="School year" required> <br>

            <label for="semester">Semester:</label>
            <input type="text" name="semester" placeholder="Semester" required> <br>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="" disabled selected>Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select> <br>

            <input type="submit" name="" value="Insert">
            <a href="faculty_profile.php" class="back-btn">Back</a>
        </form>
    </body>
</html>