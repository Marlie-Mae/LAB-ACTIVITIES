<?php
	function checker($num) {
		if ($num%2==1){
			return "Odd";
		} else {
			return "Even";
		}
	}

	if (isset($_POST['submit'])){
		if(empty($_POST['first_num']) && empty($_POST['second_num'])) {
			$cond1 = true;
		} elseif (!empty($_POST['first_num']) && !empty($_POST['second_num'])) {
			$cond2 = true;
			$first_num = $_POST['first_num'];
			$second_num = $_POST['second_num'];
			$result1 = checker($first_num);
			$result2 = checker($second_num);
		} else {
			if (!empty($_POST['first_num'])) {
				$cond3 = true;
				$first_num = $_POST['first_num'];
				$result1 = checker($first_num);
			}
			if (!empty($_POST['second_num'])) {
				$cond4 = true;
				$second_num = $_POST['second_num'];
				$result2 = $_POST['second_num'];
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz 1</title>
</head>
<body>
<form action="" method="POST">
		<table cellpadding ="5">
			<tr>
				<td width ="100">First No.</td>
				<td><input type="text" name="first_num"></td>
			</tr>
				<td width ="100">Second No.</td>
				<td><input type="text" name="second_num"></td>
			</td>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="CHECK"></td>
			</tr>
		</table>
		<div class="result-container">
			<?php
				if(isset($cond1) && $cond1=true){
					echo "The value of first number is missing. <br> The Value of Second number is missing.";
				}
				if(isset($cond2) && $cond2=true){
					echo "The value of first number is " . $first_num . "<br> The value of second number is " . $second_num;
					echo ".<br> First number is " . $result1 . ".<br>Second number is " . $result2;
				}
				if(isset($cond3) && $cond3=true){
					echo "The value of first number " . $first_num . "<br> The value of second number is missing.";
					echo "<br>First number is " . $result1 . ".<br>Second number is missing.";
				}
				if(isset($cond4) && $cond4=true){
					echo "The value of first number is missing. <br> The value of second number is " . $second_num;
					echo "<br> First number is missing. <br>Second number is " . $result2;
				}

			?>
		</div>
		
	</form>
</div>
</body>
</html>