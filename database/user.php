<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
class InvalidPassword extends Exception {
}
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
function updateUser ( $idUser, $name, $username, $email ) {
	global $db;
	$query = "UPDATE User SET name = :name, username = :username, email = :email WHERE id = :user";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
	$stmt->bindParam ( ':username', $username, PDO::PARAM_STR );
	$stmt->bindParam ( ':email', $email, PDO::PARAM_STR );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	return $stmt->execute ();
}

function getUserIDFromUsername($username) {
	global $db;
	$stmt = $db->prepare('SELECT User.id FROM User WHERE username = :username');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	
	if(sizeof($ret)!= 1)
		throw new InvalidUsername ( "Username provided does not exist or is invalid." );
	return $ret[0];
}

function updateUserPassword($userID, $old_password, $new_password) {
	global $db;
	
	$query = "SELECT hash FROM User WHERE id = :id";
	$stmt = $db->prepare($query);
	$stmt->bindParam(":id", $userID, PDO::PARAM_INT);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	
	if(sizeof($ret) != 1) throw new Exception("Invalid user id provided");
	
	if(! password_verify($old_password, $ret[0]["hash"])) throw new Exception ("Current password provided is invalid");
	
	$len = strlen($new_password);
	if($len < 6 || $len > 512) {
		throw new InvalidPassword("Password length must be between 6 and 512 characters");
	}
	
	$query = "UPDATE User SET hash = :hash WHERE id = :id";
	$stmt = $db->prepare($query);
	$stmt->bindParam(":id", $userID, PDO::PARAM_INT);
	$new_hash = password_hash($new_password, PASSWORD_DEFAULT);
	$stmt->bindParam(":hash", $new_hash, PDO::PARAM_STR);
	return $stmt->execute();
}
?>