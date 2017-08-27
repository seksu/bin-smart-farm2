<?php

	function Connection(){
		
	   	
		//$connection = mysqli_connect($server, $user, $pass);

		$connection = mysqli_connect('aa1w5h69favjr07.ckysemueavqn.ap-southeast-1.rds.amazonaws.com','blackpolb','12345678', 'ebdb','3306');
		if (!$connection) {
    		die("Connection failed: " . mysqli_connect_error());
		}

		return $connection;
	}

?>
