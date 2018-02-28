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
	
	$QDesc = $_POST["QuestionText"];
	$Course = $_POST["Course"];
	$Answer = $_POST["Answer"];
	$Weight = $_POST["PossiblePoints"];

	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}

	if (isset($_POST['submitButton1'])) {		
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

		if ($_SESSION['Role'] == "Administrator")
			$tableName = "MCQ";
		else
			$tableName = "MCQ_NotApproved";

		$sql = "SELECT * FROM ".$tableName." ORDER BY QID DESC LIMIT 1";
		$result = mysqli_query($conn, $sql);		
		$row = mysqli_fetch_assoc($result);
		$numberOfRecords = $row['QID'];
	
		$sql = "SELECT * FROM ".$tableName." WHERE QDesc = '$QDesc'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0)
			$sql = "UPDATE ".$tableName." 
					SET Course='$Course', A='$A', B='$B', C='$C', D='$D', E='$E', F='$F', G='$G', H='$H', I='$I', J='$J', K='$K', Answer='$Answer', Weight='$Weight'
					WHERE QDesc='$QDesc'";
		else {
			$sql = "INSERT INTO ".$tableName." (QID, TypeID, Course, QDesc, A, B, C, D, E, F, G, H, I, J, K, Answer, Weight) 
					VALUES ($numberOfRecords + 1, 1, '$Course','$QDesc', '$A', '$B', '$C', '$D', '$E', '$F', '$G', '$H', '$I', '$J', '$K', '$Answer', '$Weight')";
		}
	} else {
		if ($_SESSION['Role'] == "Administrator")
			$tableName = "EssayQns";
		else
			$tableName = "EssayQns_NotApproved";

		$sql = "SELECT * FROM ".$tableName;
		$result = mysqli_query($conn, $sql);
		$numberOfRecords = mysqli_num_rows($result);
	
		$sql = "SELECT * FROM ".$tableName." WHERE QDesc = '$QDesc'";	
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0)
			$sql = "UPDATE ".$tableName." 
					SET Course='$Course', Answer='$Answer', Weight='$Weight'
					WHERE QDesc='$QDesc'";
		else {
			$sql = "INSERT INTO ".$tableName." (QID, TypeID, Course, QDesc, Answer, Weight) 
					VALUES ($numberOfRecords + 1, 2, '$Course', '$QDesc', '$Answer', '$Weight')";
		}
	}
	
	if (mysqli_query($conn, $sql)) {
		echo '<h4 style="color:blue" align="center">Question was submitted successfully.</h4>';
		if($_SESSION['Role'] != "Administrator")
			echo '<h4 style="color:blue" align="center">Waiting to be approved by the Head of Track.</h4>';
		echo '<form action="../php/createQns.php" method="post">
				<p align="center">
						<input type="submit" name="createObjQns" value="Create an Objective Question" />
						<input type="submit" name="createSubjQns" value="Create a Subjective Question" />
				</p>
			</form>';
		if($_SESSION['Role'] != "Administrator")
			echo '<form action="../php/modifyQuestions.php" method="post"><p align="center"><input type="submit" name="ModifySubmittedQns" value="View Submitted Questions" /></p></form>';
	} else {
		echo '<h4 style="color:red" align="center">Failed to write into DB.</h4>';
		echo '<h4 style="color:red" align="center">The server seems to be down.</h4>';
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