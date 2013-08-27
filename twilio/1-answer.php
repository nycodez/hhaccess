<?php

require_once '../config.php';
session_start(); 

$lang = $_SESSION['lang'];
$_SESSION['cid'] = preg_replace('/\+1/', '', $_REQUEST['From']);
$json = json_encode($_REQUEST);
$qs = "insert into `calls` (`callJson`,`callCid`,`callLang`) values ('$json','{$_SESSION['cid']}','$lang')";
$d = mysql_query($qs, $conn);
$_SESSION['lastid'] = mysql_insert_id();

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$qs = "select * from `clients` where `clientPhone` = '{$_SESSION['cid']}' and `clientActive` = 1";
$d = mysql_query($qs, $conn);

while($row = mysql_fetch_assoc($d))
{
	$client = $row;
}

if(mysql_num_rows($d) !== 1)
{
?>
<Response>
<?php
if($lang == 'en')
	echo '<Say loop="5" language="en">The number you are calling from has not been registered. Please have the client call their home health care agency to update their telephone numbers on file.</Say>';
elseif($lang == 'es')
	echo '<Say loop="5" language="es">El numero del cual está llamando aún no se ha registrado. Por favor pida al cliente que llame a su agencia para actualizar sus números de telefono.</Say>';
?>
</Response>
<?php
die;
}

$_SESSION['client'] = $client['clientID'];
?>

<Response>
	<Gather numDigits="5" action="/twilio/2-receive-ident.php" method="POST">
<?php
if($lang == 'en')
	echo '<Say language="en">Enter your identifier now.</Say>';
elseif($lang == 'es')
	echo '<Say language="es">Marque su numero de identification ahora mismo.</Say>';
?>
	</Gather>
</Response>
