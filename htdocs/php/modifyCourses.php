<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modify Courses</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css" />

<script type="text/javascript" src="../js/jquery.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn)
		die("Could not connect: " . mysqli_connect_error());
	
	if (isset($_POST['submitButton1'])) {
		$CID = $_SESSION['$CID'];
		$CourseCode = $_POST['CCode'];
		$CourseName = $_POST['CName'];
		
		$sql = "UPDATE Courses 
				SET CCode = '".$CourseCode."', CName='".$CourseName."'
				WHERE CID = " .$CID;
		
		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">Course information were edited successfully.</h4>';
		else
			echo '<h4 style="color:red" align="center">Something went wrong!</h4>
					<h4 style="color:red" align="center">Your edit was not saved.</h4>';
		
	} else if (isset($_POST['createCourse'])) {
		echo '<form method="post" action="../php/courseCreated.php">
				<p style="font-size:18px">Create a Course:</p>';
		echo '<p>Course Code: <input type="text" name="CCode" id="Course Code" placeholder="Course Code" onfocus="clearContents(this);" /></p>
				<p>Course Name: <input type="text" name="CName" id="Course Name" placeholder="Course Name" onfocus="clearContents(this);" / ></p>			
				<input type="submit" class="button" name="submitButton1" id="submitButton1" value="Create Course" onclick="testTextAreas();" />';
		echo '</form>';
	} else {		
		$sql = "SELECT * FROM Courses ORDER BY CID";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			echo '<form method="post" action="../php/modifyCourses.php">';
			echo '<table id="1" width="100%"><tr><td colspan="7"><h4>Courses that exist in the database:</h4></td></tr>
					<tr><td width="50px" align="left" style="color:blue"></td>
						<td align="left" width="50px" style="color:blue">CID</td>
						<td align="left" width="50px" style="color:blue">Course Code</td>
						<td align="left" width="60px" style="color:blue">Course Name</td></tr>';
			
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr>
						<td width="125px" align="left">
							<input type="submit" name="CourseModify'. $row['CID'] . '" value="Modify" />
							<input type="submit" name="CourseDel'. $row['CID'] . '" value="Delete" />								
						<td align="left">'. $row['CID'] .'</td>
						<td align="left" width="100px">'. $row['CCode'] .'</td>
						<td align="left" width="">'. $row['CName'] .'</td>
					</tr>';
			}
			echo '</table></form>';
		} else
			echo '<h4 style="color:blue" align="center">There are no courses in the database.</h4>';
	}
	
	$sql = "SELECT * FROM Courses ORDER BY CID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['CID'];

	while ($counter > 0) {
		$courseDelButton = "CourseDel" . $counter;
		$courseModifyButton = "CourseModify" . $counter;
		if (isset($_POST[$courseDelButton])) {
			$sql = "DELETE FROM Courses WHERE CID = " . $counter;
			mysqli_query($conn, $sql);
			header("Refresh:0");
		} else if(isset($_POST[$courseModifyButton])) {
			$_SESSION['sqlModifyCourses'] = "SELECT * FROM Courses WHERE CID = " . $counter;
			header("Location: ../php/editCourses.php");
			exit;
		}
		$counter = $counter - 1;
	}

?>
<script>

function addInput(){
	var lastOption = $('#Answer option:last-child').val();
	var countBox = String.fromCharCode(lastOption.charCodeAt() + 1);
	var boxName = "Choice" + countBox;
	document.getElementById("response").innerHTML += '<p><table><tr><td width="150px"></td><td align="left"></td></tr><tr><td colspan="2"><textarea name="' + boxName + '" placeholder="' + boxName + '" onfocus="clearContents(this);" rows="4" cols="100">'+ boxName +'</textarea></td></tr></table></p>';
	var str='<option value="'+ countBox +'">' + countBox + '</option>';
	$("#Answer").append(str);
	countBox = String.fromCharCode(countBox.charCodeAt() + 1);
}
			
function clearContents(element) {
	if (element.value == element.name)
		element.value = "";
}

function testDropDownMenu() {
	$("select").each(function() {
		if (this.value == "-") {
			event.preventDefault();
			alert("You\'re not done yet!\nYou still have to provide an role to this user");
		}
	});
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
		testDropDownMenu();
	}
}
</script>

<?php
	echo '<form action="../php/start.php" method="post"><p align="center"><input name="Back" type="submit" value="Back"</p></form>';
	if (isset($_POST['Back'])) {
		header("Location: ../php/start.php");
		exit;
	}
	
	echo '<form action="../index.php" method="post"><p align="center"><input name="Logout" type="submit" value="Logout"</p></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}
?>

</body>
</html>