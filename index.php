<?php
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");

if(isUserLoggedIn()) {
	header("Location: my_events.php");
	die();
} else {
	header("Location: login.php");
	die();
}
?>