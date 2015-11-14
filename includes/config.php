<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

defined("DATABASE_PATH") or define("DATABASE_PATH", realpath(dirname(dirname(__FILE__)) . '/database'));
?>