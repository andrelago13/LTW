<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/utils.php");

if (! isUserLoggedIn ()) {
	http_response_code ( 403 );
	showError ( 'You need to login to view an event.' );
} else if (isset ( $_POST ['edit_event_image'] )) {
	if(isset($_FILES['file'])) {
		$eventID = $_POST['edit_event_image'];
		$event = getEvent ( $eventID );
		$canEdit = (isUserLoggedIn () && $event ["owner"] === getUserID ());
		
		if($canEdit) {
			try {
				if (file_exists ( $_FILES ['file'] ['tmp_name'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
					$target_dir = "images/events/";
					$extension = pathinfo ( $_FILES ["file"] ["name"], PATHINFO_EXTENSION );
					$target_file = $target_dir . $eventID . '.' . $extension;
					echo $target_file;
					if (! updateEventImage ( $eventID, $target_file )) {
						throw new RuntimeException ( "Could not set event image." );
						uploadImage ( $_FILES ["file"], $target_file );
					}
					showSuccess("Image successfully changed");
				}
			} catch (RuntimeException $e) {
				showError( $e->getMessage());
			}
		} else {
			showError("You cannot edit this event");
		}
	} else {
		showError("Missing file");
	}
}
?>