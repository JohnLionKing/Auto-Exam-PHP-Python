<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit User Information</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<script type="text/javascript" src="../js/jquery.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();
	
	$sql = $_SESSION['sqlModifyUsers'];
	$username = $_SESSION['Username'];
	$uid = $_SESSION['UID'];
	$fn = $_SESSION['firstName'];
	$ln = $_SESSION['lastName'];
	$role = $_SESSION['Role'];	
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn)
		die("Could not connect: " . mysqli_connect_error());
	
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	echo '<p style="font-size:18px">Edit user information:</p>';

	if ($role == 'Administrator') {
		$navigate = '../php/modifyUsers.php';
		$disabled = '';
	} else {
		$navigate = '../php/start.php';
		$disabled = 'disabled="disabled"';
	}
	echo '<form method="post" action="'.$navigate.'">';
			
	echo '<p><table><tr><td>Username: </td><td align="left"></td></tr><tr><td colspan="2"><input type="text" name="Username" id="Username" value="'. $row['Username'].'" '.$disabled.' /></td></tr></table></p>
			<p><table><tr><td>Password: </td><td align="left"></td></tr><tr><td colspan="2"><input type="password" name="Password" id="Password" value="'.$row['Password'].'" onfocus="clearContents(this);" /></td></tr></table></p>
			<p><table><tr><td>First Name: </td><td align="left"></td></tr><tr><td colspan="2"><input type="text" name="FName" id="FName" value="'.$row['FName'].'" onfocus="clearContents(this);" /></td></tr></table></p>
			<p><table><tr><td>Last Name: </td><td align="left"></td></tr><tr><td colspan="2"><input type="text" name="LName" id="LName" value="'.$row['LName'].'" onfocus="clearContents(this);" /></td></tr></table></p>';

	if ($role == 'Administrator') {
		echo '<p><select name="Role" id="Role">
				<option value="-">-- Select a role --</option>';
		if (ucfirst($row['Role']) == "Student")
			echo '<option selected="selected" value="Student">Student</option>
					<option value="Instructor">Instructor</option>
					<option value="Head of Track">Head of Track</option>
					<option value="Head of Department">Head of Department</option>
					<option value="Administrator">Administrator</option>';
		else if (ucfirst($row['Role']) == "Instructor")
			echo '<option value="Student">Student</option>
					<option selected="selected" value="Instructor">Instructor</option>
					<option value="Head of Track">Head of Track</option>
					<option value="Head of Department">Head of Department</option>
					<option value="Administrator">Administrator</option>';	
		else if (ucfirst($row['Role']) == "Head of Track")
			echo '<option value="Student">Student</option>
					<option value="Instructor">Instructor</option>
					<option selected="selected" value="Head of Track">Head of Track</option>
					<option value="Head of Department">Head of Department</option>
					<option value="Administrator">Administrator</option>';
		else if (ucfirst($row['Role']) == "Head of Department")
			echo '<option value="Student">Student</option>
					<option value="Instructor">Instructor</option>
					<option value="Head of Track">Head of Track</option>
					<option selected="selected" value="Head of Department">Head of Department</option>
					<option value="Administrator">Administrator</option>';	
		else if (ucfirst($row['Role']) == "Administrator")
			echo '<option value="Student">Student</option>
					<option value="Instructor">Instructor</option>
					<option value="Head of Track">Head of Track</option>
					<option value="Head of Department">Head of Department</option>
					<option selected="selected" value="Administrator">Administrator</option>';
	echo '</select></p>';
	}
	echo '<input type="submit" class="button" name="submitEdit" id="submitEdit" value="Submit Changes" onclick="testTextAreas();" />';

	echo '</form>';
	
	$_SESSION['$UID'] = $row['UID'];
	
	echo '<form action="'.$navigate.'" method="post"><p align="center"><input name="CancelEdit" type="submit" value="Cancel Edit"</p></form>';
	if (isset($_POST['CancelEdit'])) {
		$where = "Location: " . $navigate;
		header($where);
		exit;
	}

	echo '<form action="../index.php" method="post"><p align="center"><input name="Logout" type="submit" value="Logout"</p></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}	
?>

<script>
function clearContents(element) {
	if (element.value == element.name)
		element.value = "";
}

function addInput(){
	var lastOption = $('#Answer option:last-child').val();
	var countBox = String.fromCharCode(lastOption.charCodeAt() + 1);
	var boxName = "Choice" + countBox;
	document.getElementById("response").innerHTML += '<p><table><tr><td width="150px"></td><td align="left"></td></tr><tr><td colspan="2"><textarea name="' + boxName + '" placeholder="' + boxName + '" onfocus="clearContents(this);" rows="4" cols="100">'+ boxName +'</textarea></td></tr></table></p>';
	var str='<option value="'+ countBox +'">' + countBox + '</option>';
	$("#Answer").append(str);
	countBox = String.fromCharCode(countBox.charCodeAt() + 1);
}

function testTextAreas() {
	var missedTextAreas = "";
	var i = 0;
						
	// Testing if any of the textareas is left without filling.
	$("textarea").each(function() {
		if ((this.value == this.name) || (this.value == ""))
			missedTextAreas += this.name + "\n";
		else
			i++;
	});
						
	// Prompting the user in case any textarea was left without answering
	if (missedTextAreas.length > 1) {
		event.preventDefault();
		alert("You\'re not done yet!\nYou still have some textareas to fill:\n" + missedTextAreas);
	} else {
		$("#submitButton1").unbind("click");
		$("#submitButton2").unbind("click");
	}
}
</script>

</body>
</html>