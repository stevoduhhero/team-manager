<?php
  include '../includes.php';
  $id = $_GET['id'];
  if (!$id) {
	die("No id.");
  }
  echo '<h3>Comments</h3>';
  $sql = "SELECT * FROM comments WHERE type='team' AND thing_id='$id' ORDER BY id DESC";
  $query = mysql_query($sql) or die(mysql_error());
  while($array = mysql_fetch_array($query)) {
	$comment = htmlspecialchars($array['comment']);
	$author = $array['author'];
	$author = htmlspecialchars(sqlsingle("SELECT username FROM users WHERE id='$author'"));
	$when = $array['date'];
	echo '<div class="comment"><div class="comment-head">By: ', $author, '<span class="right">On ', $when, '</span></div><p>', $comment, '</p></div>';
  }
?>