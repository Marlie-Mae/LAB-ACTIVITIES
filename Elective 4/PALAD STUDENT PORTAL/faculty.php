<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Faculty Table</title>
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
		#faculty {
			width: 100% !important;
			border-collapse: collapse;
			margin-top: 20px;
		}
		#faculty th, #faculty td {
			padding: 12px 15px;
			text-align: left;
			border: 1px solid #ddd;
		}
		#faculty th {
			background-color: lightseagreen;
			color: white;
			font-weight: bold;
		}
		#faculty td {
			background-color: #ffffff;
		}
		#faculty tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		/* Hover Effect for Rows */
		#faculty tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Action Link Styling */
		#faculty td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#faculty td a:hover {
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
            width: 90%;
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

        .edit-faculty {
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
			<h2>Faculty</h2>
		</div>

        <div style="text-align: left; margin-bottom: 20px;">
			<a id="addFacultyBtn" class="action-button">+ Add New</a>
		</div>


		<?php 
		include ("cn.php");
		$query = mysqli_query($connection, "SELECT * FROM tbl_faculty");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
		?>
			<table id="faculty" class="display">
				<thead>
					<tr>
						<th>Faculty Code</th>
						<th>Faculty Name</th>
						<th>Department Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ($data = mysqli_fetch_assoc($query)) {
					?>
						<tr>
							<td><?php echo $data['faculty_code']; ?></td>
							<td><?php echo $data['faculty_name']; ?></td>
							<td><?php echo $data['department_code']; ?></td>
							<td><a href="faculty-edit.php" class="edit-faculty" data-id="<?php echo $data['faculty_code']; ?>">Edit</a></td>
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
                    $('#faculty').DataTable();
                });
        </script>
        <script>
        $(document).ready(function() {
            // Open modal for "Add New"
            $("#addFacultyBtn").click(function() {
                $("#modalTitle").text("Add Faculty");
                $("#facultyForm")[0].reset();
                $("#faculty_code").val(""); 
                $("#facultyModal").fadeIn();
            });

            // Open modal for "Edit"
            $(document).on("click", ".edit-faculty", function(e) {
                e.preventDefault();
                var faculty_code = $(this).data("id");

                $.ajax({
                    url: "fetch_faculty.php",
                    type: "POST",
                    data: { faculty_code: faculty_code },
                    dataType: "json",
                    success: function(data) {
                        $("#modalTitle").text("Edit Faculty");
                        $("#faculty_code").val(data.faculty_code);
                        $("#faculty_name").val(data.faculty_name);
                        $("#department_code").val(data.department_code);
                        $("#facultyModal").fadeIn();
                    }
                });
            });

            // Close modal
            $(".close").click(function() {
                $("#facultyModal").fadeOut();
            });

            // Handle form submission
            $("#facultyForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "save_faculty.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#facultyModal").fadeOut();
                        location.reload(); // Refresh DataTable
                    }
                });
            });

            $("#addFacultyBtn").click(function() {
                $("#modalTitle").text("Add Faculty");
                $("#facultyForm")[0].reset(); // Clear form fields
                $("#faculty_code").val(""); 
                $("#facultyModal").fadeIn(); // Show modal
            });

            // Close modal when clicking "X"
            $(".close").click(function() {
                $("#facultyModal").fadeOut();
            });

            // Close modal when clicking outside
            $(window).click(function(event) {
                if ($(event.target).is("#facultyModal")) {
                    $("#facultyModal").fadeOut(); 
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
        <div id="facultyModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Add Faculty</h2>
                <form id="facultyForm">
                    <!--<input type="hidden" id="faculty_code" name="faculty_code">-->
                    <label>Faculty Code</label>
                    <input type="text" id="faculty_code" name="faculty_code" required>
                    <label>Faculty Name</label>
                    <input type="text" id="faculty_name" name="faculty_name" required>
                    <label>Department Code</label>
                    <input type="text" id="department_code" name="department_code" required>
                    
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>

	</div>

</body>
</html>
