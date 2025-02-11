<?php
    include("cn.php");
    if (isset($_GET['subject_code'])) {
        $subject_code = mysqli_real_escape_string($connection, $_GET['subject_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "Subject Code not found";
        }
    } else {
        header("location: subject.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Subject</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="subject_code">Subject Code:</label>
            <input type="text" name="subject_code" placeholder="Subject code" required value="<?php if(isset($subject_code)) { echo $subject_code;} ?>"> <br>

            <label for="subject_name">Subject Name:</label>
            <input type="text" name="subject_name" placeholder="Subject name" required value="<?php if(isset($data['subject_name'])) {echo $data["subject_name"];} ?>"> <br>

            <label for="department_code">Department Code:</label>
            <select name="department_code" id="">
                <option value="" disabled selected>Select a department</option>
                <?php
                $department_query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                while ($department_row = mysqli_fetch_assoc($department_query)) {
                    $selected = ($department_row['department_code'] == $data['department_code']) ? "selected" : "";
                    echo "<option value='{$department_row['department_code']}' $selected>{$department_row['department_code']}</option>";
                }
                ?>
            </select>
            <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
