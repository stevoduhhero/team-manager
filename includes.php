<?php
  session_start();
  include 'dbconnect.php';
  include 'functions.php';
  
  $foldername = "team-manager";
  $timeout = 10;
  
  $ip = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set('America/Los_Angeles');
  $time = time();
  $date = date('F j, Y h:i A');
  if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
  }
  else {
	$username = "Anonymous";
  }
  $username_clean = clean($username);
  $user_id = sqlsingle("SELECT id FROM users WHERE username='$username_clean'");
  
  //kick inactive
  $cutoff = $time-(60*$timeout);
  $sql = "UPDATE users SET online='0' WHERE last_activity<'$cutoff'";
  mysql_query($sql) or die(mysql_error());
  //update activity
  $sql = "UPDATE users SET online='1', last_activity='$time' WHERE id='$user_id'";
  mysql_query($sql) or die(mysql_error());
?>