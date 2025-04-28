<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subject Table</title>
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
		#subject {
			width: 100% !important;
			border-collapse: collapse;
			margin-top: 20px;
		}
		#subject th, #subject td {
			padding: 12px 15px;
			text-align: left;
			border: 1px solid #ddd;
		}
		#subject th {
			background-color: lightseagreen;
			color: white;
			font-weight: bold;
		}
		#subject td {
			background-color: #ffffff;
		}
		#subject tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		/* Hover Effect for Rows */
		#subject tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Action Link Styling */
		#subject td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#subject td a:hover {
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

        .edit-subject {
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
			<h2>Subject</h2>
		</div>

        <div style="text-align: left; margin-bottom: 20px;">
			<a id="addSubjectBtn" class="action-button">+ Add New</a>
		</div>

		<?php 
		include ("cn.php");
		$query = mysqli_query($connection, "SELECT * FROM tbl_subject");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
		?>
			<table id="subject" class="display">
				<thead>
					<tr>
						<th>Subject Code</th>
						<th>Subject Name</th>
						<th>Department Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ($data = mysqli_fetch_assoc($query)) {
					?>
						<tr>
							<td><?php echo $data['subject_code']; ?></td>
							<td><?php echo $data['subject_name']; ?></td>
							<td><?php echo $data['department_code']; ?></td>
                            <td><a href="subject-edit.php" class="edit-subject" data-id="<?php echo $data['subject_code']; ?>">Edit</a></td>
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
                    $('#subject').DataTable();
                });
        </script>
        <script>
        $(document).ready(function() {
            // Open modal for "Add New"
            $("#addSubjectBtn").click(function() {
                $("#modalTitle").text("Add Subject");
                $("#subjectForm")[0].reset();
                $("#subject_code").val(""); 
                $("#subjectModal").fadeIn();
            });

            // Open modal for "Edit"
            $(document).on("click", ".edit-subject", function(e) {
                e.preventDefault();
                var subject_code = $(this).data("id");

                $.ajax({
                    url: "fetch_subject.php",
                    type: "POST",
                    data: { subject_code: subject_code },
                    dataType: "json",
                    success: function(data) {
                        $("#modalTitle").text("Edit Subject");
                        $("#subject_code").val(data.subject_code);
                        $("#subject_name").val(data.subject_name);
                        $("#department_code").val(data.department_code);
                        $("#subjectModal").fadeIn();
                    }
                });
            });

            // Handle form submission
            $("#subjectForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "save_subject.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#subjectModal").fadeOut();
                        location.reload(); // Refresh DataTable
                    }
                });
            });

            $("#addSubjectBtn").click(function() {
                $("#modalTitle").text("Add Subject");
                $("#subjectForm")[0].reset(); // Clear form fields
                $("#subject_code").val(""); 
                $("#subjectModal").fadeIn(); // Show modal
            });

            // Close modal when clicking "X"
            $(".close").click(function() {
                $("#subjectModal").fadeOut();
            });

            // Close modal when clicking outside
            $(window).click(function(event) {
                if ($(event.target).is("#subjectModal")) {
                    $("#subjectModal").fadeOut(); 
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
        <div id="subjectModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Add Subject</h2>
                <form id="subjectForm">
                    <!--<input type="hidden" id="subject_code" name="subject_code">-->
                    <label>Subject Code</label>
                    <input type="text" id="subject_code" name="subject_code" required>

                    <label>Subject Name</label>
                    <input type="text" id="subject_name" name="subject_name" required>
                    
                    <label>Department Code</label>
                    <input type="text" id="department_code" name="department_code" required>
                    
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
	</div>

</body>
</html>
