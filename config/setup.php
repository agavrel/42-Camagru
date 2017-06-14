<?php

require 'database.php';
require '../Core/Model.class.php';

$database = new Model();
$database->init_connection("mysql:dbname=camagru;host=localhost", $DB_USER, $DB_PASSWORD);
$database->query("CREATE TABLE IF NOT EXISTS users
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	login VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL,
	password VARCHAR(256) NOT NULL,
	email_confirmed ENUM('yes', 'no') DEFAULT 'no' NOT NULL,
	admin ENUM('yes','no') DEFAULT 'no' NOT NULL
);");

$database->query("CREATE TABLE IF NOT EXISTS posts
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    image_path VARCHAR(238) NOT NULL,
	login VARCHAR(32) NOT NULL,
    date DATETIME NOT NULL
);");

$database->query("CREATE TABLE IF NOT EXISTS likes
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    img_path VARCHAR(238) NOT NULL,
	login VARCHAR(32) NOT NULL
);");

$database->query("CREATE TABLE IF NOT EXISTS comments
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    img_path VARCHAR(238) NOT NULL,
	login VARCHAR(32) NOT NULL,
    img_comment LONGTEXT NOT NULL,
    date DATETIME NOT NULL
);");

$database->query("INSERT INTO users VALUES
(null, 'root', 'admin@camagru.io', 'cb693a235e2fdbc6cf9a4a2174a3ede6a29d58af5974fa5212e4600103cb869feaff17810c8b2c8a91314a61a4ded7dc6ce3b7b86d75bb62f1686595bf0271bb', 'yes', 'yes')
;");
?>
<a href="http://localhost:<?= substr($_SERVER['HTTP_HOST'], -4); ?>/<?= explode('/', $_SERVER['REQUEST_URI'])[1] ?>/Authsignin/signIn">Home</a>
