<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modify Questions</title>
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css" />
</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form action="../php/modifyQuestions.php" method="post">
<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}
	
	if(isset($_POST['submitButton1']) || isset($_POST['submitButton2'])) {
		$QID = $_SESSION['$QID'];
		$TypeID = $_SESSION['$TypeID'];
		$Course = $_POST['Course'];
		$QDesc = $_POST['QuestionText'];
		$Answer = $_POST['Answer'];
		$Weight = $_POST['PossiblePoints'];
				
		if (isset($_POST['submitButton1'])) {
			$A = $_POST['ChoiceA'];
			$B = $_POST['ChoiceB'];
			$C = $_POST['ChoiceC'];
			$D = $_POST['ChoiceD'];
			$E = $_POST['ChoiceE'];
			$F = $_POST['ChoiceF'];
			$G = $_POST['ChoiceG'];
			$H = $_POST['ChoiceH'];
			$I = $_POST['ChoiceI'];
			$J = $_POST['ChoiceJ'];
			$K = $_POST['ChoiceK'];	

			$sql = "UPDATE MCQ_NotApproved SET Course='".$Course."', QDesc='".$QDesc."', A='".$A."', B='".$B."', C='".$C."', D='".$D."', E='".$E."', F='".$F."', G='".$G."', H='".$H."', I='".$I."', J='".$J."', K='".$K."', Answer='".$Answer."', Weight='".$Weight."' WHERE QID=".$QID;
			
		} else if (isset($_POST['submitButton2']))
			$sql = "UPDATE EssayQns_NotApproved SET Course='".$Course."', QDesc='".$QDesc."', Answer='".$Answer."', Weight='".$Weight."' WHERE QID=".$QID;
		
		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">The question was edited successfully.</h4>
					<h4 style="color:blue" align="center">Waiting to be approved by the Head of Track.</h4>';
		else
			echo '<h4 style="color:red" align="center">Something went wrong!</h4>
					<h4 style="color:red" align="center">Your edit was not saved.</h4>';
	}
	
