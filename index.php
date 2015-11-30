<?php
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");

if(isUserLoggedIn()) {
	require_once(__DIR__ . "/my_events.php");
} else {
	require_once ("login.php");
}
?>