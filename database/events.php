<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/connection.php");
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
function isUserEventOwner($idUser, $idEvent) {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM Event WHERE idEvent = :event AND owner = :user' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	$result = $stmt->fetch ();
	if ($result)
		return true;
	else
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
function getEvent($idEvent) {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM Event WHERE id = :event' );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->fetch ();
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
function searchEvents($searchQuery, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM EventSearch WHERE name MATCH :query LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$searchQuery2 = 'name:'.$searchQuery.' OR description:'.$searchQuery;
	$stmt->bindParam ( ':query', $searchQuery2, PDO::PARAM_STR );
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
function getEventRegistrations($idEvent, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM EventRegistration
			INNER JOIN Event ON EventRegistration.idEvent = Event.id
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
function getEventTypes() {
	global $db;
	$query = "SELECT * FROM EventType";
	$stmt = $db->prepare ( $query );
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
function createEvent($type, $name, $description, $date, $public, $owner) {
	global $db;
	$query = "INSERT INTO Event (type, name, description, date, public, owner) VALUES (:type, :name, :description, :date, :public, :owner)";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':type', $type, PDO::PARAM_INT );
	$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
	$stmt->bindParam ( ':description', $description, PDO::PARAM_STR );
	$stmt->bindParam ( ':date', $date, PDO::PARAM_STR );
	$stmt->bindParam ( ':public', $public, PDO::PARAM_BOOL );
	$stmt->bindParam ( ':owner', $owner, PDO::PARAM_INT );
	if (! $stmt->execute ())
		return false;
	$idEvent = $db->lastInsertId ( 'id' );
	registerInEvent ( $owner, $idEvent );
	return $idEvent;
}
function updateEventImage($idEvent, $imagePath) {
	global $db;
	$query = "UPDATE Event SET imagePath = :imagePath WHERE id = :event";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':imagePath', $imagePath, PDO::PARAM_STR );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->execute ();
	return $stmt->rowCount () == 1;
}
?>