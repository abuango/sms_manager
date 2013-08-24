<?php
if(!isset($_SESSION['signedin'])){
	header("Location: login.php");	
}
?>