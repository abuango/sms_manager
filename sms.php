<?php
include('utils.php');
include('loginchk.php');
include('header.php');
if(isset($_GET['sl_id'])){
	$sl_id = $_GET['sl_id'];
	$s = mysql_query("select * from sms_list where sl_id = ".$_GET['sl_id'].";") or die(mysql_error());
		if(mysql_num_rows($s) > 0){
				$sr = mysql_fetch_array($s);
					$slname = $sr['sl_name'];
		if(isset($_GET['a'])){
			if($_GET['a'] == "add"){
				
				if(isset($_GET['done']) and $_GET['done'] == 'y'){
					if(!empty($_POST['sls_sms']) and !empty($sl_id)){
						$q = mysql_query("select max(sls_order) as n_max from sms_list_sms where sl_id = ".$sl_id.";") or die(mysql_error());
						$r = mysql_fetch_row($q);
						if(mysql_num_rows($q) == 0 or empty($row['n_max'])){
							$nxt_o = 1;
						}else{
							$nxt_o = $row['n_max'] + 1;
						}
						mysql_query("insert into sms_list_sms values(null,'".$sl_id."','".$_POST['sls_sms']."',".$nxt_o.", 0);") or die(mysql_error());
						echo("<script type=\"text/javascript\">alert('Message Added Successful!');location.replace('sms.php?sl_id=".$sl_id."&a=list');</script>");	
					}else{
						echo("<script type=\"text/javascript\">alert('An error occured while add new Message, please try Again!');location.replace('sms.php?sl_id=".$sl_id."&a=add');</script>");
					}
				}else{
				$outform = "
							<form method=\"post\" action=\"sms.php?sl_id=".$sl_id."&a=add&done=y\">
							<table width=\"100%\">
								<tr><td>SMS List</td><td>".$slname."</td></tr>
								<tr><td>Message</td><td><textarea cols=\"25\" rows=\"5\" name=\"sls_sms\" onKeyDown=\"limitText(this.form.sls_sms,this.form.countdown,155);\" 
onKeyUp=\"limitText(this.form.sls_sms,this.form.countdown,155);\"></textarea>
								
																<br>
<font size=\"1\">(Maximum characters: 155)<br>
You have <input readonly type=\"text\" name=\"countdown\" size=\"3\" value=\"155\"> characters left.</font>
								</td></tr>
							<tr><td></td>
							<td><input type=\"submit\"  value=\"Submit\"></td></tr>
							</table>
							</form>
						";
						
						$content ="<p style=\"font-weight:bold\">New Message Form</p>".$outform;
				}
			}else if(($_GET['a'] == "update")  and isset($_GET['id'])){
				if(isset($_GET['done']) and $_GET['done'] == 'y'){
					if(!empty($_POST['sls_sms'])){
						mysql_query("update sms_list_sms set sls_sms='".$_POST['sls_sms']."' where sls_id = ".$_GET['id'].";") or die(mysql_error());
						echo("<script type=\"text/javascript\">alert('Update was Successful!');location.replace('sms.php?sl_id=".$sl_id."&a=list');</script>");	
					}else{
						echo("<script type=\"text/javascript\">alert('An error occured while updating your data, please try Again!');location.replace('sms.php?sl_id=".$sl_id."&a=update&id=".$_GET['id']."');</script>");
					}
				}else{
					$r = mysql_query("select * from sms_list_sms where sls_id =".$_GET['id'].";") or die(mysql_error());
					if(mysql_num_rows($r) > 0){
						$row = mysql_fetch_array($r);
						
						$outform = "
							<form method=\"post\" action=\"sms.php?sl_id=".$sl_id."&a=update&id=".$row['sls_id']."&done=y\">
							<table width=\"100%\">
							<tr><td>SMS List</td><td>".$slname."</td></tr>
								<tr><td>Message</td><td><textarea name=\"sls_sms\" onKeyDown=\"limitText(this.form.sls_sms,this.form.countdown,155);\" 
onKeyUp=\"limitText(this.form.sls_sms,this.form.countdown,155);\">".$row['sls_sms']."</textarea>
								<br>
<font size=\"1\">(Maximum characters: 155)<br>
You have <input readonly type=\"text\" name=\"countdown\" size=\"3\" value=\"155\"> characters left.</font>
								</td></tr>
							<tr><td><input type=\"hidden\" name=\"a\" value=\"update\"><input type=\"hidden\" name=\"id\" value\"".$row['sls_id']."\"></td>
							<td><input type=\"submit\"  value=\"Submit\"></td></tr>
							</table>
							</form>
						";
						
						$content ="<p style=\"font-weight:bold\">sms_list_sms Update Form</p>".$outform;
					}else{
						$content ="sms_list_sms data not found!";
					}
				}
			}else if(($_GET['a'] == "delete")  and isset($_GET['id'])){
				if(isset($_GET['confirm']) and $_GET['confirm'] == 'y'){
					mysql_query("delete from sms_list_sms where sls_id =".$_GET['id'].";") or die(mysql_error());
					echo("<script type=\"text/javascript\">location.replace('sms.php?sl_id=".$sl_id."&a=list');</script>");	
				}else{
					$r = mysql_query("select * from sms_list_sms where sls_id =".$_GET['id'].";") or die(mysql_error());
					if(mysql_num_rows($r) > 0){
						$row = mysql_fetch_array($r);
						
						$outform = "
							<form method=\"post\" action=\"sms.php?sl_id=".$sl_id."&a=delete&id=".$row['sls_id']."&confirm=y\">
								<input type=\"submit\"  value=\"Yes, Delete!\">
							</form>
						";
						
						$content ="<p style=\"font-weight:bold\">Are you sure you want to delete SMS ?</p>".$outform;
					}else{
						$content ="sms_list_sms data not found!";
					}
				}
			}else{
				$r = mysql_query("select * from sms_list_sms where sl_id=".$sl_id.";") or die(mysql_error());
				if(mysql_num_rows($r) > 0){
					$content = "<table width=\"100%\" border=\"0\"><tr><th>SMS List ID</th><th>SMS ID</th><th>SMS Message</th><th>Used</th><th>Actions</th></tr>";
					while($row = mysql_fetch_array($r)){
						$content .= "<tr><td>".$row['sl_id']."</td><td>".$row['sls_id']."</td><td>".$row['sls_sms']."</td><td>".$row['sls_used']."</td><td><a href='sms.php?sl_id=".$sl_id."&a=update&id=".$row['sls_id']."'>[Update]</a>&nbsp;&nbsp;<a href='sms.php?sl_id=".$sl_id."&a=delete&id=".$row['sls_id']."'>[Delete]</a></td></tr>";
						
					}
					$content .="</table>";
				} else{
					$content = "No sms_list_sms!";
				}
			}
		}
	}else{
			$content = "sms_list not found!";
	}
}else{
	$content = "No sms_list selected!";
}
?>

    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Messages under <?php echo $slname; ?> List
        </div>
    	<div id="sub-nav">
        
        	<a href="sms.php?sl_id=<?php echo $sl_id; ?>&a=list">List</a> &nbsp; &nbsp;|&nbsp;&nbsp;<a href="sms.php?sl_id=<?php echo $sl_id; ?>&a=add">Add New</a>
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
    
    <script language="javascript" type="text/javascript">
		function limitText(limitField, limitCount, limitNum) {
			if (limitField.value.length > limitNum) {
				limitField.value = limitField.value.substring(0, limitNum);
			} else {
				limitCount.value = limitNum - limitField.value.length;
			}
		}
	</script>
<?php
include('footer.php');
?>