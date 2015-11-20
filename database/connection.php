<?php
require_once (__DIR__ . "/../config.php");
try {
	$p = utf8_encode("sqlite:" . DATABASE_PATH . "\db.db");
	$db = new PDO ($p);
	$db->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}
?>
