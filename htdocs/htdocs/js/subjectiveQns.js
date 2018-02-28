function clearContents(element) {
	if (element.value == "Type your answer here.")
		element.value = '';
}

function resetTextAreas() {
	$("textarea").val("Type your answer here.");
}

function testTextAreas() {
	var missedQuestions = "";
	var i = 0;
		
	// Testing if any of the textareas is left without answering.	
	$("textarea").each(function() {
		if (this.value == "Type your answer here.") {
			missedQuestions += this.id + " ";
		} else {
			i++;
		}
	});

	// Prompting the user in case any textarea was left without answering 
	if (missedQuestions.length > 1) {
		event.preventDefault()
		alert("You're not done yet!\nYou still have " + (5-i) + " questions to answer:\n" + missedQuestions);
	} else {
		$("#submitButton1").unbind("click");
		$("#submitButton2").unbind("click");

		// Working on saving answers to a CSV file
		var TextAreas = [];
		i = 0;
		$("textarea").each(function() {
			TextAreas[i] = this.value;
			i++;
		});
		setCookie("Subjective Questions Answers",TextAreas, 1);
				
		//toCSV(TextAreas);
	}
}

$(document).ready(function(){	
	var previousAnswers;
	
	$('#clearButton1').click(function() {
		resetTextAreas();
	});
	
	$('#clearButton2').click(function() {
		resetTextAreas();		
	});
	
	$('#submitButton1').click(function(){
		testTextAreas();
		getCookie(previousAnswers);
	});
	
	$('#submitButton2').click(function(){
		testTextAreas();
		getCookie(previousAnswers);
	});
});