<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (DATABASE_PATH . "/events.php");
require_once (TEMPLATES_PATH . "/view_event_brief.php");

try {
	if (! isset ( $_POST ["query"] )) {
		http_response_code ( 400 );
		showError ( 'Query missing.' );
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		showError ( 'You need to login to search for events.' );
	} else {
		$time = microtime(true);
		$events = searchEvents ( addslashes($_POST ["query"]), getUserID () );
		$time = (microtime(true) - $time);
		$time = sprintf('%0.5f', $time);
		$numEvents = count ( $events );
		if ($numEvents === 0)
			showError ( "No matching events found. Search took " . $time . " seconds." );
		else {
			showSuccess ( "Found " . $numEvents . " entr" . ($numEvents == 1 ? "y" : "ies") . " in " . $time . " seconds." );
			foreach ( $events as $event )
				showEventBrief ( $event ["id"] );
		}
	}
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}
?>
<script src="scripts/event.js"></script>