<?php
session_start();
if(isset($_SESSION['loggedin'])){
	echo "<script>window.open('index.php','_self')</script>";
}
	
	require("connect_db.php");
	
	if(isset($_POST['login'])){

		$user_name = SQLite3::escapeString($_POST["user_name"]);
		$user_pass = SQLite3::escapeString($_POST["pass"]);
		
		$numRows = $db->exec("SELECT count(*) FROM users where username='$user_name' AND password='$user_pass'");
		
		if($numRows>0){
		
		$new_query="select * from users where username='$user_name' AND password='$user_pass'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				$_SESSION['userid']= $rows['id'];
				$_SESSION['loggedin'] = "true";
				$_SESSION['username'] = $rows['username'];
				$_SESSION['name'] = $rows['name'];
				echo "<script>alert('Logged In Successfully!');</script>";
				echo "<script>window.open('index.php','_self')</script>";
			}
			else {
				echo "<script>window.onload = function(){document.getElementById('notholder').style.display = 'inline';}</script>";
			}
			
		} 
	}
?>






<html>
<head>
<link href='css/login.css' rel='stylesheet'/>
<script src="alert.js"></script>
<link rel="stylesheet" href="fa/css/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
<link href='../img/logo%20big.png' rel='icon'/>
<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
<script src='orthi-lightbox/orthi-lightbox.js'></script>
<title>Login - Dashboard</title>
<link rel="icon" type="image/x-icon" href="../img/logoS.png">
<noscript><title>Enable Javascript or This page may act wrong</title></noscript>
</head>
<body>
	<div style="height: 50px;"></div>
	<center>
		<?php $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value']; ?>
	<img class="logo" src="img/<?php echo $logo; ?>" width="150px"/>
	</br>
	
	<h2>Login to Dashboard</h2>
	
	<div style="display: none;" id="notholder">
	<div class="alert" style="width: 600px;">
		<span class="closebtn">&times;</span>  
		<strong>Caution!</strong>Username or Password is Incorrect
	</div>
	</div>


	
	
	
	<script>
	var close = document.getElementsByClassName("closebtn");
	var i;

	for (i = 0; i < close.length; i++) {
		close[i].onclick = function(){
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
		}
	}
	</script>
	
	
	
	</br>
		<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<i class="fa fa-user" aria-hidden="true"></i> <input type="text" placeholder="Username" required name="user_name">
			</br>
			<i class="fa fa-key" aria-hidden="true"></i> <input type="password" placeholder="Password" required name="pass">
			</br>
			<input type="submit" value="Login" name="login">
			</br>
			</br>
			<a href="#" onclick="orthi('pwordrecover.php?data=writeUsername'); return false;">Forgot Password?</a>
			</br>
			<small style="    color: #a2a2a2">Open Below URL in Browser to Access the Application from Your Browser:</small>
			</br>
			<input id="add" onclick="this.select();" class="credit" value="<?php echo htmlspecialchars((isset($_SERVER['HTTPS']) ? "http" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");?>"/>
			</br>
		</form>
		<small class="credit">
			Developed by Tawsif Torabi
		</small>
	</center>	
</body>
</html>