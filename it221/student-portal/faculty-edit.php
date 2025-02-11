<?php
    include("cn.php");
    if (isset($_GET['faculty_code'])) {
        $faculty_code = mysqli_real_escape_string($connection, $_GET['faculty_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "Faculty Code not found";
        }
    } else {
        header("location: faculty.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Faculty</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="faculty_code">Faculty Code:</label>
            <input type="text" name="faculty_code" placeholder="Faculty code" required value="<?php if(isset($faculty_code)) { echo $faculty_code;} ?>"> <br>

            <label for="faculty_name">Faculty Name:</label>
            <input type="text" name="faculty_name" placeholder="Faculty name" required value="<?php if(isset($data['faculty_name'])) {echo $data["faculty_name"];} ?>"> <br>

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
