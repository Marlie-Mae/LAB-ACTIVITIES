<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Table</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<style>
		/* Custom Styling for the Page */
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
		
		/* Back Button Styling */
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

		/* Table Styling */
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
			background-color: lightseagreen;
			color: white;
			font-weight: bold;
		}
		#student_info td {
			background-color: #ffffff;
		}
		#student_info tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		/* Hover Effect for Rows */
		#student_info tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Action Link Styling */
		#student_info td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#student_info td a:hover {
			text-decoration: underline;
		}

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
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 35%;
            max-width: 500px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Stack input fields on top of each other */
        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content input {
            width: 100%;
            padding: 5px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .modal-content label {
            margin-top: 10px;
            font-weight: 600;
        }

        .save-btn {
            background-color: lightseagreen;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            border: 2px solid #343a40 !important;
        }

        .save-btn:hover {
            background-color: #1CA099;
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        /* Style the container to align items in rows */
        .course-year-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two equal columns */
            gap: 10px; /* Add space between columns */
            margin-top: -5px;
            margin-bottom: 10px;
        }

        .course-year-container label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .course-year-container select {
            width: 80%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .action-button {
            padding: 10px 20px;
            background-color: lightseagreen;
            color: ghostwhite;
            text-decoration: none;
            border-radius: 4px;
            border: 2px solid #343A40 !important;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #1CA099;
        }

        .edit-student {
            text-decoration: none;
            padding: 3px 10px;
            border: 1px solid lightseagreen;
            color: lightseagreen;
        }
	</style>
</head>
<body>

	<div class="container">

        <div style="text-align: left; margin-bottom: 10px;">
			<h2>Student</h2>
		</div>

        <div style="text-align: left; margin-bottom: 20px;">
            <a id="addStudentBtn" class="action-button">+ Add New</a>
		</div>


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
                            <td><a href="student-edit.php" class="edit-student" data-id="<?php echo $data['student_no']; ?>">Edit</a></td>
		</tr>
					<?php 
						} // End of while loop
					?>
				</tbody>
			</table>

			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#student_info').DataTable();
                });
    </script>
    <script>
    $(document).ready(function() {
        // Open modal for "Add New"
        $(".action-button").click(function() {
            $("#modalTitle").text("Add Student");
            $("#studentForm")[0].reset();
            $("#student_no").val(""); // Clear student_no
            $("#studentModal").show();
        });

        // Open modal for "Edit"
        $(".edit-student").click(function(e) {
            e.preventDefault();
            var student_no = $(this).data("id");

            $.ajax({
                url: "fetch_student.php",
                type: "POST",
                data: { student_no: student_no },
                dataType: "json",
                success: function(data) {
                    $("#modalTitle").text("Edit Student");
                    $("#student_no").val(data.student_no);
                    $("#last_name").val(data.last_name);
                    $("#first_name").val(data.first_name);
                    $("#middle_name").val(data.middle_name);
                    $("#course_code").val(data.course_code);
                    $("#year_level").val(data.year_level);
                    $("#password").val(data.password).prop("disabled", false);
                    $("#studentModal").show();
                }
            });
        });

        // Close modal
        $(".close").click(function() {
            $("#studentModal").hide();
        });

        // Handle form submission
        $("#studentForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_student.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $("#studentModal").hide();
                    location.reload(); // Refresh DataTable
                }
            });
        });

        $("#addStudentBtn").click(function() {
            $("#modalTitle").text("Add Student");
            $("#studentForm")[0].reset(); // Clear form fields
            $("#student_no").val(""); // Clear hidden student_no field
            $("#studentModal").show(); // Show modal
        });

        // Close modal when clicking "X"
        $(".close").click(function() {
            $("#studentModal").hide();
        });

        // Close modal when clicking outside
        $(window).click(function(event) {
            if (event.target.id === "studentModal") {
                $("#studentModal").hide();
            }
        });
    });
    </script>

    <?php
        }
    ?>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap Modal -->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add Student</h2>
            <form id="studentForm">
                <!--<input type="hidden" id="student_no" name="student_no">-->
                <label>Student No.</label>
                <input type="text" id="student_no" name="student_no">
                <label>Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
                <label>First Name</label>
                <input type="text" id="first_name" name="first_name" required>
                <label>Middle Name</label>
                <input type="text" id="middle_name" name="middle_name">
                <!-- Wrap Course & Year Level in a flex container -->
        <!-- Course & Year Level container -->
    <div class="course-year-container">
        <div>
            <label for="course">Course</label>
            <select id="course_code" name="course_code">
                <option></option>
                <option value="BSIT">BSIT</option>
                <option value="BSCS">BSCS</option>
                <option value="BSECE">BSECE</option>
            </select>
        </div>

        <div>
            <label for="year_level">Year Level</label>
            <select id="year_level" name="year_level">
                <option></option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>
        </div>
    </div>

                <label>Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
            

</body>
</html>
