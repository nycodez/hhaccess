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
if($_REQUEST['func'] == 'Process')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$id = $info['attendantID'];
	foreach($info['matches'] as $k => $v)
	{
		$qs = "update `calls` set `callApproved` = 1 where `callID` = '$k'";
		$d = mysql_query($qs, $conn) or die(mysql_error());
	}

	header('Location: /agency/attendants?id='. $id);
}
elseif($_REQUEST['func'] == 'Add Attendant')
{
	require '../config.php';
	require 'auth.php';

	$info = $_REQUEST[$_REQUEST['formName']];

	$qs = BuildInsertString('attendants', $info, true);
	$d = mysql_query($qs, $conn);
	$attendantId = mysql_insert_id();

	header('Location: /agency/attendants?id='. $attendantId);
}
elseif($_REQUEST['func'] == 'addAttendant')
{
	require 'header.php';
	require_once 'hhaccess.php';
	require_once 'formFunctions.inc.php';
	require_once 'FormBuilder.php';

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();

	echo '<h3>New Attendant Information</h3>
		<label>Name</label>';
	echo $form->AddTextField('attendantName', '');

	echo '<br />
		<label>Phone</label>';
	echo $form->AddTextField('attendantPhone', '');

	echo '<br />
		<label>Address</label>';
	echo $form->AddTextField('attendantAddress', '');

	echo '<br />
		<label>City</label>';
	echo $form->AddTextField('attendantCity', '');

	echo '<br />
		<label>State</label>';
	echo $form->AddTextField('attendantState', '');

	echo '<br />
		<label>Zip</label>';
	echo $form->AddTextField('attendantZip', '');

	echo '<br />
		<label>Notes</label>';
	echo $form->AddTextArea('attendantNotes', '', 30, 5);

	echo $form->AddButton('func', 'Cancel', array('onclick'=>"window.location.href = 'attendants'"));
	echo $form->AddSubmitButton('func', 'Add Attendant');

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

	$qs = "select `assignmentAttendant` from `assignments` where `assignmentID` = '$assignmentId'";
	$d = mysql_query($qs, $conn);
	list($attendantId) = mysql_fetch_row($d);

	$qt = BuildUpdateString('assignments', "`assignmentId`='$assignmentId'", $info, true);
	$e = mysql_query($qt, $conn);

	header('Location: /agency/attendants?id='. $attendantId);
}
elseif(isset($_GET['delCall']))
{
	require '../config.php';
	require 'auth.php';

	$callId = $_GET['delCall'];

	$info['callActive'] = 0;
	$info['callRemovalDate'] = date("Y-m-d h:i:s");
	$info['callRemovalUser'] = $_SESSION['uid'];

	$qs = "select `callAttendant` from `calls` where `callID` = '$callId'";
	$d = mysql_query($qs, $conn);
	list($attendantId) = mysql_fetch_row($d);

	$qt = BuildUpdateString('calls', "`callID`='$callId'", $info, true);
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
	$callsNotCounted = $attendant->getAttendantCallsNotCounted($id);

	echo '<div id=main>';

	$form = new FormBuilder();
	$form->BeginForm();
	echo $form->AddHiddenField('attendantID', $id);

	echo '<h3>Attendant Information</h3>
		<label>Name</label>';
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
		<h3>Clients Assigned</h3>
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
			<td><a href=?delAssignment='. $k .'><b>X</b></a></td>
			</tr>';

		$alreadyAssigned[] = $v['attendantID'];
	}

	echo '</table>
		</div>';

	$form = new FormBuilder();
	$form->BeginForm('discreet');
	echo $form->AddHiddenField('attendantID', $id);

	echo '<div class=defaultForm>
		<h3>Unprocessed Attendant Logs</h3>
		<table width=100% class=defaultTable>
		<tr>
			<th></th>
			<th>Client</th>
			<th>Status</th>
			<th>Date</th>
			<th></th>
		</tr>';

	$i = 0;
	$s = 'OUT';
	foreach($callsNotCounted as $k => $v)
	{
		if($v['callStatus'] == 'IN' && $s == 'OUT')
		{
			//we're clocking in
			$check  = true;
			$s = 'IN';
			$i++;
		}
		elseif($v['callStatus'] == 'OUT' && $s == 'IN')
		{
			//we're clocking out
			$check  = true;
		}
		elseif($v['callStatus'] == 'IN' && $s == 'IN')
		{
			//yikes
			$check = false;
		}
		elseif($v['callStatus'] == 'OUT' && $s == 'OUT')
		{
			//yikes
			$check = false;
		}

		echo '<tr>
			<td>'. $form->AddCheckBox("matches][$k", '', 1, $check) .'</td>
			<td><a href=/agency/clients?id='. $v['clientID'] .'>'. $v['clientName'] .'</a></td>
			<td>'. $v['callStatus'] .'</td>
			<td>'. $v['callDate'] .'</td>
			<td><a href=?delCall='. $k .'><b>X</b></a></td>
			</tr>';

		if($v['callStatus'] == 'OUT' && $s == 'IN')
		{
			//we're clocking out
			$s = 'OUT';
			$i++;
		}
	}

	echo '</table>';

	if(count($callsNotCounted))
		echo $form->AddSubmitButton('func', 'Process');

	$form->EndForm();

	echo '</div>';

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
		<h3>List of Active Attendants</h3>
		<div class=defaultListOptions><a href=/agency/attendants?func=addAttendant>New Attendant</a></div>';

	foreach($attendants as $k => $v)
	{
		echo '<a href="attendants?id='. $k .'">'. $v .'</a><br />';
	}

	echo '</div>
		</div>';

	require 'footer.php';
}
