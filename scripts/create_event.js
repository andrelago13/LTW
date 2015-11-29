/*
 * Returns an empty string if date is valid, error message otherwise
 */
function test_date(date) {
	console.log("alive");
	if(typeof date == 'undefined')
		return "No date was provided.";

	if(date.length != 19) {
		console.log("HERE");
		return "Date must have format \"YYYY/MM/DD HH:MM:SS\".";
	}

	var regex = /^\b(2([0-9])([0-9])([0-9]))\/(([0-1])([0-9]))\/(([0-3])([0-9])) (([0-2])([0-9])):(([0-5])([0-9])):(([0-5])([0-9]))\b$/;
	
	if(!regex.test(date)) {
		return "Invalid date, must have format \"YYYY/MM/DD HH:MM:SS\".";
	}
	
	var year = parseInt("" + date[0] + date[1] + date[2] + date[3]);
	var month = parseInt("" + date[5] + date[6]);
	var day = parseInt("" + date[8] + date[9]);
	
	var hour = parseInt("" + date[11] + date[12]);
	var minutes = parseInt("" + date[14] + date[15]);
	var seconds = parseInt("" + date[17] + date[18]);
	
	if(validDate(year, month, day, hour, minutes, seconds))
		return '';

	return "Invalid date, must have format \"YYYY/MM/DD HH:MM:SS\".";
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