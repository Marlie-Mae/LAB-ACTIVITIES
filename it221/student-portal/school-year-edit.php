<?php
    include("cn.php");
    if (isset($_GET['school_year_code'])) {
        $school_year_code = mysqli_real_escape_string($connection, $_GET['school_year_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "School Year Code not found";
        }
    } else {
        header("location: school-year.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit School Year</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="school_year_code">School Year Code:</label>
            <input type="text" name="school_year_code" placeholder="School year code" required value="<?php if(isset($school_year_code)) { echo $school_year_code;} ?>"> <br>

            <label for="school_year">School Year:</label>
            <input type="text" name="school_year" placeholder="School year" required value="<?php if(isset($data['school_year'])) {echo $data["school_year"];} ?>"> <br>

            <label for="semester">Semester:</label>
            <input type="text" name="semester" placeholder="Semester" required value="<?php if(isset($data['semester'])) {echo $data["semester"];} ?>"> <br>

            <!--
            <label for="status">Status:</label>
            <input type="text" name="status" placeholder="Status" required value="<?php if(isset($data['status'])) {echo $data["status"];} ?>"> <br>
            -->

            <label for="status">Status:</label>
                <select name="status" required>
                    <option value="" disabled selected>Select Status</option>
                    <option value="1" <?php echo (isset($data['status']) && $data['status'] == 1) ? "selected" : ""; ?>>Active</option>
                    <option value="0" <?php echo (isset($data['status']) && $data['status'] == 0) ? "selected" : ""; ?>>Inactive</option>
                </select> <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
