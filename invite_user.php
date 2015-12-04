<?php
define ( "NO_SESSION_REGENERATION", true );
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
    if (!isset ($_GET ["invited_username"])) {
        http_response_code(400);
        echo 'Missing invitee username.';
    }  else if (!isset ($_GET ["idEvent"])) {
        http_response_code(400);
        echo 'Missing event ID';
    } else if (!isUserLoggedIn()) {
        http_response_code(403);
        echo 'You need to login to edit this event.';
    } else if (! validateCSRFToken ( rawurldecode($_GET ["csrf_token"]) )) {
		http_response_code ( 403 );
		echo 'Invalid CSRF token.';
	}else {
        $invited_un = $_GET ["invited_username"];
        $user_id = getUserID();
        $event_id = $_GET["idEvent"];
        $invited_id;
        
        try {
        	$invited_id = getUserIDFromUsername($invited_un);
        } catch (InvalidUsername $e) {
        	http_response_code ( 400 );
    		echo $e->getMessage ();
    		return;
        }
        
        if (!canSeeEvent($user_id, $event_id)) {
            http_response_code(403);
            echo 'You do not have access to this event.';
        } else {
            $event = Event::find ($event_id);
            if($user_id == $event->getOwner()) {
            
            	try {
            		inviteUserToEvent($user_id, $invited_id, $event_id);
            	} catch (AlreadyInvitedException $e) {
            		http_response_code ( 400 );
    				echo $e->getMessage ();
            	}
            
            	header("Location: view_event.php?id=" . $event_id);
            } else {
                http_response_code(403);
                echo 'You do not have permission to delete this event.';
            }
        }
    }
} catch ( InvalidArgumentException $e ) {
    http_response_code ( 400 );
    echo $e->getMessage ();
} catch ( Exception $e ) {
    http_response_code ( 500 );
    echo $e->getMessage();
}
