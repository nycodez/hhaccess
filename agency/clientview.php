<?php
if($_REQUEST['func'] == 'Update')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$id = $info['clientID'];
	unset($info['clientID']);
	$qs = BuildUpdateString('clients', "`clientID`='$id'",$info, true);
	$d = mysql_query($qs, $conn);
	header('Location: /agency/clients');
}
else
{
	require 'header.php';
	require_once 'hhaccess.php';
	require_once 'formFunctions.inc.php';
	require_once 'FormBuilder.php';

	$id = $_REQUEST['id'];
	$client = new Client();
	$info = $client->getClient($id);

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();
	echo $form->AddHiddenField('clientID', $id);

	echo '<label>Name</label>';
	echo $form->AddTextField('clientName', $info['clientName']);

	echo '<br />
		<label>Phone</label>';
	echo $form->AddTextField('clientPhone', $info['clientPhone']);

	echo '<br />
		<label>Address</label>';
	echo $form->AddTextField('clientAddress', $info['clientAddress']);

	echo '<br />
		<label>City</label>';
	echo $form->AddTextField('clientCity', $info['clientCity']);

	echo '<br />
		<label>State</label>';
	echo $form->AddTextField('clientState', $info['clientState']);

	echo '<br />
		<label>Zip</label>';
	echo $form->AddTextField('clientZip', $info['clientZip']);

	echo '<br />
		<label>Name</label>';
	echo $form->AddTextArea('clientNotes', $info['clientNotes'], 30, 5);

	echo '<br />';
	echo $form->AddSubmitButton('func', 'Update');

	$form->EndForm();

	echo '</div>';

	require 'footer.php';
}
