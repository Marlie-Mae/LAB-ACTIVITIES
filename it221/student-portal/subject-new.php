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
            <label for="subject_code">Subject Code:</label>
            <input type="text" name="subject_code" placeholder="Subject code" required> <br>

            <label for="subject_name">Subject Name:</label>
            <input type="text" name="subject_name" placeholder="Subject name" required> <br>
            
            <label for="department_code">Department Code:</label>
            <select name="department_code" id="">
                <option value="" disabled selected>Select a department</option>
                <?php
                    $query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                    $rows = mysqli_num_rows($query);
                    if ($rows > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                ?>
                            <option value="<?php echo $data['department_code']; ?>">
                                <?php echo $data['department_code']; ?>
                            </option>
                <?php  
                        }
                    }
                ?>
            </select>
            <br>

            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>
