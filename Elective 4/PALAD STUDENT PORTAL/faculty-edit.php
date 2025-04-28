<?php 
	include("cn.php");
	if (isset($_GET['faculty_code'])) {
		$faculty_code = mysqli_real_escape_string($connection, $_GET['faculty_code']);
		$query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
			$data = mysqli_fetch_assoc($query);
			$department_code = $data["department_code"];
		} else {
			$message = "<p class='error'>Faculty not found.</p>";
		}
	} else {
		header("location: faculty.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
		$faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
		$department_code = mysqli_real_escape_string($connection, $_POST['department_code']);

		$check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
		$rows = mysqli_num_rows($check_faculty);
		if ($rows == 1) {
			$sql = "UPDATE tbl_faculty SET faculty_code = '$faculty_code', faculty_name = '$faculty_name', department_code = '$department_code' WHERE faculty_code = '$faculty_code'";
			if (mysqli_query($connection, $sql)) {
				header("location: faculty.php");
			} else {
				$message = "<p class='error'>Failed to update record.</p>";
			}
		} else {
			$message = "<p class='error'>Faculty not found.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Faculty</title>
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
		<h2>Edit Faculty Information</h2>
		<?php if (isset($message)) { echo $message; } ?>
		<form method="post" action="">
			<div class="input-group">
				<label for="faculty_code">Faculty Code</label>
				<input type="text" name="faculty_code" id="faculty_code" placeholder="Faculty Code" required value="<?php echo isset($data['faculty_code']) ? $data['faculty_code'] : ''; ?>" readonly>
			</div>
			<div class="input-group">
				<label for="faculty_name">Faculty Name</label>
				<input type="text" name="faculty_name" id="faculty_name" placeholder="Faculty Name" required value="<?php echo isset($data['faculty_name']) ? $data['faculty_name'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="department_code">Department</label>
				<select name="department_code" id="department_code" required>
					<option value="" disabled>Select a Department</option>
					<?php 
						$query = mysqli_query($connection, "SELECT * FROM tbl_department");
						while ($department = mysqli_fetch_assoc($query)) {
					?>
					<option value="<?php echo $department['department_code']; ?>" <?php echo ($department_code == $department['department_code']) ? 'selected' : ''; ?>>
						<?php echo $department['department_code']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<button type="submit" class="btn-submit">UPDATE</button>
		</form>
	</div>
</body>
</html>
