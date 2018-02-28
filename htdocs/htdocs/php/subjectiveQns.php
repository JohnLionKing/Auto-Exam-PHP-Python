<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subjective Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />


<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/subjectiveQns.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form method="post" action="../php/insertSubjToDB.php">
<table width="100%">
	<tr>
		<td width="90%"><input type="button" class="button" id="clearButton1" value="Clear Answers" /></td>
		<td><input type="submit" class="button" name="submitButton1" id="submitButton1" value="Submit Answers" /></td>
	</tr>
</table>

<?php 
	session_start();
			
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");

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
    	    echo '<p class="question">' . $index . '. ' . $row['QDesc'] . '</p>';
			echo '<textarea name="q' . $index .  '" onfocus="clearContents(this);" id="Q' . $row["QID"] . '" rows="4" cols="100">Type your answer here.</textarea>';
			$index++;
	    }
		$_SESSION['FetchedQuestionsSubj'] = $fetchedQuestions;
	} else {
    	echo "No questions in the database to show";
	}
	
	mysqli_close($conn);
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
