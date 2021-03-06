<?php
define ( "NO_SESSION_REGENERATION", true );
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
    if (!isset ($_GET ["idEvent"])) {
        http_response_code(400);
        echo 'Missing event ID.';
    }  else if (!isset ($_GET ["action"])) {
        http_response_code(400);
        echo 'Missing action value.';
    } else if (!isUserLoggedIn()) {
        http_response_code(403);
        echo 'You need to login to edit this event.';
    } else if (! validateCSRFToken ( rawurldecode($_GET ["csrf_token"]) )) {
		http_response_code ( 403 );
		echo 'Invalid CSRF token.';
	}else {
        $event_id = $_GET ["idEvent"];
        $user_id = getUserID();
        $register = $_GET ["action"];
        
        if (!canSeeEvent($user_id, $event_id)) {
            http_response_code(403);
            echo 'You do not have access to this event.';
        } else {
            if($register) {
            	registerInEvent($user_id, $event_id);
            } else {
            	unregisterFromEvent($user_id, $event_id);
            }
            header("Location: view_event.php?id=" . $event_id);
        }
    }
} catch ( InvalidArgumentException $e ) {
    http_response_code ( 400 );
    echo $e->getMessage ();
} catch ( Exception $e ) {
    http_response_code ( 500 );
}
