<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Questions</title>

<link rel="stylesheet" type="text/css" href="../CSS/input.css" />

<script type="text/javascript" src="../js/jquery.js"></script>

</head>

<body>
<p align="center" style="font-size:24px">Objective and Subjective Questions Examination</p>

<form method="post" action="../php/modifyQuestions.php">

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
	
	$sql = $_SESSION['sql'];
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if ($row['TypeID'] == 1) {
		echo '<p style="font-size:18px">Edit an objective question:</p>';
		echo $selectTag;
		echo '<p><table><tr><td width="150px">Question Description: </td><td align="left">'. $row['QDesc'] .'</td></tr><tr><td colspan="2"><textarea name="QuestionText" placeholder="New value for Question Text" id="New value for Question Text" onfocus="clearContents(this);" rows="4" cols="100">New value for Question Text</textarea></td></tr></table></p>';		
		echo '<p><table><tr><td width="150px">Choice A: </td><td align="left">'.$row['A'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceA" placeholder="New value for Choice A" id="New value for Choice A" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice A</textarea></td></tr></table></p>
			<p><table><tr><td width="150px">Choice B: </td><td align="left">'.$row['B'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceB" placeholder="New value for Choice B" id="New value for Choice B" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice B</textarea></td></tr></table></p>';

		if($row['C'] != "")
			echo '<p><table><tr><td width="150px">Choice C: </td><td align="left">'.$row['C'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceC" placeholder="New value for Choice C" id="New value for Choice C" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice C</textarea></td></tr></table></p>';
		if($row['D'] != "")
			echo '<p><table><tr><td width="150px">Choice D: </td><td align="left">'.$row['D'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceD" placeholder="New value for Choice D" id="New value for Choice D" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice D</textarea></td></tr></table></p>';
		if($row['E'] != "")
			echo '<p><table><tr><td width="150px">Choice E: </td><td align="left">'.$row['E'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceE" placeholder="New value for Choice E" id="New value for Choice E" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice E</textarea></td></tr></table></p>';
		if($row['F'] != "")
			echo '<p><table><tr><td width="150px">Choice F: </td><td align="left">'.$row['F'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceF" placeholder="New value for Choice F" id="New value for Choice F" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice F</textarea></td></tr></table></p>';
		if($row['G'] != "")
			echo '<p><table><tr><td width="150px">Choice G: </td><td align="left">'.$row['G'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceG" placeholder="New value for Choice G" id="New value for Choice G" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice G</textarea></td></tr></table></p>';
		if($row['H'] != "")
			echo '<p><table><tr><td width="150px">Choice H: </td><td align="left">'.$row['H'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceH" placeholder="New value for Choice H" id="New value for Choice H" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice H</textarea></td></tr></table></p>';
		if($row['I'] != "")
			echo '<p><table><tr><td width="150px">Choice I: </td><td align="left">'.$row['I'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceI" placeholder="New value for Choice I" id="New value for Choice I" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice I</textarea></td></tr></table></p>';
		if($row['J'] != "")
			echo '<p><table><tr><td width="150px">Choice J: </td><td align="left">'.$row['J'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceJ" placeholder="New value for Choice J" id="New value for Choice J" onfocus="clearContents(this);" rows="4" cols="100">New value for Choice J</textarea></td></tr></table></p>';
		if($row['K'] != "")
			echo '<p><table><tr><td width="150px">Choice K: </td><td align="left">'.$row['K'].'</td></tr><tr><td colspan="2"><textarea name="ChoiceK" placeholder="New value for Choice K" id="New value for Choice K" onfocus="clearContents(this);" rows="4" cols="100">Choice K</textarea></td></tr></table></p>';

		echo '<span id="response"></span>
				<input type="button" class="button" id="addChoice" value="Add Choice" onclick="addInput();" />
				<input type="button" class="button" id="removeChoice" value="Remove Choice" onclick="removeInput();" />';

		echo '<p><select name="Answer" id="Answer">
				<option value="-">-- Select an answer --</option>';
		if ($row['Answer'] == "A")
			echo '<option selected="selected" value="A">A</option>
					<option value="B">B</option>';
		else if ($row['Answer'] == "B")
			echo '<option value="A">A</option>
					<option selected="selected" value="B">B</option>';
		else if ($row['Answer'] == "C")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option selected="selected" value="C">C</option>';
		else if ($row['Answer'] == "D")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option selected="selected" value="D">D</option>';
		else if ($row['Answer'] == "E")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option selected="selected" value="E">E</option>';
		else if ($row['Answer'] == "F")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option selected="selected" value="F">F</option>';
		else if ($row['Answer'] == "G")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>					
					<option selected="selected" value="G">G</option>';
		else if ($row['Answer'] == "H")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>
					<option value="G">G</option>
					<option selected="selected" value="H">H</option>';
		else if ($row['Answer'] == "I")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>
					<option value="G">G</option>
					<option value="H">H</option>
					<option selected="selected" value="I">I</option>';
		else if ($row['Answer'] == "J")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>
					<option value="G">G</option>
					<option value="H">H</option>
					<option value="I">I</option>
					<option selected="selected" value="J">J</option>';
		else if ($row['Answer'] == "K")
			echo '<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>
					<option value="G">G</option>
					<option value="H">H</option>
					<option value="I">I</option>
					<option value="J">J</option>
					<option selected="selected" value="K">K</option>';
				
		echo '</select></p>
				<p>Possible Points: '. $row['Weight'] .'</p>
				<p><input type="text" name="PossiblePoints" placeholder="New value for Possible Points" id="New value for Possible Points" value="New value for Possible Points" onfocus="clearContents(this);"/></p>';
		echo '<p><input type="submit" class="button" name="submitButton1" id="submitButton1" value="Submit Question" onclick="testTextAreas();" /></p>';
	}

	else if ($row['TypeID'] == 2) {
		echo '<p style="font-size:18px">Edit a subjective question:</p>';
		echo $selectTag;
		echo '<p><table><tr><td width="150px">Question Description: </td><td align="left">'. $row['QDesc'] .'</td></tr><tr><td colspan="2"><textarea name="QuestionText" id="New value of Question Text" placeholder="New value of Question Text" onfocus="clearContents(this);" rows="4" cols="100">New value of Question Text</textarea></td></tr></table></p>
				<p><table><tr><td width="150px">Question Answer: </td><td align="left">'. $row['Answer'] .'</td></tr><tr><td colspan="2"><textarea name="Answer" id="New value of Answer" placeholder="New value of Answer" onfocus="clearContents(this);" rows="4" cols="100">New value of Answer</textarea></td></tr>
				<tr><td><input type="text" name="PossiblePoints" placeholder="New value of Possible Points" id="New value of Possible Points" onfocus="clearContents(this);"/></td></tr></table></p>';
		echo '<input type="submit" class="button" name="submitButton2" id="submitButton2" value="Submit Question" onclick="testTextAreas();" />';
	}
	
	$_SESSION['$QID'] = $row['QID'];
	$_SESSION['$TypeID'] = $row['TypeID'];

	echo '</form>';
	
	echo '<form action="../php/modifyQuestions.php" method="post"><p align="center"><input name="CancelEdit" type="submit" value="Cancel Edit"</p></form>';
	if (isset($_POST['CancelEdit'])) {
		header("Location: ../php/modifyQuestions.php");
		exit;
	}

	echo '<form action="../index.php" method="post"><p align="center"><input name="Logout" type="submit" value="Logout"</p></form>';
	if (isset($_POST['Logout'])) {
		session_unset();
		header("Location: ../index.php");
		exit;
	}	
?>

<script>


function clearContents(element) {
	if (element.value == element.id)
		element.value = "";
}

var lastOption = $('#Answer option:last-child').val();
var countBox = String.fromCharCode(lastOption.charCodeAt() + 1);
var boxName = "Choice " + countBox;

function addInput(){
	document.getElementById("response").innerHTML += '<p><table><tr><td width="150px"></td><td align="left"></td></tr><tr><td colspan="2"><textarea name=Choice"' + countBox + '" id="' + boxName + '" placeholder="' + boxName + '" onfocus="clearContents(this);" rows="4" cols="100">'+ boxName +'</textarea></td></tr></table></p>';
	var str='<option value="'+ countBox +'">' + countBox + '</option>';
	$("#Answer").append(str);
	countBox = String.fromCharCode(countBox.charCodeAt() + 1);
	boxName = "Choice " + countBox;
}

function removeInput() {
	var numberOfTextareas = $('textarea').size();
	if (numberOfTextareas > 3) {
		$('table:last').remove();
		$('option:last').remove();
		numberOfTextareas--;
		countBox = String.fromCharCode(countBox.charCodeAt() - 1);
		boxName = "New value for Choice " + countBox;
	} else {
		alert ("Choices cannot be less than two");
	}
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

</body>
</html>