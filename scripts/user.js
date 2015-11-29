$(document).ready(function() {
	userInlineEdit();
});


function userInlineEdit() {
	var name = name;
	$(".user_profile p #name + a.edit").click(function() {
		editTextField($(this).prev(), "name", function(inputElement) {
			return test_name(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".user_profile p #username + a.edit").click(function() {
		editTextField($(this).prev(), "description", function(inputElement) {
			return test_username(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".user_profile p #email + a.edit").click(function() {
		editTextField($(this).prev(), "description", function(inputElement) {
			return test_email(inputElement.val()).length === 0;
		});
		return false;
	});
}

function eventUpdateField(field, name, inputElement) {
	var data = {
			'id' : field.closest('.user_profile').attr('id').substr("user".length, 99999),
	}
	data[field.attr('id')] = inputElement.val();
	$.ajax({
		url : "edit_user.php",
		type: "POST",
		data : data,
		success: function(data, textStatus, jqXHR)
		{
			console.log(jqXHR.responseText);
			var obj = JSON.parse(jqXHR.responseText);
			field.html(nl2br(htmlspecialchars(obj[name])));
			field.show();
			inputElement.remove();
			field.next().toggle();
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

	if(date.length != 15) {
		return "Date must have format \"DD/MM/YYYY HH:MM\".";
	}

	var regex = /^\b(([0-3])([0-9]))\/(([0-1])([0-9]))\/(2([0-9])([0-9])([0-9])) (([0-2])([0-9])):(([0-6])([0-9]))\b$/;

	if(!regex.test(date)) {
		return "Invalid date, must have format \"DD/MM/YYYY HH:MM\".";
	}

	var day = parseInt("" + date[0] + date[1]);
	var month = parseInt("" + date[3] + date[4]);
	var year = parseInt("" + date[6] + date[7] + date[8] + date[9]);

	var hour = parseInt("" + date[11] + date[12]);
	var minutes = parseInt("" + date[14] + date[15]);

	if(validDate(year, month, day, hour, minutes))
		return '';

	return "Invalid date, must have format \"DD/MM/YYYY HH:MM\".";
}

function validDate(year, month, day, hour, minutes) {
	var normalYearMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	var leapYearMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

	if(year < 2000 || month < 1 || month > 12 || day < 1 || day > 31 || hour < 0 || hour > 23 || minutes < 0 || minutes > 59)
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