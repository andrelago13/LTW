$(document).ready(function() {
	var oldPasswordField = $('form.change_password input#old_password');
	var newPasswordField = $('form.change_password input#new_password');
	var confirmPasswordField = $('form.change_password input#new_password_confirm');
	
	oldPasswordField.keyup(function() {
		validateField(oldPasswordField, function() {
			return oldPasswordField.val().length >= 6 && oldPasswordField.val().length <= 512;
		});
		/*validateField(confirmPasswordField, function() {
			return confirmPassword(oldPasswordField, confirmPasswordField);
		});*/
	});
	
	newPasswordField.keyup(function() {
		validateField(newPasswordField, function() {
			return newPasswordField.val().length >= 6 && newPasswordField.val().length <= 512;
		});
		validateField(confirmPasswordField, function() {
			return confirmPasswordField.val() === newPasswordField.val();
		});
	});
	
	confirmPasswordField.keyup(function() {
		validateField(confirmPasswordField, function() {
			return confirmPasswordField.val() === newPasswordField.val();
		});
		
	});
});