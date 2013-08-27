<?php

require_once 'config.php';
session_start(); 

$lang = $_SESSION['lang'];
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$digits = $_REQUEST['Digits'];

if($digits)
{
	$qs = "select * from `attendants` where `attendantID` = '{$_SESSION['attendant']}' and `attendantSecret` = '$digits'";
	$d = mysql_query($qs, $conn);

	if(mysql_num_rows($d) !== 1)
	{
?>
<Response>
<?php
if($lang == 'en')
	echo '<Say language="en">That is not the correct passcode. Please try again.</Say>';
elseif($lang == 'es')
	echo '<Say language="en">Su clave secreta no se ha verificado. Intente de nuevo.</Say>';
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

}
else
{
?>
<Response>
<?php
if($lang == 'en')
	echo '<Say language="en">You did not enter a passcode. Please try again.</Say>';
elseif($lang == 'es')
	echo '<Say language="en">No ha marcado su clave secreta. Intente de nuevo.</Say>';
?>
	<Redirect method="POST">1-answer.php</Redirect>
</Response>
<?php
}

?>
<Response>
	<Redirect method="POST">4-match-assignment.php</Redirect>
</Response>
