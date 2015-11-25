<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
require_once (DATABASE_PATH . "/events.php");
if (! isset ( $_GET ["id"] )) {
	echo "Missing event ID.";
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