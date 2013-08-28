<?php
require_once 'header.php';
?>
<body onload="start()">

<script type ="application/javascript" language="javascript">
var ctx;
var circleX = -5;
function start()
{
	var element = document.getElementById("canvas");
	ctx = element.getContext("2d");

	var interval = setInterval(animate,100/50);
}
function animate()
{
	circleX = circleX + 3;
	draw(circleX, 75);
}
function draw(x,y) 
{
	ctx.fillStyle= "rgb(0,0,100)";
	ctx.arc(x,y,1,0,Math.PI*2,true);
	ctx.fill();

ctx.font = "1.5em Tahoma";
ctx.fillText("Home Health Access", 50, 70);
}
</script>

<div id=banner><canvas id="canvas"></canvas></div>
<div id=signup>Get started right away. No credit card required. <!--a id="tour-button" href="/tour">See it in action</a--!><a id="signup-button" href="/signup">Sign up for free</a></div>
<div id=map>
	<p align=center>
	<br />
	<br />
	<br />
	<table border=0 height=200>
		<tr>
			<td align=center valign=top width=200><b>Business Administration</b><br />Manage workers and clients easily from one web portal</td>
<td width=50>&nbsp;</td>
			<td align=center valign=top width=200><b>One-click Reporting</b><br />Report accurate billable hours with the click of a button</td>
<td width=50>&nbsp;</td>
			<td align=center valign=top width=200><b>Easy form submission</b><br />Automated form submission to state and local agencies</td>
		</tr>
	</table>	
	</p>
</div>
<?php
require_once 'footer.php';
