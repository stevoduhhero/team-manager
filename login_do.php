<?php
  include 'includes.php';
  
  $username = $_POST['username'];
  $username_clean = clean($username);
  $password = md5(clean($_POST['password']));
  
  
  //check if user exists
  $count = sqlcount("SELECT * FROM users WHERE username='$username_clean'");
  if ($count > 0) {
	//check if passwords match
	$dbpassword = sqlsingle("SELECT password FROM users WHERE username='$username_clean'");
	if ($dbpassword == $password) {
		//passwords matched
		//log them in
		$dbusername = sqlsingle("SELECT username FROM users WHERE username='$username_clean'");
		$user_id = sqlsingle("SELECT id FROM users WHERE username='$username_clean'");
		$sql = "UPDATE users SET online='1' WHERE username='$username_clean'";
		mysql_query($sql) or die(mysql_error());
		$_SESSION['username'] = $dbusername;
		$add = "<div>Logged in successfully.</div><div><a href=\"./teams?id=$user_id\">Click here to visit your team manager.</a></div>";
	}
	else {
		//passwords did not match
		$add = "<div>Incorrect password.</div>";
	}
  }
  else {
	//user does not exist
	$add = "<div>This user doesn't exist.</div>";
  }
  
  include 'header.html';
  
  echo '<div class="box">', $add ,'</div>';
  
  include 'footer.html';
?>