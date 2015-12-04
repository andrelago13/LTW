<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (DATABASE_PATH . "/comment.php");
require_once (INCLUDES_PATH . "/comment.php");

if (isset ( $_GET ['invite_comment'] )) {
	switch($_GET['invite_comment']) {
		case 0:
			showSuccess ( "User was invited" );
			break;
		case 1:
			showError ( "User was already invited." );
			break;
		case 2:
			showError ( "You do not have permission to edit this event." );
			break;
		case 3:
			showError ( "Username provided is invalid or does not exist." );
			break;
		case 4:
			showError ( "Invalid link provider (Invalid CSRF token)" );
			break;
		case 5:
			break;
		case 6:
			break;
		case 7:
			showError ( "Missing invited user username" );
			break;
	}
}
?>