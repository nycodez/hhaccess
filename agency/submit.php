<?php
if($_REQUEST['func'] == 'Preview')
{
	require '../config.php';
	require 'auth.php';
	require 'hhaccess.php';
	require 'pdftk-php.php';

	$info = $_REQUEST[$_REQUEST['formName']];
	$id = $info['formID'];

	$formulario = new Form();
	$formularioInfo = $formulario->getForm($id);

	$client = new Client();
	$clientInfo = $client->getClient($info['formClient']);

//	pr($formularioInfo);

	$pdfmaker = new pdftk_php();

	$fdf_data_strings = array
		(
		 'patientsNameLastFirstMiddleInitial' => $clientInfo['clientName'],
		 'patientsAddressNoStreet' => $clientInfo['clientAddress'],
		 'patientsCity' => $clientInfo['clientCity'],
		 'patientsState' => $clientInfo['clientState'],
		 'patientsZip' => $clientInfo['clientZip'],
		 'patientsPhoneNumber' => $clientInfo['clientPhone'],
		);

	// Used for radio buttons and check boxes
	// Example: (For check boxes options are Yes and Off)
	// $pdf_checkbox1 = "Yes";
	// $pdf_checkbox2 = "Off";
	// $pdf_checkbox3 = "Yes";
	// $fdf_data_names = array('checkbox1' => $pdf_checkbox1,'checkbox2' => $pdf_checkbox2,'checkbox3' => $pdf_checkbox3,'checkbox4' => $pdf_checkbox4); 
	$fdf_data_names = array
		(
		); // Leave empty if there are no radio buttons or check boxes

	$fields_hidden = array
		(
		); // Used to hide form fields

	$fields_readonly = array
		(
		); // Used to make fields read only - however, flattening the output with pdftk will in effect make every field read only. If you don't want a flattened pdf and still want some read only fields, use this variable and remove the flatten flag near line 70 in pdftk-php.php

	// Name of file to be downloaded
	$pdf_filename = "output.pdf";

	// Name/location of original, empty PDF form
	$pdf_original =  dirname(__DIR__) .'/forms/'. $formularioInfo['formFile'];

	// Finally make the actual PDF file!
	$pdfmaker->make_pdf($fdf_data_strings, $fdf_data_names, $fields_hidden, $fields_readonly, $pdf_original, $pdf_filename);
	exit;

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

	echo '<div id=main>';

	$formulario = new Form();
	$formularios = $formulario->getActiveFormList();

	$client = new Client();
	$clients = $client->getActiveClientList();
	$clients = array(0=>'All Clients') + $clients;

	$dates = array
		(
		 'all'=>'All Available',
		 'thisWeek'=>'This Week',
		 'lastWeek'=>'Last Week',
		 'thisMonth'=>'This Month',
		 'lastMonth'=>'Last Month',
		);

	$form = new FormBuilder();
	$form->BeginForm();

	echo '<h3>Submit a form for payment</h3>';

	echo $form->AddSelect('formID', 'Select a form to submit', $formularios);

	echo '<br />';

	echo $form->AddSelect('formClient', 'Select a client to bill for', $clients);

	echo '<br />';

	echo $form->AddSelect('formDates', 'Select a date range', $dates, 'all');

	echo '<br />';

	echo $form->AddSubmitButton('func', 'Preview');

	$form->EndForm();

	echo '</div>';

	require 'footer.php';
}
