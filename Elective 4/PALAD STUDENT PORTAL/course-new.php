<?php   
    include("cn.php");

    $message = ""; // Variable to store success/error message

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $department_code = mysqli_real_escape_string($connection, $_POST['course_code']);
        $department_name = mysqli_real_escape_string($connection, $_POST['course_description']);

        // Check if course already exists
        $check_department = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$department_code'");
        
        if (mysqli_num_rows($check_department) > 0) {
            $message = "<p class='error'>Course already exists.</p>";
        } else {
            $query = "INSERT INTO tbl_course (course_code, course_description) VALUES ('$department_code', '$department_name')";
            
            if (mysqli_query($connection, $query)) {
                $message = "<p class='success'>Record was saved successfully.</p>";
            } else {
                $message = "<p class='error'>Error: " . mysqli_error($connection) . "</p>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Course</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #FFC0CB;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-submit {
            width: 100%;
            background: #87CEEB;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: #4682B4;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-btn {
            display: inline-block;
            background: #87CEEB;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .back-btn:hover {
            background: #4682B4;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back to Profile Button -->
        <a href="course.php" class="back-btn">Course Table</a>
        <a href="home.php" class="back-btn">← Back to Home</a>

        <h2>Insert New Course</h2>
        <?php echo $message; ?>
        <form method="post" action="">
            <div class="input-group">
                <label for="course_code">Course Code</label>
                <input type="text" name="course_code" id="course_code" placeholder="Course Code" required>
            </div>
            <div class="input-group">
                <label for="course_description">Course Description</label>
                <textarea name="course_description" id="course_description" placeholder="Course Description" required rows="4"></textarea>
            </div>
            <button type="submit" class="btn-submit">INSERT</button>
        </form>
    </div>
</body>
</html>
