<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$account_type = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #eaf6fb;
        }
        .sidebar {
            width: 400px; /* Increased width */
            height: 100vh;
            background: #2aa198;
            color: white;
            padding: 26px; /* Increased padding */
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }
        .profile {
            text-align: center;
            margin-bottom: 26px; /* Increased spacing */
        }
        .profile img {
            width: 130px; /* Increased from 100px */
            height: 130px; /* Increased from 100px */
            border-radius: 50%;
            border: 4px solid white;
            margin-bottom: 13px; /* Increased spacing */
        }
        .profile h5 {
            font-size: 1.7rem; /* Increased from 1.3rem */
            margin-bottom: 6px; /* Increased spacing */
        }
        .profile p {
            font-size: 1.3rem; /* Increased from 1rem */
            color: #e4f5f4;
        }
        .nav-links a {
    display: block;
    padding: 16px 20px; /* Maintain padding */
    font-size: 1.3rem; 
    background: #3b8070;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    text-align: left;
    transition: all 0.3s ease;
    margin-bottom: 0; /* Remove space between buttons */
}

.nav-links {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 5px; /* Optional: Add small gap between buttons if desired */
}

        .nav-links a:hover,
        .nav-links a.active {
            background: #1e6a5e;
            color: white;
        }
        .btn-danger {
            font-size: 1.3rem; /* Increased button font size */
            padding: 14px; /* Increased button padding */
        }
        .content {
            margin-left: 420px; /* Adjusted for sidebar width */
            padding: 40px;
            background: #eaf6fb;
            width: calc(100% - 420px); /* Adjusted for sidebar */
            height: 100vh;
            overflow-y: auto;
        }
        .header {
            background: #dfeef4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 1.8rem;
            color: #2c3e50;
        }
        .admin-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .admin-info h3 {
            font-size: 1.5rem;
            color: #34495E;
            margin-bottom: 15px;
        }
        .admin-info p {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #2C3E50;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="images/picture.png" alt="Profile Picture">
            <h5><?php echo htmlspecialchars($user_id); ?></h5>
            <p><?php echo htmlspecialchars($account_type); ?></p>
        </div>
        <div class="nav-links">
            <a href="#" class="nav-item active" data-page="profile">Profile</a>
            <a href="#" class="nav-item" data-page="school-year.php">School Year</a>
            <a href="#" class="nav-item" data-page="department.php">Department</a>
            <a href="#" class="nav-item" data-page="faculty.php">Faculty</a>
            <a href="#" class="nav-item" data-page="subject.php">Subject</a>
            <a href="#" class="nav-item" data-page="student.php">Student</a>
            <a href="#" class="nav-item" data-page="course.php">Course</a>
            <a href="#" class="nav-item" data-page="user.php">User</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
        </div>
    </div>

    <div class="content">
        <div class="header">
            <h1>User Portal</h1>
        </div>
        <div id="content-area">
            <div class="admin-info">
                <h3>Admin Information</h3>
                <p><strong>User Id:</strong> <?php echo htmlspecialchars($_SESSION['user_id'] ?? 'N/A'); ?></p>
                <p><strong>Account Type:</strong> <?php echo htmlspecialchars($_SESSION['role'] ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-item').click(function(e) {
                e.preventDefault();
                $('.nav-item').removeClass('active');
                $(this).addClass('active');

                let page = $(this).data('page');

                if (page === "profile") {
                    $('#content-area').html(`
                        <div class="admin-info">
                            <h3>Admin Information</h3>
                            <p><strong>User Id:</strong> <?php echo htmlspecialchars($_SESSION['user_id'] ?? 'N/A'); ?></p>
                            <p><strong>Account Type:</strong> <?php echo htmlspecialchars($_SESSION['role'] ?? 'N/A'); ?></p>
                        </div>
                    `);
                } else {
                    $('#content-area').load(page);
                }
            });
        });
    </script>
</body>
</html>
