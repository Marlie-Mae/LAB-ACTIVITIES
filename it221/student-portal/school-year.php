<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>School Year Table</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>
        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        <table id="school_year" class="display">
            <thead>
                <tr>
                    <th>School Year Code</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['school_year_code']; ?></td>
                    <td><?php echo $data['school_year']; ?></td>
                    <td><?php echo $data['semester']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                        <a href="school_year-edit.php?school_year_code=<?php echo $data['school_year_code']; ?>">Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#school_year').DataTable();
            });
        </script>
        <?php } ?>
    </body>
</html>
