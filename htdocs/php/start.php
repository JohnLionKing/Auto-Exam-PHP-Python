<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<title>Start Page</title>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();	
	
	$Username = $_SESSION['Username'];
	$UID = $_SESSION['UID'];
	$fn = $_SESSION['firstName'];
	$ln = $_SESSION['lastName'];
	$role = $_SESSION['Role'];

	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");;
	if (!$conn)
		die("Could not connect: " . mysqli_connect_error());
	
	if (isset($_POST['submitEdit'])) {
		$Username = $_POST['Username'];
		$Password = $_POST['Password'];
		$FName = $_POST['FName'];
		$LName = $_POST['LName'];
		
		$sql = "UPDATE Users
				SET Password='".$Password."', 
					FName='".$FName."', 
					LName='".$LName."' 
				WHERE UID = " .$UID;

		if (mysqli_query($conn, $sql))
			echo '<h4 style="color:blue" align="center">User information were edited successfully.</h4>';
		else
			echo '<h4 style="color:red" align="center">Something went wrong!</h4>
					<h4 style="color:red" align="center">Your edit was not saved.</h4>';
	} else
		echo '<h4 style="color:blue" align="center">Welcome ' . $fn . ' ' . $ln . '</h4>';
	
	if (isset($_POST['FinalGrade'])) {
		$sql = "SELECT * from FinalGrades WHERE Username = '". $Username ."'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result))
				echo '<h4 style="color:blue" align="center">Your grade is: '.$row['Grade'].'</h4>';
		} else {
			echo '<h4 style="color:red" align="center">You do not have a grade stored in the database.</h4>';
			echo '<h4 style="color:red" align="center">Make sure that you took the exam. </h4>';
			echo '<h4 style="color:red" align="center">In case you did already, then your grade is still not approved by your instructor or the head of your department.</h4>';
		}
	}
	
	if (isset($_POST['StartExam'])) {
		if ($_POST['Course'] != '-') {			
			$_SESSION['Course'] = $_POST['Course'];
			header("Location: ../php/objectiveQns.php");
			exit;
		} else
		echo '<h4 style="color:red" align="center">You have to choose a course to start an exam.</h4>';
	}
					
	if($role == 'Student') {
		$sql1 = "SELECT * FROM Courses";
		$result1 = mysqli_query($conn, $sql1);
	
		$selectTag = '<p align="center"><select name="Course" id="Course"><option selected="selected" value="-">-- Select a course --</option>';
		if (mysqli_num_rows($result1) > 0) {
			$options = array();
			while($row1 = mysqli_fetch_assoc($result1)) {
				$entry = $row1['CCode'] . ': ' . $row1['CName'];
				array_push($options, $entry);
				$selectTag = $selectTag . '<option value="' . $row1['CCode'] . '">' . $entry . '</option>';
			}
		}
		$selectTag = $selectTag . '</select>';
		echo '<form method="post">
					<p align="center">'.$selectTag .'&nbsp;&nbsp;<input type="submit" name="StartExam" id="StartExam" value="Start the Exam" /></p>
				</form>';
		echo '<form method="post"><p align="center"><input type="submit" name="FinalGrade" value="View Final Grade" /></p></form>';
	} else {
		if ($role == 'Head of Track')
			echo '<form action="../php/approveQns.php" method="post"><p align="center"><input type="submit" value="Approve Questions"</p></form>';
		if ($role == 'Instructor')
			echo '<form action="../php/createQns.php" method="post"><p align="center">
					<input type="submit" class="button" name="createObjQns" value="Create an Objective Question" />
					<input type="submit" class="button" name="createSubjQns" value="Create a Subjective Question" /></p>
				</form>';
		echo '<form action="../php/modifyQuestions.php" method="post">
					<p align="center"><input type="submit" class="button" name="ModifySubmittedQns" value="View Submitted Questions" /></p>
				</form>';
		echo '<form action="../php/viewGrades.php" method="post"><p align="center"><input name="viewGrades" type="submit" value="View Grades"</p></form>';
		if ($role == 'Administrator')
			echo '<form action="../php/modifyApprovedQuestions.php" method="post">
					<p align="center">
						<input type="submit" name="viewApprovedQns" value="View Approved Questions" />
					</p>
					</form>
					<form action="../php/modifyUsers.php" method="post">
						<p align="center">
							<input type="submit" name="addUser" value="Create a User" />
							<input type="submit" name="modifyUser" value="View Users" />
						</p>
					</form>
					<form action="../php/modifyCourses.php" method="post">
						<p align="center">
							<input type="submit" class="button" name="createCourse" value="Create a Course" />
							<input type="submit" class="button" name="modifyCourse" value="View Courses" />
						</p>
					</form>';
	}
		
	$_SESSION['Role'] = $role;
	$_SESSION['Username'] = $_SESSION['Username'];
	
	$_SESSION['UID'] = $UID;
	$_SESSION['firstName'] = $fn;
	$_SESSION['lastName'] = $ln;

	if ($role != 'Administrator')
		echo '<form method="post"><p align="center"><input name="EditUser" type="submit" value="Edit User Account"</p></form>';
		if (isset($_POST['EditUser'])) {
			$_SESSION['sqlModifyUsers'] = "SELECT * FROM Users WHERE UID = " . $UID;
			header("Location: ../php/editUsers.php");
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
