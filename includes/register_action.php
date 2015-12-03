<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");

if (isset ( $_POST ['submit'] )) {
	if (isset ( $_POST ['name'] ) && isset ( $_POST ['email'] ) && isset ( $_POST ['username'] ) && isset ( $_POST ['password'] ) && isset ( $_POST ["confirm_password"] )) {
		try {
			createAccount ( $_POST ['name'], $_POST ['username'], $_POST ['email'], $_POST ['password'] );
			showSuccess("Welcome <strong>" . htmlspecialchars($_POST['name']) . "</strong>! Your account has been successfully created. You will be redirected to the login page soon...");
			header ( "refresh:5;url=login.php" );
			die ();
		} catch ( Exception $e ) {
			showError ( $e->getMessage () );
		}
	} else
		showError ( "Event information missing." );
}
?>