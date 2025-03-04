<?php
    include("cn.php");
    session_start();
    if (!isset($_SESSION['faculty_code'])) {
        header("location: faculty_login.php");
        exit();
    }

    $faculty_code = mysqli_real_escape_string($connection, $_SESSION['faculty_code']);
    $query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
    $row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Table</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>
    <div class="table-container">
        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_student_info");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <h1 class="title">Student Information</h1>
        
            <table id="student_info" class="styled-table">
                <thead>
                    <tr>
                        <th>Student No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $data['student_no']; ?></td>
                        <td><?php echo $data['last_name']; ?></td>
                        <td><?php echo $data['first_name']; ?></td>
                        <td><?php echo $data['middle_name']; ?></td>
                        <td><?php echo $data['course_code']; ?></td>
                        <td><?php echo $data['year_level']; ?></td>
                        <td>
                            <a href="student-edit.php?student_no=<?php echo $data['student_no']; ?>" class="btn-edit">Edit</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#student_info').DataTable();
            });
        </script>
        <?php } ?>

        <a href="faculty_profile.php" class="back-btn">Back</a>
    </div>
</body>
</html>
