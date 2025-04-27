<?php 
include("cn.php"); 

session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
    exit();
}

if ($_SESSION['account_type'] === 'User' && basename($_SERVER['PHP_SELF']) !== 'USER/users.php') {
    header("location: USER/users.php");
    exit();
}

// Prevent admins from accessing profile.php
if ($_SESSION['account_type'] === 'Admin' && basename($_SERVER['PHP_SELF']) === 'USER/users.php') {
    header("location: user.php"); // Redirect admins elsewhere (e.g., users page)
    exit();
}
?>

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Adjust if your login file is named differently
    exit();
}

echo "<h1>Welcome, Admin!</h1>";
echo "<p>User ID: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
echo "<p>Account Type: " . htmlspecialchars($_SESSION['account_type']) . "</p>";
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | Users</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/profile.png"></div>
                <div class="user-info">USER<br></div>
            </div>
            <div class="menu-con">
                <a href="school_year.php">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
                <a href="subject.php">SUBJECTS</a>
                <a href="faculty.php">FACULTY</a>
                <a href="students.php">STUDENTS</a>
                <a href="course.php">COURSES</a>
                <a href="users.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">USERS</a>
                <a href="../logout.php">LOGOUT</a>
            </div>
        </div>
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">USER PORTAL</div>
            </div>
            <div class="body">
                <div class="content-title"><h1>USERS</h1></div>
                <div class="content">
                    <?php 
                        $query = mysqli_query($connection, "SELECT * FROM tbl_users");
                        if (mysqli_num_rows($query) > 0) {
                    ?>
                    <table id="user_info" class="display">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Account Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['user_id']; ?></td>
                            <td><?php echo $data['account_type']; ?></td>
                            <td><?php echo $data['status']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#user_info').DataTable();
                        });
                    </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Change Password Modal -->
</body>
</html>
