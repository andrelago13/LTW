<?php
require_once (__DIR__ . "/../config.php");
try {
    echo "sqlite:" . DATABASE_PATH . "/db.db";
    echo "sqlite:C:Users/André/git/LTW/database/db.db";
	$db = new PDO ("sqlite:C:Users/André/git/LTW/database/db.db");
	$db->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}
?>