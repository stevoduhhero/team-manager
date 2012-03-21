<?php
  session_start();
  include 'dbconnect.php';
  include 'functions.php';
  
  $foldername = "team-manager";
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
?>