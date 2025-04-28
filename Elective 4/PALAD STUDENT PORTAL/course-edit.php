<?php  
	include("cn.php");
	if (isset($_GET['course_code'])) {
		$course_code = mysqli_real_escape_string($connection, $_GET['course_code']);
		$query = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
			$data = mysqli_fetch_assoc($query);
		} else {
			$message = "<p class='error'>Course not found.</p>";
		}
	} else {
		header("location: course.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
		$course_description = mysqli_real_escape_string($connection, $_POST['course_description']);

		$check_course = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
		$rows = mysqli_num_rows($check_course);
		if ($rows == 1) {
			$sql = "UPDATE tbl_course SET course_code = '$course_code', course_description = '$course_description' WHERE course_code = '$course_code'";
			if (mysqli_query($connection, $sql)) {
				header("location: course.php");
			} else {
				$message = "<p class='error'>Failed to update record.</p>";
			}
		} else {
			$message = "<p class='error'>Course not found.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Course</title>
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
			max-width: 500px;
			background: #fff;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
			padding: 30px;
			margin: 20px 0;
			position: relative;
		}
		h2 {
			margin-bottom: 20px;
			text-align: center;
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
		.input-group input {
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
	</style>
</head>
<body>
	<div class="container">
		<h2>Edit Course</h2>
		<?php if (isset($message)) { echo $message; } ?>
		<form action="" method="POST">
			<div class="input-group">
				<label for="course_code">Course Code</label>
				<input type="text" name="course_code" id="course_code" required value="<?php echo isset($data['course_code']) ? $data['course_code'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="course_description">Course Description</label>
				<input type="text" name="course_description" id="course_description" required value="<?php echo isset($data['course_description']) ? $data['course_description'] : ''; ?>">
			</div>
			<button type="submit" class="btn-submit">UPDATE</button>
		</form>
	</div>
</body>
</html>
