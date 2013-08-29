<?php
if($_REQUEST['func'] == 'Submit')
{
	echo 'BUSTA';
}
elseif($_REQUEST['func'] == 'OK')
{
	echo 'SUCKA';
}
elseif($_REQUEST['func'] == 'Sign Up')
{
	require 'config.php';

	$info = $_REQUEST[$_REQUEST['formName']];
pr($info);
exit;
	$id = $info['attendantID'];
	unset($info['attendantID']);

	$qs = BuildUpdateString('attendants', "`attendantID`='$id'",$info, true);
	$d = mysql_query($qs, $conn);

	header('Location: /agency/attendants');
}
else
{
	$uri = explode('.', $_SERVER['SERVER_NAME']);
	$subdomain = $uri[0];

	require_once 'header.php';
	require_once 'agency/formFunctions.inc.php';
	require_once 'agency/FormBuilder.php';

	echo '<link href="/css/agency.css" type="text/css">
		<body onload="document.getElementById(\'demoName\').focus();">
		<div id=main><p>Please fill out the short form below to enable a fully functional account.</p>';

	$form = new FormBuilder();
	$form->BeginForm();
	echo $form->AddHiddenField('demoReferer', $subdomain);

	echo '<h3>Your Information</h3>
		<label>Your Name</label>';

	echo $form->AddTextField('demoName', '', false, false, array('id'=>'demoName'));

	echo '<br />
		<label>Your Email</label>';
	echo $form->AddTextField('demoEmail');

	echo '<br />
		<label>Choose Password</label>';
	echo $form->AddTextField('demoPass');

	echo '<br />
		<label>Agency Name</label>';
	echo $form->AddTextField('demoAgencyName');

	echo '<br />
		<label>Agency Zip Code</label>';
	echo $form->AddTextField('demoAgencyZip');

	echo '<br />
		<label>Number of Clients</label>';
	echo $form->AddTextField('demoNumberOfClients');

	echo $form->AddSubmitButton('func', 'Submit', array('style'=>'display: none;'));

	echo $form->AddSubmitButton('func', 'Sign Up');

	echo $form->AddSubmitButton('func', 'OK', array('style'=>'display: none;'));

	$form->EndForm();

	echo '</div>';

	require_once 'footer.php';
}
