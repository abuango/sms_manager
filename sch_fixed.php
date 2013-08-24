<?php
include('utils.php');
include('loginchk.php');
include('header.php');
$upd = 0;
if(isset($_GET['action']) and $_GET['action'] == 'mod'){
	if(isset($_POST['sch_chng']) and $_POST['sch_chng'] == "1" ){
		if($_POST['update'] == "0"){
			
			if(!empty($_POST['sch_name']) and !empty($_POST['sch_desc'])){
							
				if($_POST['recp_type'] == "s"){
						$recp = $_POST['single'];
					}else{
						$recp = $_POST['grp'];
					}
					if($_POST['msg_type'] == "s"){
						$msg = $_POST['smssingle'];
					}else{
						$msg = $_POST['smslist'];
					}
					
				
					//$rtimings = $_POST['hr'].":".$_POST['day'].":".$_POST['wk'].":".$_POST['mnth'];
					
					mysql_query("insert into schedules(sch_id, sch_name, sch_desc, sch_fixeddate, sch_dates, sch_rec, sch_recp_type, sch_msg_type, sch_recipient, sch_msg) values(null, '".$_POST['sch_name']."', '".$_POST['sch_desc']."', '".$_POST['sch_fixeddate']."', '".$_POST['hr']."', 'nr', '".$_POST['recp_type']."', 's', '".$recp."', '".$msg."');") or die(mysql_error());
					echo("<script type=\"text/javascript\">alert('Schedule Added Successful!');</script>");
				
				
				
			}else{
				echo("<script type=\"text/javascript\">alert('Something is wrong with the form you filled, please try again!');</script>");
			}
		}else{
			
			if(!empty($_POST['sch_name']) and !empty($_POST['sch_desc'])){
							
				if($_POST['recp_type'] == "s"){
						$recp = $_POST['single'];
					}else{
						$recp = $_POST['grp'];
					}
					if($_POST['msg_type'] == "s"){
						$msg = $_POST['smssingle'];
					}else{
						$msg = $_POST['smslist'];
					}
					
					$uid = $_POST['uid'];
					//$rtimings = .":".$_POST['day'].":".$_POST['wk'].":".$_POST['mnth'];
					
					mysql_query("update schedules set sch_name = '".$_POST['sch_name']."', sch_desc = '".$_POST['sch_desc']."', sch_fixeddate = '".$_POST['sch_fixeddate']."', sch_dates = '".$_POST['hr']."', sch_recp_type = '".$_POST['recp_type']."', sch_msg_type = '".$_POST['msg_type']."', sch_recipient = '".$recp."', sch_msg = '".$msg."',  sch_enable = '".$_POST['sch_enable']."' where sch_id = '".$_POST['update']."' and sch_rec = 'nr';") or die(mysql_error());
					
					echo("<script type=\"text/javascript\">alert('Schedule Updated Successful!'); location.replace('sch_fixed.php?action=mod&uid=".$uid."');</script>");
				
				
				
			}else{
				echo("<script type=\"text/javascript\">alert('Something is wrong with the form you filled, please try again!');</script>");
			}
			
		}
	}

}

if($_GET['action'] == 'del'){
	
	mysql_query("delete from schedules where sch_id = ".$_GET['uid']." and sch_rec ='nr';") or die(mysql_error());
	echo("<script type=\"text/javascript\">alert('Schedule was deleted Successfully!'); location.replace('sch_list.php');</script>");
}

if(isset($_GET['uid'])){
	$uid = $upd = $_GET['uid'];
	$q = mysql_query("select * from schedules where sch_id = ".$_GET['uid'].";") or die(mysql_error());
	if(mysql_num_rows($q) > 0){
		
		$qr = mysql_fetch_array($q);
	
		$gl = mysql_query("select g_id, g_name from groups;") or die(mysql_error());
		if(mysql_num_rows($gl) > 0){
			$group_list = "";
			while($gr = mysql_fetch_array($gl)){
				if($qr['sch_recp_type'] == 'g' and $qr['sch_recipient'] == $gr['g_id'])
				$group_list .= "<option value=\"".$gr['g_id']."\" selected=\"selected\">".$gr['g_name']."</option>";
				else
				$group_list .= "<option value=\"".$gr['g_id']."\">".$gr['g_name']."</option>";
			}
		}
		
		$cl = mysql_query("select c_id, c_name from contacts;") or die(mysql_error());
		if(mysql_num_rows($cl) > 0){
			
			$contacts_list = "";
			while($cr = mysql_fetch_array($cl)){
				if($qr['sch_recp_type'] == 's' and $qr['sch_recipient'] == $cr['c_id'])
				$contacts_list .= "<option value=\"".$cr['c_id']."\" selected=\"selected\">".$cr['c_name']."</option>";
				else
				$contacts_list .= "<option value=\"".$cr['c_id']."\" >".$cr['c_name']."</option>";
			}
		}
		
		$sl = mysql_query("select sl_id, sl_name from sms_list;") or die(mysql_error());
		if(mysql_num_rows($sl) > 0){
			$sms_list = "";
			while($sr = mysql_fetch_array($sl)){
				if($qr['sch_msg_type'] == 'l' and $qr['sch_msg'] == $sr['sl_id'])
				$sms_list .= "<option value=\"".$sr['sl_id']."\" selected=\"selected\">".$sr['sl_name']."</option>";
				else
				$sms_list .= "<option value=\"".$sr['sl_id']."\" >".$sr['sl_name']."</option>";
			}
		}
	
	}
} else{
	
	$gl = mysql_query("select g_id, g_name from groups;") or die(mysql_error());
	if(mysql_num_rows($gl) > 0){
		$group_list = "";
		while($gr = mysql_fetch_array($gl)){
			$group_list .= "<option value=\"".$gr['g_id']."\">".$gr['g_name']."</option>";
		}
	}
	
	$cl = mysql_query("select c_id, c_name from contacts;") or die(mysql_error());
	if(mysql_num_rows($cl) > 0){
		$contacts_list = "";
		while($cr = mysql_fetch_array($cl)){
			$contacts_list .= "<option value=\"".$cr['c_id']."\">".$cr['c_name']."</option>";
		}
	}
	
	$sl = mysql_query("select sl_id, sl_name from sms_list;") or die(mysql_error());
	if(mysql_num_rows($sl) > 0){
		$sms_list = "";
		while($sr = mysql_fetch_array($sl)){
			$sms_list .= "<option value=\"".$sr['sl_id']."\">".$sr['sl_name']."</option>";
		}
	}
}


