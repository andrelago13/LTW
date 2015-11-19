<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/events.php");

if (! isset ( $_GET ["id"] )) {
	http_response_code ( 400 );	
	echo '<p class="errormsg">Missing event ID.</p>';
}
else if (!isset($_SESSION["userid"]))
{
	http_response_code(403);
	echo '<p class="errormsg">You need to login to view this event.</p>';
} else if (! canSeeEvent ( $_SESSION ["userid"], $_GET ["id"] )) {
	http_response_code (403);
	echo '<p class="errormsg">You do not have access to this event.</p>';
} else {
	$idEvent = $_GET ["id"];
	$event = getEvent ( $idEvent );
	echo '<h1>' . $event ["name"] . '</h1>';
	echo '<img src="database/event_image.php?id=' . $idEvent . '" alt="' . $event ["name"] . '" width="256" height="256" />';
	echo '<p>' . $event ["description"] . '</p>';
	echo '<time>' . $event ["date"] . '</time>';
}
?>