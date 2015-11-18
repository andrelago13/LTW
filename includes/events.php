<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/events.php");
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