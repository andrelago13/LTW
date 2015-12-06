$(document).ready(function() {
	eventBriefEllipsis();
	eventInlineEdit();
});

function eventBriefEllipsis() {
	$('.event_brief p').each(function() {
		var numCharsToShow = 100;
		var content = $(this).html();
		if(content.length > numCharsToShow) {
			var lessContent = content.substr(0, numCharsToShow);
			var moreContent = content.substr(numCharsToShow, content.length - numCharsToShow);
			var newContent = lessContent;
			newContent += '<span class="ellipsis">...</span><span class="more_content"><span>';
			newContent += moreContent;
			newContent += '</span>&nbsp;<a href="" class="more_link">more</a></span>';
			$(this).html(newContent);
		}
	});

	$(".more_link").click(function(){
		$(this).parent().prev().toggle(); // .ellipsis span
		$(this).prev().toggle(); // .moreContent span

		if($(this).hasClass("less")) { // Retract
			$(this).removeClass("less");
			$(this).html("more");
		} else { // Expand
			$(this).addClass("less");
			$(this).html("less");
		}
		return false;
	});
}

function eventInlineEdit() {
	$(".event .name + a.edit").click(function() {
		editTextField($(this).prev(), "name", function(inputElement) {
			return eventTestName(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".event .description + a.edit").click(function() {
		editTextareaField($(this).prev(), "description", function(inputElement) {
			return eventTestDescription(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".event .date + a.edit").click(function() {
		editTextField($(this).prev(), "date", function(inputElement) {
			return eventTestDate(inputElement.val()).length === 0;
		});
		return false;
	});
	$("div.event img.image + a.edit").click(function() {
		$("div.event img.image + a.edit").removeClass("visible");
		$("div.event div.container form.new_image_form.invisible").removeClass("invisible").addClass("visible");
	});
}

function updateField(field, name, inputElement, inputSelector) {
	var data = {
			'id' : field.closest('.event').attr('id').substr("event".length, 99999),
			'csrf_token' : csrf_token
	}
	data[field.attr('name')] = inputElement.val();
	$.ajax({
		url : "edit_event.php",
		type: "POST",
		data : data,
		success: function(data, textStatus, jqXHR)
		{
			var obj = JSON.parse(jqXHR.responseText);
			editFieldFinish(field, nl2br(htmlspecialchars(obj[name])), inputElement, inputSelector);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			console.error("Error: " + jqXHR.responseText);
		}
	});
}

/*
 * Returns an empty string if name is valid, error message otherwise
 */
function eventTestName(name) {
	if(typeof name == 'undefined')
		return "No name was provided.";

	if(name.length > 100) {
		return "name too large, maximum 100 chars.";
	}

	if(name.length == 0) {
		return "name cannot be empty.";
	}

	return '';
}

/*
 * Returns an empty string if description is valid, error message otherwise
 */
function eventTestDescription(description) {
	if(typeof description == 'undefined')
		return "No description was provided.";

	if(description.length > 10000) {
		return "Description too large, maximum 10000 chars.";
	}

	return '';
}

/*
 * Returns an empty string if date is valid, error message otherwise
 */
function eventTestDate(date) {
	if(typeof date == 'undefined')
		return "No date was provided.";
	
	if(date.length != 19) {
		return "Date must have format \"YYYY-MM-DD HH:MM:SS\".";
	}

	var regex = /^\b(2([0-9])([0-9])([0-9]))-(([0-1])([0-9]))-(([0-3])([0-9])) (([0-2])([0-9])):(([0-5])([0-9])):(([0-5])([0-9]))\b$/;
	
	if(!regex.test(date)) {
		return "Invalid date, must have format \"YYYY-MM-DD HH:MM:SS\".";
	}
	
	var year = parseInt("" + date[0] + date[1] + date[2] + date[3]);
	var month = parseInt("" + date[5] + date[6]);
	var day = parseInt("" + date[8] + date[9]);
	
	var hour = parseInt("" + date[11] + date[12]);
	var minutes = parseInt("" + date[14] + date[15]);
	var seconds = parseInt("" + date[17] + date[18]);
	
	if(validDate(year, month, day, hour, minutes, seconds))
		return "";

	return "Invalid date, must have format \"YYYY-MM-DD HH:MM:SS\".";
}

function validDate(year, month, day, hour, minutes, seconds) {
	var normalYearMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	var leapYearMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	if(year < 2000 || month < 1 || month > 12 || day < 1 || day > 31 || hour < 0 || hour > 23 || minutes < 0 || minutes > 59 || seconds < 0 || seconds > 59)
		return false;
	
	 if ( year%400 == 0) {
		 if(day > leapYearMonths[month-1])
			 return false;
	 } else if (year % 100 == 0) {
		 if(day > normalYearMonths[month-1])
			 return false;
	 } else if(year % 4 == 0) {
		 if(day > leapYearMonths[month-1])
			 return false;
	 } else {
		 if(day > normalYearMonths[month-1])
			 return false;
	 }
	 return true;
}

