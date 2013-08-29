<?php
session_start();
if(isset($_SESSION['loggedIn']))
	$loggedin = true;
else
	$loggedin = false;
?>
<html>
<head>
<title>Home Health Access - Home Health Care agency management made easy</title>
<link rel="main stylesheet" href="/css/main.css" type="text/css">
</head>
<div id=message></div>
<div id=menu>
	<ul>
	<li><a href="/">Home</a></li>
	<li><a href="/about">About</a></li>
	<li><a href="/blog">Blog</a></li>
	<li><a href="/contact">Contact</a></li>
	<li><a href="/agency"><?php if($loggedin) echo 'Admin'; else echo 'Login'; ?></a></li>
	</ul>
</div>
