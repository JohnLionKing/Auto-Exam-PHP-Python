<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Save Confirmation</title>
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
</head>

<body>

<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}

	if (isset($_POST['submitButton1'])) {
		$Username = $_POST["Username"];
		$Password = $_POST["Password"];
		$FName = $_POST["FName"];
		$LName = $_POST["LName"];
		$Role = $_POST["Role"];
		
		$sql = "SELECT * FROM Users ORDER BY UID DESC LIMIT 1";
		$result = mysqli_query($conn, $sql);		
		$row = mysqli_fetch_assoc($result);
		$numberOfRecords = $row['UID'];
		
		$sql = "INSERT INTO Users (UID, Username, Password, FName, LName, Role) 
				VALUES ($numberOfRecords + 1, '$Username', '$Password', '$FName', '$LName', '$Role')";

		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">User was created successfully.</h4>';
		else {	
			echo '<h4 style="color:red" align="center">Failed to write into DB.</h4>';
			echo '<h4 style="color:red" align="center">The server seems to be down.</h4>';
		}
	}
	echo '<form action="../php/start.php" method="post"><p align="center"><input name="Done" type="submit" value="Done"</p></form>';
	if (isset($_POST['Done'])) {
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