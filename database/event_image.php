<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
if (! isset ( $_GET ["id"] )) {
	echo "Missing event ID.";
} else {
	global $db;
	$stmt = $db->prepare ( 'SELECT image FROM Event WHERE id = :event' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->execute ();
	$result = $stmt->fetch ();
	if ($result) {
		header ( 'Content-Type: image/jpeg' );
		echo $result ["image"];
	} else {
		header('Location: ' . '../images/event_default.png');
		die();
	}
}
?>