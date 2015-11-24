<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/utils.php");

print_r ( $_POST );

if (! isUserLoggedIn ()) {
	http_response_code ( 403 );
	showError ( 'You need to login to create an event.' );
} else if (isset ( $_POST ['type'] ) && isset ( $_POST ['name'] ) && isset ( $_POST ['description'] ) && isset ( $_POST ['date'] ) && isset ( $_FILES ["image"] )) {	
	$idEvent = createEvent ( $_POST ['type'], $_POST ['name'], $_POST ['description'], $_POST ['date'], isset ( $_POST ['public'] ), $_SESSION['userid']);
	if ($idEvent) {
		$target_dir = "images/events/";
		$target_file = $target_dir . $idEvent . '.' . pathinfo ( $_FILES ["image"] ["name"] ) ['extension'];
		uploadImage ( $_FILES ["image"], $target_file );
		showSuccess ( "Event created." );
	} else
		showError ( "Could not create the event." );
}
?>