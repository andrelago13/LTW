<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
function register($name, $username, $email, $password) {
	if (strlen($name) > 100)
		throw new InvalidArgumentException ( "Name too large, maximum 100 chars.");
	if (! preg_match ( "^([ \u00c0-\u01ffa-zA-Z'\-])+$", $name ))
		throw new InvalidArgumentException ( "Invalid name." );
	
	$username = strtolower ( $username );
	if (! preg_match ( "^[a-z0-9_-\.]{3,30}$", $username ))
		throw new InvalidArgumentException ( "Invalid username. It must contain only alfanumeric characters and have length between 3 and 30." );
	
	if (strlen($email) > 254)
		throw new InvalidArgumentException ( "Email too large, maximum 254 chars.");
	$email = strtolower ( $email );
	if (! preg_match ( "^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$", $email))
		throw new InvalidArgumentException ( "Invalid email address." );
	
	$password_length = strlen ( $password );
	if ($password_length < 6)
		throw new InvalidArgumentException ( "Password too short, minimum 6 chars." );
	if ($password_length > 512)
		throw new InvalidArgumentException ( "Password too large, maximum 512 chars." );
}