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
	public function getAttendeesAssignedToClient($id)
	{
		$qs = "select * from `assignments` A
			left join `attendants` T on A.assignmentAttendant = T.attendantID
			left join `users` U on A.assignmentUser = U.userID
			where A.assignmentActive = 1
			and A.`assignmentClient` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['assignmentID']] = $row;
		}
		return $arr;
	}
}
class Attendant
{
	public function __construct()
	{
		global $conn;
		$this->conn = $conn;
	}
	public function getActiveAttendants()
	{
		$qs = "select * from `attendants` where `attendantActive` = 1 order by `attendantName`";
		$d = mysql_query($qs, $this->conn) or die(mysql_error());
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['attendantID']] = $row;
		}
		return $arr;
	}
	public function getActiveAttendantList($alreadyAssigned = array())
	{
		if(count($alreadyAssigned))
		{
			$alreadyAssignedList = implode(',', $alreadyAssigned);
			$assigned = "and attendantID not in ($alreadyAssignedList)";
		}
		else
		{
			$assigned = '';
		}
		$qs = "select attendantID,attendantName from `attendants` 
			where `attendantActive` = 1 
			$assigned
			order by `attendantName`";
		$d = mysql_query($qs, $this->conn) or die(mysql_error());
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['attendantID']] = $row['attendantName'];
		}
		return $arr;
	}
	public function getAttendant($id)
	{
		$qs = "select * from `attendants` where `attendantID` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}
		return $arr;
	}
	public function getClientsAssignedToAttendant($id)
	{
		$qs = "select * from `assignments` A
			left join `clients` C on A.assignmentClient = C.clientID
			left join `users` U on A.assignmentUser = U.userID
			where A.assignmentActive = 1
			and A.`assignmentAttendant` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['assignmentID']] = $row;
		}
		return $arr;
	}
}
class User 
{
	public function __construct()
	{
		global $conn;
		$this->conn = $conn;
	}
	public function getActiveUsers()
	{
		$qs = "select * from `users` where `userActive` = 1 order by `userName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['userID']] = $row;
		}
		return $arr;
	}
	public function getActiveUserList()
	{
		$qs = "select userID,userName from `users` where `userActive` = 1 order by `userName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['userID']] = $row['userName'];
		}
		return $arr;
	}
	public function getUser($id)
	{
		$qs = "select * from `users` where `userID` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}
		return $arr;
	}
}
