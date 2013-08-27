<?php

class Client
{
	public function __construct()
	{
		global $conn;
		$this->conn = $conn;
	}
	public function getActiveClients()
	{
		$qs = "select * from `clients` where `clientActive` = 1 order by `clientName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['clientID']]['name'] = $row['clientName'];
		}
		return $arr;
	}
	public function getClient($id)
	{
		$qs = "select * from `clients` where `clientID` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}
		return $arr;
	}
}
