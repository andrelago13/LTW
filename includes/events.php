<?php
require_once ("../database/connection.php");
function getAllEvents() {
	$stmt = $db->prepare('SELECT * FROM Event');
	$stmt->execute();
	return $stmt->fetchAll();
}
function getEventsByOwner($idOwner, $amount = -1, $offset = 0) {
	$query = "SELECT * FROM Event WHERE owner = :owner ORDER BY date DESC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare($query);
	$stmt->bindParam(':owner', $idOwner, PDO::PARAM_INT);
	$stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
	$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();
}
?>