<?php
// http://localhost:8080/camagru/config/setup.php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require('caller.php');
	define('PORT', '8080');
	date_default_timezone_set('Europe/Paris');
	$dispatcher = new Dispatcher(array($DB_DSN, $DB_USER, $DB_PASSWORD));
?>
