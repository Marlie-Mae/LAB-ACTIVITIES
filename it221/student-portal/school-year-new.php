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
            $display = "School Year already exist.";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_school_year VALUES ('$school_year_code', '$school_year', '$semester', '$status')");
            $display = "Record was saved successfully.";
        } 
    } else {
        echo "Add School Year";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add School Year</title>
    </head>
    <body>
        <?php
            if(isset($display)) {
                echo $display;
            }
        ?>
        <form action="" method="POST">
            
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

            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>
