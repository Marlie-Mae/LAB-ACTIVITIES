<?php
	$connection = mysqli_connect("localhost", "root", "", "testing");
	if (!$connection) {
		die("Database connection failed: " . mysqli_error());
	}
?>
