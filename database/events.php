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

function getFuturePublicEvents() {
	global $db;
	$stmt = $db->prepare ( 'SELECT * FROM Event WHERE public = 1 AND date >= CURRENT_TIMESTAMP ORDER BY date');
	$stmt->execute ();
	return $stmt->fetchAll ();
}
function getFutureRegisteredEvents($idUser) {
    global $db;
    $stmt = $db->prepare ( 'SELECT * FROM Event INNER JOIN EventRegistration ON Event.id = EventRegistration.idEvent
WHERE EventRegistration.idUser = :user  AND Event.date >= CURRENT_TIMESTAMP ORDER BY date');
    $stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
    $stmt->execute ();
    return $stmt->fetchAll ();
}
function getUserEventHistory($idUser) {
    global $db;
    $stmt = $db->prepare ( 'SELECT * FROM Event INNER JOIN EventRegistration ON Event.id = EventRegistration.idEvent
WHERE EventRegistration.idUser = :user  AND Event.date < CURRENT_TIMESTAMP ORDER BY date');
    $stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
    $stmt->execute ();
    return $stmt->fetchAll ();
}
function getFutureEventsByOwner($idOwner, $amount = -1, $offset = 0) {
	global $db;
	$query = "SELECT * FROM Event WHERE owner = :owner AND date >= CURRENT_TIMESTAMP ORDER BY date DESC LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':owner', $idOwner, PDO::PARAM_INT );
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
function searchEvents($searchQuery, $idUser, $amount = -1, $offset = 0) {
	global $db;
	$condition = "EventSearch.id = Event.id AND
			(Event.public OR
				Event.owner = :user OR
				(SELECT count(*) FROM EventRegistration WHERE idEvent = Event.id AND idUser = :user) = 1)
			AND EventSearch MATCH :query";
	$query = "SELECT * FROM EventSearch, Event WHERE " . $condition . " LIMIT :amount OFFSET :offset";
	$stmt = $db->prepare ( $query );
	$searchQuery2 = 'name:' . $searchQuery . ' OR description:' . $searchQuery;
	$stmt->bindParam ( ':query', $searchQuery2, PDO::PARAM_STR );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
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
function getEventTypeName($idType) {
	global $db;
	$query = "SELECT name FROM EventType WHERE id=:id";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':id', $idType, PDO::PARAM_INT );
	$stmt->execute ();
	$res = $stmt->fetchAll();
	if(sizeof($res) == 0)
		return "";
	return $res[0]["name"];
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
function unregisterFromEvent($idUser, $idEvent) {
	global $db;
	
	// Check if already registered
	$query = "SELECT * FROM EventRegistration WHERE idEvent = :event AND idUser = :user";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
	$stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
	$stmt->execute ();
	if ($stmt->fetch ()) {
		$query = "DELETE FROM EventRegistration  WHERE idUser = :user AND idEvent = :event";
		$stmt = $db->prepare ( $query );
		$stmt->execute ();
	} else
		throw new AlreadyRegisteredException ( "User is not registered in Event." );
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
		return -1;
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
function updateEvent($name, $description, $date, $public) {
	global $db;
	$query = "UPDATE Event SET name = :name, description = :description, date = :date, public = :public";
	$stmt = $db->prepare ( $query );
	$stmt->bindParam ( ':name', $name, PDO::PARAM_STR );
	$stmt->bindParam ( ':description', $description, PDO::PARAM_STR );
	$stmt->bindParam ( ':date', $date, PDO::PARAM_STR );
	$stmt->bindParam ( ':public', $public, PDO::PARAM_BOOL );
	if (! $stmt->execute ())
		return false;
	$idEvent = $db->lastInsertId ( 'id' );
	return $idEvent;
}

function deleteEvent($idEvent) {
    global $db;
    $query = "DELETE FROM Event WHERE id = :event ";
    $stmt = $db->prepare ( $query );
    $stmt->bindParam ( ':event', $idEvent, PDO::PARAM_INT );
    if($stmt->execute ()) {
        return $idEvent;
    }
    return false;
}

function getInvitedEvents($idUser) {
    global $db;
    $stmt = $db->prepare ( 'SELECT * FROM Event INNER JOIN EventInvite ON Event.id = EventInvite.idEvent
WHERE EventInvite.idInvited = :user  AND Event.date >= CURRENT_TIMESTAMP ORDER BY date');
    $stmt->bindParam ( ':user', $idUser, PDO::PARAM_INT );
    $stmt->execute ();
    return $stmt->fetchAll ();
}

?>
