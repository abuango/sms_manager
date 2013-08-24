<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Manager</title>

<style type="text/css">
body{
	background-color:#FF9933;
	text-align:center;	
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}

.box{
	background-color:#FFFFFF;
	border-width:2px !important;	
	
}

#container{
	position:relative;
	width:1050px;
	margin:auto;
	top:25px;
	height:auto;
	text-align:left;	
}

#left-panel{
	position:relative;
	width:200px;
	float:left;
	height:400px;
	border: 1px #666666 solid;
	margin:5px;
	padding:5px;
	font-size:14px;
}

#right-panel{
	position:relative;
	width:800px;
	float:right;
	min-height:400px;
	height:auto;
	border: 1px #666666 solid;
	margin:5px;
	padding:5px;
}

#footer{
	position:relative;
	height:20px;
	clear:both;
	width:100%;
	border: 1px #666666 solid;
	
}

#header{
	position:relative;
	height:25px;
	width:1040px;
	border: 1px #666666 solid;	
	font-size:18px;
	padding:5px;
	font-weight:bold;
}

.captions{
	position:relative;
	margin:auto;
	margin-top:5px;
	margin-bottom:5px;
	padding:5px;
	color:#fff;
	background-color:#FF9933;
	border: 1px #666666 solid;
	font-size:14px;
	font-weight:bold;

}

#content-title{
	
	width:780px;
}

#main-nav-title{
	width:180px;
}

#sub-nav{
	position:relative;
	width:780px;
	margin:auto;	
	color: #666666;
	font-size:14px;
	border-bottom: 1px #FF9933 solid;
	text-align:center;
	margin-bottom:5px;
}

#nav{
	position:relative;
	width:180px;
	font-size:14px;
	padding:5px;
	margin:auto;
	margin-top:5px;
	margin-bottom:5px;
	color:#666;
	font-weight:bold;
}
</style>



</head>

<body>

<div id="container">
	<div class="box" id="header">
    	SMS Manager
    </div>
    
	<div class="box" id="left-panel">
    	<?php
			if(isset($_SESSION['user'])){
				echo "<div class=\"captions\" id=\"main-nav-title\">Welcome!</div><div style=\"text-align:center;\"> ".$_SESSION['user']."<br><a href='login.php?out=1'>[Logout]</a></div>
		
        <div class=\"captions\" id=\"main-nav-title\">
           	Navigation
        </div>
        <div id=\"nav\">
        	<ul>
            	<li><a href=\"index.php\">Home</a></li>
                <li><a href=\"users.php?a=list\">User Management</a></li>
                <li><a href=\"contacts.php?a=list\">Contacts</a></li>
                <li><a href=\"groups.php?a=list\">Groups</a></li>
                <li><a href=\"sms_list.php?a=list\">SMS List</a></li>
                <li><a href=\"sch_list.php\">Schedules Listing</a></li>                
                <li><a href=\"log.php\">System Log</a></li>
                
            </ul>
        </div>
		";
			}
		?>
    </div>
    