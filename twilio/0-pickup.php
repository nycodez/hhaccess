<?php

require_once 'config.php';
session_start(); 

$_SESSION['lang'] = $_GET['lang'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
	<Play>harp.mp3</Play>
	<Say language="en">Home health access.</Say>
	<Redirect method="POST">1-answer.php</Redirect>
</Response>
