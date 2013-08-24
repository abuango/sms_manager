<?php
include('utils.php');
include('loginchk.php');
include('header.php');

if(isset($_GET['a'])){
	if($_GET['a'] == "add"){
		
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['c_name']) and !empty($_POST['c_number'])){
				mysql_query("insert into contacts values(null,'".$_POST['c_name']."','".$_POST['c_number']."', '".$_POST['c_birthdate']."');") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('User Added Successful!');location.replace('contacts.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while add new User, please try Again!');location.replace('contacts.php?a=add');</script>");
			}
		}else{
		$outform = "
					<form method=\"post\" action=\"contacts.php?a=add&done=y\">
					<table width=\"100%\">
					<tr><td>Fullname</td><td><input type=\"text\" name=\"c_name\" value=\"\"></td></tr>
					<tr><td>Phone Number</td><td><input type=\"text\" name=\"c_number\" value=\"\"></td></tr>
					<tr><td>Birthdate</td><td><input type=\"text\" name=\"c_birthdate\" value=\"\"></td></tr>
					<tr><td></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">New Contacts Form</p>".$outform;
		}
	}else if(($_GET['a'] == "update")  and isset($_GET['id'])){
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
			if(!empty($_POST['c_name']) and !empty($_POST['c_number']) ){
				mysql_query("update contacts set c_number='".$_POST['c_number']."', c_name='".$_POST['c_name']."', c_birthdate='".$_POST['c_birthdate']."' where c_id =".$_GET['id'].";") or die(mysql_error());
				echo("<script type=\"text/javascript\">alert('Update was Successful!');location.replace('contacts.php?a=list');</script>");	
			}else{
				echo("<script type=\"text/javascript\">alert('An error occured while updating your data, please try Again!');location.replace('contacts.php?a=update&id=".$_GET['id']."');</script>");
			}
		}else{
			$r = mysql_query("select * from contacts where c_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"contacts.php?a=update&id=".$row['c_id']."&done=y\">
					<table width=\"100%\">
					<tr><td>Fullname</td><td><input type=\"text\" name=\"c_name\" value=\"".$row['c_name']."\"></td></tr>
					<tr><td>Phone Number</td><td><input type=\"text\" name=\"c_number\" value=\"".$row['c_number']."\"></td></tr>
					<tr><td>Birth Date</td><td><input type=\"text\" name=\"c_birthdate\" value=\"".$row['c_birthdate']."\"></td></tr>
					<tr><td><input type=\"hidden\" name=\"a\" value=\"update\"><input type=\"hidden\" name=\"id\" value\"".$row['c_id']."\"></td>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Contacts Update Form</p>".$outform;
			}else{
				$content ="Contacts data not found!";
			}
		}
	}else if(($_GET['a'] == "delete")  and isset($_GET['id'])){
		if(isset($_GET['confirm']) and $_GET['confirm'] == 'y'){
			mysql_query("delete from contacts where c_id =".$_GET['id'].";") or die(mysql_error());
			echo("<script type=\"text/javascript\">location.replace('contacts.php?a=list');</script>");	
		}else{
			$r = mysql_query("select * from contacts where c_id =".$_GET['id'].";") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$row = mysql_fetch_array($r);
				
				$outform = "
					<form method=\"post\" action=\"contacts.php?a=delete&id=".$row['c_id']."&confirm=y\">
						<input type=\"submit\"  value=\"Yes, Delete!\">
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Are you sure you want to delete Contacts data for '".$row['c_name']."'?</p>".$outform;
			}else{
				$content ="Contacts data not found!";
			}
		}
	}else if (($_GET['a'] == "upload")){
	
		
		
		if(isset($_GET['done']) and $_GET['done'] == 'y'){
		
		if(!empty($_FILES['c_file']['name'])){
			
					$image_tempname = $_FILES['c_file']['tmp_name'];
				$ext = substr($image_tempname, strrpos($image_tempname, '.'));
				//if($ext == ".csv"){;
					$ImageName = "csvfile.csv";
					
					if (move_uploaded_file($image_tempname,$ImageName)) {
					
						$fp = fopen($ImageName,'r') or die("can't open file");
						
						while($csv_line = fgetcsv($fp)) {
							
								$num = str_replace("+","",str_replace(",","",str_replace("'","",$num)));
								if(!empty($csv_line[1])){
									$num = $csv_line[1];
									$num = str_replace("+","",str_replace(",","",str_replace("'","",$num)));
									if(mysql_query("insert into contacts values(null,'".$csv_line[0]."','".$num."', '');")){}
								}
								if(!empty($csv_line[2]) ){
									$num = ",".$csv_line[2];
									$num = str_replace("+","",str_replace(",","",str_replace("'","",$num)));
									if(mysql_query("insert into contacts values(null,'".$csv_line[0]."','".$num."', '');") ){}
								}
								
								if(!empty($csv_line[3]) and !empty($num)){
									$num = ",".$csv_line[3];
									$num = str_replace("+","",str_replace(",","",str_replace("'","",$num)));
									if(mysql_query("insert into contacts values(null,'".$csv_line[0]."','".$num."', '');")){}
								}
								
							
							
						}
						
						fclose($fp) or die("can't close file");
						
						unlink($ImageName);
						
						echo("<script type=\"text/javascript\">alert('Contacts Uploaded Successful!');location.replace('contacts.php?a=list');</script>");	
					}else{
						echo("<script type=\"text/javascript\">alert('An Error occured, Could not upload file, please try Again!');location.replace('contacts.php?a=list');</script>");
					}
				/*
				}else{
					echo("<script type=\"text/javascript\">alert('You Uploaded a wrong file type ".$ext.", please try Again!');location.replace('contacts.php?a=list');</script>");
				}
				*/
					
				}else{
					echo("<script type=\"text/javascript\">alert('An error occured while Uploading Contacts, please try Again!');location.replace('contacts.php?a=list');</script>");
				}
		
		}else{
		$outform = "
					<form method=\"post\" action=\"contacts.php?a=upload&done=y\" enctype=\"multipart/form-data\">
					<table width=\"100%\">
					<tr><td>CSV File</td><td><input type=\"file\" name=\"c_file\" value=\"\"></td></tr>
					<td><input type=\"submit\"  value=\"Submit\"></td></tr>
					</table>
					</form>
				";
				
				$content ="<p style=\"font-weight:bold\">Contacts Upload Form</p>".$outform;
		}
		
	}else{
		$r = mysql_query("select * from contacts;") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><tr><th>Fullname</th><th>Phone Number</th><th>Birthdate</th><th>Actions</th></tr>";
			while($row = mysql_fetch_array($r)){
				$content .= "<tr><td>".$row['c_name']."</td><td>".$row['c_number']."</td><td>".$row['c_birthdate']."</td><td><a href='contacts.php?a=update&id=".$row['c_id']."'>[Update]</a>&nbsp;&nbsp;<a href='contacts.php?a=delete&id=".$row['c_id']."'>[Delete]</a></td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No contacts!";
		}
	}
}
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Contacts
        </div>
    	<div id="sub-nav">
        
        	<a href="contacts.php?a=list">List</a> &nbsp; &nbsp;|&nbsp;&nbsp;<a href="contacts.php?a=add">Add New</a>&nbsp; &nbsp;|&nbsp;&nbsp;<a href="contacts.php?a=upload">Upload Contacts</a>
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>