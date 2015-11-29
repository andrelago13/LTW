<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
function getUser($idUser) {
	global $db;
	$query = "SELECT * FROM User WHERE id = :user";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetch ();
}
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
function createUser($name, $username, $email, $hash) {
	global $db;
	$query = "INSERT INTO User (name, username, email, hash) VALUES (:name, :username, :email, :hash)";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
	$stmt->bindParam ( ':username', $username, PDO::PARAM_STR );
	$stmt->bindParam ( ':email', $email, PDO::PARAM_STR );
	$stmt->bindParam ( ':hash', $hash, PDO::PARAM_STR );
	return $stmt->execute ();
}
?>