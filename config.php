<?php
define('DBNAME', 'hhaccess');
define('DBUSER', 'hhaccess');
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

function BuildUpdateString($table, $where, &$arr, $addSlashes = false, $database = false)
{
	if(count($arr))
	{
		foreach($arr as $k => $v)
		{
			if($v === false)
			$qs .= "$k = NULL,";
			else if(is_object($v))
			$qs .= "$k = $v->value,";
			else
			{
				if($addSlashes)
				$v = addslashes($v);
				$qs .= "$k = '$v',";
			}
		}

		$qs = substr($qs, 0, -1);
		if($database)
			return "update `$database`.$table set $qs where $where";
		else
			return "update $table set $qs where $where";
	}
	else
	return false;
}

function BuildInsertString($table, $inArr, $addSlashes = false, $replace = false, $multi = false, $database = false)
{
	if(count($inArr))
	{
		if(!$multi)
		$inArr = array($inArr);

		$vals = array();
		foreach($inArr as $arr)
		{
			if(!isset($varsArr))
			$varsArr = array_keys($arr);

			$valArr = array();
			foreach($varsArr as $k)
			{
				$v = $arr[$k];

				if($v === false)
				$valArr[] = 'NULL';
				else if(is_object($v))
				$valArr[] = $v->value;
				else
				{
					if($addSlashes)
					$v = addslashes($v);

					$valArr[] = "'$v'";
				}
			}

			$vals[] = '(' . implode(',', $valArr) . ')';
		}

		if($replace)
		$insert = 'replace';
		else
		$insert = 'insert';

		$vars = implode(',', $varsArr);
		$vals = implode(',', $vals);
		if($database)
			return "$insert into `$database`.$table($vars) values $vals";
		else
			return "$insert into $table($vars) values $vals";
	}
	else
	return false;
}