//	$sql = "SELECT A.*, B.CCode, B.CName FROM MCQ_NotApproved A, Courses B Where A.Course = B.CCode";
	$sql = "SELECT * FROM MCQ_NotApproved";
	$result = mysqli_query($conn, $sql);
	
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%"><tr><td colspan="8"><h4>Objective Questions to be modified:</h4></td></tr>
					<tr><td width="75px"></td>
							<td align="center" valign="top" width="5%" style="color:blue">QID</td>
							<td align="center" valign="top" width="5%" style="color:blue">TypeID</td>
							<td align="center" valign="top" width="5%" style="color:blue">Course</td>
							<td align="left" valign="top" width="300px" style="color:blue">Question Text</td>
							<td align="left" valign="top" width="200px" style="color:blue">Choices</td>
							<td align="center" valign="top" width="5%" style="color:blue">Answer</td>
							<td align="center" valign="top" width="5%" style="color:blue">Points</td>
						</tr>';
		while($row = mysqli_fetch_assoc($result)) {
			$choices = $row['A'] . '<br />'. $row['B'];
			if ($row['C'] != '') $choices = $choices . '<br />'. $row['C'];
			if ($row['D'] != '') $choices = $choices . '<br />'. $row['D'];
			if ($row['E'] != '') $choices = $choices . '<br />'. $row['E'];
			if ($row['F'] != '') $choices = $choices . '<br />'. $row['F'];
			if ($row['G'] != '') $choices = $choices . '<br />'. $row['G'];
			if ($row['H'] != '') $choices = $choices . '<br />'. $row['H'];
			if ($row['I'] != '') $choices = $choices . '<br />'. $row['I'];
			if ($row['J'] != '') $choices = $choices . '<br />'. $row['J'];
			if ($row['K'] != '') $choices = $choices . '<br />'. $row['K'];
			echo '<tr><td colspan="8"><hr /></td></tr>
					<tr>
						<td width="75px" align="center" valign="top">
							<input type="submit" name="ObjEdit'. $row['QID'] . '" value="Edit" />
							<input type="submit" name="ObjDel'. $row['QID'] . '" value="Delete" />
						</td>															
						<td align="center" valign="top">'. $row['QID'] .'</td>
						<td align="center" valign="top">'. $row['TypeID'] .'</td>
						<td align="left" valign="top">'. $row['Course'] .'</td>
						<td align="left" valign="top">'. $row['QDesc'] . '</td>
						<td align="left" valign="top">'. $choices . '</td>
						<td align="center" valign="top">'. $row['Answer'] .'</td>
						<td align="center" valign="top">'. $row['Weight'] .'</td>
					</tr>';
		}
		echo '</table>';
	} else
		echo '<h4 style="color:blue" align="center">There are no questions to be edited.</h4>';
	echo '</td></tr></table><br />';
	
	$sql = "SELECT * FROM EssayQns_NotApproved";
	$result = mysqli_query($conn, $sql);
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%">
				<tr>
					<td colspan="8">
						<h4>Subjective Questions to be modified:</h4>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top" width="75px" style="color:blue"></td>
					<td align="center" valign="top" width="5%" style="color:blue">QID</td>
					<td align="center" valign="top" width="5%" style="color:blue">TypeID</td>
					<td align="center" valign="top" width="5%" style="color:blue">Course</td>
					<td align="left" valign="top" width="300px" style="color:blue">Question Text</td>
					<td align="left" valign="top" width="200px" style="color:blue">Answer</td>
					<td width="5%"></td>
					<td align="center" valign="top" width="5%" style="color:blue">Points</td>
				</tr>';	
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td colspan="8"><hr /></td></tr>
					<tr>
						<td width="75px" align="center">
							<input type="submit" name="SubjEdit'. $row['QID'] . '" value="Edit" />
							<input type="submit" name="SubjDel'. $row['QID'] . '" value="Delete" />
						</td>
						<td align="center" valign="top" width="5%">'. $row['QID'] .'</td>
						<td align="center" valign="top" width="5%">'. $row['TypeID'] .'</td>
						<td align="center" valign="top" width="5%">'. $row['Course'] .'</td>
						<td align="left" valign="top" width="300px">' . $row['QDesc'] . '</td>
						<td align="left" valign="top" width="200px">'. $row['Answer'] .'</td>
						<td width="5%"></td>
						<td align="center" valign="top" width="5%">'. $row['Weight'] .'</td>	
					</tr>';
		}
		echo '</table>';
	} else
		echo '<h4 style="color:blue" align="center">There are no questions to be edited.</h4>';
	echo '</td></tr></table><br />';
	
	$sql = "SELECT * FROM MCQ_NotApproved ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$objDelButton = "ObjDel" . $counter;
		$objEditButton = "ObjEdit" . $counter;
		if (isset($_POST[$objDelButton])) {
			$sql = "DELETE FROM MCQ_NotApproved WHERE QID = " . $counter;
			mysqli_query($conn, $sql);
			header("Refresh:0");
		} else if(isset($_POST[$objEditButton])) {
			$_SESSION['sql'] = "SELECT * FROM MCQ_NotApproved WHERE QID = " . $counter;
			header("Location: ../php/editQns.php");
			exit;
		}
		$counter = $counter - 1;
	}

	$sql = "SELECT * FROM EssayQns_NotApproved ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$subjDelButton = "SubjDel" . $counter;
		$subjEditButton = "SubjEdit" . $counter;
		if (isset($_POST[$subjDelButton])) {
			$sql = "DELETE FROM EssayQns_NotApproved WHERE QID = " . $counter;
			mysqli_query($conn, $sql);
			header("Refresh:0");
		} else if(isset($_POST[$subjEditButton])) {
			$_SESSION['sql'] = "SELECT * FROM EssayQns_NotApproved WHERE QID = ". $counter;
			header("Location: ../php/editQns.php");
			exit;
		}
		$counter = $counter - 1;
	}
	
	echo '</form>';

	if ($_SESSION['Role'] == 'Head of Track')
		echo '<form action="../php/createQns.php" method="post"><p align="center">
				<input type="submit" class="button" name="createObjQns" value="Create an Objective Question" />
				<input type="submit" class="button" name="createSubjQns" value="Create a Subjective Question" /></p>
			</form>';

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