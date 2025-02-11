<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Faculty Table</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>
        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_faculty");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        <table id="faculty" class="display">
            <thead>
                <tr>
                    <th>Faculty Code</th>
                    <th>Faculty Name</th>
                    <th>Department Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['faculty_code']; ?></td>
                    <td><?php echo $data['faculty_name']; ?></td>
                    <td><?php echo $data['department_code']; ?></td>
                    <td>
                        <a href="faculty-edit.php?faculty_code=<?php echo $data['faculty_code']; ?>">Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#faculty').DataTable();
            });
        </script>
        <?php } ?>
    </body>
</html>
