<?php
	include 'includes.php';
	include 'header.html';
	
	if (!isset($_POST['username']) && !isset($_POST['password'])) {
		//both form input is missing
		include 'register.html';	
	}
	else {
		if (!isset($_POST['username']) || !isset($_POST['password'])) {
			//one form input is missing
			echo '<h2><center>You did not enter every field.</center></h2>';
			include 'register.html';
		}
		else {
			$username = $_POST['username'];
			$username_clean = clean($username);
			$password = md5(clean($_POST['password']));
			//check if user already exists
			$count = sqlcount("SELECT * FROM users WHERE username='$username_clean'");
			if ($count > 0) {
				//user already exists
				echo '<h2><center>This user already exists.</center></h2>';
				include 'register.html';
			}
			else {
				//register
				$sql = "INSERT INTO users (id, username, password, ip, joindate, online, authority, last_activity) VALUES ('', '$username_clean', '$password', '$ip', '$date', '1', 'user', '$time')";
				mysql_query($sql) or die(mysql_error());
				$_SESSION['username'] = $username;
				$user_id = sqlsingle("SELECT MAX(id) FROM users");
				echo "<div class=\"box\"><div>Registered successfully.</div><div><a href=\"./teams?id=$user_id\">Click here to visit your team manager.</a></div></div>";
			}
		}
	}
	
	include 'footer.html';
?>