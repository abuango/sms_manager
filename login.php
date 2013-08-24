<?php
include('utils.php');
if(isset($_GET['out']) and $_GET['out'] == "1"){
	unset($_SESSION['signedin']);
	unset($_SESSION['user']);
	$error = "<p style=\" color:#090; font-size:16px;\">You have successfully logged out!</p>";
}
if(isset($_POST['login-sent']) and $_POST['login-sent'] == "1"){
	$r = mysql_query("select * from users where username = '".$_POST['username']."' and password = '".$_POST['password']."';") or die(mysql_error());
	if(mysql_num_rows($r) > 0){
		$row = mysql_fetch_array($r);
		$_SESSION['signedin'] = 1;
		$_SESSION['user'] = $row['fullname'];
		header("Location: index.php");
	}else{
		$error = "<p style=\" color:#f00; font-size:16px;\">Invalid Login, Please try again!</p>";
	}
}

include('header.php');
?>
    <div class="box" id="right-panel">
    	<div class="captions" id="content-title">
        	Login!
        </div>
    	<div id="sub-nav">
		<?php echo $error; ?>
        	Please enter your login credentials below...
            
        </div>
        <div style="text-align:center; margin-top:10px;">
         
            <form  method="post" action="login.php">
            	<label for="username">Username:</label>
                <input type="text" name="username" value="" placeholder="username" />
                <label for="password">Password:</label>
                <input type="password" name="password" value="" placeholder="**********" />
                <input type="hidden" name="login-sent" value="1" />
                <input type="submit" value="Log In" />
            </form>
            </div>
    </div>
<?php
include('footer.php');
?>