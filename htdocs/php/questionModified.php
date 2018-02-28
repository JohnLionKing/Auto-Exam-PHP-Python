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
	
	$QDesc = $_POST['QuestionText'];
	$Answer = $_POST['Answer'];

	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}

	if (isset($_POST['Edit'])) {		
		if ($_POST['ChoiceA'] != NULL) $A = 'A. ' . $_POST['ChoiceA']; else $A = $_POST['ChoiceA'];
		if ($_POST['ChoiceB'] != NULL) $B = 'B. ' . $_POST['ChoiceB']; else $B = $_POST['ChoiceB'];
		if ($_POST['ChoiceC'] != NULL) $C = 'C. ' . $_POST['ChoiceC']; else $C = $_POST['ChoiceC'];
		if ($_POST['ChoiceD'] != NULL) $D = 'D. ' . $_POST['ChoiceD']; else $D = $_POST['ChoiceD'];
		if ($_POST['ChoiceE'] != NULL) $E = 'E. ' . $_POST['ChoiceE']; else $E = $_POST['ChoiceE'];
		if ($_POST['ChoiceF'] != NULL) $F = 'F. ' . $_POST['ChoiceF']; else $F = $_POST['ChoiceF'];
		if ($_POST['ChoiceG'] != NULL) $G = 'G. ' . $_POST['ChoiceG']; else $G = $_POST['ChoiceG'];
		if ($_POST['ChoiceH'] != NULL) $H = 'H. ' . $_POST['ChoiceH']; else $H = $_POST['ChoiceH'];
		if ($_POST['ChoiceI'] != NULL) $I = 'I. ' . $_POST['ChoiceI']; else $I = $_POST['ChoiceI'];
		if ($_POST['ChoiceJ'] != NULL) $J = 'J. ' . $_POST['ChoiceJ']; else $J = $_POST['ChoiceJ'];
		if ($_POST['ChoiceK'] != NULL) $K = 'K. ' . $_POST['ChoiceK']; else $K = $_POST['ChoiceK'];

		$sql = "SELECT * FROM MCQ_NotApproved ORDER BY QID DESC LIMIT 1";
		$result = mysqli_query($conn, $sql);		
		$row = mysqli_fetch_assoc($result);
		$numberOfRecords = $row['QID'];
	
		$sql = "SELECT * FROM MCQ_NotApproved WHERE QDesc = '$QDesc'";	
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0)
			$sql = "UPDATE MCQ_NotApproved 
					SET A='$A', B='$B', C='$C', D='$D', E='$E', F='$F', G='$G', H='$H', I='$I', J='$J', K='$K', Answer='$Answer'
					WHERE QDesc='$QDesc'";
		else {
			$sql = "INSERT INTO MCQ_NotApproved (QID, TypeID, QDesc, A, B, C, D, E, F, G, H, I, J, K, Answer) 
					VALUES ($numberOfRecords + 1, 1, '$QDesc', '$A', '$B', '$C', '$D', '$E', '$F', '$G', '$H', '$I', '$J', '$K', '$Answer')";
		}
	} else {
		$sql = "SELECT * FROM EssayQns_NotApproved";
		$result = mysqli_query($conn, $sql);
		$numberOfRecords = mysqli_num_rows($result);
	
		$sql = "SELECT * FROM EssayQns_NotApproved WHERE QDesc = '$QDesc'";	
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0)
			$sql = "UPDATE EssayQns_NotApproved 
					SET Answer='$Answer'
					WHERE QDesc='$QDesc'";
		else {
			$sql = "INSERT INTO EssayQns_NotApproved (QID, TypeID, QDesc, Answer) 
					VALUES ($numberOfRecords + 1, 2, '$QDesc', '$Answer')";
		}
	}
	
	if (mysqli_query($conn, $sql)) {
		echo '<h4 style="color:blue" align="center">Question was submitted successfully.</h4>
				<h4 style="color:blue" align="center">Waiting to be approved by the Principal.</h4>';
		echo '<form action="../php/createQns.php" method="post"><table align="center"><tr><td><input type="submit" name="createObjQns" value="Create an Objective Question"</td></tr></table></form>';
		echo '<form action="../php/createQns.php" method="post"><table align="center"><tr><td><input type="submit" name="createSubjQns" value="Create a Subjective Question"</td></tr></table></form>';
	} else {
		echo '<h4 style="color:red" align="center">Failed to write into DB.</h4>';
		echo '<h4 style="color:red" align="center">The server seems to be down.</h4>';
	}
	
	echo '<form action="../index.php" method="post"><table align="center"><tr><td><input name="Logout" type="submit" value="Logout"</td></tr></table></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}
?>

</body>
</html>