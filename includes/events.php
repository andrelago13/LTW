<?php
require_once ("../database/connection.php");
class AlreadyRegisteredException extends Exception {
}
function isEventPublic($idEvent) {
	global $db;
	$stmt = $db->prepare ( 'SELECT public FROM Event WHERE id = :event' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->execute ();
	$result = $stmt->fetch ();
	if (! $result)
		throw new InvalidArgumentException ( "Couldn't find event with ID " . $idEvent . "." );
	return ( bool ) $result ["public"];
}
function isUserRegisteredInEvent($idUser, $idEvent) {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM EventRegistration WHERE idEvent = :event AND idUser = :user' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	$result = $stmt->fetch ();
	if ($result)
		return true;
	else
		return false;
}
function isUserInvitedToEvent($idUser, $idEvent) {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM EventInvite WHERE idEvent = :event AND idInvited = :user' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	$result = $stmt->fetch ();
	if ($result)
		return true;
	else
		return false;
}
function canSeeEvent($idUser, $idEvent) {
	if (isEventPublic ( $idEvent ))
		return true;
	if (isUserRegisteredInEvent ( $idUser, $idEvent ))
		return true;
	if (isUserInvitedToEvent ( $idUser, $idEvent ))
		return true;
	
	return false;
}
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
function getRegisteredEvents($idUser, $amount = -1, $offset = 0) {
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
function getEvent($idEvent) {
	global $db;
	$stmt = $db->prepare ( "SELECT * FROM Event WHERE id = :event" );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getEventRegistrations($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM EventRegistration
			INNER JOIN Event ON EventRegistration.idEvent = Event.idEvent
			INNER JOIN User ON EventRegistration.idUser = User.id
			WHERE Event.id = :event
			ORDER BY User.name ASC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idUser, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getEventAlbums($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Album INNER JOIN Event ON Event.id = :event LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':amount', $amount, PDO::PARAM_INT );
	$stmt->bindParam ( ':offset', $offset, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function registerInEvent($idUser, $idEvent) {
	global $db;
	
	// Check if already registered
	$query = "SELECT * FROM EventRegistration WHERE idEvent = :event AND idUser = :user";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	if ($stmt->fetch ())
		throw new AlreadyRegisteredException ( "User is already registered in the event." );
	
	$query = "INSERT INTO EventRegistration (idEvent, idUser) VALUES (:event, :user)";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
}
print_r ( getEventsByOwner ( 1 ) );
print_r ( getRegisteredEvents ( 1 ) );
echo "Public: " . canSeeEvent ( 1, 1 ) ? "true" : "false";
?>