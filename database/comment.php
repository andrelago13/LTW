<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
function getComments($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT DISTINCT Comment.*, User.name, User.id as user_id
			FROM Comment
			INNER JOIN User ON Comment.author = User.id
			INNER JOIN Event ON Comment.idEvent = :event ORDER BY Comment.date DESC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getComment($idComment) {
	global $db;
	$query = "SELECT DISTINCT Comment.*, User.*
			FROM Comment, User
			WHERE Comment.id = :comment AND Comment.author = User.id";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':comment', $idComment, PDO::PARAM_INT );
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
function addCommentReply($idComment, $idUser, $text) {
	global $db;
	$query = "INSERT INTO Reply (idComment, author, text) VALUES (:comment, :user, :text)";
	$stmt = $db->prepare($query);
	$stmt->bindParam ( ':event', $idComment, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->bindParam ( ':text', $text, PDO::PARAM_STR);
	return $stmt->execute();
}
function getCommentReplies($idComment) {
	global $db;
	$query = "SELECT DISTINCT Reply.*, User.*
			FROM Reply, Comment, User
			WHERE Reply.idComment = Comment.id AND Comment.id = :comment AND Reply.author = User.id";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':comment', $idComment, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
?>