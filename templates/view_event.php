<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
	if (! isset ( $_GET ["id"] )) {
		http_response_code ( 400 );
		showError ( 'Missing event ID.' );
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		showError ( 'You need to login to view this event.' );
	} else if (! canSeeEvent ( $_SESSION ["userid"], $_GET ["id"] )) {
		http_response_code ( 403 );
		showError ( 'You do not have access to this event.' );
	} else {
		$idEvent = $_GET ["id"];
		$event = getEvent ( $idEvent );
		echo '<div class="event" id="event' . $idEvent . '">';
		echo '<a href="" class="delete" id="delete_event"><img src="" alt="Delete Event" /></a>';
		echo '<h1 id="name">' . htmlspecialchars ( $event ["name"] ) . '</h1>';
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '<div class="container">';
		echo '<img id="image" src="database/event_image.php?id=' . $idEvent . '" alt="' . htmlspecialchars ( $event ["name"] ) . '" width="256" height="256" />';
		echo '<p id="description">' . preg_replace("/\n/", "<br />", htmlspecialchars ( $event ["description"] )) . '</p>';
		echo '<a href="" class="edit" id="edit_description"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '</div>';
		echo '<datetime id="date">' . htmlspecialchars ( $event ["date"] ) . '</datetime>';
		echo '<a href="" class="edit" id="edit_date"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '</div>';
	}
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}
?>
<script src="scripts/event.js"></script>
