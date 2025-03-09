<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Portal | Students</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<div class="main-con">
		<div class="left-con">
			<div class="user-con">
				<div class="img-con"><img src="images/picture.png"></div>
				<div class="user-info">Admin<br>Fadrigo, Ryan Allan D.</div>
			</div>
			<div class="menu-con">
				<a href="#">SCHOOL YEAR</a>
				<a href="#">DEPARTMENTS</a>
				<a href="#">SUBJECTS</a>
				<a href="#">FACULTY</a>
				<a href="#" style="background-color: lightblue;
	border-radius: 7px;
	color: darkslategray;">STUDENTS</a>
				
				
				<a href="#">LOGOUT</a>
			</div>
		</div>
		<div class="right-con">
			<div class="top-nav">
				<div class="brand">STUDENT PORTAL</div>
			</div>
			<div class="body">
				<div class="content-title"><h1>STUDENTS</h1></div>
				<div class="content">
					<a id="addStudentBtn" class="action-button">+ Add New</a>
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
			<td><a href="#" class="edit-student" data-id="<?php echo $data['student_no']; ?>">Edit</a></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

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
            <input type="text" id="student_no" name="student_no" required>
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
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

</body>
</html>