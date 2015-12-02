<?php
define ( "NO_SESSION_REGENERATION", true );
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
    if (!isset ($_POST ["id"])) {
        http_response_code(400);
        echo 'Missing event ID.';
    } else if (!isUserLoggedIn()) {
        http_response_code(403);
        echo 'You need to login to register in this event.';
    } else if (!validateCSRFToken($_POST ["csrf_token"])) {
        http_response_code(403);
        echo 'Invalid CSRF token.';
    } else {
        $event_id = $_POST ["id"];
        if (!canSeeEvent(getUserID(), $event_id)) {
            http_response_code(403);
            echo 'You do not have access to edit this event.';
        } else {
            registerInEvent(getUserID(), $idEvent);
        }
    }
} catch ( InvalidArgumentException $e ) {
    http_response_code ( 400 );
    echo $e->getMessage ();
} catch ( Exception $e ) {
    http_response_code ( 500 );
}
?>