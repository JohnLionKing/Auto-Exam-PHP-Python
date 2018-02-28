<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Objective Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/objectiveQns.js"></script>

</head>

<body>

<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form method="post" action="../php/insertToDB.php">
<table width="100%">
	<tr>
		<td width="90%"><input type="button" class="button" id="clearButton1" value="Clear Answers" /></td>
		<td><input type="submit" class="button" name="button1" id="button1" value="Submit Answers" /></td>
	</tr>
</table>

<?php
	session_start();
			
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");

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
		
   		    echo '<p class="question">' . $index . ". " . $row["QDesc"] . "</p>";
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
