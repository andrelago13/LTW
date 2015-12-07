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
        header("Location: view_event.php?id=" . $event_id . "&invite_comment=7");
    }  else if (!isset ($_GET ["idEvent"])) {
        http_response_code(400);
        header("Location: view_event.php?id=" . $event_id . "&invite_comment=6");
    } else if (!isUserLoggedIn()) {
        http_response_code(403);
        header("Location: view_event.php?id=" . $event_id . "&invite_comment=5");
    } else if (! validateCSRFToken ( rawurldecode($_GET ["csrf_token"]) )) {
		http_response_code ( 403 );
        header("Location: view_event.php?id=" . $event_id . "&invite_comment=4");
	}else {
        $invited_un = $_GET ["invited_username"];
        $user_id = getUserID();
        $event_id = $_GET["idEvent"];
        $invited_id;
        
        try {
        	$invited_id = getUserIDFromUsername($invited_un);
        } catch (InvalidUsername $e) {
        	http_response_code ( 400 );
    		header("Location: view_event.php?id=" . $event_id . "&invite_comment=3");
    		return;
        }
        
        if (!canSeeEvent($user_id, $event_id)) {
            http_response_code(403);
        } else {
            $event = Event::find ($event_id);
            if($user_id == $event->getOwner()) {
            
            	try {
            		inviteUserToEvent($user_id, $invited_id, $event_id);
                	header("Location: view_event.php?id=" . $event_id . "&invite_comment=0");
            	} catch (AlreadyInvitedException $e) {
            		http_response_code ( 400 );
                	header("Location: view_event.php?id=" . $event_id . "&invite_comment=1");
            	} catch (IllegalUserInvitedException $e) {
            		http_response_code ( 400 );
                	header("Location: view_event.php?id=" . $event_id . "&invite_comment=8");
            	}
            } else {
                http_response_code(403);
                header("Location: view_event.php?id=" . $event_id . "&invite_comment=2");
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
