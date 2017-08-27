
<?php

session_start();
if(!isset($_SESSION["UserID"])){
   header("Location:index.html");
}

  include("connectAdd.php");  
  
  $link=Connection();
  $qid = $_SESSION["UserID"];
  $result=mysqli_query($link,"SELECT * FROM seksu WHERE userId= $qid " );
  $sql1 = "SELECT * FROM member WHERE UserID=$qid";
  $result1=mysqli_query($link,$sql1);
  $display = mysqli_fetch_array($result1);
  $dpuser = $display['Username'];
  $email1 = $display['email1'];


  $airHumi = array( );
  $airTemp = array( );
  $groundHumi = array( );
  $groundTemp = array( );
  $light = array( );
  $rain = array( );
  $first = null;
  $index = 0;
  $second = null;
  if($result!== FALSE){
     while($row = mysqli_fetch_array($result)) {
     	if($index == 0) {
     		$first = strtotime($row["time"])/10;
     		$index +=1;
     	}
     $second = strtotime($row["time"])/10;

        array_push($airHumi,array('x' =>  $second-$first,'y' => $row["airHumi"]) );
        array_push($airTemp,array('x' => $second-$first,'y' => $row["airTemp"]) );
        array_push($groundHumi,array('x' =>  $second-$first,'y' => $row["groundHumi"]) );
        array_push($groundTemp,array('x' =>  $second-$first,'y' => $row["groundTemp"]) );
        array_push($light,array('x' =>  $second-$first,'y' => $row["light"]) );
        array_push($rain,array('x' =>  $second-$first,'y' => $row["rain"]) );

	     }	
	 
     //mysql_free_result($result);
    //mysql_close();
  }
?>

<!DOCTYPE html>
<html>
<head>
<title>Smart Farm</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.css" >

</head>
<body>
	<!-- main -->
		<div class="main" style="width: 100%; align-items: center; margin: 1em;">
			<h1>Smart Farm</h1>
	      	<div class="row">
	      		<div class="col-xs-8" id="nodeChart">
					<svg style="width:100%;  height:400px;"></svg>
				</div>
				<div class="col-xs-3 col-xs-offset-1">
					<div class="row">
						<h4>Name : <?php echo $dpuser; ?></h4>
					</div>
					<div class="row">
						<h4>Email : <?php echo $email1; ?></h4>
					</div>
				</div>
			</div>

				<form action="/logout.php">
					<div class="ckeck-bg">
						<div class="checkbox-form">
							<div class="check-right">
								<input type="submit" value="log out">
							</div>
						</div>
					</div>
				</form>

			
		</div>
	<!-- //main -->

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.js"></script>
<script type="text/javascript" src="gscript.js"></script>
<script type="text/javascript">
	

function sinAndCos() {
  var rain = <?php echo json_encode($rain); ?>;
  var light = <?php echo json_encode($light); ?>;
  var airHumi = <?php echo json_encode($airHumi); ?>;
  var airTemp  = <?php echo json_encode($airTemp); ?>;
  var groundHumi = <?php echo json_encode($groundHumi); ?>;
  var groundTemp  = <?php echo json_encode($groundTemp); ?>;
console.log(rain);
console.log(light);
  //Data is represented as an array of {x,y} pairs.
    //Line chart data should be sent as an array of series objects.
  return [
    {
      values: airTemp,      //values - represents the array of {x,y} data points
      key: 'airTemp', //key  - the name of the series.
      color: '#e74c3c',  //color - optional: choose your own line color.
    }
    ,
    {
      values: airHumi,
      key: 'airHumi',
      color: '#1abc9c'
    }
    ,
    {
      values: groundTemp,
      key: 'groundTemp',
      color: '#f39c12'
    }
    ,
    {
      values: groundHumi,
      key: 'groundHumi',
      color: '#f39c12'
    }
  ];
}
</script>
</body>
</html>