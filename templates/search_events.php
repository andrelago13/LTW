<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (DATABASE_PATH . "/events.php");

try {
	if (! isset ( $_GET ["query"] )) {
		http_response_code ( 400 );
		showError ( 'Query missing.' );
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		showError ( 'You need to login to search for events.' );
	} else {
		$events = searchEvents($_GET["query"]);
		print_r($events);
	}
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}
?>
