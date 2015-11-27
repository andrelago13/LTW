<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");


if (!isset ($_POST ["id"])) {
    http_response_code(400);
    showError('Missing event ID.');
} else if (!isUserLoggedIn()) {
    http_response_code(403);
    showError('You need to login to edit this event.');
}  else if($_POST['userid'] != $_SESSION["userid"]){
    http_response_code(403);
    showError('You do not have access to edit this event.');
} else {
    $event_id  = $_POST["id"];
    $event = Event::find($event_id);
    if(isset($_POST['name'])) {
        $event->setName($_POST['date']);
    }
    if(isset($_POST['date'])) {
        $event->setDate($_POST['date']);
    }
    if(isset($_POST['description'])) {
        $event->setDescription($_POST['description']);
    }
    if(isset($_POST['public'])) {
        $event->setPublic($_POST['public']);
    }
    $event->update();
    return true;

}