?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Fixed Schedules
        </div>
    	<div id="sub-nav">
        <?php
		if(isset($upd) and $upd == 0){
			echo "Add Fixed Schedule";
		}else{
			echo "Update Fixed Schedule";	
		}
		?>
        	
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        	<form method="post" action="sch_fixed.php?action=mod" >
            <table  width="500px">
            	<tr><td style="text-align:right">Title</td><td><input type="text" name="sch_name" value="<?php echo $qr['sch_name']; ?>"></td></tr>
                <tr><td style="text-align:right">Description</td><td><input type="text" name="sch_desc" value="<?php echo $qr['sch_desc']; ?>"></td></tr>
                         
                    <tr> <td style="text-align:right">Fixed Date</td><td><input type="text" name="sch_fixeddate" value="<?php echo $qr['sch_fixeddate']; ?>" placeholder="2012-1-1"></td></tr>
                    
                    
                    <tr ><td style="text-align:right"> Timing (Hour):</td><td>
                     
                        <input type="text" name="hr" value="<?php echo $qr['sch_dates']; ?>" placeholder="0 - 23"> 0 for Midnight</td></tr>
                    <?php
						
															
								function chkselect($val, $data){
									
									if($val == $data)
										return "selected = \"selected\"";
									
								}
								
							
						
						?>
                    
                    
                    <tr><td style="text-align:right">Recipient</td><td>
                        <select id="recp_type" name="recp_type" onchange="chg_recp();">
                            <option value="g" <?php echo chkselect("g", $qr['sch_recp_type']); ?>>Group</option>
                            <option value="s" <?php echo chkselect("s", $qr['sch_recp_type']); ?>>Single</option>
                            
                        </select> 
                        
                        <select id="grp" style="display:block" name="grp">
                            <?php echo $group_list; ?>
                        </select>
                        <select id="single" style="display:none" name="single">
                            <?php echo $contacts_list; ?>
                        </select>  
                    </td></tr>
                    
                    <tr><td style="text-align:right">Message</td><td>
                        <select id="msg_type" name="msg_type" onchange="chg_msg();">
                            <option value="l" <?php echo chkselect("l", $qr['sch_msg_type']); ?>>SMS List</option>
                            <option value="s" <?php echo chkselect("s", $qr['sch_msg_type']); ?>>Single</option>
                            
                        </select>
                       
                        <select id="smslist" style="display:block" name="smslist">
                            <?php echo $sms_list; ?>
                        </select>
                        
                        <input type="text" id="smssingle" style="display:none" value="<?php echo $qr['sch_msg']; ?>" name="smssingle">
                         
                    </td ></tr>
                     <tr><td style="text-align:right">Status</td><td>
                        <select id="sch_enable" name="sch_enable" >
                            <option value="1" <?php echo chkselect("1", $qr['sch_enable']); ?>>Enabled</option>
                            <option value="0" <?php echo chkselect("0", $qr['sch_enable']); ?>>Disabled</option>
                            
                        </select>
                    </td></tr>
                    <tr><td><input type="hidden" name="sch_chng" value="1" /><input type="hidden" name="update" value="<?php echo $upd; ?>" /><input type="hidden" name="uid" value="<?php echo $uid; ?>" /></td><td><input type="submit" value="Submit" /></td></tr>
             
            </table>
            </form>
        </div>
    </div>
    
    <script type="text/javascript">
		
		chg_recp();
		chg_msg();
		function chg_recp(){
			var dom_rec = document.getElementById('recp_type');
			if (dom_rec.value == "g"){
				document.getElementById('grp').style.display = 'block';	
				document.getElementById('single').style.display = 'none';	
			}else{
				document.getElementById('grp').style.display = 'none';	
				document.getElementById('single').style.display = 'block';	
			}
			
		}
		
		function chg_msg(){
			var dom_rec = document.getElementById('msg_type');
			if (dom_rec.value == "s"){
				document.getElementById('smssingle').style.display = 'block';	
				document.getElementById('smslist').style.display = 'none';	
			}else{
				document.getElementById('smssingle').style.display = 'none';	
				document.getElementById('smslist').style.display = 'block';	
			}
			
		}
	</script>
<?php
include('footer.php');
?>