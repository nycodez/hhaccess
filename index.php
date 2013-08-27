<html>
<head>
<title>Home Health Access - Home Health Care agency management made easy</title>
<style>
body {
	margin: 0px;
	border: 0px;
	background-color: #eeeeee;
}
#message {
	height: 50px;
	background-color: #333333;
}
#menu {
	margin: 0px;
	height: 50px;
	background-color: #336699;
}
#menu ul {
	margin: 0 100 0 100;
}
#menu ul li {
	float: left;
	font: 1.3em Verdana;
	margin-top: 10px;
	margin-right: 50px;
	text-transform: uppercase;
}
#menu ul li a {
	text-decoration: none;
	color: white;
}
#menu ul li a:hover {
	color: #dddddd;
}
#banner {
	height: 250px;
	background-color: #336699;
	text-align: center;
}
#banner h1 {
	margin: 0px;
	padding: 80px;
	font: 4em Tahoma;
	color: white;
}
#signup {
	background-color: #dddddd;
	text-align: center;
	padding: 75px;
	font: 20px Arial;
	color: #333333;
}
#tour-button {
	text-decoration: none;
	background-color: #eeeeee;
	color: #666666;
	border: solid 1px #222222;
	margin: 10px;
	padding: 10 40 10 40;
	margin-left: 30px;
	font: 16px Arial;
	border-radius: 6px;
}
#signup-button {
	text-decoration: none;
	background-color: red;
	color: white;
	border: solid 1px #222222;
	margin: 10px;
	padding: 10 40 10 40;
	margin-left: 30px;
	font: 16px Arial;
	border-radius: 6px;
}
#map {
	height: 450px;
	font: 16px Arial;
}
#footer {
	font: .8em Verdana;
	color: #cccccc;
	height: 100px;
	text-align: right;
}
canvas {
	width: 600px;
	height: 200px;
//	border: solid 1px black;
}
</style>
</head>
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

<div id=message></div>
<div id=menu>
	<ul>
	<li><a href="/">Home</a></li>
	<li><a href="/about">About Us</a></li>
	<li><a href="/blog">Blog</a></li>
	<li><a href="/contact">Contact</a></li>
	<li><a href="/help">Help</a></li>
	<li><a href="/agency">Login</a></li>
	</ul>
</div>
<div id=banner><canvas id="canvas"></canvas></div>
<div id=signup>Get started right away. No credit card required. <a id="tour-button" href="/tour">See it in action</a> <a id="signup-button" href="/signup">Sign up for free</a></div>
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
<div id=footer>&copy; 2013 Gonzales Consulting LLC. All rights reserved.</div>
</body>
</html>
