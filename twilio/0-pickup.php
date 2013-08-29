<?php

require_once '../config.php';
session_start(); 

$_SESSION['lang'] = $_GET['lang'];
$lang = $_SESSION['lang'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
	<Play>harp.mp3</Play>
	<Say language="en">Home health access.</Say>
<?php
if($lang == 'en')
{
	echo '<Say language="en">Attendant portal.</Say>';
}
elseif($lang == 'es')
{
	echo '<Say language="es">Portal de atendiente.</Say>';
}
?>
	<Redirect method="POST">1-answer.php</Redirect>
</Response>
