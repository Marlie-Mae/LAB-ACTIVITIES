<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Course Table</title>
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
            margin-top: 20px;
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
		#course {
			width: 100% !important;
			border-collapse: collapse;
			margin-top: 0px;
		}
		#course th, #course td {
			padding: 12px 15px;
			text-align: left;
			border: 1px solid #ddd;
		}
		#course th {
			background-color: lightseagreen;
			color: white;
			font-weight: bold;
		}
		#course td {
			background-color: #ffffff;
		}
		#course tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		/* Hover Effect for Rows */
		#course tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Action Link Styling */
		#course td a {
			color: #007bff;
			text-decoration: none;
			font-weight: bold;
		}
		#course td a:hover {
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

        .edit-course {
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
			<h2>Courses</h2>
		</div>

        <div style="text-align: left; margin-bottom: 20px;">
			<a id="addCourseBtn" class="action-button">+ Add New</a>
		</div>


		<?php 
		include ("cn.php");
		$query = mysqli_query($connection, "SELECT * FROM tbl_course");
		$rows = mysqli_num_rows($query);
		if ($rows > 0) {
		?>
			<table id="course" class="display">
				<thead>
					<tr>
						<th>Course Code</th>
						<th>Course Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						while ($data = mysqli_fetch_assoc($query)) {
					?>
						<tr>
							<td><?php echo $data['course_code']; ?></td>
							<td><?php echo $data['course_description']; ?></td>
                            <td><a href="course-edit.php" class="edit-course" data-id="<?php echo $data['course_code']; ?>">Edit</a></td>
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
                    $('#course').DataTable();
                });
        </script>
        <script>
        $(document).ready(function() {
            // Open modal for "Add New"
            $("#addCourseBtn").click(function() {
                $("#modalTitle").text("Add Course");
                $("#courseForm")[0].reset();
                $("#course_code").val(""); 
                $("#courseModal").fadeIn();
            });

            // Open modal for "Edit"
            $(document).on("click", ".edit-course", function(e) {
                e.preventDefault();
                var course_code = $(this).data("id");

                $.ajax({
                    url: "fetch_course.php",
                    type: "POST",
                    data: { course_code: course_code },
                    dataType: "json",
                    success: function(data) {
                        $("#modalTitle").text("Edit Course");
                        $("#course_code").val(data.course_code);
                        $("#course_description").val(data.course_description);
                        $("#courseModal").fadeIn();
                    }
                });
            });

            // Handle form submission
            $("#courseForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "save_course.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#courseModal").fadeOut();
                        location.reload(); // Refresh DataTable
                    }
                });
            });

            $("#addCourseBtn").click(function() {
                $("#modalTitle").text("Add Course");
                $("#courseForm")[0].reset(); // Clear form fields
                $("#course_code").val(""); 
                $("#courseModal").fadeIn(); // Show modal
            });

            // Close modal when clicking "X"
            $(".close").click(function() {
                $("#courseModal").fadeOut();
            });

            // Close modal when clicking outside
            $(window).click(function(event) {
                if ($(event.target).is("#courseModal")) {
                    $("#courseModal").fadeOut(); 
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
        <div id="courseModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Add Course</h2>
                <form id="courseForm">
                    <!--<input type="hidden" id="course_code" name="course_code">-->
                    <label>Course Code</label>
                    <input type="text" id="course_code" name="course_code" required>
                    <label>Course Description</label>
                    <input type="text" id="course_description" name="course_description" required>
                    
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
	</div>

</body>
</html>
