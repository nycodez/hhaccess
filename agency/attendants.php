<?php
if($_REQUEST['func'] == 'Update')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$id = $info['attendantID'];
	unset($info['attendantID']);

	$qs = BuildUpdateString('attendants', "`attendantID`='$id'",$info, true);
	$d = mysql_query($qs, $conn);

	header('Location: /agency/attendants');
}
elseif(isset($_GET['delAssignment']))
{
	require '../config.php';
	require 'auth.php';

	$assignmentId = $_GET['delAssignment'];

	$info['assignmentActive'] = 0;
	$info['assignmentRemovalDate'] = date("Y-m-d h:i:s");

	$qs = "select `assignmentAttendant` from `assignments` where `assignmentID` = '$assignmentId'";
	$d = mysql_query($qs, $conn);
	list($attendantId) = mysql_fetch_row($d);

	$qt = BuildUpdateString('assignments', "`assignmentId`='$assignmentId'", $info, true);
	$e = mysql_query($qt, $conn);

	header('Location: /agency/attendants?id='. $attendantId);
}
elseif(isset($_GET['id']))
{
	require 'header.php';
	require_once 'hhaccess.php';
	require_once 'formFunctions.inc.php';
	require_once 'FormBuilder.php';

	$id = $_REQUEST['id'];
	$attendant = new Attendant();
	$info = $attendant->getAttendant($id);
	$assignments = $attendant->getClientsAssignedToAttendant($id);

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();
	echo $form->AddHiddenField('attendantID', $id);

	echo '<label>Name</label>';
	echo $form->AddTextField('attendantName', $info['attendantName']);

	echo '<br />
		<label>Identifier</label>';
	echo '<input type=text readonly=true value="'. $info['attendantID'] .'" />';

	echo '<br />
		<label>Passcode</label>';
	echo $form->AddTextField('attendantSecret', $info['attendantSecret']);

	echo '<br />
		<label>Phone</label>';
	echo $form->AddTextField('attendantPhone', $info['attendantPhone']);

	echo '<br />
		<label>Address</label>';
	echo $form->AddTextField('attendantAddress', $info['attendantAddress']);

	echo '<br />
		<label>City</label>';
	echo $form->AddTextField('attendantCity', $info['attendantCity']);

	echo '<br />
		<label>State</label>';
	echo $form->AddTextField('attendantState', $info['attendantState']);

	echo '<br />
		<label>Zip</label>';
	echo $form->AddTextField('attendantZip', $info['attendantZip']);

	echo '<br />
		<label>Notes</label>';
	echo $form->AddTextArea('attendantNotes', $info['attendantNotes'], 30, 5);

	echo $form->AddButton('func', 'Cancel', array('onclick'=>"window.location.href = 'attendants'"));
	echo $form->AddSubmitButton('func', 'Update');

	$form->EndForm();

	echo '</div>

		<div class=defaultForm>
		<table width=100% class=defaultTable>
		<tr>
			<th>Client</th>
			<th>Status</th>
			<th>Assigned</th>
			<th>By</th>
			<th></th>
		</tr>';

	foreach($assignments as $k => $v)
	{
		echo '<tr>
			<td><a href=/agency/clients?id='. $v['clientID'] .'>'. $v['clientName'] .'</a></td>
			<td>'. $v['assignmentStatus'] .'</td>
			<td>'. date("n/j/y", strtotime($v['assignmentDate'])) .'</td>
			<td>'. $v['userName'] .'</td>
			<td><a href=?delAssignment='. $k .'><b>X</a></a></td>
			</tr>';

		$alreadyAssigned[] = $v['attendantID'];
	}

	echo '</table>
		</div>';

	require 'footer.php';
}
else
{
	require 'header.php';
	require_once 'hhaccess.php';

	$attendant = new Attendant();
	$attendants = $attendant->getActiveAttendantList();

	echo '<div id=main>
		<div class=defaultList>
		<h3>List of Active Attendants</h3>';

	foreach($attendants as $k => $v)
	{
		echo '<a href="attendants?id='. $k .'">'. $v .'</a><br />';
	}

	echo '</div>
		</div>';

	require 'footer.php';
}
