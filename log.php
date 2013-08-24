<?php
include('utils.php');
include('loginchk.php');
include('header.php');

		$r = mysql_query("select * from log;") or die(mysql_error());
		if(mysql_num_rows($r) > 0){
			$content = "<table width=\"100%\" border=\"0\"><thead><th width=\"30%\">Date/Time</th><th>Description</th></thead>";
			while($row = mysql_fetch_array($r)){
				$content .= "<tr><td>".$row['log_date_time']."</td><td>".$row['log_desc']."</td></tr>";
				
			}
			$content .="</table>";
		} else{
			$content = "No Log Entry!";
		}

?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	System Log
        </div>
    	<div id="sub-nav">
        
        	
        </div>
        <div style="margin:auto; width:780px; height:auto;">
        <?php echo $content; ?>
        </div>
    </div>
<?php
include('footer.php');
?>