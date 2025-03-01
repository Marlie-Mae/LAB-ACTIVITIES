<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
        $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);

        $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
        $rows = mysqli_num_rows($check_faculty);
        if ($rows == 1) {
            $display = "<div class='message error'>Faculty Code already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_faculty VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')");
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
        <title>Add Faculty</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New Faculty</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>

            <label for="faculty_code">Faculty Code:</label>
            <input type="text" name="faculty_code" placeholder="Faculty code" required> <br>

            <label for="faculty_name">Faculty Name:</label>
            <input type="text" name="faculty_name" placeholder="Faculty name" required> <br>

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

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required> <br>

            <input type="submit" name="" value="Insert">
            <a href="faculty.php" class="back-btn">Back</a>
        </form>
    </body>
</html>