<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Grades</title>
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css" />
</head>

<body>

<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>
<form action="../php/viewGrades.php" method="post">

<?php
	session_start();
	
	$role = $_SESSION['Role'];
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) 
		die("Could not connect: " . mysqli_connect_error());
	
	if ($role == "Instructor")
		$sql = "SELECT * FROM TestSession";
	else if ($role == "Head of Department")
		$sql = "SELECT * FROM ApprovedByInst";
	$result = mysqli_query($conn, $sql);
	
	echo '<table border="1" width="100%"><tr><td>';
	if (mysqli_num_rows($result) > 0) {
		echo '<table id="1" border="0" width="100%"><tr><td colspan="4"><h4>Students grades to be approved:</h4></td></tr>
				<tr><td align="center" style="color:blue"></td>
					<td align="left" style="color:blue">Student ID</td>
					<td align="left" style="color:blue">Student Name</td>
					<td align="left" style="color:blue">Course Name</td>					
					<td align="left" style="color:blue">Student Grade</td>
				</tr>';
		while($row = mysqli_fetch_assoc($result)) {
			$sql1 = "SELECT * FROM Users WHERE Username = '". $row['Username'] . "'";
			$result1 = mysqli_query($conn, $sql1);
			if (mysqli_num_rows($result1) > 0) {
				$row1 = mysqli_fetch_assoc($result1);				
				$sql2 = "SELECT * FROM Courses WHERE CID = '". $row['CID'] . "'";
				$result2 = mysqli_query($conn, $sql2);
				if (mysqli_num_rows($result2) > 0)
					$row2 = mysqli_fetch_assoc($result2);	
			}
			echo '<tr>
					<td width="125px" align="center"><input type="submit" name="approveGrade'. $row['UID'] . '" value="Approve" /></td>
					<td align="left">'. $row['Username'] .'</td>
					<td align="left">'. $row1['FName'] .' '. $row1['LName'] .'</td>
					<td align="left">'. $row2['CCode'] .': '. $row2['CName'] .'</td>
					<td>'. $row['Grade'] . '</td>
				</tr>';
		}
		$fn = $row1['FName'];
		$ln = $row1['LName'];
		$CID = $row2['CID'];
		echo '<tr><td colspan="16"><h4 align="center"><input type="submit" name="approveAllGrades" value="Approve all" /></h4></td></tr></table>';
	} else 
		echo '<tr><td><h4 style="color:blue" align="center">All grades were approved successfully.</h4></td></tr></table>';
	
	echo '</td></tr></table><br />';

	if ($role == "Instructor")
		$tableName = 'TestSession';
	else if ($role == "Head of Department")
		$tableName = 'ApprovedByInst';
	$sql = "SELECT * FROM ".$tableName." ORDER BY UID DESC LIMIT 1";

	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['UID'];

	while ($counter > 0) {
		$approveButton = "approveGrade" . $counter;
		if (isset($_POST[$approveButton])) {
			if ($role == "Head of Department") 
				$tableName = "FinalGrades";
			else if ($role == "Instructor")
				$tableName = "ApprovedByInst";
			$sql = "SELECT * FROM ".$tableName." ORDER BY UID DESC LIMIT 1";
			$result = mysqli_query($conn, $sql);		
			$row = mysqli_fetch_assoc($result);
			$numberOfRecords = $row['UID'];

			if ($role == "Instructor")
				$tableName = "TestSession";
			else if ($role == "Head of Department") 
				$tableName = "ApprovedByInst";
			$sql = "SELECT * FROM ".$tableName." WHERE UID = " . $counter;
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$Username = $row['Username'];
			$firstName = $fn;
			$lastName = $ln;
			$Grade = $row['Grade'];
			
			// Moving record into its destination
			if ($role == "Head of Department")
				$tableName = 'FinalGrades';
			else if ($role == "Instructor")
				$tableName = 'ApprovedByInst';

			$sql = "SELECT * FROM ".$tableName." WHERE Username = '" . $username . "'";	
			$result = mysqli_query($conn, $sql);
		
			if (mysqli_num_rows($result) > 0)
				$sql = "UPDATE ".$tableName."
						SET FName='$firstName', LName='$lastName', CID='$CID', Grade='$Grade'
						WHERE Username='" . $username . "'";
			else
				$sql = "INSERT INTO 
						".$tableName." (UID, Username, FName, LName, CID, Grade) 
						VALUES($numberOfRecords + 1, '$Username', '$firstName', '$lastName', '$CID', '$Grade')";
			mysqli_query($conn, $sql);

			// Deleting record from its origin
			if ($role == "Head of Department")
				$tableName = 'ApprovedByInst';
			else if ($role == "Instructor")
				$tableName = 'TestSession';
				
			$sql = "DELETE FROM ".$tableName." WHERE UID = ".$counter;
			mysqli_query($conn, $sql);
		
			header("Refresh:0");
		}
		$counter = $counter - 1;
	}

	if ($role == "Instructor")
		$sql = "SELECT * FROM TestSession ORDER BY UID DESC LIMIT 1";
	else if ($role == "Head of Department")
		$sql = "SELECT * FROM ApprovedByInst ORDER BY UID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);		
	$row = mysqli_fetch_assoc($result);
	$counter = $row['UID'];
	
	if(isset($_POST['approveAllGrades'])) {
		while ($counter > 0) {
			if ($role == "Head of Department") 
				$sql = "SELECT * FROM FinalGrades ORDER BY UID DESC LIMIT 1";
			else if ($role == "Instructor")
				$sql = "SELECT * FROM ApprovedByInst ORDER BY UID DESC LIMIT 1";
			
			$result = mysqli_query($conn, $sql);		
			$row = mysqli_fetch_assoc($result);
			$numberOfRecords = $row['UID'];
						
			$Username = $row['Username'];
			$firstName = $fn;
			$lastName = $ln;
			$Grade = $row['Grade'];

			// Moving record into its destination
			if ($role == "Head of Department")
				$tableName = 'FinalGrades';
			else if ($role == "Instructor")
				$tableName = 'ApprovedByInst';

			$sql = "SELECT * FROM ".$tableName." WHERE Username = '" . $username . "'";	
			$result = mysqli_query($conn, $sql);
		
			if (mysqli_num_rows($result) > 0)
				$sql = "UPDATE ".$tableName."
						SET FName='$firstName', LName='$lastName', CID='$CID', Grade='$Grade'
						WHERE Username='" . $username . "'";
			else
				$sql = "INSERT INTO 
						".$tableName." (UID, Username, FName, LName, CID, Grade) 
						VALUES($numberOfRecords + 1, '$Username', '$firstName', '$lastName', '$CID', '$Grade')";
			mysqli_query($conn, $sql);

			// Deleting record from its origin
			if ($role == "Head of Department")
				$tableName = "ApprovedByInst";
			else if ($role == "Instructor")
				$tableName = "TestSession";
			$sql = "DELETE FROM ".$tableName." WHERE UID = " . $counter;
			mysqli_query($conn, $sql);
			
			$counter = $counter - 1;
		}
		header("Refresh:0");
	}

	echo '<form method="post"><p align="center"><input name="Back" type="submit" value="Back"</p></form>';
	if (isset($_POST['Back'])) {
		header("Location: ../php/start.php");
		exit;
	}
	
	echo '<form method="post"><p align="center"><input name="Logout" type="submit" value="Logout"</p></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}
?>
</form>
</body>
</html>