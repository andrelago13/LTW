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
	$hash = password_hash($password, PASSWORD_DEFAULT);
	
	global $db;
	$query = "INSERT INTO User (name, username, email, hash) VALUES (:name, :username, :email, :hash)";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
	$stmt->bindParam ( ':username', $username, PDO::PARAM_STR );
	$stmt->bindParam ( ':email', $email, PDO::PARAM_STR );
	$stmt->bindParam ( ':hash', $hash, PDO::PARAM_STR );
	$stmt->execute ();
}
createAccount ( "Joao Pinheiro", "mabaclu", "mabaclu@gmail.com", "123456" );
?>