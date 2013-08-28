<?php
require '../config.php';
require 'auth.php';
?>
<html>
<head>
<title>Home Health Access - Agency Account</title>
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
	margin: 0 50 0 0;
}
#menu ul li {
	float: left;
	font: 1em Verdana;
	margin-top: 15px;
	margin-right: 40px;
	text-transform: uppercase;
}
#menu ul li a {
	text-decoration: none;
	color: white;
}
#menu ul li a:hover {
	color: #dddddd;
}
#footer {
	font: .8em Verdana;
	color: #cccccc;
	height: 50px;
	text-align: right;
}
.dashboardWidget {
	float: left;
	border: solid 1px blue;
	margin: 20 0 20 20;
	padding: 10px;
	width: 400px;
	height: 300px;
}
.dashboardWidget h3 {
	margin: 0 0 10 0;
	font: 1.1em Tahoma;
	text-transform: uppercase;
}
.defaultList {
	border: solid 1px blue;
	margin: 50px ;
	padding: 10px;
	border-radius: 5px;
	font-family: Tahoma;
}
.defaultList h3 {
	margin: 0 0 10 0;
	font: 1.1em Tahoma;
	text-transform: uppercase;
}
.defaultList a:link, a:visited {
	text-decoration: none;
	color: blue;
}
.defaultForm {
	margin: 50px;
	border: solid 1px #bbbbbb;
	border-radius: 10px;
	padding: 20px;
	margin: 50 auto 50;
	width: 500px;
	background-color: #EFF9FC;
}
.defaultForm input:not([type=submit]):not([type=file]):not([type=button]), textarea {
	width: 300px;
	margin: 10px;
	padding: 3px;
	font: 1.2em Arial;
	color: #333333;
	background-color: #fffffd;
	border-radius: 3px;
}
.defaultForm input[type=submit],[type=file],[type=button] {
	width: 100px;
	margin: 5px;
	padding: 3px;
	font: 1.2em Arial;
	color: #333333;
	background-color: #A6DEEE;
	border-radius: 9px;
}
.defaultForm label {
	text-align: right;
	float: left;
	font: 1.1em Arial;
	margin: 10px;
	padding: 3px;
	width: 100px;
	color: #888888;
}
.defaultTable {
	width: 100%;
	font: .9em Verdana;
}
.defaultTable th {
	text-align: left;
}
.defaultTable a {
	text-decoration: none;
}
</style>
</head>
<body>
<div id=message></div>
<div id=menu>
	<ul>
	<li><a href="/">HH</a></li>
	<li><a href="/agency">Dashboard</a></li>
	<li><a href="/agency/clients">Clients</a></li>
	<li><a href="/agency/attendants">Attendants</a></li>
	<li><a href="/agency/users">Agency Staff</a></li>
	<li><a href="/agency/reports">Reports</a></li>
	<li><a href="/agency/logout">Logout</a></li>
	</ul>
</div>
