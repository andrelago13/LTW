<?php
require_once ("../database/connection.php");
function getAllEvents($amount = -1, $offset = 0) {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM Event ORDER BY date DESC LIMIT :amount OFFSET :offset' );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getEventsByOwner($idOwner, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Event WHERE owner = :owner ORDER BY date DESC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':owner', $idOwner, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getRegistredEvents($idUser, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Event INNER JOIN EventRegistration ON Event.id = EventRegistration.idEvent
				WHERE EventRegistration.idUser = :user ORDER BY date DESC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
print_r ( getEventsByOwner ( 1 ) );
print_r ( getRegistredEvents ( 1 ) );
?>