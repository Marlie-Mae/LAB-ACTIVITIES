<?php
    include("cn.php");
    if (isset($_GET['subject_code'])) {
        $subject_code = mysqli_real_escape_string($connection, $_GET['subject_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
            $department_code = $data['department_code'];
        } else {
            echo "Subject Code not found";
        }
    } else {
        header("location: subject.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $subject_code = mysqli_real_escape_string($connection, $_POST['subject_code']);
        $subject_name = mysqli_real_escape_string($connection, $_POST['subject_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);

        $check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
        $rows = mysqli_num_rows($check_subject);
        if ($rows == 1) {
            $sql = "UPDATE tbl_subject SET subject_name = '$subject_name', department_code = '$department_code' WHERE subject_code = '$subject_code'";
            if (mysqli_query($connection,$sql)) {
                header("location: subject.php");
            } else {
                $display = "Failed to update records.";
            }
        } else {
            $display = "Subject Code not found.";
        }
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
        <?php if(isset($status)) {echo $status; } ?>
        <?php if(isset($display)) {echo $display; } ?>
        <form action="" method="POST">
            <label for="subject_code">Subject Code:</label>
            <input type="text" name="subject_code" placeholder="Subject code" required value="<?php if(isset($subject_code)) { echo $subject_code;} ?>"> <br>

            <label for="subject_name">Subject Name:</label>
            <input type="text" name="subject_name" placeholder="Subject name" required value="<?php if(isset($data['subject_name'])) {echo $data["subject_name"];} ?>"> <br>

            <label for="department_code">Department Code:</label>
            <select name="department_code" id="">
                <option value="" disabled selected>Select a department</option>
                <?php
                $query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                $rows = mysqli_num_rows($query);
                while ($department = mysqli_fetch_assoc($query)) {
                ?>
                <option value="<?php echo $department['department_code']; ?>" <?php if($department_code == $department["department_code"]) {echo "selected"; }?>>

                <?php echo $department['department_code']; ?> </option>
                <?php } ?>
                ?>
            </select>
            <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
