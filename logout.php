<?php
  session_start();
  session_destroy();
  include 'includes.php';
  
  $sql = "UPDATE users SET online='0' WHERE username='$username_clean'";
  mysql_query($sql) or die(mysql_error());
  
  include 'header.html';
  echo '<div class="box"><div>You have been logged out successfully.</div></div>';
  include 'footer.html';
?>