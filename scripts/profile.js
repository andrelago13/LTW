$(document).ready(function() {
	var oldPasswordField = $('form.change_password input#old_password');
	var newPpasswordField = $('form.change_password input#old_password');
	var confirmPasswordField = $('form.change_password input#old_password');
	
	oldPasswordField.keyup(function() {
		validateField(oldPasswordField, function() {
			return oldPasswordField.val().length >= 6 && oldPasswordField.val().length <= 512;
		});
		/*validateField(confirmPasswordField, function() {
			return confirmPassword(oldPasswordField, confirmPasswordField);
		});*/
	});
});

function confirmPassword(passwordField, confirmPasswordField) {
	
}