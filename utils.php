<?php
session_start();
$con = mysql_connect("localhost","ango1200_sms","abuango247") or die(mysql_error());
mysql_select_db("ango1200_sms", $con) or die(mysql_error());
ini_set('date.timezone', 'Africa/Lagos');
?>