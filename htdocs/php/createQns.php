<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<script type="text/javascript" src="../js/jquery.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form method="post" action="../php/questionSubmitted.php">

<?php
	session_start();
	
	$conn = new mysqli("sql100.rf.gd","rfgd_18896475","K12345678", "rfgd_18896475_DB");
//$conn = new mysqli("localhost","root","mysql", "rfgd_18896475_DB");
	if (!$conn) {
		die("Could not connect: " . mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM Courses";
	$result = mysqli_query($conn, $sql);
	
	$selectTag = '<p><select name="Course" id="Course"><option selected="selected" value="-">-- Select a course --</option>';
	if (mysqli_num_rows($result) > 0) {
		$options = array();
		while($row = mysqli_fetch_assoc($result)) {
			$entry = $row['CCode'] . ': ' . $row['CName'];
			array_push($options, $entry);
			$selectTag = $selectTag . '<option value="' . $row['CCode'] . '">' . $entry . '</option>';
		}
	}
	$selectTag = $selectTag . '</select></p>';
	
	if (isset($_POST['objQns']) || isset($_POST['createObjQns'])) {
		echo '<p style="font-size:18px">Create an objective question:</p>';
		echo $selectTag;
		echo '<p><textarea name="QuestionText" id="Question Text" placeholder="Question Text" onfocus="clearContents(this);" rows="4" cols="100">Question Text</textarea></p>
				<p><textarea name="ChoiceA" id="Choice A" placeholder="Choice A" onfocus="clearContents(this);" rows="4" cols="100">Choice A</textarea></p>
				<p><textarea name="ChoiceB" id="Choice B" placeholder="Choice B" onfocus="clearContents(this);" rows="4" cols="100">Choice B</textarea></p>

				<span id="response"></span>
				<input type="button" class="button" id="addChoice" value="Add Choice" onclick="addInput();" />
				<input type="button" class="button" id="removeChoice" value="Remove Choice" onclick="removeInput();" />
				
				<p><select name="Answer" id="Answer">
					<option value="-">-- Select an answer --</option>
					<option value="A">A</option>
					<option value="B">B</option>
				</select></p>
				
				<p><input type="text" name="PossiblePoints" id="Possible Points" value="Possible Points" placeholder="Possible Points" onfocus="clearContents(this);" /></p>
				<input type="submit" class="button" name="submitButton1" id="submitButton1" value="Submit Question" onclick="testTextAreas();" />';
	}
	else if (isset($_POST['subjQns']) || isset($_POST['createSubjQns'])) {
		echo '<p style="font-size:18px">Create a subjective question:</p>';
		echo '<p><textarea name="QuestionText" id="Question Text" placeholder="Question Text" onfocus="clearContents(this);" rows="4" cols="100">Question Text</textarea></p>
				<p><textarea name="Answer" id="Answer" placeholder="Answer" onfocus="clearContents(this);" rows="4" cols="100">Answer</textarea></p>
				<p><input type="text" name="PossiblePoints" id="Possible Points" value="Possible Points" placeholder="Possible Points" onfocus="clearContents(this);" /></p>';
		echo '<input type="submit" class="button" name="submitButton2" id="submitButton2" value="Submit Question" onclick="testTextAreas();" />';
	}
?>
<script>

var lastOption = $('#Answer option:last-child').val();
var countBox = String.fromCharCode(lastOption.charCodeAt() + 1);
var boxName = "Choice " + countBox;

function addInput(){
	document.getElementById("response").innerHTML += '<p><textarea name="Choice' + countBox + '" id="' + boxName + '" placeholder="' + boxName + '" onfocus="clearContents(this);" rows="4" cols="100">'+ boxName +'</textarea></p>';
	var str='<option value="'+ countBox +'">' + countBox + '</option>';
	$("#Answer").append(str);
	countBox = String.fromCharCode(countBox.charCodeAt() + 1);
	boxName = "Choice " + countBox;
}
			
function removeInput() {
	var numberOfTextareas = $('textarea').size();
	if (numberOfTextareas > 3) {
		$('textarea:last').parent().remove();
		$('option:last').remove();
		numberOfTextareas--;
		countBox = String.fromCharCode(countBox.charCodeAt() - 1);
		boxName = "Choice " + countBox;
	} else {
		alert ("Choices cannot be less than two");
	}
}

function clearContents(element) {
	if (element.value == element.id)
		element.value = "";
}

function testInput() {
	$("input").each(function() {
		if (this.value == "Possible Points") {
			event.preventDefault();
			alert("You still need to provide the possible points for this question.");
		}
	});
}

function testDropDownMenu() {
	$("select").each(function() {
		if (this.value == "-") {
			event.preventDefault();
			alert("You\'re not done yet!\nYou still have to provide an answer to the question");
		} else {
			testInput();
		}
		
	});
}

function testTextAreas() {
	var missedTextAreas = "";
	var i = 0;
						
	// Testing if any of the textareas is left without filling.
	$("textarea").each(function() {
		if ((this.value == this.name) || (this.value == ""))
			missedTextAreas += this.name + "\n";
		else
			i++;
	});
						
	// Prompting the user in case any textarea was left without answering
	if (missedTextAreas.length > 1) {
		event.preventDefault();
		alert("You\'re not done yet!\nYou still have some textareas to fill:\n" + missedTextAreas);
	} else {
		$("#submitButton1").unbind("click");
		$("#submitButton2").unbind("click");
		testDropDownMenu();
	}
}
</script>
</td></tr></table></form>

<?php
	$_SESSION['Role'] = $_SESSION['Role'];
	echo '<form action="../php/start.php" method="post"><p align="center"><input name="Cancel" type="submit" value="Cancel"</p></form>';
	if (isset($_POST['Cancel'])) {
		header("Location: ../php/start.php");
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