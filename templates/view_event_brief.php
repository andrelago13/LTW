<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");
function showEventBrief($idEvent) {
	if (! isUserLoggedIn ())
		throw new RuntimeException ( "You need to be logged in." );
	if (! canSeeEvent ( $_SESSION ["userid"], $idEvent ))
		throw new RuntimeException ( "You do not have access to this event." );
	
	$event = getEvent ( $idEvent );
	echo '<div class="event_brief" id="event' . $idEvent . '">';
	
	echo '<div class="name">';
	echo '<h2>' . htmlspecialchars ( $event ["name"] ) . '</h1>';
	echo '</div>';
	
	echo '<img src="database/event_image.php?id=' . $idEvent . '" alt="' . htmlspecialchars ( $event ["name"] ) . '" width="64" height="64" />';
	
	echo '<div class="description">';
	echo '<p class="description">' . htmlspecialchars ( $event ["description"] ) . '</p>';
	echo '</div>';
	
	echo '<datetime>' . htmlspecialchars ( $event ["date"] ) . '</datetime>';
	
	
	echo '</div>';
}

?>
