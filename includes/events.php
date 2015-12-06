<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/events.php");
class Event {
	private $id;
	private $name;
	private $owner;
	private $description;
	private $date;
	private $public;
	private $imagePath;
	
	public function getOwner() {
		return $this->owner;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function setDate($date) {
		$this->date = $date;
	}
	public function setPublic($public) {
		$this->public = $public;
	}
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	public function setImagePath($imagePath) {
		$this->imagePath = $imagePath;
	}
	public static function find($id) {
		$event_query = getEvent ( $id );
		
		$event = new Event ();
		$event->setId ( $event_query ["id"] );
		$event->setDate ( $event_query ["date"] );
		$event->setDescription ( $event_query ["description"] );
		$event->setName ( $event_query ["name"] );
		$event->setPublic ( $event_query ["public"] );
		$event->setOwner ( $event_query ["owner"] );
		$event->setImagePath ( $event_query ["imagePath"] );
		
		return $event;
	}
	public function update() {
		updateEvent ( $this->name, $this->description, $this->date, $this->public );
	}
	public function expose() {
		return get_object_vars ( $this );
	}
	public function delete() {
		$error = false;
		$error |= deleteEvent ( $this->id );
		if (!@is_null($this->imagePath))
			$error |= unlink($this->imagePath);
		return $error;
	}
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
?>