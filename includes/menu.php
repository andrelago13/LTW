<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
function getMenuPages() {
	$pages = array ();
	if (isUserLoggedIn ()) {
		$pages ["user_profile.php"] = "Profile";
		$pages ["public_events.php"] = "Public Events";
		$pages ["my_events.php"] = "My events";
		$pages ["invited_events.php"] = "Upcoming Invites";
		$pages ["create_event.php"] = "Create event";
		$pages ["event_history.php"] = "Event History";
		$pages ["logout.php"] = "Logout";
	} else {
		$pages ["login.php"] = "Login";
		$pages ["register.php"] = "Register";
	}
	return $pages;
}
?>