<?php
    include("cn.php");
    if (isset($_GET['faculty_code'])) {
        $faculty_code = mysqli_real_escape_string($connection, $_GET['faculty_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
            $department_code = $data['department_code'];
        } else {
            echo "Faculty Code not found";
        }
    } else {
        header("location: faculty.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
        $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);

        $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
        $rows = mysqli_num_rows($check_faculty);
        if ($rows == 1) {
            $sql = "UPDATE tbl_faculty SET faculty_name = '$faculty_name', department_code = '$department_code' WHERE faculty_code = '$faculty_code'";
            if (mysqli_query($connection,$sql)) {
                header("location: faculty.php");
            } else {
                $display = "Failed to update records.";
            }
        } else {
            $display = "Faculty Code not found.";
        }
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>Edit Faculty</title>
    </head>
    <body>
        <?php if(isset($status)) {echo $status; } ?>
        <?php if(isset($display)) {echo $display; } ?>
        <form action="" method="POST">
            <h1>Edit Faculty</h1>

            <label for="faculty_code">Faculty Code:</label>
            <input type="text" name="faculty_code" placeholder="Faculty code" required value="<?php if(isset($faculty_code)) { echo $faculty_code;} ?>"> <br>

            <label for="faculty_name">Faculty Name:</label>
            <input type="text" name="faculty_name" placeholder="Faculty name" required value="<?php if(isset($data['faculty_name'])) {echo $data["faculty_name"];} ?>"> <br>

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

            <input type="submit" name="" value="Update">
            <a href="faculty.php" class="back-btn">Back</a>
        </form>
    </body>
</html>