<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
    if (!isset ($_GET ["id"])) {
        http_response_code(400);
        showError('Missing event ID.');
    } else if (!isUserLoggedIn()) {
        http_response_code(403);
        showError('You need to login to edit this event.');
    } else if (!canSeeEvent($_SESSION ["userid"], $_GET ["id"])) {
        http_response_code(403);
        showError('You do not have access to this event.');
    } else if($_GET['userid'] != $_SESSION["userid"]){
        http_response_code(403);
        showError('You do not have access to edit this event.');
    } else {
        ?>
        //TODO html
        <?php }
} catch ( Exception $e ) {
    showError($e->getMessage());
}
?>