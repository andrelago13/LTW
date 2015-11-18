<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/events.php");

if (! isset ( $_GET ["id"] )) {
	http_response_code(400);
	echo "Missing event ID.";
} else {
	$idEvent = $_GET["id"];
	$event = getEvent($idEvent);
	echo '<h1>' . $event["name"] . '</h1>';
	echo '<img src="database/event_image.php?id=' . $idEvent . '" alt="' . $event["name"] . '" width="256" height="256" />';
	echo '<p>' . $event["description"] . '</p>';
	echo '<time>' . $event["date"] . '</time>';
}
?>