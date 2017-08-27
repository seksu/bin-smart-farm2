<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);
	include ("connectAdd.php");
	//$con = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	$con = Connection();

	//*** Reject user not online
	$intRejectTime = 20; // Minute
	$sql = "UPDATE member SET LoginStatus = '0', LastUpdate = '0000-00-00 00:00:00'  WHERE 1 AND DATE_ADD(LastUpdate, INTERVAL $intRejectTime MINUTE) <= NOW() ";
	$query = mysqli_query($con,$sql);

?>
