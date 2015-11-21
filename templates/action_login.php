<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");

if (! isset ( $_POST ['username'] ) || ! isset ( $_POST ['password'] ))
	showError ( "Login info missing." );
else {
	try {
		login ( $_POST ['username'], $_POST ['password'] );
	} catch ( Exception $e ) {
		showError ( $e->getMessage () );
	}
}
?>