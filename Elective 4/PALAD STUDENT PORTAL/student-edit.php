<?php 
	include("cn.php");

	if (isset($_GET['student_no'])) {
		$student_no = mysqli_real_escape_string($connection, $_GET['student_no']);
		$query = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
			$data = mysqli_fetch_assoc($query);
			$course_code = $data["course_code"];
		} else {
			$message = "<p class='error'>Student No. not found.</p>";
		}
	} else {
		header("location: student.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
		$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
		$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
		$middle_name = mysqli_real_escape_string($connection, $_POST['middle_name']);
		$course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
		$year_level = mysqli_real_escape_string($connection, $_POST['year_level']);

		$check_student = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
		$rows = mysqli_num_rows($check_student);
		if ($rows == 1) {
			$sql = "UPDATE tbl_student_info SET last_name = '$last_name', first_name = '$first_name', middle_name = '$middle_name', course_code = '$course_code', year_level = '$year_level' WHERE student_no = '$student_no'";
			if (mysqli_query($connection,$sql)) {
				header("location: student.php");
			} else {
				$message = "<p class='error'>Failed to update record.</p>";
			}
		} else {
			$message = "<p class='error'>Student No. not found.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Student</title>
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
		.input-group input,
		.input-group select {
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
		<h2>Edit Student Information</h2>
		<?php if (isset($message)) { echo $message; } ?>
		<form method="post" action="">
			<div class="input-group">
				<label for="student_no">Student No.</label>
				<input type="text" name="student_no" id="student_no" placeholder="Student Number" required value="<?php echo isset($data['student_no']) ? $data['student_no'] : ''; ?>" readonly>
			</div>
			<div class="input-group">
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" id="last_name" placeholder="Last Name" required value="<?php echo isset($data['last_name']) ? $data['last_name'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" id="first_name" placeholder="First Name" required value="<?php echo isset($data['first_name']) ? $data['first_name'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="middle_name">Middle Name</label>
				<input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" required value="<?php echo isset($data['middle_name']) ? $data['middle_name'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="course_code">Course</label>
				<select name="course_code" id="course_code" required>
					<option value="" disabled>Select a Course</option>
					<?php 
						$query = mysqli_query($connection, "SELECT * FROM tbl_course");
						while ($course = mysqli_fetch_assoc($query)) {
					?>
					<option value="<?php echo $course['course_code']; ?>" <?php echo ($course_code == $course['course_code']) ? 'selected' : ''; ?>>
						<?php echo $course['course_code']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<div class="input-group">
				<label for="year_level">Year Level</label>
				<input type="number" name="year_level" id="year_level" min="1" max="4" placeholder="Year Level" required value="<?php echo isset($data['year_level']) ? $data['year_level'] : ''; ?>">
			</div>
			<button type="submit" class="btn-submit">UPDATE</button>
		</form>
	</div>
</body>
</html>
