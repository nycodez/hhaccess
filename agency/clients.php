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
elseif($_REQUEST['func'] == 'addAssignment')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$info['assignmentUser'] = $_SESSION['uid'];

	$qs = BuildInsertString('assignments', $info, true);
	$d = mysql_query($qs, $conn);

	header('Location: /agency/clients?id='. $info['assignmentClient']);
}
elseif(isset($_GET['delAssignment']))
{
	require '../config.php';
	require 'auth.php';

	$assignmentId = $_GET['delAssignment'];

	$info['assignmentActive'] = 0;
	$info['assignmentRemovalDate'] = date("Y-m-d h:i:s");

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
	$client = new Client();
	$info = $client->getClient($id);
	$assignments = $client->getAttendeesAssignedToClient($id);

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
		<label>Notes</label>';
	echo $form->AddTextArea('clientNotes', $info['clientNotes'], 30, 5);

	echo $form->AddButton('func', 'Cancel', array('onclick'=>"window.location.href = 'clients'"));
	echo $form->AddSubmitButton('func', 'Update');

	$form->EndForm();

	echo '</div>
		<div class=defaultForm>
		<table width=100% class=defaultTable>
		<tr>
			<th>Attendant</th>
			<th>Status</th>
			<th>Assigned</th>
			<th>By</th>
			<th></th>
		</tr>';

	foreach($assignments as $k => $v)
	{
		echo '<tr>
			<td><a href=/agency/attendants?id='. $v['attendantID'] .'>'. $v['attendantName'] .'</a></td>
			<td>'. $v['assignmentStatus'] .'</td>
			<td>'. date("n/j/y", strtotime($v['assignmentDate'])) .'</td>
			<td>'. $v['userName'] .'</td>
			<td><a href=?delAssignment='. $k .'><b>X</a></a></td>
			</tr>';

		$alreadyAssigned[] = $v['attendantID'];
	}

	echo '</table>
		<br /><b>Assign an attendant to this client:</b>';

	$attendant = new Attendant();
	$attendants = $attendant->getActiveAttendantList($alreadyAssigned);

	$form = new FormBuilder();
	$form->BeginForm('discrete');
	echo '<input type=hidden name=func value=addAssignment />';
	echo $form->AddHiddenField('assignmentClient', $id);
	echo $form->AddSelect('assignmentAttendant', 'Select an Attendant', $attendants, false, array('onchange'=>"this.form.submit()"));
	$form->EndForm();
	
	echo '</div>';

	require 'footer.php';
}
else
{
	require 'header.php';
	require_once 'hhaccess.php';

	$client = new Client();
	$clients = $client->getActiveClients();

	echo '<div id=main>
		<div class=defaultList>
		<h3>List of Active Clients</h3>';

	foreach($clients as $k => $v)
	{
		echo '<a href="clients?id='. $k .'">'. $v['name'] .'</a><br />';
	}

	echo '</div>
		</div>';

	require 'footer.php';
}
