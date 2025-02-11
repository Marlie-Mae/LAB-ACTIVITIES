<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Course Table</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>
        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_course");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        <table id="course" class="display">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['course_code']; ?></td>
                    <td><?php echo $data['course_description']; ?></td>
                    <td>
                        <a href="course-edit.php?student_no=<?php echo $data['course_code']; ?>">Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#course').DataTable();
            });
        </script>
        <?php } ?>
    </body>
</html>
