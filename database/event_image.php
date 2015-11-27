<?php
define("NO_SESSION_REGENERATION", true);
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
require_once (DATABASE_PATH . "/events.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (INCLUDES_PATH . "/authentication.php");
if (! isset ( $_GET ["id"] )) {
	echo "Missing event ID.";
	http_response_code(400);
} else if (!isUserLoggedIn()) {
	echo "You are not logged in.";
	http_response_code(401);
} else if (!canSeeEvent(getUserID(), $_GET["id"])) {
	echo "You do not have access to this event.";
	http_response_code(403);
} else {
	$event = getEvent ( $_GET ["id"] );
	if ($event && !@is_null($event["imagePath"])) {
		header ( 'Location: ../' . $event ['imagePath'] );
		die ();
	} else {
		header ( 'Location: ../images/event_default.png' );
		die ();
	}
}
?>