<?php  
	include("cn.php");

	$message = ""; // Variable to store success/error message

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$school_year_code = mysqli_real_escape_string($connection, $_POST['school_year_code']);
		$school_year = mysqli_real_escape_string($connection, $_POST['school_year']);
		$semester = mysqli_real_escape_string($connection, $_POST['semester']);
		$status = mysqli_real_escape_string($connection, $_POST['status']);

		$check_school_year = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
		if (mysqli_num_rows($check_school_year) > 0) {
			$message = "<p class='error'>School Year already exists.</p>";
		} else {
			$query = "INSERT INTO tbl_school_year (school_year_code, school_year, semester, status) 
				VALUES ('$school_year_code', '$school_year', '$semester', '$status')";

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
	<title>School Year</title>
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
		.input-group input, .input-group select {
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
        <a href="school-year.php" class="back-btn">School Year Table</a>
		<a href="home.php" class="back-btn">← Back to Home</a>
		<h2>Add New School Year</h2>
		<?php echo $message; ?>
		<form method="post" action="">
			<div class="input-group">
				<label for="school_year_code">School Year Code</label>
				<input type="text" name="school_year_code" id="school_year_code" required>
			</div>
			<div class="input-group">
				<label for="school_year">School Year</label>
				<input type="text" name="school_year" id="school_year" required>
			</div>
			<div class="input-group">
				<label for="semester">Semester</label>
				<input type="text" name="semester" id="semester" required>
			</div>
			<div class="input-group">
				<label for="status">Status</label>
				<select name="status" id="status" required>
					<option value="1">Active</option>
					<option value="2">Inactive</option>
				</select>
			</div>
			<button type="submit" class="btn-submit">INSERT</button>
		</form>
	</div>
</body>
</html>
