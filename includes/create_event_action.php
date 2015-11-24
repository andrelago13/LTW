<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (TEMPLATES_PATH . "/utils.php");

print_r ( $_POST );

if (isset ( $_POST ['name'] ) && isset ( $_POST ['description'] ) && isset ( $_POST ['date'] ) && isset ( $_POST ['owner'] ) && isset ( $_FILES ["image"] )) {
	$target_dir = "images/events/";
	$target_file = $target_dir . basename ( $_FILES ["image"] ["name"] );
	
	uploadImage($_FILES["image"], $target_file);
	
	showSuccess ( "Event created." );
}
?>