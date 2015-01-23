<?php
require_once 'header.php';
require_once 'hhaccess.php';

$attendant = new Attendant();
$todaysClockins = $attendant->getDateRangeClockins(false, date("Y-m-d 00:00:00"));
?>
<div id=main>

<div class=dashboardWidget>
	<h3>Today's Clock Ins</h3>
<?php
foreach($todaysClockins as $k => $v)
{
	echo '<a href=/agency/attendants?id='. $v['attendantID'] .'>'. $v['attendantName'] .'</a> - <a href=/agency/clients?id='. $v['clientID'] .'>'. $v['clientName'] .'</a> - '. date("g:ia", strtotime($v['callDate'])) .' <b>'. $v['callStatus'] .'</b><br />';
}
?>
</div>

<br style="clear: both;" />
</div>
<?php
require 'footer.php';
?>
