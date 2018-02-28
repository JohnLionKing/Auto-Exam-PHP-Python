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
	
	$username = $_SESSION['username'];
	$_SESSION['q1'] = $_POST['q1'];
	$_SESSION['q2'] = $_POST['q2'];
	$_SESSION['q3'] = $_POST['q3'];
	$_SESSION['q4'] = $_POST['q4'];
	$_SESSION['q5'] = $_POST['q5'];
	
	$q1 = $_SESSION['q1'];
	$q2 = $_SESSION['q2'];
	$q3 = $_SESSION['q3'];
	$q4 = $_SESSION['q4'];
	$q5 = $_SESSION['q5'];

	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM TestSession WHERE Username = '$username'";	
	$result = mysqli_query($conn, $sql);
		
	if (mysqli_num_rows($result) > 0)
		$sql = "UPDATE TestSession 
				SET Q1='$q1', Q2='$q2', Q3='$q3', Q4='$q4', Q5='$q5'
				WHERE Username='$username'";
	else
		$sql = "INSERT INTO TestSession (Username, Q1, Q2, Q3, Q4, Q5) 
				VALUES ('$username', '$q1', '$q2', '$q3', '$q4', '$q5')";
	
	
	if (mysqli_query($conn, $sql)) {
		echo '<h4 style="color:blue" align="center">Question answers were submitted successfully.</h4>';
		echo '<form action="../php/subjectiveQns.php" method="post"><table align="center"><tr><td><input type="submit" value="Next Section"</td></tr></table></form>';
	} else {
		echo '<h4 style="color:red" align="center">Failed to write into DB.</h4>';
		echo '<h4 style="color:red" align="center">The server seems to be down.</h4>';
		echo '<form action="../index.php" method="post"><table align="center"><tr><td><input name="Logout" type="submit" value="Logout"</td></tr></table></form>';
	}
	
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}

?>

</body>
</html>