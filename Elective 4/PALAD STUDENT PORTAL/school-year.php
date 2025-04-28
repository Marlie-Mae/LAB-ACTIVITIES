<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>School Year Table</title>
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
		#school_year {
			width: 100% !important;
			border-collapse: collapse;
			margin-top: 20px;
		}
		#school_year th, #school_year td {
			padding: 12px 15px;
			text-align: left;
			border: 1px solid #ddd;
		}
		#school_year th {
			background-color: lightseagreen;
			color: white;
			font-weight: bold;
		}
		#school_year td {
			background-color: #ffffff;
		}
		#school_year tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		/* Hover Effect for Rows */
		#school_year tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Action Link Styling */
		#school_year td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#school_year td a:hover {
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

        .edit-school-year {
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
			<h2>School Year</h2>
		</div>

        <div style="text-align: left; margin-bottom: 20px;">
			<a id="addSchoolYearBtn" class="action-button">+ Add New</a>
		</div>


		<?php 
		include ("cn.php");
		$query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
		?>
			<table id="school_year" class="display">
				<thead>
					<tr>
						<th>School Year Code</th>
						<th>School Year</th>
						<th>Semester</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ($data = mysqli_fetch_assoc($query)) {
					?>
						<tr>
							<td><?php echo $data['school_year_code']; ?></td>
							<td><?php echo $data['school_year']; ?></td>
							<td><?php echo $data['semester']; ?></td>
							<td><?php echo $data['status']; ?></td>
                            <td><a href="school-year-edit.php" class="edit-school-year" data-id="<?php echo $data['school_year_code']; ?>">Edit</a></td>
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
                    $('#school_year').DataTable();
                });
        </script>
        <script>
        $(document).ready(function() {
            // Open modal for "Add New"
            $("#addSchoolYearBtn").click(function() {
                $("#modalTitle").text("Add School Year");
                $("#schoolyearForm")[0].reset();
                $("#school_year_code").val(""); 
                $("#schoolyearModal").fadeIn();
            });

            // Open modal for "Edit"
            $(document).on("click", ".edit-school-year", function(e) {
                e.preventDefault();
                var school_year_code = $(this).data("id");

                $.ajax({
                    url: "fetch_school_year.php",
                    type: "POST",
                    data: { school_year_code: school_year_code },
                    dataType: "json",
                    success: function(data) {
                        $("#modalTitle").text("Edit School Year");
                        $("#school_year_code").val(data.school_year_code);
                        $("#school_year").val(data.school_year);
                        $("#semester").val(data.semester);
                        $("#status").val(data.status);
                        $("#schoolyearModal").fadeIn();
                    }
                });
            });

            // Handle form submission
            $("#schoolyearForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "save_school_year.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#schoolyearModal").fadeOut();
                        location.reload(); // Refresh DataTable
                    }
                });
            });

            $("#addSchoolYearBtn").click(function() {
                $("#modalTitle").text("Add School Year");
                $("#schoolyearForm")[0].reset(); // Clear form fields
                $("#school_year_code").val(""); 
                $("#schoolyearModal").fadeIn(); // Show modal
            });

            // Close modal when clicking "X"
            $(".close").click(function() {
                $("#schoolyearModal").fadeOut();
            });

            // Close modal when clicking outside
            $(window).click(function(event) {
                if ($(event.target).is("#schoolyearModal")) {
                    $("#schoolyearModal").fadeOut(); 
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
        <div id="schoolyearModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Add School Year</h2>
                <form id="schoolyearForm">
                    <!--<input type="hidden" id="school_year_code" name="school_year_code">-->
                    <label>School Year Code</label>
                    <input type="text" id="school_year_code" name="school_year_code" required>

                    <label>School Year</label>
                    <input type="text" id="school_year" name="school_year" required>

                    <label>Semester</label>
                    <input type="number" id="semester" name="semester" min="1" max="2" required>
                    
                    <label>Status</label>
                    <input type="text" id="status" name="status" required>
                    
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
	</div>

</body>
</html>