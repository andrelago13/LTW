<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (DATABASE_PATH . "/comment.php");
require_once (INCLUDES_PATH . "/comment.php");

if (isset ( $_POST ['submit_comment'] )) {
	if (! isUserLoggedIn ()) {
		showError ( 'You need to login to add a comment.' );
	} else if (! isset ( $_POST ["text"] ) || ! isset ( $_POST ["idEvent"] )) {
		showError ( "Comment information missing." );
	} else if (! canWriteComment ( getUserID (), $_POST ['idEvent'] )) {
		showError ( "You cannot write a comment to this event." );
	} else {
		addComment ( $_POST ["idEvent"], getUserID (), $_POST ["text"] );
		showSuccess ( "Comment added." );
	}
}
?>