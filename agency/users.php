<?php
if($_REQUEST['func'] == 'Update')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$id = $info['userID'];
	unset($info['userID']);

	$qs = BuildUpdateString('users', "`userID`='$id'",$info, true);
	$d = mysql_query($qs, $conn);

	header('Location: /agency/users');
}
elseif(isset($_GET['id']))
{
	require 'header.php';
	require_once 'hhaccess.php';
	require_once 'formFunctions.inc.php';
	require_once 'FormBuilder.php';

	$id = $_REQUEST['id'];
	$user = new User();
	$info = $user->getUser($id);

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();
	echo $form->AddHiddenField('userID', $id);

	echo '<label>Name</label>';
	echo $form->AddTextField('userName', $info['userName']);

	echo '<br />
		<label>Phone</label>';
	echo $form->AddTextField('userPhone', $info['userPhone']);

	echo '<br />
		<label>Address</label>';
	echo $form->AddTextField('userAddress', $info['userAddress']);

	echo '<br />
		<label>City</label>';
	echo $form->AddTextField('userCity', $info['userCity']);

	echo '<br />
		<label>State</label>';
	echo $form->AddTextField('userState', $info['userState']);

	echo '<br />
		<label>Zip</label>';
	echo $form->AddTextField('userZip', $info['userZip']);

	echo '<br />
		<label>Notes</label>';
	echo $form->AddTextArea('userNotes', $info['userNotes'], 30, 5);

	echo $form->AddButton('func', 'Cancel', array('onclick'=>"window.location.href = 'users'"));
	echo $form->AddSubmitButton('func', 'Update');

	$form->EndForm();

	echo '</div>';

	require 'footer.php';
}
else
{
	require 'header.php';
	require_once 'hhaccess.php';

	$user = new User();
	$users = $user->getActiveUserList();

	echo '<div id=main>
		<div class=defaultList>
		<h3>List of Active Users</h3>';

	foreach($users as $k => $v)
	{
		echo '<a href="users?id='. $k .'">'. $v .'</a><br />';
	}

	echo '</div>
		</div>';

	require 'footer.php';
}
