<?php
session_start();
$con = mysql_connect("localhost","db_user_sms","***") or die(mysql_error());
mysql_select_db("db_sms", $con) or die(mysql_error());
ini_set('date.timezone', 'Africa/Lagos');
?>
