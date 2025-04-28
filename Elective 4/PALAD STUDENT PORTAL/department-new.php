<?php  
	include("cn.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
		$department_name = mysqli_real_escape_string($connection, $_POST['department_name']);

		$check_department = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
		$rows = mysqli_num_rows($check_department);
		if ($rows == 1) {
			$display = "<p class='error'>Department already exists.</p>";
		} else {
			$query = mysqli_query($connection, "INSERT INTO tbl_department VALUES ('$department_code', '$department_name')");
			$display = "<p class='success'>Record was saved successfully.</p>";
		}
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Department</title>
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
        <a href="department.php" class="back-btn">Department Table</a>
		<a href="home.php" class="back-btn">← Back to Home</a>
		<h2>Insert New Department</h2>
		<?php if(isset($display)) { echo $display; } ?>
		<form action="" method="POST">
			<div class="input-group">
				<label for="department_code">Department Code</label>
				<input type="text" name="department_code" id="department_code" placeholder="Department Code" required>
			</div>
			<div class="input-group">
				<label for="department_name">Department Name</label>
				<input type="text" name="department_name" id="department_name" placeholder="Department Name" required>
			</div>
			<button type="submit" class="btn-submit">INSERT</button>
		</form>
	</div>
</body>
</html>
<?php  
	include("cn.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
		$department_name = mysqli_real_escape_string($connection, $_POST['department_name']);

		$check_department = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
		$rows = mysqli_num_rows($check_department);
		if ($rows == 1) {
			$display = "<p class='error'>Department already exists.</p>";
		} else {
			$query = mysqli_query($connection, "INSERT INTO tbl_department VALUES ('$department_code', '$department_name')");
			$display = "<p class='success'>Record was saved successfully.</p>";
		}
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Department</title>
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
        <a href="department.php" class="back-btn">Department Table</a>
		<a href="home.php" class="back-btn">← Back to Home</a>
		<h2>Insert New Department</h2>
		<?php if(isset($display)) { echo $display; } ?>
		<form action="" method="POST">
			<div class="input-group">
				<label for="department_code">Department Code</label>
				<input type="text" name="department_code" id="department_code" placeholder="Department Code" required>
			</div>
			<div class="input-group">
				<label for="department_name">Department Name</label>
				<input type="text" name="department_name" id="department_name" placeholder="Department Name" required>
			</div>
			<button type="submit" class="btn-submit">INSERT</button>
		</form>
	</div>
</body>
</html>
