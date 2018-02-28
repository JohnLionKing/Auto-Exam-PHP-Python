<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subjective Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />
<link rel="stylesheet" type="text/css" href="../CSS/jquery.countdown.css"> 
<style type="text/css">
	#defaultCountdown { width: 240px; height: 45px; }
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/subjectiveQns.js"></script>

<script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/85973903-0CB6-4244-9200-F1B2813F4E79/main.js" charset="UTF-8"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../js/jquery.plugin.min.js"></script> 
<script src="../js/jquery.countdown.js"></script>
<script>
$(function () {
	var day = new Date();
	day = new Date(day.getFullYear(), day.getMonth(), day.getDate(), day.getHours(), day.getMinutes()+55, 0, 0);
	$('#defaultCountdown').countdown({until: day});
});
</script>

</head>

<body oncontextmenu="return false;">
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>
<p>You have 55 minutes to finish this section. After they pass by your answers will be submitted automatically. thus, make sure to answer all questions promptly.</p>

<form method="post" action="../php/insertSubjToDB.php">
<table width="100%">
	<tr>
    	<td colspan="2" align="center">
        	<div id="defaultCountdown"></div>
        </td>
    </tr>
	<tr>
		<td width="90%"><input type="button" class="button" id="clearButton1" value="Clear Answers" /></td>
		<td><input type="submit" class="button" name="submitButton1" id="submitButton1" value="Submit Answers" /></td>
	</tr>
</table>

<script>
	setTimeout(function () {
		window.location.href = "../php/insertSubjToDB.php";
    }, 3300000);
</script>

<?php 
	session_start();
			
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");

	if (!$conn) {
   		die("Could not connect: " . mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM EssayQns ORDER BY RAND() LIMIT 5";
	$result = mysqli_query($conn, $sql);
		
	if (mysqli_num_rows($result) > 0) {
    	// output data of each row
		$index = 6;		
		$fetchedQuestions = array();
	    while($row = mysqli_fetch_assoc($result)) {
			if ($index == 6)
				$fetchedQuestions[$index] = $row["QID"];
			else
				array_push($fetchedQuestions, $row["QID"]);
				
			if ($row["Weight"] == 1)
				$points = 'Point';
			else
				$points = 'Points';
				
    	    echo '<p class="question">(' . $row["Weight"] . ' ' . $points .')&nbsp&nbsp&nbsp&nbsp' . $index . '. ' . $row['QDesc'] . '</p>';
			echo '<textarea name="q' . $index .  '" onfocus="clearContents(this);" id="Q' . $row["QID"] . '" rows="4" cols="100">Type your answer here.</textarea>';
			$index++;
	    }
		$_SESSION['FetchedQuestionsSubj'] = $fetchedQuestions;
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
		<td><input type="submit" class="button" name="submitButton2" id="submitButton2" value="Submit Answers" /></td>
	</tr>
</table>
</form>

</body>
</html>
