<?php
include('utils.php');
/*

============================================================================================
Recurrent Schedulings

*/

$msgid = 0;
$q=mysql_query("select * from schedules where sch_enable = 1 AND sch_rec = 'r' AND sch_startdate <= CURDATE();") or die(mysql_error());
 if(mysql_num_rows($q) > 0){
	 $i = 0;
	//$rowset[][]; 
	
	while($row = mysql_fetch_array($q)){
		$rowset[$i] = $row;
		//echo $rowset[$i];
		
		$i++;
 	}
	 //echo "i: ". $i;
	
	
	
	
	for($j = 0; $j < $i; $j++){
		/*
		while (list ($key, $val) = each ($rowset[$j])) {
			echo "$key => $val<br>";
			}*/
			//ho $rowset[$j]["sch_dates"];
		$timings = split(":", $rowset[$j]["sch_dates"]);
		//echo "\r\nh: ".implode("," , $timings);
		//echo "\r\nday: ".$day;
		
		switch($rowset[$j]["sch_type"]){
			
			case 'd':
			//echo $timings[0];
			//$t_now = localtime(time(), 1);
			//echo date ("l dS of F Y h:i:s A");
			//echo date_default_timezone_get();
			//echo "\n";
			//echo date('G', time());
				if($timings[0] == date('G', time())){
					
					$credit = hourly($rowset[$j]['sch_recp_type'],$rowset[$j]['sch_msg_type'], $rowset[$j]['sch_recipient'],$rowset[$j]['sch_msg']); 
					if($credit[0] != 0){
						logger("SUCCESS: Schedule ".$rowset[$j]['sch_name']." ran successfully; ".$credit[1]);
						//echo $credit[0].":".$credit[1];
						
					}else{
						logger("Error: Schedule ".$rowset[$j]['sch_name']." failed, ".$credit[1]);
						//echo "failed";
						//echo $rowset[$j]['sch_msg'];
						undoMsgUse($msgid);
						
					}
				}
				break;
			case 'w':
				if($timings[2] == date('w', time()) and $timings[0] == date('G', time())){
					
					$credit = hourly($rowset[$j]['sch_recp_type'],$rowset[$j]['sch_msg_type'], $rowset[$j]['sch_recipient'],$rowset[$j]['sch_msg']); 
					if($credit[0] != 0){
						logger("SUCCESS: Schedule ".$rowset[$j]['sch_name']." ran successfully; ".$credit[1]);
						
					}else{
						
						logger("Error: Schedule ".$rowset[$j]['sch_name']." failed, ".$credit[1]);
						undoMsgUse($msgid);
					}
					
				}
				break;
			case 'm':
				if($timings[1] == date('j', time()) and $timings[0] == date('G', time())){
					
					$credit = hourly($rowset[$j]['sch_recp_type'],$rowset[$j]['sch_msg_type'], $rowset[$j]['sch_recipient'],$rowset[$j]['sch_msg']); 
					if($credit[0] != 0){
						logger("SUCCESS: Schedule ".$rowset[$j]['sch_name']." ran successfully; ".$credit[1]);
						
					}else{
						logger("Error: Schedule ".$rowset[$j]['sch_name']." failed, ".$credit[1]);
						undoMsgUse($msgid);
						
					}
					
				}
				break;
			case 'y':
				if($timings[3] == date('n', time()) and $timings[1] == date('j', time()) and $timings[0] == date('G', time())){
					
					
					$credit = hourly($rowset[$j]['sch_recp_type'],$rowset[$j]['sch_msg_type'], $rowset[$j]['sch_recipient'],$rowset[$j]['sch_msg']); 
					if($credit[0] != 0){
						logger("SUCCESS: Schedule ".$rowset[$j]['sch_name']." ran successfully; ".$credit[1]);
						
					}else{
						logger("Error: Schedule ".$rowset[$j]['sch_name']." failed, ".$credit[1]);
						undoMsgUse($msgid);
						
					}
					
				}
				break;
			
		}
		
	}
	
	//echo $i;
 }
 	
