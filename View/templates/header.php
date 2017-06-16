<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="better than instagram">
	<meta name="author" content="angavrel">
	<link rel="icon" type="image/png" href="../public/resources/favicon.ico">
	<title>Camagru</title>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/header.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
</head>
<!-- http://localhost:8080/Camagru/ -->
<body>
<div class="bar">
	<div class="inner-bar">
		<div class="logo-bar">
			<?php if (isset($logo))echo $logo; ?>
		</div>
		<div class="icones-bar">
			<?php if (isset($home))echo $home; ?>
			<?php if (isset($cam))echo $cam; ?>
			<?php if (isset($camphp))echo $camphp; ?>
			<?php if (isset($gallery))echo $gallery; ?>
			<?php if (isset($profile))echo $profile; ?>
			<?php if (isset($disconnect))echo $disconnect; ?>
		</div>
	</div>
</div>
<div class="container">
	<div class="starter-template">
