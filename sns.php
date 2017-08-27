<?php 
			

	function pub($userid,$linkadd,$msg){
		
	   	
		$sql = "SELECT arn FROM member WHERE userId='$userid'";
		$result=mysqli_query($linkadd,$sql);
		$display = mysqli_fetch_array($result);
		$dparn = $display['arn'];
		$sns = Aws\Sns\SnsClient::factory(array('key'    => 'AKIAI5SRO5GZJTH5PH4A',
                                            'version' => '2010-03-31',
                                            'secret' => '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',
                                            'region' => 'ap-southeast-1'));
        $result = $sns->publish(['Message' => $msg,'TargetArn'=>$dparn,'Subject'=>'Alert from ScareCrow',]);
		return 0;
	}




?>