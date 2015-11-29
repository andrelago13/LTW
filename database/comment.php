<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
function getComments($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Comment INNER JOIN Event ON Comment.idEvent = :event LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getComment($idComment) {
	global $db;
	$query = "SELECT * FROM Comment WHERE id = :comment";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':coment', $idComment, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetch ();
}
function addComment($idEvent, $idUser, $text) {
	global $db;
	$query = "INSERT INTO Comment (idEvent, author, text) VALUES (:event, :user, :text)";
	$stmt = $db->prepare($query);
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->bindParam ( ':text', $text, PDO::PARAM_STR);
	return $stmt->execute();
}
?>