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
	echo '<h4 style="color:blue" align="center">Welcome ' . $_SESSION['firstName'] . '</h4>';
	echo '<form action="../php/objectiveQns.php" method="post"><table align="center"><tr><td><input type="submit" value="Start the Exam"</td></tr></table></form>';
?>

</body>
</html>
