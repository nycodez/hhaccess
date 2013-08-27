<?php

require_once 'config.php';
session_start(); 

$lang = $_SESSION['lang'];
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$digits = $_REQUEST['Digits'];

if($digits)
{
	$qs = "select * from `attendants` where `attendantID` = '$digits'";
	$d = mysql_query($qs, $conn);

	if(mysql_num_rows($d) !== 1)
	{
?>
<Response>
<?php
if($lang == 'en')
	echo '<Say language="en">Identifier not found. Please try again.</Say>';
elseif($lang == 'es')
	echo '<Say language="es">Su numero de identification no se ha verificado. Intente de nuevo.</Say>';
?>
	<Redirect method="POST">1-answer.php</Redirect>
</Response>
<?php
die;
	}

	while($row = mysql_fetch_assoc($d))
	{
		$attendant = $row;
	}

	$_SESSION['attendant'] = $digits;
}
else
{
?>
<Response>
<?php
if($lang == 'en')
	echo '<Say language="en">You did not enter an identifier. Please try again.</Say>';
elseif($lang == 'es')
	echo '<Say language="es">No ha marcado su numero de identification. Intente de nuevo.</Say>';
?>
	<Redirect method="POST">1-answer.php</Redirect>
</Response>
<?php
die;
}

?>
<Response>
	<Gather numDigits="10" method="POST" action="/twilio/3-receive-secret.php">
<?php
if($lang == 'en')
	echo '<Say language="en">'. $attendant['attendantName'] .'. Enter your passcode now.</Say>';
elseif($lang == 'es')
	echo '<Say language="es">'. $attendant['attendantName'] .'. Marque su clave secreta ahora mismo.</Say>';
?>
	</Gather>
</Response>
