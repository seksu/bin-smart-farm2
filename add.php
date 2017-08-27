<?php
   	include("connectAdd.php");
   	include("sns.php");
      require __DIR__ . '/aws.phar';
   	$link=Connection();

      $airHumi = $_POST["airHumi"];
      $airTemp = $_POST["airTemp"];
      $groundHumi = $_POST["groundHumi"];
      $groundTemp = $_POST["groundTemp"];
      $light = $_POST["light"];
      $rain = $_POST["rain"];
      $userId = $_POST["userId"];


	   $query = "INSERT INTO seksu (airHumi,airTemp,groundHumi,groundTemp,light,rain,userId) 
		VALUES ('".$airHumi."','".$airTemp."','".$groundHumi."','".$groundTemp."','".$light."','".$rain."','".$userId."')"; 
   	
   	$temp = mysqli_query($link,$query);

      if($groundHumi > 50){
         pub($userId,$link,"It has something wrong about ground humidity in your farm.");
      }
      if($airHumi > 50  ){
         pub($userId,$link,"It has something wrong about air humidity in your farm.");
      }
      if($groundTemp > 40 || $groundTemp < 0 ){
         pub($userId,$link,"It has something wrong about ground temperature in your farm.");
      }
      if($airTemp > 40 || $airTemp < 0 ){
         pub($userId,$link,"It has something wrong about air temperature in your farm.");
      }
      mysqli_close($link);
	
   	//header("Location: index.php");
?>
