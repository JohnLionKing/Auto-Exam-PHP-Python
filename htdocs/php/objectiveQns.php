<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Objective Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/jquery.countdown.css"> 
<style type="text/css">
	#defaultCountdown { width: 240px; height: 45px; }
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/objectiveQns.js"></script>
<script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/85973903-0CB6-4244-9200-F1B2813F4E79/main.js" charset="UTF-8"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../js/jquery.plugin.min.js"></script> 
<script src="../js/jquery.countdown.js"></script>
<script>
$(function () {
	var day = new Date();
	day = new Date(day.getFullYear(), day.getMonth(), day.getDate(), day.getHours()+1, day.getMinutes()+20, 0, 0);
	$('#defaultCountdown').countdown({until: day});
});
   
</script>

</head>

<body oncontextmenu="return false;">
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>
<p>You have 25 minutes to finish this section. After they pass by your answers will be submitted automatically. thus, make sure to answer all questions promptly.</p> 

<form method="post" action="../php/insertToDB.php">
<table width="100%">
	<tr>
    	<td colspan="2" align="center">
        	<div id="defaultCountdown"></div>
        </td>
    </tr>
	<tr>
		<td width="90%"><input type="button" class="button" id="clearButton1" value="Clear Answers" /></td>
		<td><input type="submit" class="button" name="button1" id="button1" value="Submit Answers" /></td>
	</tr>
</table>

<script>
	setTimeout(function () {
       window.location.href = "../php/insertToDB.php";
    }, 1500000);
</script>

<?php
	session_start();
			
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");

	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM MCQ ORDER BY RAND() LIMIT 5";
	$result = mysqli_query($conn, $sql);
		
	if (mysqli_num_rows($result) > 0) {
		
    	// output data of each row
		$index = 1;
		$fetchedQuestions = array();
	    while($row = mysqli_fetch_assoc($result)) {
			$_SESSION['i'] = "q" . $row["QID"];
			if ($index == 1)
				$fetchedQuestions[$index] = $row["QID"];
			else
				array_push($fetchedQuestions, $row["QID"]);
				
			if ($row["Weight"] == 1)
				$points = 'Point';
			else
				$points = 'Points';
			echo '<p class="question">(' . $row["Weight"] . ' ' . $points .')&nbsp&nbsp&nbsp&nbsp' . $index . '. ' . $row["QDesc"] . '</p>';
			echo '<ul class="answers" id="Q' . $index . '">';
			if ($row["A"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"A\" id=" . $_SESSION['i'] . "a\"><label for=" . $_SESSION['i'] . "A\">" . $row["A"] . ".</label><br />\n";
			if ($row["B"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"B\" id=" . $_SESSION['i'] . "b\"><label for=" . $_SESSION['i'] . "B\">" . $row["B"] . ".</label><br />\n";
			if ($row["C"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"C\" id=" . $_SESSION['i'] . "c\"><label for=" . $_SESSION['i'] . "B\">" . $row["C"] . ".</label><br />\n";
			if ($row["D"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"D\" id=" . $_SESSION['i'] . "d\"><label for=" . $_SESSION['i'] . "D\">" . $row["D"] . ".</label><br />\n";
			if ($row["E"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"E\" id=" . $_SESSION['i'] . "e\"><label for=" . $_SESSION['i'] . "E\">" . $row["E"] . ".</label><br />\n";
			if ($row["F"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"F\" id=" . $_SESSION['i'] . "f\"><label for=" . $_SESSION['i'] . "F\">" . $row["F"] . ".</label><br />\n";
			if ($row["G"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"G\" id=" . $_SESSION['i'] . "g\"><label for=" . $_SESSION['i'] . "G\">" . $row["G"] . ".</label><br />\n";
			if ($row["H"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"H\" id=" . $_SESSION['i'] . "h\"><label for=" . $_SESSION['i'] . "H\">" . $row["H"] . ".</label><br />\n";
			if ($row["I"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"I\" id=" . $_SESSION['i'] . "i\"><label for=" . $_SESSION['i'] . "I\">" . $row["I"] . ".</label><br />\n";
			if ($row["J"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"J\" id=" . $_SESSION['i'] . "j\"><label for=" . $_SESSION['i'] . "J\">" . $row["J"] . ".</label><br />\n";
			if ($row["K"] != null)
				echo "<input type=\"radio\" name=\"q" . $index . "\" value=\"K\" id=\"q" . $_SESSION['i'] . "k\"><label for=\"q" . $_SESSION['i'] . "K\">" . $row["K"] . ".</label><br />\n";
			echo '</ul>';//</form>';
			$index++;
	    }
		$_SESSION['FetchedQuestions'] = $fetchedQuestions;
	} else {
   		echo "No questions in the database to show";
	}
	mysqli_close($conn);
	$_SESSION['Username'] = $_SESSION['Username'];
	$_SESSION['Course'] = $_SESSION['Course'];
?>

<table width="100%">
	<tr>
		<td width="90%"><input type="button" class="button" id="clearButton2" value="Clear Answers" /></td>
		<td><input type="submit" class="button" name="button2" id="button2" value="Submit Answers" /></td>
	</tr>
</table>
</form>
            
</body>
</html>
