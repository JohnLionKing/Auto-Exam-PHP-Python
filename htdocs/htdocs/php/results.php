<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Results</title>

<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryMenuBarHorizontal.css" />
<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>
<h4 align="center" style="color:blue">Your Answers are:</h4>
<?php
	session_start();
	$username = $_SESSION['username'];
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");

	// Testing if connecting to the database fails.
	if (!$conn) {
   		die("Could not connect: " . mysqli_connect_error());
	}
	
	// fetching the user answers for the questions from the database for objective questions.
	$sql_userAnswers = "SELECT * FROM TestSession WHERE Username = '$username'";
	$result_userExists = mysqli_query($conn, $sql_userAnswers);

	if (mysqli_num_rows($result_userExists) <= 0) { //If the user has exam answers been recorded in the database
		echo '<div id="errorMessage" align="center"><p><span style="color:red">Error!</span> There were no questions saved in this session</p></div>';
		session_unset();
	} else {
		while($userAnswer = mysqli_fetch_assoc($result_userExists)) {
			// fetching the key answers for the questions from database for objective questions.
			$counter = 1;
			$correctObjAnswers = 0;
			foreach($_SESSION['FetchedQuestions'] as $x => $x_value) {
				$sql = "SELECT * FROM MCQ WHERE QID = " . $x_value;
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) { //If the question exists in the database
    				// output data of each row
					echo '<div id="objectiveAnswers" align="center">';
					while($row = mysqli_fetch_assoc($result)) {
						$QuestionName = "Q" . $counter;
						echo "<p>$QuestionName: " . $userAnswer[$QuestionName];
						if ($userAnswer[$QuestionName] != $row["Answer"]) {
							echo "<span style=\"color:red\">	(Incorrect)</span></p>";
						} else {
							echo "<span style=\"color:blue\">	(Correct!)</span></p>";
							$correctObjAnswers++;
						}
						$counter++;
					}
				}
			}
			echo "</div><p>You have earned: " . $correctObjAnswers . "/5 in the objective questions</p>";
	
			// fetching answers from database for subjective questions.	
			$counter = 6;
			$correctSubjAnswers = 0;
			foreach($_SESSION['FetchedQuestionsSubj'] as $x => $x_value) {
				$sql = "SELECT * FROM EssayQns WHERE QID = " . $x_value;
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
    				// output data of each row
					echo '<div id="subjectiveAnswers" align="center">';
		    		while($row = mysqli_fetch_assoc($result)) {
						$QuestionName = "Q" . $counter;
						echo "<p>$QuestionName: " . $userAnswer[$QuestionName];
						
						$url = 'http://www.scurtu.it/apis/documentSimilarity';

						$data = array(
							'doc1' => $userAnswer[$QuestionName],
							'doc2' => $row["Answer"]
						);
						
						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_HEADER, false);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
						$json_response = curl_exec($curl);
						$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
						curl_close($curl);
						$response = json_decode($json_response, true);
						
/*						// create a new cURL resource
						$ch = curl_init();

						// set URL and other appropriate options
						curl_setopt($ch, CURLOPT_URL, "kholoud.pythonanywhere.com/findSimilarity.py");
						curl_setopt($ch, CURLOPT_HEADER, 0);
						
						// grab URL and pass it to the browser
						curl_exec($ch);
						
						// close cURL resource, and free up system resources
						curl_close($ch);
*/						
/*						$tokenizedUserAnswer = array();
						$tokenizedKeyAnswer = array();
						$passedUserAnswer = $userAnswer[$QuestionName];
						$passedKeyAnswer = $row["Answer"];
						exec("java ManipulateText.class $passedUserAnswer", $tokenizedUserAnswer);
						exec("java ManipulateText.class $passedKeyAnswer", $tokenizedKeyAnswer);						
						if (!empty($tokenizedUserAnswer)) {
							$y_counter = 0;
							foreach($tokenizedUserAnswer as $y => $y_value) {
								$y_counter++;
								echo "<p>$y_counter. " . $y_value . "</p>";
							}
						} else {
							echo "<p>Tokenized User Answers is empty</p>";
						}
//						exec("java -jar Testphp2java.jar $some_value", $output);

						$arraysDifference = array_diff($tokenizedKeyAnswer, $tokenizedUserAnswer);
						if (empty($arraysDifference)) {
*/
//						if ($userAnswer[$QuestionName] != $row["Answer"]) {
						echo "<br /><p>Similarity between user answer and golden answer is: " . ($response['result'] * 100) . "%</p><p>Thus you answer is ";
						if ($response['result'] < 0.7) {
							echo "<span style=\"color:red\"> Incorrect</span></p>";
						} else {
							echo "<span style=\"color:blue\"> Correct!</span></p>";
							$correctSubjAnswers++;
						}
						$counter++;
					}
				}
			}
			echo "</div><p>You have earned: " . $correctSubjAnswers . "/5 in the subjective questions</p>";
			echo "</div><p>You have earned: " . ($correctSubjAnswers + $correctObjAnswers) . "/10 in total</p>";
		}
	}
	echo '<form action="../index.php" method="post"><table align="center"><tr><td><input name="Logout" type="submit" value="Logout"</td></tr></table></form>';
	
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}
?>

</body>
</html>
