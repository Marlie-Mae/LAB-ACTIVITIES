<?php
    //$connection = mysqli_connect("localhost", "root", "", "student_portal");
    $connection = mysqli_connect("sql213.infinityfree.com", "if0_38326677","HutDvUj3zfL6R", "if0_38326677_student_portal");
    if (!$connection) {
        die("Database connection failed:" . musqli_error());
    }
?>