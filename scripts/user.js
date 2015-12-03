$(document).ready(function() {
	userInlineEdit();
	$("#edit_password_label").click(function() { $("div.user_profile form.change_password").toggle(); });
});

function userInlineEdit() {
	$(".user_profile p .name + a.edit").click(function() {
		editTextField($(this).prev(), "name", function(inputElement) {
			return test_name(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".user_profile p .username + a.edit").click(function() {
		editTextField($(this).prev(), "username", function(inputElement) {
			return test_username(inputElement.val()).length === 0;
		});
		return false;
	});
	$(".user_profile p span a.edit").click(function() {
		editTextField($(this).prev(), "email", function(inputElement) {
			return test_email(inputElement.val()).length === 0;
		});
		return false;
	});
}

function updateField(field, name, inputElement, inputSelector) {
	var data = {
			'id' : field.closest('.user_profile').attr('id').substr("user".length, 99999),
			'csrf_token' : csrf_token
	}
	data[field.attr('id')] = inputElement.val();
	$.ajax({
		url : "edit_user.php",
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
function test_name(name) {
	if(typeof name == 'undefined')
		return "No name was provided.";

	if(name.length > 100) {
		return "Name too large, maximum 100 chars.";
	}

	var regex = /^\b([A-Z]|[\u00C0-\u00DE])(([A-Z]|[\u00C0-\u00DE])|([a-z]|[\u00DF-\u00FF])|(([A-Z]|[\u00C0-\u00DE])|([a-z]|[\u00DF-\u00FF]))+\'(([A-Z]|[\u00C0-\u00DE])|([a-z]|[\u00DF-\u00FF]))+| )*\b$/;

	if(!regex.test(name)) {
		return "Invalid name";
	}

	return '';
}

/*
 * Returns an empty string if username is valid, error message otherwise
 */
function test_username(username) {
	if(typeof username == 'undefined')
		return "No username was provided.";

	var regex = /^([A-z0-9]|_|-|\.){3,30}$/;
	if(!regex.test(username)) {
		return "Invalid username.";
	}

	return '';
}

/*
 * Returns an empty string if email is valid, error message otherwise
 */
function test_email(email) {
	if(typeof email == 'undefined')
		return "No email was provided.";

	if(email.length > 254) {
		return "Email too large, maximum 254 chars.";
	}

	var regex = /^[A-z0-9._%+-]+@[A-z0-9.-]+\.[a-z]{2,}$/;
	if(!regex.test(email)) {
		return "Invalid email.";
	}

	return '';
}