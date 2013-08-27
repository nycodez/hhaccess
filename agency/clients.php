<?php
require 'header.php';
require_once 'hhaccess.php';

$client = new Client();
$clients = $client->getActiveClients();

echo '<div id=main>
	<div class=defaultList>
	<h3>List of Active Clients</h3>';

	foreach($clients as $k => $v)
	{
		echo '<a href="clientview?id='. $k .'">'. $v['name'] .'</a><br />';
	}

echo '</div>
	</div>';

require 'footer.php';
