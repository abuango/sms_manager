<?php
include('utils.php');
include('loginchk.php');
include('header.php');

if(isset($_GET['a'])){
	if($_GET['a'] == "add"){
		
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['fullname']) and !empty($_POST['username']) and !empty($_POST['password'])){
				mysql_query("insert into users values(null,'".$_POST['fullname']."','".$_POST['username']."', '".$_POST['password']."');") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('User Added Successful!');location.replace('users.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while add new User, please try Again!');location.replace('users.php?a=add');</script>");
			}
		}else{
		$outform = "
					<form method=\"post\" action=\"users.php?a=add&done=y\">
					<table width=\"100%\">
					<tr><td>Fullname</td><td><input type=\"text\" name=\"fullname\" value=\"\"></td></tr>
					<tr><td>Username</td><td><input type=\"text\" name=\"username\" value=\"\"></td></tr>
					<tr><td>Password</td><td><input type=\"password\" name=\"password\" value=\"\"></td></tr>
					<tr><td></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">New User Form</p>".$outform;
		}
	}else if(($_GET['a'] == "update")  and isset($_GET['id'])){
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['fullname']) and !empty($_POST['username']) and !empty($_POST['password'])){
				mysql_query("update users set username='".$_POST['username']."', fullname='".$_POST['fullname']."', password='".$_POST['password']."' where u_id =".$_GET['id'].";") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('Update was Successful!');location.replace('users.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while updating your data, please try Again!');location.replace('users.php?a=update&id=".$_GET['id']."');</script>");
			}
		}else{
			$r = mysql_query("select * from users where u_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"users.php?a=update&id=".$row['u_id']."&done=y\">
					<table width=\"100%\">
					<tr><td>Fullname</td><td><input type=\"text\" name=\"fullname\" value=\"".$row['fullname']."\"></td></tr>
					<tr><td>Username</td><td><input type=\"text\" name=\"username\" value=\"".$row['username']."\"></td></tr>
					<tr><td>Password</td><td><input type=\"password\" name=\"password\" value=\"".$row['password']."\"></td></tr>
					<tr><td><input type=\"hidden\" name=\"a\" value=\"update\"><input type=\"hidden\" name=\"id\" value\"".$row['u_id']."\"></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">User Update Form</p>".$outform;
			}else{
				$content ="User data not found!";
			}
		}
	}else if(($_GET['a'] == "delete")  and isset($_GET['id'])){
		if(isset($_GET['confirm']) and $_GET['confirm'] == 'y'){
			mysql_query("delete from users where u_id =".$_GET['id'].";") or die(mysql_error());
			echo("<script type=\"text/javascript\">location.replace('users.php?a=list');</script>");	
		}else{
			$r = mysql_query("select * from users where u_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"users.php?a=delete&id=".$row['u_id']."&confirm=y\">
						<input type=\"submit\"  value=\"Yes, Delete!\">
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Are you sure you want to delete user data for '".$row['fullname']."'?</p>".$outform;
			}else{
				$content ="User data not found!";
			}
		}
	}else{
		$r = mysql_query("select * from users;") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><tr><th>Username</th><th>Fullname</th><th>Actions</th></tr>";
			while($row = mysql_fetch_array($r)){
				$content .= "<tr><td>".$row['username']."</td><td>".$row['fullname']."</td><td><a href='users.php?a=update&id=".$row['u_id']."'>[Update]</a>&nbsp;&nbsp;<a href='users.php?a=delete&id=".$row['u_id']."'>[Delete]</a></td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No Users!";
		}
	}
}
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Users
        </div>
    	<div id="sub-nav">
        
        	<a href="users.php?a=list">List</a> &nbsp; &nbsp;|&nbsp;&nbsp;<a href="users.php?a=add">Add New</a>
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>