<?php
require_once (__DIR__ . "/../config.php");
try {
	$db = new PDO ("sqlite:" . DATABASE_PATH . "/db.db");
	$db->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}
?>
