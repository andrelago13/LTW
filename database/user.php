<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
function getUserByUsername($username) {
	global $db;
	$query = "SELECT * FROM User WHERE username = :username";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':username', $username, PDO::PARAM_STR );
	$stmt->execute ();
	return $stmt->fetch ();
}
function getUserByEmail($email) {
	global $db;
	$query = "SELECT * FROM User WHERE email = :email";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':email', $email, PDO::PARAM_STR );
	$stmt->execute ();
	return $stmt->fetch ();
}
?>