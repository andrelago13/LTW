/*
 * Returns "" if name is valid, error message otherwise
 */
function test_name(name) {
	if(typeof name == 'undefined')
		return "No name was provided.";
	
	if(name.length > 100) {
		return "Name too large, maximum 100 chars.";
	}
	
	var regex = /^\b[A-Z]([A-Z]|[a-z]|([A-Z]|[a-z])+\'([A-Z]|[a-z])+| )*\b$/;
	if(!regex.test(name)) {
		return "Invalid name";
	}
	
	return "";
}

/*
 * Returns "" if username is valid, error message otherwise
 */
function test_username(username) {
	if(typeof username == 'undefined')
		return "No username was provided.";
	
	var regex = /^([A-z0-9]|_|-|\.){3,30}$/;
	if(!regex.test(username))
		return "Invalid username.";
	
	return "";
}

/*
 * Returns "" if email is valid, error message otherwise
 */
function test_email(email) {
	if(typeof email == 'undefined')
		return "No email was provided.";
	
	if(email.length > 254) {
		return "Email too large, maximum 254 chars.";
	}
	
	var regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
	if(!regex.test(email)) {
		return "Invalid email.";
	}
	
	return "";
}