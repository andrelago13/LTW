<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/view_event_brief.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (DATABASE_PATH . "/events.php");
require_once (TEMPLATES_PATH . "/no_events.php");

try {
	if (isUserLoggedIn ()) {
		$events = getUserEventHistory ( getUserID () );
		if(sizeof($events) > 0) {
			foreach ( $events as $event ) {
				showEventBrief ( $event ["id"] );
			}
		} else {
			showNoEvents();
		}
	} else
		showError ( "You are not logged in." );
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}

?>