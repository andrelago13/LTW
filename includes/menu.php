<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
function getMenuPages() {
	$pages = array ();
	if (isUserLoggedIn ()) {
		$pages ["user_profile.php"] = "Profile";
		$pages ["my_events.php"] = "My events";
		$pages ["create_event.php"] = "Create event";
		$pages ["logout.php"] = "Logout";
	} else {
		$pages ["login.php"] = "Login";
		$pages ["register.php"] = "Register";
	}
	return $pages;
}
?>