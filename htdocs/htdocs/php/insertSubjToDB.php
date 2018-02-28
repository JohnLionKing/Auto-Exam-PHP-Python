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
	$_SESSION['q6'] = $_POST['q6'];
	$_SESSION['q7'] = $_POST['q7'];
	$_SESSION['q8'] = $_POST['q8'];
	$_SESSION['q9'] = $_POST['q9'];
	$_SESSION['q10'] = $_POST['q10'];
	
	$q6 = $_SESSION['q6'];
	$q7 = $_SESSION['q7'];
	$q8 = $_SESSION['q8'];
	$q9 = $_SESSION['q9'];
	$q10 = $_SESSION['q10'];
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM TestSession WHERE Username = '$username'";	
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		$sql = "UPDATE TestSession 
				SET Q6 = '$q6', Q7 = '$q7', Q8 = '$q8', Q9 = '$q9', Q10 = '$q10', Done=1
				WHERE Username = '$username'";
	} else {
		$sql = "INSERT INTO TestSession (Username, Q6, Q7, Q8, Q9, Q10, Done) 
				VALUES ('$username', '$q6', '$q7', '$q8', '$q9', '$q10', 1)";
	}
				
	if (mysqli_query($conn, $sql)) {
		echo '<h4 style="color:blue" align="center">Question answers were submitted successfully.</h4>';
		echo '<form action="../php/results.php" method="post"><table align="center"><tr><td><input type="submit" value="View Results"</td></tr></table></form>';
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