/*
 * Returns an empty string if date is valid, error message otherwise
 */
function test_date(date) {
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