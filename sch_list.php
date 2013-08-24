<?php
include('utils.php');
include('loginchk.php');
include('header.php');

if(isset($_GET['action']) and $_GET['action'] = 'ed'){
	
	mysql_query("update schedules set sch_enable = ".$_GET['actid']." where sch_id = ".$_GET['uid'].";") or die(mysql_error());
	
}

		$r = mysql_query("select * from schedules where sch_rec = 'r';") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><tr><th>Title</th><th>Description</th><th>Type</th><th>Start Date</th><th>Timings</th><th>Enabled</th><th>Action</th></tr>";
			while($row = mysql_fetch_array($r)){
					if($row['sch_enable'] == 1){
						$act = "Disable";
						$act_id = 0;
					}else{
						$act = "Enable";
						$act_id = 1;
					}
				$content .= "<tr><td>".$row['sch_name']."</td><td>".$row['sch_desc']."</td><td>".$row['sch_type']."</td><td>".$row['sch_startdate']."</td><td>".$row['sch_dates']."</td><td>".$row['sch_enable']."</td><td><a href='schedules.php?action=mod&uid=".$row['sch_id']."'>[Update]</a>&nbsp;&nbsp;<a href='schedules.php?action=del&uid=".$row['sch_id']."'>[Delete]</a>&nbsp;&nbsp;<a href='sch_list.php?action=ed&uid=".$row['sch_id']."&actid=".$act_id."'>[".$act."]</a></td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No Recurrent Schedules!";
		}
		
		$r = mysql_query("select * from schedules where sch_rec = 'nr';") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$fcontent = "<table width=\"100%\" border=\"0\"><tr><th>Title</th><th>Description</th><th>Fixed Date</th><th>Timing</th><th>Enabled</th><th>Action</th></tr>";
			while($row = mysql_fetch_array($r)){
				if($row['sch_enable'] == 1){
						$act = "Disable";
						$act_id = 0;
					}else{
						$act = "Enable";
						$act_id = 1;
					}
				$fcontent .= "<tr><td>".$row['sch_name']."</td><td>".$row['sch_desc']."</td><td>".$row['sch_fixeddate']."</td><td>".$row['sch_dates']."</td><td>".$row['sch_enable']."</td><td><a href='sch_fixed.php?action=mod&uid=".$row['sch_id']."'>[Update]</a>&nbsp;&nbsp;<a href='sch_fixed.php?action=del&uid=".$row['sch_id']."'>[Delete]</a>&nbsp;&nbsp;<a href='sch_list.php?action=ed&uid=".$row['sch_id']."&actid=".$act_id."'>[".$act."]</a></td></tr>";
				
			}
			$fcontent .="</table>";
		} else{
			$fcontent = "No Fixed Schedules!";
		}

?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Schedules Listings
        </div>
    	<div id="sub-nav">
        	Recurrent Schedules     
            <br>
            <a href="schedules.php?action=mod">[ Create Recurrent Schdule ] </a>  
            <br>
            (Type Guide: d = Daily; w = Weekly; m = Monthly; y = Yearly)   	
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        	<?php echo $content; ?>
        </div>
        <hr>
        <div id="sub-nav">
        	Fixed Schedules     
            <br>
            <a href="sch_fixed.php?action=mod">[ Create Fixed Schdule ] </a>  	
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        	<?php echo $fcontent; ?>
        </div>
    </div>
<?php
include('footer.php');
?>