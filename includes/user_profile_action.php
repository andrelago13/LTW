<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (DATABASE_PATH . "/user.php");

if(! isUserLoggedIn ()) {
	showError("You need to be logged in to access this page");
	die();
}

if (isset ( $_POST ['submit'] )) {
	if (isset ( $_POST ['old_password'] ) && isset ( $_POST ['new_password'] ) && isset ( $_POST ['new_password_confirm'] )) {
		try {
			$old_password = $_POST['old_password'];
			$new_password = $_POST['new_password'];
			$new_password_confirm = $_POST['new_password_confirm'];
			$userID = getUserID();
			
			if($new_password != $new_password_confirm) {
				showError("New password confirmation doesn't match new password.");
			} else {
				updateUserPassword($userID, $old_password, $new_password);
				
				showSuccess("User profile edited.");
			}
		} catch ( Exception $e ) {
			showError ( $e->getMessage () );
		}
	} else
		showError ( "User information missing." );
}
?>