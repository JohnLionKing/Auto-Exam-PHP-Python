<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modify Approved Quesitons</title>
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css" />
</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form method="post" action="../php/modifyApprovedQuestions.php">

<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn)
		die("Could not connect: " . mysqli_connect_error());
	
	if(isset($_POST['submitButton1']) || isset($_POST['submitButton2'])) {
		$QID = $_SESSION['$QID'];
		$TypeID = $_SESSION['$TypeID'];
		$QDesc = $_POST['QuestionText'];
		$Answer = $_POST['Answer'];
		
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

			$sql = "UPDATE MCQ_NotApproved SET QDesc='".$QDesc."', A='".$A."', B='".$B."', C='".$C."', D='".$D."', E='".$E."', F='".$F."', G='".$G."', H='".$H."', I='".$I."', J='".$J."', K='".$K."', Answer='".$Answer."' WHERE QID=".$QID;
			
		} else if (isset($_POST['submitButton2']))
			$sql = "UPDATE EssayQns_NotApproved SET QDesc='".$QDesc."', Answer='".$Answer."' WHERE QID=".$QID;
		
		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">The question was edited successfully.</h4>
					<h4 style="color:blue" align="center">Waiting to be approved by the Principal.</h4>';
		else
			echo '<h4 style="color:red" align="center">Something went wrong!</h4>
					<h4 style="color:red" align="center">Your edit was not saved.</h4>';
	}
	
	$sql = "SELECT * FROM MCQ";
	$result = mysqli_query($conn, $sql);
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%"><tr><td colspan="16"><h4>Approved Objective Questions to be modified:</h4></td></tr>
					<tr><td width="125px" align="center" style="color:blue"></td>
							<td align="center" width="50px" style="color:blue">QID</td>
							<td align="center" width="60px" style="color:blue">TypeID</td>
							<td align="left" width="300px" style="color:blue">Question Text</td>
							<td width="5%" style="color:blue">A</td>
							<td width="5%" style="color:blue">B</td>
							<td width="5%" style="color:blue">C</td>
							<td width="5%" style="color:blue">D</td>
							<td width="5%" style="color:blue">E</td>
							<td width="5%" style="color:blue">F</td>
							<td width="5%" style="color:blue">G</td>
							<td width="5%" style="color:blue">H</td>
							<td width="5%" style="color:blue">I</td>
							<td width="5%" style="color:blue">J</td>
							<td width="5%" style="color:blue">K</td>
							<td align="left" style="color:blue">Answer</td>
						</tr>';
		$i = 0;
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr>
						<td width="125px" align="center">
							<input type="submit" name="ObjEdit'. $row['QID'] . '" value="Edit" />
							<input type="submit" name="ObjDel'. $row['QID'] . '" value="Delete" />								
						<td align="center">'. $row['QID'] .'</td>
						<td align="center">'. $row['TypeID'] .'</td>
						<td>'. $row['QDesc'] . '</td>
						<td>'. $row['A'] .'</td>
						<td>'. $row['B'] .'</td>
						<td>'. $row['C'] .'</td>
						<td>'. $row['D'] .'</td>
						<td>'. $row['E'] .'</td>
						<td>'. $row['F'] .'</td>
						<td>'. $row['G'] .'</td>
						<td>'. $row['H'] .'</td>
						<td>'. $row['I'] .'</td>
						<td>'. $row['J'] .'</td>
						<td>'. $row['K'] .'</td>
						<td>'. $row['Answer'] .'</td>
					</tr>';
			$i++;
		}
		echo '</table>';
	} else
		echo '<h4 style="color:blue" align="center">There are no questions in the database.</h4>';
	echo '</td></tr></table><br />';
	
	$sql = "SELECT * FROM EssayQns";
	$result = mysqli_query($conn, $sql);
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%">
				<tr>
					<td colspan="5">
						<h4>Approved Subjective Questions to be modified:</h4>
					</td>
				</tr>
				<tr>
					<td width="125px" align="center" style="color:blue"></td>
					<td align="center" width="50px" style="color:blue">QID</td>
					<td align="center" width="60px" style="color:blue">TypeID</td>
					<td width="300px" style="color:blue">Question Text</td>
					<td style="color:blue">Answer</td>
				</tr>';	
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr>
					<td width="125px" align="center">
						<input type="submit" name="SubjEdit'. $row['QID'] . '" value="Edit" />
						<input type="submit" name="SubjDel'. $row['QID'] . '" value="Delete" />								
					</td>
					<td align="center">
						'. $row['QID'] .'
					</td>
					<td align="center">
							'. $row['TypeID'] .'
					</td>
					<td align="left" width="300px">
						' . $row['QDesc'] . '
					</td>
						<td align="left">'. $row['Answer'] .'</td>
				</tr>';
			$i++;
		}
		echo '</table>';
	} else
		echo '<h4 style="color:blue" align="center">There are no subjective questions in the database.</h4>';
	echo '</td></tr></table><br />';
	
	$sql = "SELECT * FROM MCQ ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$objDelButton = "ObjDel" . $counter;
		$objEditButton = "ObjEdit" . $counter;
		if (isset($_POST[$objDelButton])) {
			$sql = "DELETE FROM MCQ WHERE QID = $counter";
			mysqli_query($conn, $sql);
		
			header("Refresh:0");
		} else if(isset($_POST[$objEditButton])) {
			$_SESSION['sql'] = "SELECT * FROM MCQ WHERE QID = $counter";
			header("Location: ../php/editQns.php");
			exit;
		}
		$counter = $counter - 1;
	}

	$sql = "SELECT * FROM EssayQns ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$subjDelButton = "SubjDel" . $counter;
		$subjEditButton = "SubjEdit" . $counter;
		if (isset($_POST[$subjDelButton])) {

			$sql = "DELETE FROM EssayQns WHERE QID = $counter";
			mysqli_query($conn, $sql);
		
			header("Refresh:0");
		} else if(isset($_POST[$subjEditButton])) {
			$_SESSION['sql'] = "SELECT * FROM EssayQns WHERE QID = $counter";
			header("Location: ../php/editQns.php");
			exit;
		}
		$counter = $counter - 1;
	}
	
	echo '</form>';

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