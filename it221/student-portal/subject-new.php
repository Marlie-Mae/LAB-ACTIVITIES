<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $subject_code = mysqli_real_escape_string($connection, $_POST['subject_code']);
        $subject_name = mysqli_real_escape_string($connection, $_POST['subject_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);

        $check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
        $rows = mysqli_num_rows($check_subject);
        if ($rows == 1) {
            $display = "Subject already exist.";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_subject VALUES ('$subject_code', '$subject_name', '$department_code')");
            $display = "Record was saved successfully.";
        } 
    } else {
        echo "Add New Subject";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add New Subject</title>
    </head>
    <body>
        <?php
            if(isset($display)) {
                echo $display;
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="subject_code" placeholder="Subject code" required> <br>
            <input type="text" name="subject_name" placeholder="Subject name" required> <br>
            
            <select name="department_code" required>
                <option value="">Department code</option>
                <option value="D-001">D-001 - Information Technology</option>
                <option value="D-002">D-002 - Computer Science</option>
                <option value="D-003">D-003 - Criminology</option>
            </select> <br>

            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>
