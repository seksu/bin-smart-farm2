<?php
   	include("connectAdd.php");
      include("sns.php");
   	require __DIR__ . '/aws.phar';
   	$linkadd=Connection();

      $airHumi = $_POST["airHumi"];
      $airTemp = $_POST["airTemp"];
      $groundHumi = $_POST["groundHumi"];
      $groundTemp = $_POST["groundTemp"];
      $light = $_POST["light"];
      $rain = $_POST["rain"];
      $userId = $_POST["userId"];

      echo $airHumi;
      echo $airTemp;
      echo $groundHumi;
      echo $groundHumi;
      echo $light;
      echo $userId;

	   $query1 = "INSERT INTO seksu (airHumi,airTemp,groundHumi,groundTemp,light,rain,userId) 
        VALUES ('".$airHumi."','".$airTemp."','".$groundHumi."','".$groundTemp."','".$light."','".$rain."','".$userId."')"; 
   	
   	mysqli_query($linkadd,$query1);

      if($groundHumi > 50){
         pub($userId,$linkadd,"It has something wrong about ground humidity in your farm.");
      }
      if($airHumi > 50  ){
         pub($userId,$linkadd,"It has something wrong about air humidity in your farm.");
      }
      if($groundTemp > 40 || $groundTemp < 0 ){
         pub($userId,$linkadd,"It has something wrong about ground temperature in your farm.");
      }
      if($airTemp > 40 || $airTemp < 0 ){
         pub($userId,$linkadd,"It has something wrong about air temperature in your farm.");
      }
      mysqli_close($linkadd);


   	//header("Location: alert.php");
?>
