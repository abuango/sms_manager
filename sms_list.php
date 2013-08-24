<?php
include('utils.php');
include('loginchk.php');
include('header.php');

if(isset($_GET['a'])){
	if($_GET['a'] == "add"){
		
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['sl_name']) and !empty($_POST['sl_desc'])){
				mysql_query("insert into sms_list values(null,'".$_POST['sl_name']."','".$_POST['sl_desc']."');") or die(mysql_error());
				mysql_query("insert into sms_list_sms values(null,'".mysql_insert_id()."','FirstTestMessage',0,0);") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('SMS List Added Successful!');location.replace('sms_list.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while add new SMS List, please try Again!');location.replace('sms_list.php?a=add');</script>");
			}
		}else{
		$outform = "
					<form method=\"post\" action=\"sms_list.php?a=add&done=y\">
					<table width=\"100%\">
					<tr><td>SMS List name</td><td><input type=\"text\" name=\"sl_name\" value=\"\"></td></tr>
					<tr><td>SMS List Desc</td><td><input type=\"text\" name=\"sl_desc\" value=\"\"></td></tr>
					<tr><td></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">New sms_list Form</p>".$outform;
		}
	}else if(($_GET['a'] == "update")  and isset($_GET['id'])){
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['sl_name']) and !empty($_POST['sl_desc'])){
				mysql_query("update sms_list set sl_desc='".$_POST['sl_desc']."', sl_name='".$_POST['sl_name']."' where sl_id =".$_GET['id'].";") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('Update was Successful!');location.replace('sms_list.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while updating your data, please try Again!');location.replace('sms_list.php?a=update&id=".$_GET['id']."');</script>");
			}
		}else{
			$r = mysql_query("select * from sms_list where sl_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"sms_list.php?a=update&id=".$row['sl_id']."&done=y\">
					<table width=\"100%\">
					<tr><td>SMS List name</td><td><input type=\"text\" name=\"sl_name\" value=\"".$row['sl_name']."\"></td></tr>
					<tr><td>SMS List desc</td><td><input type=\"text\" name=\"sl_desc\" value=\"".$row['sl_desc']."\"></td></tr>
					<tr><td><input type=\"hidden\" name=\"a\" value=\"update\"><input type=\"hidden\" name=\"id\" value\"".$row['sl_id']."\"></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">sms_list Update Form</p>".$outform;
			}else{
				$content ="sms_list data not found!";
			}
		}
	}else if(($_GET['a'] == "delete")  and isset($_GET['id'])){
		if(isset($_GET['confirm']) and $_GET['confirm'] == 'y'){
			mysql_query("delete from sms_list where sl_id =".$_GET['id'].";") or die(mysql_error());
			echo("<script type=\"text/javascript\">location.replace('sms_list.php?a=list');</script>");	
		}else{
			$r = mysql_query("select * from sms_list where sl_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"sms_list.php?a=delete&id=".$row['sl_id']."&confirm=y\">
						<input type=\"submit\"  value=\"Yes, Delete!\">
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Are you sure you want to delete SMS List data for '".$row['sl_name']."'?</p>".$outform;
			}else{
				$content ="sms_list data not found!";
			}
		}
	}else{
		$r = mysql_query("select * from sms_list;") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><tr><th>SMS List name</th><th>SMS List desc</th><th>Actions</th></tr>";
			while($row = mysql_fetch_array($r)){
				$content .= "<tr><td><a href='sms.php?sl_id=".$row['sl_id']."&a=list'>".$row['sl_name']."</a></td><td>".$row['sl_desc']."</td><td><a href='sms_list.php?a=update&id=".$row['sl_id']."'>[Update]</a>&nbsp;&nbsp;<a href='sms_list.php?a=delete&id=".$row['sl_id']."'>[Delete]</a></td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No sms_list!";
		}
	}
}
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	SMS List
        </div>
    	<div id="sub-nav">
        
        	<a href="sms_list.php?a=list">List</a> &nbsp; &nbsp;|&nbsp;&nbsp;<a href="sms_list.php?a=add">Add New</a>
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>