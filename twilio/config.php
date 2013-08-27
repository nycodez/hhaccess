<?php
define('DBNAME', 'hha');
define('DBUSER', 'hha');
define('DBPASS', 'wQmTGAE2uqQ3fJ8m');
define('DBHOST', 'localhost');
function connectDB($database = DBNAME, $user = DBUSER, $pass = DBPASS, $hostname = DBHOST)
{
        $conn = @mysql_connect($hostname, $user, $pass);

        if($conn)
                mysql_select_db($database, $conn);

        return $conn;
}
$conn = connectDB();
if(!$conn)
{
        echo 'Unable to connect to the database.';
        exit;
}
function pr($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
