<?php
    session_start();
    $_SESSION['message'] = '';
    require __DIR__ . '/aws.phar';
    include ("connectAdd.php");

    
    $link=Connection();
   
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST["username"];
        $name = $_POST["name"];
        $email1 = $_POST["email1"];
        $email2 = $_POST["email2"];
        $email3 = $_POST["email3"];
        $email4 = $_POST["email4"];
        $email5 = $_POST["email5"];
        $password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];
        if($password == $confirmpassword ){
         
   // Create a new Amazon SNS client
        $sns = Aws\Sns\SnsClient::factory(array('key'    => 'AKIAI5SRO5GZJTH5PH4A',
                                            'version' => '2010-03-31',
                                            'secret' => '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',
                                            'region' => 'ap-southeast-1'));
        $result = $sns -> createTopic(['Name' => $name,]);
        $test1 = array('arn' => $result['TopicArn']);
        //echo $test1['arn'];  
          
        $emaillist = array('mail1'=>$email1,'mail2' => $email2,'mail3' => $email3, 'mail4' => $email4,'mail5' => $email5);
          //echo $test1['arn'];
          //echo $test1['endpoint'];
        $subs = $sns->subscribe(array(
            'TopicArn' => $test1['arn'],
            'Protocol' => 'email',
            'Endpoint' => $emaillist['mail1'],));
        if($email2 != NULL){
              $subs2 = $sns->subscribe(array(
              'TopicArn' => $test1['arn'],
              'Protocol' => 'email',
              'Endpoint' => $emaillist['mail2'],));
        }
        if($email3 != NULL){
              $subs3 = $sns->subscribe(array(
              'TopicArn' => $test1['arn'],
              'Protocol' => 'email',
              'Endpoint' => $emaillist['mail3'],));
        }
        if($email4 != NULL){
              $subs4 = $sns->subscribe(array(
              'TopicArn' => $test1['arn'],
              'Protocol' => 'email',
              'Endpoint' => $emaillist['mail4'],));
        }
        if($email5 != NULL){
              $subs5 = $sns->subscribe(array(
              'TopicArn' => $test1['arn'],
              'Protocol' => 'email',
              'Endpoint' => $emaillist['mail5'],));
        }

        //create new account  
        $query = "INSERT INTO member (Username,Password,Name,email1,email2,email3,email4,email5,arn) 
        VALUES ('".$username."','".$password."','".$name."','".$email1."','".$email2."','".$email3."','".$email4."','".$email5."','".$test1['arn']."')"; 
        
        
        if (mysqli_query($link, $query)) {
            echo "New record created successfully";
        } 
        else {
          echo "Error: " . $link . "<br>" . mysqli_error($link);
        }

        
        
          
          


          mysqli_close($link);;
          header("Location: index.html");
      }
    }
?>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="regisform.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Create an account</h1>
    <form class="input_form" action="regisform.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="text" placeholder="DisplayName" name="name" required />
      <input type="email" placeholder="Email for noti (must)" name="email1" required />
      <input type="email" placeholder="other Email for noti(optional) " name="email2"  />
      <input type="email" placeholder="other Email for noti(optional) " name="email3"  />
      <input type="email" placeholder="other Email for noti(optional) " name="email4" />
      <input type="email" placeholder="other Email for noti(optional) " name="email5"  />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
  
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>