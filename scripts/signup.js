$(document).ready(function() {
	var nameField = $('.register_form #reg_name');
	var emailField = $('.register_form #reg_email');
	var usernameField = $('.register_form #reg_username');
	var passwordField = $('.register_form  #reg_password');
	var confirmPasswordField = $('.register_form #reg_confirm_password');
	
	nameField.keyup(function() {
		validateField(nameField, function() {
			return test_name(nameField.val()).length === 0;
		});
	});
	emailField.keyup(function() {
		validateField(emailField, function() {
			return test_email(emailField.val()).length === 0;
		});
	});
	usernameField.keyup(function() {
		validateField(usernameField, function() {
			return test_username(usernameField.val()).length === 0;
		});
	});
	passwordField.keyup(function() {
		validateField(passwordField, function() {
			return passwordField.val().length >= 6 && passwordField.val().length <= 512;
		});
		validateField(confirmPasswordField, function() {
			return confirmPassword(passwordField, confirmPasswordField);
		});
	});
	confirmPasswordField.keyup(function() {
		validateField(confirmPasswordField, function() {
			return confirmPassword(passwordField, confirmPasswordField);
		});
	});
});

function confirmPassword(passwordField, confirmPasswordField) {
	return passwordField.val() === confirmPasswordField.val();
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