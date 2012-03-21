<?php
  include '../includes.php';  

  $comment = clean($_POST['text']);
  $thing_id = clean($_POST['thing_id']);
  if (!$comment) {
	echo "You did not enter a comment.";
  }
  else {
	$sql = "INSERT INTO comments (id, thing_id, type, date, author, comment) VALUES ('', '$thing_id', 'team', '$date', '$user_id', '$comment')";
	mysql_query($sql) or die(mysql_error());
	echo "Message submitted successfully.";
  }
?>