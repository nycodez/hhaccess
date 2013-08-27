<?php

require_once '../config.php';
session_start(); 

$lang = $_SESSION['lang'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$qs = "select `assignmentID`,`assignmentStatus` from `assignments` where `assignmentActive` = 1
	and `assignmentClient` = '{$_SESSION['client']}' 
	and `assignmentAttendant` = '{$_SESSION['attendant']}'";

$d = mysql_query($qs, $conn);

if(mysql_num_rows($d) !== 1)
{
?>
	<Response>
<?php
	if($lang == 'en')
		echo '<Say loop="3" language="en">The number you are calling from has not been assigned to you. Please call your agency.</Say>';
	elseif($lang == 'es')
		echo '<Say loop="3" language="es">El numero del cual llama no se le ha asignado. Llame a su agencia.</Say>';
?>
	</Response>
<?php
die;
}

list($assignmentID,$currentStatus) = mysql_fetch_row($d);

if($currentStatus == 'IN')
{
	$newStatus = 'OUT';
}
elseif($currentStatus == 'OUT')
{
	$newStatus = 'IN';
}

$qt = "update `calls` set
	`callClient` = '{$_SESSION['client']}',
	`callAttendant` = '{$_SESSION['attendant']}',
	`callStatus` = '{$newStatus}'
	where `callID` = '{$_SESSION['lastid']}'";
$e = mysql_query($qt, $conn);

$qu = "update `assignments` set
	`assignmentStatus` = '$newStatus' 
	where `assignmentID` = '$assignmentID'";
$f = mysql_query($qu, $conn);

?>
<Response>
<?php
if($lang == 'en')
{
	$dateEN = date("g ia");
	if($newStatus == 'IN')
	{
		echo '<Say loop="3" language="en">Arrival verified. '.$dateEN.'</Say>';
	}
	elseif($newStatus == 'OUT')
	{
		echo '<Say loop="3" language="en">Departure verified. '.$dateEN.'</Say>';
	}
}
elseif($lang == 'es')
{
	$dateES = date("g i");
	if($newStatus == 'IN')
	{
		echo '<Say loop="3" language="es">Entrada verificada. '.$dateES.'</Say>';
	}
	elseif($newStatus == 'OUT')
	{
		echo '<Say loop="3" language="es">Salida verificada. '.$dateES.'</Say>';
	}
}
?>
</Response>
