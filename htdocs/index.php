<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<?php
	session_start();
	
	if (isset($_POST['Login']))
		echo '<h4 style="color:red" align="center">The username and password you entered are incorrect.</h4>
				<h4 style="color:red" align="center">Make sure you entered your creditials correctly.</h4>';
		
	echo '<table align="center">
			<tr>
				<th><h4 style="color:blue" align="center">Enter you credintials</h4></th>
			</tr>
  			<tr>
				<td>
					<form method="post" action="">
						<p align="center">Username: <input type="text" name="Username" /></p>
					    <p align="center">Password: <input type="password" name="Password" /></p>
			            <p align="center"><input type="submit" name="Login" value="Login" /></p>
					</form>
			  </td>
			</tr>
		</table>';
			
	if (isset($_POST['Username']) && isset($_POST['Password'])) {
		$_SESSION['Username'] = $_POST['Username'];
		$_SESSION['Password'] = $_POST['Password'];
	
		$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
		//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");

		if (!$conn)
   			die("Could not connect: " . mysqli_connect_error());
	
		$sql = "SELECT * FROM Users WHERE Username='" . $_SESSION['Username'] . "' AND Password='" . $_SESSION['Password'] . "'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['UID'] = $row['UID'];
			$_SESSION['firstName'] = $row['FName'];
			$_SESSION['lastName'] = $row['LName'];
			$_SESSION['Role'] = $row['Role'];
			//header("Location: ../php/start.php");
			header("Location: 	php/start.php");
			exit;
		}
	}
?>
</body>
</html>