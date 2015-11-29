<?php
define ( "NO_SESSION_REGENERATION", true );
require_once (__DIR__ . "/config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/user.php");
require_once (DATABASE_PATH . "/user.php");

try {
	if (! isset ( $_POST ["id"] )) {
		http_response_code ( 400 );
		echo 'Missing user ID.';
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		echo 'You need to login to edit your user info.';
	} else if (! validateCSRFToken ( $_POST ["csrf_token"] )) {
		http_response_code ( 403 );
		echo 'Invalid CSRF token.';
	} else {
		$idUser = $_POST ["id"];
		if (getUserID () !== $idUser) {
			http_response_code ( 403 );
			echo 'You can only edit your own user info.';
		} else {
			$user = User::find ( $idUser );
			if (isset ( $_POST ['name'] )) {
				$user->setName ( $_POST ['name'] );
			}
			if (isset ( $_POST ['username'] )) {
				$user->setUsername ( $_POST ['username'] );
			}
			if (isset ( $_POST ['email'] )) {
				$user->setEmail ( $_POST ['email'] );
			}
			$user->update ();
			
			header ( 'Content-Type: application/json' );
			echo json_encode ( $user->expose () );
		}
	}
} catch ( InvalidArgumentException $e ) {
	http_response_code ( 400 );
	echo $e->getMessage ();
} catch ( Exception $e ) {
	http_response_code ( 500 );
}
?>