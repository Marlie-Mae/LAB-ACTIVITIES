<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Table</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<style>
		body {
			font-family: 'Arial', sans-serif;
			background-color: #f8f9fa;
			margin: 0;
			padding: 20px;
		}
		.container {
			width: 100%;
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
			text-align: center;
		}
		h1 {
			color: #333;
		}

		.back-btn {
			background-color: #87CEEB;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
			text-decoration: none;
			display: inline-block;
			margin-bottom: 20px;
		}
		.back-btn:hover {
			background-color: #4682B4;
		}

		#student_info {
			width: 100% !important;
			border-collapse: collapse;
			margin-top: 20px;
		}
		#student_info th, #student_info td {
			padding: 12px 15px;
			text-align: left;
			border: 1px solid #ddd;
		}
		#student_info th {
			background-color: #87CEEB;
			color: white;
			font-weight: bold;
		}
		#student_info tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		#student_info tbody tr:hover {
			background-color: #f1f1f1;
		}

		#student_info td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#student_info td a:hover {
			text-decoration: underline;
		}

		/* Modal Styles */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
		}
		.modal-content {
			background-color: #fff;
			margin: 10% auto;
			padding: 20px;
			border-radius: 10px;
			width: 50%;
			text-align: left;
		}
		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
			cursor: pointer;
		}
		.close:hover {
			color: black;
		}
		.input-group {
			margin-bottom: 10px;
		}
		.input-group label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
		}
		.input-group input {
			width: 100%;
			padding: 8px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}
		.btn-submit {
			background-color: #87CEEB;
			color: white;
			border: none;
			padding: 10px;
			cursor: pointer;
			width: 100%;
			border-radius: 5px;
		}
		.btn-submit:hover {
			background-color: #4682B4;
		}
	</style>
</head>
<body>

	<div class="container">
        <button class="back-btn" id="openModal">Add</button>
		<a href="home.php" class="back-btn">← Back to Home</a>

		<h1>Student Information</h1>

		<?php 
		include ("cn.php");
		$query = mysqli_query($connection, "SELECT * FROM tbl_student_info");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
		?>
			<table id="student_info" class="display">
				<thead>
					<tr>
						<th>Student No.</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Course</th>
						<th>Year Level</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ($data = mysqli_fetch_assoc($query)) {
					?>
						<tr>
							<td><?php echo $data['student_no']; ?></td>
							<td><?php echo $data['last_name']; ?></td>
							<td><?php echo $data['first_name']; ?></td>
							<td><?php echo $data['middle_name']; ?></td>
							<td><?php echo $data['course_code']; ?></td>
							<td><?php echo $data['year_level']; ?></td>
							<td><a href="student-edit.php?student_no=<?php echo $data['student_no']; ?>">Edit</a></td>
						</tr>
					<?php 
						} 
					?>
				</tbody>
			</table>

			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
			<script>
				$(document).ready(function() {
					$('#student_info').DataTable();
				});

				// Modal functionality
				var modal = document.getElementById("myModal");
				var btn = document.getElementById("openModal");
				var closeBtn = document.getElementsByClassName("close")[0];

				btn.onclick = function() {
					modal.style.display = "block";
				}

				closeBtn.onclick = function() {
					modal.style.display = "none";
				}

				window.onclick = function(event) {
					if (event.target == modal) {
						modal.style.display = "none";
					}
				}
			</script>

		<?php 
		} else {
			echo "<p>No students found.</p>";
		}
		?>
	</div>

	<!-- MODAL STRUCTURE -->
	<div id="myModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h2>Add New Student</h2>
			<form method="post" action="student-new.php">
				<div class="input-group">
					<label for="student_no">Student No.</label>
					<input type="text" name="student_no" id="student_no" required>
				</div>
				<div class="input-group">
					<label for="last_name">Last Name</label>
					<input type="text" name="last_name" id="last_name" required>
				</div>
				<div class="input-group">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" id="first_name" required>
				</div>
				<div class="input-group">
					<label for="middle_name">Middle Name</label>
					<input type="text" name="middle_name" id="middle_name" required>
				</div>
				<div class="input-group">
					<label for="course_code">Course</label>
					<input type="text" name="course_code" id="course_code" required>
				</div>
				<div class="input-group">
					<label for="year_level">Year Level</label>
					<input type="number" name="year_level" id="year_level" min="1" max="4" required>
				</div>
				<div class="input-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" required>
				</div>
				<button type="submit" class="btn-submit">Insert</button>
			</form>
		</div>
	</div>

</body>
</html>
