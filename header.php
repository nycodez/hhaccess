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
<style>
body {
	margin: 0px;
	border: 0px;
	background-color: #eeeeee;
}
#message {
	height: 50px;
	background-color: #333333;
}
#menu {
	margin: 0px;
	height: 50px;
	background-color: #336699;
}
#menu ul {
	margin: 0 100 0 100;
}
#menu ul li {
	float: left;
	font: 1.3em Verdana;
	margin-top: 10px;
	margin-right: 50px;
	text-transform: uppercase;
}
#menu ul li a {
	text-decoration: none;
	color: white;
}
#menu ul li a:hover {
	color: #dddddd;
}
#banner {
	height: 250px;
	background-color: #336699;
	text-align: center;
}
#banner h1 {
	margin: 0px;
	padding: 80px;
	font: 4em Tahoma;
	color: white;
}
#signup {
	background-color: #dddddd;
	text-align: center;
	padding: 75px;
	font: 20px Arial;
	color: #333333;
}
#tour-button {
	text-decoration: none;
	background-color: #eeeeee;
	color: #666666;
	border: solid 1px #222222;
	margin: 10px;
	padding: 10 40 10 40;
	margin-left: 30px;
	font: 16px Arial;
	border-radius: 6px;
}
#signup-button {
	text-decoration: none;
	background-color: red;
	color: white;
	border: solid 1px #222222;
	margin: 10px;
	padding: 10 40 10 40;
	margin-left: 30px;
	font: 16px Arial;
	border-radius: 6px;
}
#map {
	height: 200px;
	font: 16px Arial;
}
#footer {
	font: .8em Verdana;
	color: #cccccc;
	height: 50px;
	text-align: right;
}
#login {
	border: solid 1px blue;
	border-radius: 10px;
	width: 400px;
	height: 150px;
	margin: 30 auto;
	padding: 30px;
	text-align: center;
}
#login form {
	padding: 0;
	margin: 0;
}
#login h3 {
	margin: 0;
	font: 1.3em Arial;
	text-transform: uppercase;
}
#login input:not([type=submit]):not([type=file]):not([type=button]), textarea {
	width: 200px;
	margin: 5px;
	padding: 3px;
	font: 1.2em Arial;
	color: #333333;
	background-color: #fffffd;
	border-radius: 3px;
}
#login input[type=submit],[type=file],[type=button] {
	width: 100px;
	margin: 5px;
	padding: 3px;
	font: 1.2em Arial;
	color: #333333;
	background-color: #A6DEEE;
	border-radius: 9px;
}
canvas {
	width: 600px;
	height: 200px;
//	border: solid 1px black;
}
</style>
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
