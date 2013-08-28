<?php
require_once '../header.php';
?>
<div id=login>
	<form method=post>
		<h3>Agency Admin Portal Login</h3>
		<br />
		<input type=text name=login placeholder=username />
		<br />
		<input type=password name=pass placeholder=password />
		<br style="clear: both;" />
		<input type=submit name=func value=Login />
	</form>
</div>
<?php
require '../footer.php';
?>
