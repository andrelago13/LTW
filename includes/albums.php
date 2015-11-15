<?php
require_once ("../database/connection.php");
function getAlbums($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Album INNER JOIN Event ON Event.id = :event LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
?>