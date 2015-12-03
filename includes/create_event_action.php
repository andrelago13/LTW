<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/utils.php");

function test_date(&$date) {
	if(strlen($date) != 19) {
		if(strlen($date) == 16) {
			$date[16] = ':';
			$date[17] = 0;
			$date[18] = 0;
		} else
			return false;
	}

	$regex = '/^\b(2([0-9])([0-9])([0-9]))\-(([0-1])([0-9]))\-(([0-3])([0-9])) (([0-2])([0-9])):(([0-5])([0-9])):(([0-5])([0-9]))\b$/';
	
	if(!preg_match($regex, $date)) {
		return false;
	}
	
	$year = (int)("" . $date[0] . $date[1] . $date[2] . $date[3]);
	$month = (int)("" . $date[5] . $date[6]);
	$day = (int)("" . $date[8] . $date[9]);
	
	$hour = (int)("" . $date[11] . $date[12]);
	$minutes = (int)("" . $date[14] . $date[15]);
	$seconds = (int)("" . $date[17] . $date[18]);
	
	return validDate($year, $month, $day, $hour, $minutes, $seconds);
}

function validDate($year, $month, $day, $hour, $minutes, $seconds) {
	$normalYearMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	$leapYearMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	if($year < 2000 || $month < 1 || $month > 12 || $day < 1 || $day > 31 || $hour < 0 || $hour > 23 || $minutes < 0 || $minutes > 59 || $seconds < 0 || $seconds > 59)
		return false;
	
	 if ( $year%400 == 0) {
		 if($day > $leapYearMonths[$month-1])
			 return false;
	 } else if ($year % 100 == 0) {
		 if($day > $normalYearMonths[$month-1])
			 return false;
	 } else if($year % 4 == 0) {
		 if($day > $leapYearMonths[$month-1])
			 return false;
	 } else {
		 if($day > $normalYearMonths[$month-1])
			 return false;
	 }
	 return true;
}

if (! isUserLoggedIn ()) {
	http_response_code ( 403 );
	showError ( 'You need to login to create an event.' );
} else if (isset ( $_POST ['submit'] )) {
	if (isset ( $_POST ['type'] ) && isset ( $_POST ['name'] ) && isset ( $_POST ['description'] ) && isset ( $_POST ['date'] ) && isset ( $_FILES ["image"] ) && isset ( $_POST ["csrf_token"] )) {
		if (validateCSRFToken ( $_POST ["csrf_token"] )) {
			$extension = pathinfo ( $_FILES ["image"] ["name"], PATHINFO_EXTENSION );
			if (isset ( $extension )) {
				if(test_date($_POST['date'])) {
					$idEvent = createEvent ( $_POST ['type'], $_POST ['name'], $_POST ['description'], $_POST ['date'], isset ( $_POST ['public'] ), $_SESSION ['userid'] );
					if ($idEvent != -1) {
						try {
							if (file_exists ( $_FILES ['image'] ['tmp_name'] ) && is_uploaded_file ( $_FILES ['image'] ['tmp_name'] )) { // Check if an image was been uploaded
								$target_dir = "images/events/";
								$target_file = $target_dir . $idEvent . '.' . $extension;
								if (! updateEventImage ( $idEvent, $target_file ))
									throw new RuntimeException ( "Could not set event image." );
								uploadImage ( $_FILES ["image"], $target_file );
							}
							showSuccess ( "Event created." );
						} catch ( RuntimeException $e ) {
							showError ( $e->getMessage () );
						}
					} else
						showError ( "Could not create the event." );
				} else
					showError ( "Invalid event date. Date must have format YYYY-MM-DD HH:MM(:SS)" );
			} else
				showError ( "Invalid file." );
		} else
			showError ( "Invalid CSRF token." );
	} else
		showError ( "Event information missing." );
}
?>