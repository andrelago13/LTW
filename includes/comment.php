<?php
require_once (__DIR__ . "/../config.php");
require_once (DATABASE_PATH . "/events.php");
function canWriteComment($idUser, $idEvent) {
	return isUserRegisteredInEvent ( $idUser, $idEvent );
}