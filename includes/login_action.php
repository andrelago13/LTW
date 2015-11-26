<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");

if (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) {
	try {
		login ( $_POST ['username'], $_POST ['password'] );
		header ( "Location: my_events.php" );
		die ();
	} catch ( Exception $e ) {
		showError($e->getMessage());
	}
}
?>