/*

============================================================================================
Fixed Schedulings

*/
$q=mysql_query("select * from schedules where sch_enable = 1 AND sch_rec = 'nr' AND sch_fixeddate = CURDATE();") or die(mysql_error());
 if(mysql_num_rows($q) > 0){
	 $i = 0;
	//$rowset[][]; 
	
	while($row = mysql_fetch_array($q)){
		$rowset[$i] = $row;
		//echo $rowset[$i];
		
		$i++;
 	}

	for($j = 0; $j < $i; $j++){	
		if($rowset[$j]['sch_dates'] == date('G', time())){
					
					$credit = hourly($rowset[$j]['sch_recp_type'],$rowset[$j]['sch_msg_type'], $rowset[$j]['sch_recipient'],$rowset[$j]['sch_msg']); 
					if($credit[0] != 0){
						logger("SUCCESS: Fixed Schedule ".$rowset[$j]['sch_name']." ran successfully; ".$credit[1]);
						
					}else{
						logger("Error: Fixed Schedule ".$rowset[$j]['sch_name']." failed, ". $credit[1]);
						undoMsgUse($msgid);
						
					}
				}
	}
 }
 
 
  /*

============================================================================================
Birthdays

*/

$q=mysql_query("select * from contacts where c_birthdate = CONCAT(DAY(CURDATE()),'/',MONTH(CURDATE()));") or die(mysql_error());
 if(mysql_num_rows($q) > 0){
	 $i = 0;
	//$rowset[][]; 
	$cnums;
	while($row = mysql_fetch_array($q)){
		//$rowset[$i] = $row;
		$cnums[$i] = $row['c_number'];
		$i++;
 	}

	//for($j = 0; $j < $i; $j++){	
		if(date('G', time()) == '6'){
			$m = getMsg('l',3); //ID for the list of birthdays
			if($m[0] != 0){
				$credit = sendmsg(implode(",",$cnums), $m[1]);
			
				if($credit[0] != 0){
					
							logger("SUCCESS: Birthday Schedule ran successfully; ".$credit[1]);
							
						}else{
							logger("Error: Birthday Schedule failed, ".$credit[1]);
							undoMsgUse($msgid);
							
				}
			}else{
				logger("Error: Birthday Schedule failed, ".$m[1]);
			}
		}
	//}
 }
 
 
 
 /*

============================================================================================
Other Functions

*/
function hourly($recptype, $msgtype, $recp, $msg){
	if($recptype == 's'){
		$r = getRecp('s',$recp);
		if($r[0] != 0){
			if($msgtype == 's'){
				
					$m = getMsg('s',$msg);
					if($m[0] != 0){
						return sendmsg($r[1], $m[1]);
					}else{
						return $m;
					}
			}else{
				$m = getMsg('l',$msg);
				if($m[0] != 0){
					return sendmsg($r[1], $m[1]);
					}else{
						return $m;
					}
			}
		}else{
			return $r;
		}
	}else{
		$r = getRecp('g',$recp);
		
		if($r[0] != 0){
			if($msgtype == 's'){
				$m = getMsg('s',$msg);
					//echo 1;
					if($m[0] != 0){
							return sendmsg($r[1], $m[1]);
						}else{
							return $m;
						}
			}else{
				$m = getMsg('l',$msg);
				//echo "m:".$msg;
				//echo "r:".$r;
					if($m[0] != 0){
							return sendmsg($r[1], $m[1]);
						}else{
							return $m;
						}
			}
		}else{
			return $r;
		}
	}
	
}

function getRecp($type, $id){
	if($type == 's'){
		$cq = mysql_query("select c_number from contacts where c_id = ".$id.";") or die(mysql_error());
		if(mysql_num_rows($cq) > 0){
			$cr = mysql_fetch_array($cq);
			$status[0] = 1;
			$status[1] = $cr['c_number'];
			return $status;
		}else{
			$status[0] = 0;
			$status[1] = "Contact with ID: ".$id." was not found.";
			return $status;
		}
	}else{
		$cq = mysql_query("select c_number from contacts as c, groupings as gr where c.c_id = gr.c_id and gr.g_id = ".$id.";") or die(mysql_error());
		if(mysql_num_rows($cq) > 0){
			$i = 0;
			while($row = mysql_fetch_array($cq)){
				$rowset[$i] = $row['c_number'];
				//echo $row['c_number'];
				$i++;
			}
			//$cr = mysql_fetch_array($cq);
//			if(is_array($rowset
			//	echo implode(",",$rowset);
			$status[0] = 1;
			$status[1] = implode(",",$rowset);
			return $status;
			
		}else{
			$status[0] = 0;
			$status[1] = "Group with ID: ".$id." was not found.";
			return $status;
		}
	}
	
}

