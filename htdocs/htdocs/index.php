<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<table align="center">
  <tr><th>Enter you credintials</th></tr>
  <tr><td>
	  <form action="index.php" method="post">
			<p align="center">Username: <input type="text" name="username" /></p>
		    <p align="center">Password: <input type="password" name="password" /></p>
            <p align="center"><input type="submit" value="Login" /></p>
      </form>
  </td></tr>
</table>
<?php
	session_start();
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		checkUsername();		
	}
	 
	function checkUsername() {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password']; 
	
		$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");

		if (!$conn) {
   			die("Could not connect: " . mysqli_connect_error());
		}
	
		$sql = "SELECT FName FROM Users WHERE Username='" . $_SESSION['username'] . "' AND Password='" . $_SESSION['password'] . "'";
			
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['firstName'] = $row['FName'];//$_POST['FName'];
			header("Location: ../php/start.php");
			exit;
		} else {
			echo "<script type='text/javascript'>alert('" . $SESSION['username'] . " does not exist!')</script>";
		}
	}
?>
</body>
</html>