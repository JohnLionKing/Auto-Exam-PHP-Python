<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Course Information</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<script type="text/javascript" src="../js/jquery.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();
	
	$sql = $_SESSION['sqlModifyCourses'];
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}
	
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	
	echo '<p style="font-size:18px">Edit a Course:</p>';
	echo '<form method="post" action="../php/modifyCourses.php">';
	echo '<p><table><tr><td>Course Code: </td><td align="left" style="color:blue">'.$row["CCode"].'</td></tr><tr><td colspan="2"><input type="text" name="CCode" id="Enter New Course Code" placeholder="Enter New Course Code" value="Enter New Course Code" onfocus="clearContents(this);" /></td></tr></table></p>
			<p><table><tr><td>Course Name: </td><td align="left" style="color:blue">'. $row["CName"] .'</td></tr><tr><td colspan="2"><input type="text" name="CName" id="Enter New Course Name" placeholder="Enter New Course Name" value="Enter New Course Name" onfocus="clearContents(this);" /></td></tr></table></p>
			<p><input type="submit" class="button" name="submitButton1" id="submitButton1" value="Submit Changes" onclick="testTextAreas();" /></p></form>';
	
	$_SESSION['$CID'] = $row['CID'];
	
	echo '<form action="../php/modifyCourses.php" method="post"><p align="center"><input name="CancelEdit" type="submit" value="Cancel Edit"</p></form>';
	if (isset($_POST['CancelEdit'])) {
		header("Location: ../php/modifyCourses.php");
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
	if (element.value == element.id)
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