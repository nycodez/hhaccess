<?php
session_start();
function showLogin()
{
	require 'login.php';
	exit;
}
function authenticateUser($login, $password)
{
        global $conn;

        $login = strtolower($login);

	$qs = "select * from users where userActive = 1 and userLogin = '$login' and userPass = '$password'";
        $d = mysql_query($qs, $conn);

	if(mysql_num_rows($d))
	{
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}

		$sessionId = session_id();

		$_SESSION['loggedIn'] = TRUE;
		$_SESSION['username'] = $arr['userLogin'];
		$_SESSION['password'] = $arr['userPass'];
		$_SESSION['sessionId'] = $sessionId;
		$_SESSION['uid'] = $arr['userID'];

		$qt = "insert into `sessions` (`sessionUser`,`sessionAddress`,`sessionValue`) values ('{$arr['userID']}','{$_SERVER['REMOTE_ADDR']}','$sessionId')";
		$e = mysql_query($qt, $conn);

		unset($_REQUEST);
	}
        else
        {
/*                $line = $_SERVER['HTTP_HOST'] .'|'. $_SERVER['REMOTE_ADDR'] .'|'. $login .'|'. date("Y-m-d h:i:s") .'|'. $_SERVER['HTTP_USER_AGENT'] ."\n";
                $f = fopen("/data/logs/fmd/failedLogin", "a");
                fwrite($f, $line, strlen($line));
                fclose($f);*/

		require 'login.php';

                exit;
        }
}
function confirmUser($login, $password, $sessionId)
{
        global $conn;

	$qs = "select * from sessions S
		left join users U on S.sessionUser = U.userID
		where userActive = 1 and userLogin = '$login' and userPass = '$password'
		order by sessionID desc 
		limit 1";
	$d = mysql_query($qs, $conn);

	if(mysql_num_rows($d))
	{
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}

		$sessionId = session_id();

		if($sessionId !== $arr['sessionValue'])
		{
			echo '<p>Another session has been started.</p>';

			showLogin();

			exit;
		}
	}
}
function logoutUser()
{
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $_SESSION = array();
        session_destroy();

        unset($_POST['logout']);

	header('Location: /');
}
if(isset($_REQUEST['logout']))
        logoutUser();
else if($_REQUEST['func'] == 'Login')
        authenticateUser($_POST['login'], $_POST['pass']);
else if($_SESSION['loggedIn'] && $_SESSION['username'] && $_SESSION['password'])
        confirmUser($_SESSION['username'], $_SESSION['password'], session_id());
else
        showLogin();
