<?php
include('utils.php');
include('loginchk.php');
include('header.php');
	if(($_GET['a'] == "delete")){
			
				mysql_query("delete from groupings where gr_id =".$_GET['id'].";") or die(mysql_error());
				echo("<script type=\"text/javascript\">location.replace('groups.php?a=list');</script>");	
			
		}
		
		
		
	if(isset($_GET['g_id'])){
		$g = mysql_query("select * from groups where g_id = ".$_GET['g_id'].";") or die(mysql_error());
		if(mysql_num_rows($g) > 0){
				$gr = mysql_fetch_array($g);
				$g_details = "<h1>Group: ".$gr['g_name']."</h1>".$gr['g_desc']."<br><a href='make_grouping.php?g_id=".$_GET['g_id']."'>Add More Members to Group</a>";
			$r = mysql_query("select c.c_name as c_name, c.c_number as c_num, gr.gr_id as gr_id from contacts as c, groupings as gr where gr.g_id = ".$_GET['g_id']." and gr.c_id = c.c_id order by c_name;") or die(mysql_error());
			if(mysql_num_rows($r) > 0){
				$content = "Total of ".mysql_num_rows($r)." members <br><table width=\"100%\" border=\"0\"><tr><th>Contacts Name</th><th>Phone Numbers</th><th>Actions</th></tr>";
				while($row = mysql_fetch_array($r)){
					$content .= "<tr><td>".$row['c_name']."</td><td>".$row['c_num']."</td><td><a href='groupings.php?a=delete&id=".$row['gr_id']."'>[Remove from Group]</a></td></tr>";
					
				}
				$content .="</table>";
			} else{
				$content = "No Contacts under group!";
			}
		}else{
			$content = "Group not found!";
		}
	}else{
		$content = "No Group Selected!";
	}
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Groupings
        </div>
    	<div id="sub-nav">
        	<?php echo $g_details; ?>
        	
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>