<?php 
	include("cn.php");
	if (isset($_GET['school_year_code'])) {
		$school_year_code = mysqli_real_escape_string($connection, $_GET['school_year_code']);
		$query = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
			$data = mysqli_fetch_assoc($query);
			$school_year_code = $data["school_year_code"];
		} else {
			$message = "<p class='error'>School Year not found.</p>";
		}
	} else {
		header("location: school-year.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$school_year_code = mysqli_real_escape_string($connection, $_POST['school_year_code']);
		$school_year = mysqli_real_escape_string($connection, $_POST['school_year']);
		$semester = mysqli_real_escape_string($connection, $_POST['semester']);
		$status = mysqli_real_escape_string($connection, $_POST['status']);

		$check_school_year = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
		$rows = mysqli_num_rows($check_school_year);
		if ($rows == 1) {
			$sql = "UPDATE tbl_school_year SET school_year_code = '$school_year_code', school_year = '$school_year', semester = '$semester', status = '$status' WHERE school_year_code = '$school_year_code'";
			if (mysqli_query($connection, $sql)) {
				header("location: school-year.php");
			} else {
				$message = "<p class='error'>Failed to update record.</p>";
			}
		} else {
			$message = "<p class='error'>School Year not found.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit School Year</title>
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
	</style>
</head>
<body>
	<div class="container">
		<h2>Edit School Year</h2>
		<?php if (isset($message)) { echo $message; } ?>
		<form action="" method="POST">
			<div class="input-group">
				<label for="school_year_code">School Year Code</label>
				<input type="text" name="school_year_code" id="school_year_code" required value="<?php echo isset($data['school_year_code']) ? $data['school_year_code'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="school_year">School Year</label>
				<input type="text" name="school_year" id="school_year" required value="<?php echo isset($data['school_year']) ? $data['school_year'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="semester">Semester</label>
				<input type="number" name="semester" id="semester" min="1" max="2" required value="<?php echo isset($data['semester']) ? $data['semester'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="status">Status</label>
				<select name="status" id="status" required>
					<option value="Active" <?php if (isset($data['status']) && $data['status'] == 'Active') echo 'selected'; ?>>Active</option>
					<option value="Inactive" <?php if (isset($data['status']) && $data['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
				</select>
			</div>
			<button type="submit" class="btn-submit">UPDATE</button>
		</form>
	</div>
</body>
</html>
