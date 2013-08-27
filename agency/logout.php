<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
$_SESSION = array();
session_destroy();

unset($_POST['logout']);

header('Location: /');
