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
elseif($_REQUEST['func'] == 'Add User')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];

	$qs = BuildInsertString('users', $info, true);
	$d = mysql_query($qs, $conn);
	$userId = mysql_insert_id();

	header('Location: /agency/users?id='. $userId);
}
elseif($_REQUEST['func'] == 'addUser')
{
	require 'header.php';
	require_once 'hhaccess.php';
	require_once 'formFunctions.inc.php';
	require_once 'FormBuilder.php';

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();

	echo '<h3>New User Information</h3>
		<label>Name</label>';
	echo $form->AddTextField('userName', '');

	echo '<br />
		<label>Login</label>';
	echo $form->AddTextField('userLogin', '');

	echo '<br />
		<label>Password</label>';
	echo $form->AddTextField('userPass', '');

	echo '<br />
		<label>Phone</label>';
	echo $form->AddTextField('userPhone', '');

	echo '<br />
		<label>Address</label>';
	echo $form->AddTextField('userAddress', '');

	echo '<br />
		<label>City</label>';
	echo $form->AddTextField('userCity', '');

	echo '<br />
		<label>State</label>';
	echo $form->AddTextField('userState', '');

	echo '<br />
		<label>Zip</label>';
	echo $form->AddTextField('userZip', '');

	echo '<br />
		<label>Notes</label>';
	echo $form->AddTextArea('userNotes', '', 30, 5);

	echo $form->AddButton('func', 'Cancel', array('onclick'=>"window.location.href = 'users'"));
	echo $form->AddSubmitButton('func', 'Add User');

	$form->EndForm();

	echo '</div>';
}
elseif(isset($_GET['delAssignment']))
{
	require '../config.php';
	require 'auth.php';

	$assignmentId = $_GET['delAssignment'];

	$info['assignmentActive'] = 0;
	$info['assignmentRemovalDate'] = date("Y-m-d h:i:s");
	$info['assignmentRemovalUser'] = $_SESSION['uid'];

	$qs = "select `assignmentClient` from `assignments` where `assignmentID` = '$assignmentId'";
	$d = mysql_query($qs, $conn);
	list($clientId) = mysql_fetch_row($d);

	$qt = BuildUpdateString('assignments', "`assignmentId`='$assignmentId'", $info, true);
	$e = mysql_query($qt, $conn);

	header('Location: /agency/clients?id='. $clientId);
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

	echo '<h3>User Information</h3>
		<label>Name</label>';
	echo $form->AddTextField('userName', $info['userName']);

	echo '<br />
		<label>Login</label>';
	echo $form->AddTextField('userLogin', $info['userLogin']);

	echo '<br />
		<label>Password</label>';
	echo $form->AddTextField('userPass', $info['userPass']);

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
		<h3>List of Active Users</h3>
		<div class=defaultListOptions><a href=/agency/users?func=addUser>New User</a></div>';

	foreach($users as $k => $v)
	{
		echo '<a href="users?id='. $k .'">'. $v .'</a><br />';
	}

	echo '</div>
		</div>';

	require 'footer.php';
}
