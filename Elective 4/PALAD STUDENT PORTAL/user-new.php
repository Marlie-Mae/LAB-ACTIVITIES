<?php  
	include("cn.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$id = mysqli_real_escape_string($connection, $_POST['id']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = md5($password);
		$role = mysqli_real_escape_string($connection, $_POST['role']);

		$check_user = mysqli_query($connection, "SELECT * FROM users WHERE id = '$id'");
		$rows = mysqli_num_rows($check_users);
		if ($rows == 1) {
			$display = "<p class='error'>User already exists.</p>";
		} else {
			$query = mysqli_query($connection, "INSERT INTO tbl_user VALUES ('$id', '$hashed_password', '$role')");
			$display = "<p class='success'>Record was saved successfully.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Management</title>
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
        <a href="user.php" class="back-btn">User Table</a>
		<a href="home.php" class="back-btn">← Back to Home</a>
		<h2>Add New User</h2>
		<?php if(isset($display)) { echo $display; } ?>
		<form method="post" action="">
			<div class="input-group">
				<label for="user_id">User ID</label>
				<input type="text" name="user_id" id="user_id" placeholder="Enter User ID" required>
			</div>
			<div class="input-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" placeholder="Enter Password" required>
			</div>
			<div class="input-group">
				<label for="account_type">Account Type</label>
				<select name="account_type" id="account_type" required>
					<option value="Admin">Admin</option>
					<option value="User">User</option>
				</select>
			</div>
			<button type="submit" class="btn-submit">INSERT</button>
		</form>
	</div>
</body>
</html>
