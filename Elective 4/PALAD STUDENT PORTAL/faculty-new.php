<?php  
	include("cn.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
		$faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
		$department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = md5($password);

		$check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
		$rows = mysqli_num_rows($check_faculty);
		if ($rows == 1) {
			$display = "<p class='error'>Faculty already exists.</p>";
		} else {
			$query = mysqli_query($connection, "INSERT INTO tbl_faculty VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')");
			$display = "<p class='success'>Record was saved successfully.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FACULTY</title>
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
        <a href="faculty.php" class="back-btn">Faculty Table</a>
		<a href="home.php" class="back-btn">← Back to Home</a>
		<h2>Insert New Faculty</h2>
		<?php if(isset($display)) { echo $display; } ?>
		<form method="post" action="">
			<div class="input-group">
				<label for="faculty_code">Faculty Code</label>
				<input type="text" name="faculty_code" id="faculty_code" placeholder="Faculty Code" required>
			</div>
			<div class="input-group">
				<label for="faculty_name">Faculty Name</label>
				<input type="text" name="faculty_name" id="faculty_name" placeholder="Faculty Name" required>
			</div>
			<div class="input-group">
                <label for="department_code">Department Code</label>
				<select name="department_code" required>
                    <option value="">Department Code</option>
                    <option value="DeptCode001">DeptCode001 - BSIT</option>
                    <option value="DeptCode002">DeptCode002 - BSHM</option>
                    <option value="DeptCode003">DeptCode003 - BS Psych</option>
                    <option value="DeptCode004">DeptCode004 - BSED</option>
                    <option value="DeptCode005">DeptCode005 - BS Crim</option>
		        </select><br>
			</div>
			<div class="input-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" placeholder="Password" required>
			</div>
			<button type="submit" class="btn-submit">INSERT</button>
		</form>
	</div>
</body>
</html>
