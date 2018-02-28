function clearRadioButtons() {
	$("input").each(function() {
		$(this).attr('checked', false);
	});
}

function nextButtonClicked() {
	var missedQuestions = "";
	var buttons = "";
	var answers = [];
	var i = 0;
	
	$("input").parent().each(function() {
		if (!$(this).children().is('#button1') && !$(this).children().is('#button2') && !$(this).children().is('#clearButton1') && !$(this).children().is('#clearButton2')) {
			// gathering missed questions.
			if (!$(this).children().is(':checked')) { 
				missedQuestions += $(this).attr("id") + " ";
			} 
			// gathering answered questions.
			else { 
				answers[i] = $(this).children(":checked").attr("value");
				i++;
			}
		}
	});
	
	if (missedQuestions.length > 1) {
		event.preventDefault()
		alert("You're not done yet!\nYou still have " + (5-i) + " questions to answer:\n" + missedQuestions);
	} else {
		$("#button1").unbind("click");
		$("#button2").unbind("click");
		
		setCookie("Objective Questions Answers", answers, 1);
	}
}

$(document).ready(function(){	
	$("#clearButton1").click(function() {
		clearRadioButtons();
	});
	
	$("#clearButton2").click(function() {
		clearRadioButtons();
	});
	
	$('#button1').click(function(){
		nextButtonClicked();
	});
	
	$('#button2').click(function(){
		nextButtonClicked();
	});
});