<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Approve Questions</title>
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css" />
</head>

<body>

<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>
<form action="../php/approveQns.php" method="post">

<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM MCQ_NotApproved";
	$result = mysqli_query($conn, $sql);
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%"><tr><td colspan="16"><h4>Objective Questions to be modified:</h4></td></tr>
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
					<td width="125px" align="center"><input type="submit" name="approveObj'. $row['QID'] . '" value="Approve" /></td>
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
		echo '<tr><td colspan="16"><h4 align="center"><input type="submit" name="approveAllObj" value="Approve all" /></h4></td></tr></table>';
	} else {
		echo '<tr><td><h4 style="color:blue" align="center">All Objective questions were approved successfully.</h4></td></tr></table>';
	}
	
	echo '</td></tr></table><br />';
	
	$sql = "SELECT * FROM EssayQns_NotApproved";
	$result = mysqli_query($conn, $sql);
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%">
				<tr>
					<td colspan="5">
						<h4>Subjective Questions to be modified:</h4>
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
			echo '<tr><td width="125px" align="center"><input type="submit" name="approveSubj'. $row['QID'] . '" value="Approve" /></td>
					<td align="center">'. $row['QID'] .'</td>
					<td align="center">'. $row['TypeID'] .'</td>
					<td>' . $row['QDesc'] . '</td>
					<td align="left">'. $row['Answer'] .'</td>
				</tr>';
			$i++;
		}
		echo '<tr><td colspan="5"><h4 align="center"><input type="submit" name="approveAllSubj" value="Approve all" /></h4></td></tr></table>';
	} else {
		echo '<tr><td><h4 style="color:blue" align="center">All Subjective questions were approved successfully.</h4></td></tr></table>';
	}
	
	echo '</td></tr></table><br />';

	$sql = "SELECT * FROM MCQ_NotApproved ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$objApproveButton = "approveObj" . $counter;
		if (isset($_POST[$objApproveButton])) {
			$sql = "SELECT * FROM MCQ ORDER BY QID DESC LIMIT 1";
			$result = mysqli_query($conn, $sql);		
			$row = mysqli_fetch_assoc($result);
			$numberOfRecords = $row['QID'];

			$sql = "SELECT * FROM MCQ_NotApproved WHERE QID = $counter";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$QDesc = $row['QDesc'];
			$A = $row['A'];
			$B = $row['B'];
			$C = $row['C'];
			$D = $row['D'];
			$E = $row['E'];
			$F = $row['F'];
			$G = $row['G'];
			$H = $row['H'];
			$I = $row['I'];
			$J = $row['J'];
			$K = $row['K'];
			$Answer = $row['Answer'];
			
			$sql = "INSERT INTO 
					MCQ (QID, TypeID, QDesc, A, B, C, D, E, F, G, H, I, J, K, Answer) 
					VALUES($numberOfRecords + 1, 1, '$QDesc', '$A', '$B', '$C', '$D', '$E', '$F', '$G', '$H', '$I', '$J', '$K', '$Answer')";
			mysqli_query($conn, $sql);

			$sql = "DELETE FROM MCQ_NotApproved WHERE QID = $counter";
			mysqli_query($conn, $sql);
		
			header("Refresh:0");
		}
		$counter = $counter - 1;
	}
	
	$sql = "SELECT * FROM EssayQns_NotApproved ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];

	while ($counter > 0) {
		$subjApproveButton = "approveSubj" . $counter;
		if (isset($_POST[$subjApproveButton])) {
			$sql = "SELECT * FROM EssayQns ORDER BY QID DESC LIMIT 1";
			$result = mysqli_query($conn, $sql);		
			$row = mysqli_fetch_assoc($result);
			$numberOfRecords = $row['QID'];

			$sql = "SELECT * FROM EssayQns_NotApproved WHERE QID = $counter";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$QDesc = $row['QDesc'];
			$Answer = $row['Answer'];

			$sql = "INSERT INTO 
					EssayQns (QID, TypeID, QDesc, Answer) 
					VALUES($numberOfRecords + 1, 1, '$QDesc', '$Answer')";
			mysqli_query($conn, $sql);

			$sql = "DELETE FROM EssayQns_NotApproved WHERE QID = $counter";
			mysqli_query($conn, $sql);
		
			header("Refresh:0");
		}
		$counter = $counter - 1;
	}

	$sql = "SELECT * FROM EssayQns_NotApproved ORDER BY QID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['QID'];
	
	if(isset($_POST['approveAllSubj'])) {
		while ($counter > 0) {
			$sql = "SELECT * FROM EssayQns ORDER BY QID DESC LIMIT 1";
			$result = mysqli_query($conn, $sql);		
			$row = mysqli_fetch_assoc($result);
			$numberOfRecords = $row['QID'];
			
			$sql = "SELECT * FROM EssayQns_NotApproved WHERE QID = $counter";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$QDesc = $row['QDesc'];
			$Answer = $row['Answer'];

			$sql = "INSERT INTO 
					EssayQns (QID, TypeID, QDesc, Answer) 
					VALUES($numberOfRecords + 1, 1, '$QDesc', '$Answer')";
			mysqli_query($conn, $sql);

			$sql = "DELETE FROM EssayQns_NotApproved WHERE QID = $counter";
			mysqli_query($conn, $sql);
			
			$counter = $counter - 1;
		}
		header("Refresh:0");
	}

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
</form>
</body>
</html>