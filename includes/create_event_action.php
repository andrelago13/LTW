<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/utils.php");

if (! isUserLoggedIn ()) {
	http_response_code ( 403 );
	showError ( 'You need to login to create an event.' );
} else if (isset ( $_POST ['submit'] )) {
	if (isset ( $_POST ['type'] ) && isset ( $_POST ['name'] ) && isset ( $_POST ['description'] ) && isset ( $_POST ['date'] ) && isset ( $_FILES ["image"] ) && isset ( $_POST ["csrf_token"] )) {
		if (validateCSRFToken ( $_POST ["csrf_token"] )) {
			$extension = pathinfo ( $_FILES ["image"] ["name"], PATHINFO_EXTENSION );
			if (isset ( $extension )) {
				$idEvent = createEvent ( $_POST ['type'], $_POST ['name'], $_POST ['description'], $_POST ['date'], isset ( $_POST ['public'] ), $_SESSION ['userid'] );
				if ($idEvent) {
					$target_dir = "images/events/";
					$target_file = $target_dir . $idEvent . '.' . $extension;
					try {
						if (! updateEventImage ( $idEvent, $target_file ))
							throw new RuntimeException ( "Could not set event image." );
						uploadImage ( $_FILES ["image"], $target_file );
						showSuccess ( "Event created." );
					} catch ( RuntimeException $e ) {
						showError ( $e->getMessage () );
					}
				} else
					showError ( "Could not create the event." );
			} else
				showError ( "Invalid file." );
		} else
			showError ( "Invalid CSRF token." );
	} else
		showError ( "Event information missing." );
}
?>