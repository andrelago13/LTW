<?php
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( E_ALL );

$dir_file = dirname ( __FILE__ );

defined ( "DATABASE_PATH" ) or define ( "DATABASE_PATH", str_replace ( '\\', '/', realpath ( $dir_file . '/database' ) ) );
defined ( "INCLUDES_PATH" ) or define ( "INCLUDES_PATH", str_replace ( '\\', '/', $dir_file . '/includes' ) );
defined ( "TEMPLATES_PATH" ) or define ( "TEMPLATES_PATH", str_replace ( '\\', '/', $dir_file . '/templates' ) );

defined ( "MAX_IMAGE_SIZE" ) or define ( "MAX_IMAGE_SIZE", 2 * 1024 * 1024 );

session_start ();
if (! defined ( "NO_SESSION_REGENERATION" ))
	session_regenerate_id ( true ); // To prevent session fixation
if (! isset ( $_SESSION ['csrf_token'] ))
		$_SESSION['csrf_token'] = base64_encode( openssl_random_pseudo_bytes(32));
?>