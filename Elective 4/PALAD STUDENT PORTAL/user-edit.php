<?php 
	include("cn.php");
	if (isset($_GET['id'])) {
		$user_id = mysqli_real_escape_string($connection, $_GET['id']);
		$query = mysqli_query($connection, "SELECT * FROM users WHERE id = '$id'");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
			$data = mysqli_fetch_assoc($query);
		} else {
			$message = "<p class='error'>User not found.</p>";
		}
	} else {
		header("location: user.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$user_id = mysqli_real_escape_string($connection, $_POST['id']);
		$account_type = mysqli_real_escape_string($connection, $_POST['account_type']);
		$status = mysqli_real_escape_string($connection, $_POST['status']);

		$check_user = mysqli_query($connection, "SELECT * FROM tbl_user WHERE user_id = '$user_id'");
		$rows = mysqli_num_rows($check_user);
		if ($rows == 1) {
			$sql = "UPDATE tbl_user SET account_type = '$account_type', status = '$status' WHERE user_id = '$user_id'";
			if (mysqli_query($connection, $sql)) {
				header("location: user.php");
			} else {
				$message = "<p class='error'>Failed to update record.</p>";
			}
		} else {
			$message = "<p class='error'>User not found.</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit User</title>
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
		}
		h2 {
			text-align: center;
			color: #333;
			margin-bottom: 20px;
		}
		.input-group {
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
		<h2>Edit User</h2>
		<?php if (isset($message)) { echo $message; } ?>
		<form action="" method="POST">
			<div class="input-group">
				<label for="user_id">User ID</label>
				<input type="text" name="user_id" id="user_id" required value="<?php echo isset($data['user_id']) ? $data['user_id'] : ''; ?>">
			</div>
			<div class="input-group">
				<label for="account_type">Account Type</label>
				<select name="account_type" id="account_type" required>
					<option value="Admin" <?php echo (isset($data['account_type']) && $data['account_type'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
					<option value="User" <?php echo (isset($data['account_type']) && $data['account_type'] == 'User') ? 'selected' : ''; ?>>User</option>
				</select>
			</div>
			<div class="input-group">
				<label for="status">Status</label>
				<select name="status" id="status" required>
					<option value="Active" <?php echo (isset($data['status']) && $data['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
					<option value="Inactive" <?php echo (isset($data['status']) && $data['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
				</select>
			</div>
			<button type="submit" class="btn-submit">UPDATE</button>
		</form>
	</div>
</body>
</html>
