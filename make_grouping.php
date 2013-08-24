<?php
include('utils.php');
include('loginchk.php');
include('header.php');
	if(isset($_GET['g_id'])){
		if(isset($_GET['done']) and $_GET['done'] = 'y'){
			$n = 0;
			foreach($_POST['contacts'] as $cont){
				mysql_query("insert into groupings values(null,'".$cont."','".$_GET['g_id']."');") or die(mysql_error());
				$n++;	
			}
			
			echo("<script type=\"text/javascript\">alert('".$n." members added to group!');location.replace('make_grouping.php?g_id=".$_GET['g_id']."');</script>");
		}
		
		$g = mysql_query("select * from groups where g_id = ".$_GET['g_id'].";") or die(mysql_error());
		if(mysql_num_rows($g) > 0){
				$gr = mysql_fetch_array($g);
				$g_details = "<h1>Group: ".$gr['g_name']."</h1>".$gr['g_desc']."<br><a href='make_grouping.php?g_id=".$_GET['g_id']."'>Add More Members to Group</a>";
				
				$u = mysql_query("select c.c_id as cid, c.c_name as cname from contacts as c where c.c_id NOT IN (select gr.c_id from groupings as gr where gr.g_id = ".$_GET['g_id'].");") or die(mysql_error());
				if(mysql_num_rows($u) > 0){
					$options = "";
					while($ur = mysql_fetch_array($u)){
						$options .="
							<option value=\"".$ur['cid']."\">".$ur['cname']."</option>\r\n
						";
					}
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
       		
            
                <form method="post" id="addform" action="make_grouping.php?g_id=<?php echo $_GET['g_id']; ?>&done=y" >
                    <div style="width:40%; float:left">
                    Select Members to add to Group:
                        <select name="contacts1[]" id="main_contacts" multiple="multiple" style="width:100%" size="10" >
                            <?php echo $options; ?>
                        </select>
                    </div>
                    <div style="width:20%; padding-top:30px; text-align:center; float:left">
                    	<a id="btnadd" href="#" name="btnadd" onclick="return swapElement('main_contacts','contactstoadd');"> Add >> </a>
                        <br />
                        <br />
                        <a id="btnremove" href="#" name="btnremove" onclick="return swapElement('contactstoadd','main_contacts');"> << Remove </a>
                        
                    </div>
                    <div style="width:40%; float:left">
                    Members that will be added to Group:
                    	<select name="contacts[]" id="contactstoadd" multiple="multiple" style="width:100%" size="10" >
                           
                        </select>
                    </div>
                    <br>
                    <input type="submit" value="Add">
                </form>
        </div>
    </div>
    
    <script type="text/javascript">
		
			
			function swapElement(fromList,toList){
				var selectOptions = document.getElementById(fromList);
				for (var i = 0; i < selectOptions.length; i++) {
					var opt = selectOptions[i];
					if (opt.selected) {
						document.getElementById(fromList).removeChild(opt);
						document.getElementById(toList).appendChild(opt);
						i--;
					}
				}
			}
			
			
	</script>
<?php
include('footer.php');
?>