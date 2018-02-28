<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modify Users</title>

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
	
	if (isset($_POST['submitEdit'])) {
		$UID = $_SESSION['$UID'];
		$Username = $_POST['Username'];
		$Password = $_POST['Password'];
		$FName = $_POST['FName'];
		$LName = $_POST['LName'];
		$Role = $_POST['Role'];
		
		$sql = "UPDATE Users 
				SET Password='".$Password."', 
					FName='".$FName."', 
					LName='".$LName."', 
					Role='".$Role."' 
				WHERE Username = '" .$Username. "' 
				AND UID = " .$UID;
						
		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">User information were edited successfully.</h4>';
		else
			echo '<h4 style="color:red" align="center">Something went wrong!</h4>
					<h4 style="color:red" align="center">Your edit was not saved.</h4>';
		echo '<form method="post"><p align="center"><input name="Back1" type="submit" value="Back"</p></form>';
	} else if (isset($_POST['addUser'])) {
		echo '<form method="post" action="../php/userCreated.php">
				<p style="font-size:18px">Create a User:</p>
				<p>Username: <input type="text" name="Username" id="Username" placeholder="Username" onfocus="clearContents(this);" / ></p>
				<p>Password: <input type="password" name="Password" id="Password" placeholder="Password" onfocus="clearContents(this);" / ></p>
				<p>First Name: <input type="text" name="FName" id="FName" placeholder="First Name" onfocus="clearContents(this);" / ></p>
				<p>Last Name: <input type="text" name="LName" id="LName" placeholder="Last Name" onfocus="clearContents(this);" / ></p>				
				<p><select name="Role" id="Role">
					<option value="-">-- Select a role --</option>
					<option value="Student">Student</option>
					<option value="Instructor">Instructor</option>
					<option value="Head of Track">Head of Track</option>
					<option value="Head of Department">Head of Department</option>
					<option value="Administrator">Administrator</option>
				</select></p>
		
				<input type="submit" class="button" name="submitButton1" id="submitButton1" value="Create User" onclick="testTextAreas();" /></form>';
		echo '<form method="post"><p align="center"><input name="Cancel" type="submit" value="Cancel"</p></form>';
	} else {		
		$sql = "SELECT * FROM Users ORDER BY UID";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			echo '<form method="post">';
			echo '<table id="1" width="100%"><tr><td colspan="7"><h4>Users that exist in the database:</h4></td></tr>
					<tr><td width="125px" align="center" style="color:blue"></td>
						<td align="center" width="50px" style="color:blue">UID</td>
						<td align="center" width="60px" style="color:blue">Username</td>
						<td align="center" width="60px" style="color:blue">First Name</td>
						<td align="center" width="60px" style="color:blue">Last Name</td>
						<td align="center" width="60px" style="color:blue">Role</td></tr>';
		
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr>
						<td width="125px" align="center">
							<input type="submit" name="UserModify'. $row['UID'] . '" value="Modify" />
							<input type="submit" name="UserDel'. $row['UID'] . '" value="Delete" />								
						<td align="center">'. $row['UID'] .'</td>
						<td align="center">'. $row['Username'] .'</td>
						<td align="center">'. $row['FName'] .'</td>
						<td align="center">'. $row['LName'] .'</td>
						<td align="center">'. $row['Role'] .'</td>
					</tr>';
			}
			echo '</table>';
		} else
			echo '<h4 style="color:blue" align="center">There are no courses in the database.</h4>';

		$sql = "SELECT * FROM Users ORDER BY UID DESC LIMIT 1";
		$result = mysqli_query($conn, $sql);		
		$row = mysqli_fetch_assoc($result);
		$counter = $row['UID'];
		while ($counter > 0) {
			$userDelButton = "UserDel" . $counter;
			$userModifyButton = "UserModify" . $counter;
			if (isset($_POST[$userDelButton])) {
				$sql = "DELETE FROM Users WHERE UID = $counter";
				mysqli_query($conn, $sql);
				header("Refresh:0");
			} else if(isset($_POST[$userModifyButton])) {
				$_SESSION['sqlModifyUsers'] = "SELECT * FROM Users WHERE UID = $counter";
				header("Location: ../php/editUsers.php");
				exit;
			}	
			$counter = $counter - 1;
		}
		echo '<form method="post"><p align="center"><input name="Back" type="submit" value="Back"</p></form>';
	}
	if (isset($_POST['Back1'])) {
		header("Location: ../php/modifyUsers.php");
		exit;
	}
	
	if (isset($_POST['Back']) || isset($_POST['Cancel'])) {
		header("Location: ../php/start.php");
		exit;
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
	echo '<form method="post"><p align="center"><input name="Logout" type="submit" value="Logout"</p></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}
?>

</body>
</html>