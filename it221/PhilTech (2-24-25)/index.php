<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhilTech Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <div class="right-panel">
            <img src="images/philtech_logo.png" alt="PhilTech" class="seal">
            <h2>Hi, Technovators!</h2>
            <p>Please click or tap your destination.</p>
            <a href="student_login.php" class="btn student">Student</a>
            <a href="faculty_login.php" class="btn faculty">Faculty</a>
            <p class="terms">By using this service, you understood and agree to the PhilTech Online Services <a href="#">Terms of Use</a> and <a href="#">Privacy Statement</a>.</p>
        </div>
    </div>
</body>
</html>
