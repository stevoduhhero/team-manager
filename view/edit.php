<?php
  include '../includes.php';
  include '../header.html';
  
  $id = clean($_GET['id']);
  $description = htmlspecialchars(sqlsingle("SELECT description FROM teams WHERE id='$id'"));
  $team = htmlspecialchars(sqlsingle("SELECT text FROM teams WHERE id='$id'"));
  $author = sqlsingle("SELECT user_id FROM teams WHERE id='$id'");
  $auth = sqlsingle("SELECT authority FROM users WHERE id='$user_id'");
  if ($user_id == $author || $auth == "admin") {
	if (isset($_POST['id'])) {
		$id = clean($_POST['id']);
		$team = clean($_POST['team']);
		$description = clean($_POST['description']);
		$sql = "UPDATE teams SET description='$description', text='$team' WHERE id='$id'";
		mysql_query($sql) or die(mysql_error());
		echo '<div class="box"><div>Successfully edited your team.</div><div><a href="./?id=', $id, '">Click here to view the edited team.</a></div></div>';
	}
	else {
		include 'edit.html';
	}
  }
  else {
	echo '<div class="box">You do not have access to this team!</div>';
  }
  
  include '../footer.html';
?>