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
			$arr[$row['clientID']] = $row;
		}
		return $arr;
	}
	public function getActiveClientList()
	{
		$qs = "select * from `clients` where `clientActive` = 1 order by `clientName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['clientID']] = $row['clientName'];
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
	public function getAttendantsAssignedToClient($id)
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
	public function getAttendantCallsNotCounted($id = false)
	{
		if(!$id)
			return false;
		$qs = "select * from `calls` L
			left join `clients` C on L.callClient = C.clientID
			where L.`callActive` = 1
			and L.`callApproved` = 0
			and L.`callCounted` = 0
			and L.`callAttendant` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['callID']] = $row;
		}
		return $arr;
	}
	public function getDateRangeClockins($attendantId = false, $fromDate = false, $toDate = false)
	{
		$qs = "select * from `calls` L
			left join `clients` C on L.callClient = C.clientID
			left join `attendants` A on L.callAttendant = A.attendantID
			where L.`callActive` = 1\n";

		if($attendantId)
		{
			$qs .= "and L.`callAttendant` = '$id'\n";
		}
		if($fromDate)
		{
//			$fromDate = date("Y-m-d h:i:s", strtotime($fromDate));
			$qs .= "and L.`callDate` >= '$fromDate'\n";
		}
		if($toDate)
		{
			$toDate = date("Y-m-d h:i:s", strtotime($toDate));
//			$qs .= "and L.`callDate` <= '$toDate'\n";
		}

		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['callID']] = $row;
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
class Form
{
	public function __construct()
	{
		global $conn;
		$this->conn = $conn;
	}
	public function getActiveForms()
	{
		$qs = "select * from `forms` where `formActive` = 1 order by `formName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['formID']] = $row;
		}
		return $arr;
	}
	public function getActiveFormList()
	{
		$qs = "select formID,formName from `forms` where `formActive` = 1 order by `formName`";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr[$row['formID']] = $row['formName'];
		}
		return $arr;
	}
	public function getForm($id)
	{
		$qs = "select * from `forms` where `formID` = '$id'";
		$d = mysql_query($qs, $this->conn);
		while($row = mysql_fetch_assoc($d))
		{
			$arr = $row;
		}
		return $arr;
	}
}
