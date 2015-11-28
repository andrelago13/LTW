function validateField(field, condition) {
	if (field.val().length === 0 && !field.hasClass('error') && !field.hasClass('valid'))
		field.removeClass('valid error');
	else if (condition()) // Valid
		field.removeClass('error').addClass('valid');
	else // Invalid
		field.removeClass('valid').addClass('error');
}