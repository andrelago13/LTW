<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
require_once (DATABASE_PATH . "/user.php");
function createAccount($name, $username, $email, $password) {
	if (strlen ( $name ) > 100)
		throw new InvalidArgumentException ( "Name too large, maximum 100 chars." );
	if (! preg_match ( "/^\p{Lu}[\p{L&}\.' ]*$/u", $name ))
		throw new InvalidArgumentException ( "Invalid name." );
	
	$username = strtolower ( $username );
	if (! preg_match ( "/^([A-z0-9]|_|-|\.){3,30}$/", $username ))
		throw new InvalidArgumentException ( "Invalid username. It must contain only alfanumeric characters and have length between 3 and 30." );
	if (getUserByUsername ( $username ))
		throw new InvalidArgumentException ( "Username already registered. Choose a different one." );
	
	if (strlen ( $email ) > 254) // 254 is the maximum email address size
		throw new InvalidArgumentException ( "Email too large, maximum 254 chars." );
	$email = strtolower ( $email );
	if (! preg_match ( "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/", $email ))
		throw new InvalidArgumentException ( "Invalid email address." );
	if (getUserByEmail ( $email ))
		throw new InvalidArgumentException ( "Email address already registered. Choose a different one." );
	
	$password_length = strlen ( $password );
	if ($password_length < 6)
		throw new InvalidArgumentException ( "Password too short, minimum 6 chars." );
	if ($password_length > 512)
		throw new InvalidArgumentException ( "Password too large, maximum 512 chars." );
	
	$hash = password_hash ( $password, PASSWORD_DEFAULT );
	if (! createUser ( $name, $username, $email, $hash ))
		throw new RuntimeException ( "Error inserting new user in the database." );
}
function login($username, $password) {
	$user = getUserByUsername ( $username );
	if (! $user)
		throw new InvalidArgumentException ( "Username not registered." );
	
	if (! password_verify ( $password, $user["hash"] ))
		throw new InvalidArgumentException ( "Password incorrect." );
	
	$_SESSION["userid"] = $user["id"];
}
//createAccount ( "Joao Pinheiro", "mabaclu", "mabaclu@gmail.com", "123456" );
login("gtugablue", "123456");
?>