function getMsg($type, $id){
	global $msgid;
	if($type == 's'){
		$mq = mysql_query("select sls_sms from sms_list_sms where sls_id = ".$id.";") or die(mysql_error());
		if(mysql_num_rows($mq) > 0){
			$mr = mysql_fetch_array($mq);
			$status[0] = 1;
			$status[1] = $mr['sls_sms'];
			return $status;
			
		}else{
			$status[0] = 0;
			$status[1] = "Message with ID: ".$id." was not found.";
			return $status;
		}
	}else{
		$mq = mysql_query("select * from sms_list_sms where sl_id = ".$id." and sls_used = 0 limit 1;") or die(mysql_error());
		//echo mysql_num_rows($mq);
		if(mysql_num_rows($mq) > 0){
			$mr = mysql_fetch_array($mq);
			mysql_query("update sms_list_sms set sls_used = 1 where sls_id = ".$mr['sls_id'].";") or die(mysql_error());
			//return $mr['sls_sms'];
			$msgid = $mr['sls_id'];
			$status[0] = 1;
			$status[1] = $mr['sls_sms'];
			//echo $status[1];
			return $status;
		}else{
			//return 0;
			$status[0] = 0;
			$status[1] = "Message for SMS List with ID: ".$id." was not found.";
			return $status;
		}
		
	}
}

function undoMsgUse($id){
	
	mysql_query("update sms_list_sms set sls_used = 0 where sls_id = ".$id.";") or die(mysql_error());
	
}

function sendmsg($recp, $msg){
	if(is_array($recp)){
		$contacts = implode(",",$recp);
	}else{
		$contacts = $recp;
	}
	/*echo "<br>---<br>Sending Message<br>Recipients: ".$contacts."<br>Message: ".$msg."<br>";
	$status[0] = 1;
			$status[1] = "1002";
			return $status;
	
	*/
	
	$data= array(
"Type"=> "sendparam", 
"Username" => "SMS-API-USER",
"Password" => "*******",
"live" => "true",
"numto" => $contacts,
"data1" => $msg,
//"default_senderid" => "2348069741803",
"senderid" => "abuango",
"return_credits" => true
) ; //This contains data that you will send to the server.
$data = http_build_query($data); //builds the post string ready for posting
$resp = do_post_request('http://www.mymobileapi.com/api5/http5.aspx', $data);
//echo  $data;
if( $resp[0] != 0){
	  //Sends the post, and returns the result from the server.
	  $res = $resp[1];
	  $r = strip_tags(substr($res, strpos($res,"<credits>"),strpos($res,"<credits>")));
	  /*$res = $resp[1];
	  $r1 = strip_tags(substr($res, strpos($res,"<msgs_success>"),strpos($res,"</msgs_success>")));
	  $res = $resp[1];
	  $r2 = strip_tags(substr($res, strpos($res,"<msgs_failed>"),strpos($res,"</msgs_failed>")));
	  */
	  		$status[0] = 1;
			$status[1] = "Credits Left: ". $r;
			return $status;
	 
}else{
			$status[0] = 0;
			$status[1] = $resp[1];
			return $status;
}


}

function logger($emsg){
	
	mysql_query("insert into log values(null, DATE_ADD(NOW(), INTERVAL 8 HOUR), '".$emsg."');") or die(mysql_error());
	//echo $emsg;
	sendmsg("08069741803",$emsg);
}

function do_post_request($url, $data, $optional_headers = null)
  {
     $params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
	// echo $url;
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        $status[0] = 0;
				$status[1] = "There was a problem Receiving data with the Gateway.";
				return $status;
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        $status[0] = 0;
				$status[1] = "There was a problem Receiving data with the Gateway.";
				return $status;
     }
	 $status[0] = 1;
	 $status[1] = $response;
     return $status;
     //formatXmlString($response);
     
  }

?>
