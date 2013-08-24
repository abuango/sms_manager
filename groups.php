<?php
include('utils.php');
include('loginchk.php');
include('header.php');

if(isset($_GET['a'])){
	if($_GET['a'] == "add"){
		
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['g_name']) and !empty($_POST['g_desc'])){
				mysql_query("insert into groups values(null,'".$_POST['g_name']."','".$_POST['g_desc']."');") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('Group Added Successful!');location.replace('groups.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while add new User, please try Again!');location.replace('groups.php?a=add');</script>");
			}
		}else{
		$outform = "
					<form method=\"post\" action=\"groups.php?a=add&done=y\">
					<table width=\"100%\">
					<tr><td>Group name</td><td><input type=\"text\" name=\"g_name\" value=\"\"></td></tr>
					<tr><td>Group Desc</td><td><input type=\"text\" name=\"g_desc\" value=\"\"></td></tr>
					<tr><td></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">New groups Form</p>".$outform;
		}
	}else if(($_GET['a'] == "update")  and isset($_GET['id'])){
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['g_name']) and !empty($_POST['g_desc'])){
				mysql_query("update groups set g_desc='".$_POST['g_desc']."', g_name='".$_POST['g_name']."' where g_id =".$_GET['id'].";") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('Update was Successful!');location.replace('groups.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while updating your data, please try Again!');location.replace('groups.php?a=update&id=".$_GET['id']."');</script>");
			}
		}else{
			$r = mysql_query("select * from groups where g_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"groups.php?a=update&id=".$row['g_id']."&done=y\">
					<table width=\"100%\">
					<tr><td>Group name</td><td><input type=\"text\" name=\"g_name\" value=\"".$row['g_name']."\"></td></tr>
					<tr><td>Group Desc</td><td><input type=\"text\" name=\"g_desc\" value=\"".$row['g_desc']."\"></td></tr>
					<tr><td><input type=\"hidden\" name=\"a\" value=\"update\"><input type=\"hidden\" name=\"id\" value\"".$row['g_id']."\"></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">groups Update Form</p>".$outform;
			}else{
				$content ="groups data not found!";
			}
		}
	}else if(($_GET['a'] == "delete")  and isset($_GET['id'])){
		if(isset($_GET['confirm']) and $_GET['confirm'] == 'y'){
			mysql_query("delete from groups where g_id =".$_GET['id'].";") or die(mysql_error());
			echo("<script type=\"text/javascript\">location.replace('groups.php?a=list');</script>");	
		}else{
			$r = mysql_query("select * from groups where g_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"groups.php?a=delete&id=".$row['g_id']."&confirm=y\">
						<input type=\"submit\"  value=\"Yes, Delete!\">
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Are you sure you want to delete groups data for '".$row['g_name']."'?</p>".$outform;
			}else{
				$content ="groups data not found!";
			}
		}
	}else{
		$r = mysql_query("select * from groups;") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><tr><th>Group name</th><th>Group Desc</th><th>Actions</th></tr>";
			while($row = mysql_fetch_array($r)){
				$content .= "<tr><td><a href=\"groupings.php?g_id=".$row['g_id']."\">".$row['g_name']."</a></td><td>".$row['g_desc']."</td><td><a href='groups.php?a=update&id=".$row['g_id']."'>[Update]</a>&nbsp;&nbsp;<a href='groups.php?a=delete&id=".$row['g_id']."'>[Delete]</a></td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No groups!";
		}
	}
}
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	groups
        </div>
    	<div id="sub-nav">
        
        	<a href="groups.php?a=list">List</a> &nbsp; &nbsp;|&nbsp;&nbsp;<a href="groups.php?a=add">Add New</a>
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>