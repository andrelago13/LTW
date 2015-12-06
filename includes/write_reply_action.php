<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/comment.php");

if (isset ( $_POST ['submit_reply'] )) {
	if (! isUserLoggedIn ()) {
		showError ( 'You need to login to add a reply.' );
	} else if (! isset ( $_POST ["idComment"] ) || ! isset ( $_POST ["text"] ) || ! isset ( $_POST ["idEvent"] )) {
		showError ( "Reply information missing." );
	} else if (! canWriteComment ( getUserID (), $_POST ['idEvent'] )) {
		showError ( "You cannot write a reply to this comment in this event." );
	} else {
		addCommentReply ( $_POST ["idComment"], getUserID (), $_POST ["text"] );
		showSuccess ( "Reply added." );
	}
}
?>