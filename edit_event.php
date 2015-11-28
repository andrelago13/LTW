<?php
define ( "NO_SESSION_REGENERATION", true );
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
	if (! isset ( $_POST ["id"] )) {
		http_response_code ( 400 );
		echo 'Missing event ID.';
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		echo 'You need to login to edit this event.';
	} else {
		$event_id = $_POST ["id"];
		if (! canSeeEvent ( getUserID (), $event_id )) {
			http_response_code ( 403 );
			echo 'You do not have access to edit this event.';
		} else {
			$event = Event::find ( $event_id );
			if (isset ( $_POST ['name'] )) {
				$event->setName ( $_POST ['name'] );
			}
			if (isset ( $_POST ['date'] )) {
				$event->setDate ( $_POST ['date'] );
			}
			if (isset ( $_POST ['description'] )) {
				$event->setDescription ( $_POST ['description'] );
			}
			if (isset ( $_POST ['public'] )) {
				$event->setPublic ( $_POST ['public'] );
			}
			$event->update ();
			
			header ( 'Content-Type: application/json' );
			echo json_encode ( $event->expose () );
		}
	}
} catch ( InvalidArgumentException $e ) {
	http_response_code ( 400 );
	echo $e->getMessage ();
} catch ( Exception $e ) {
	http_response_code ( 500 );
}
?>