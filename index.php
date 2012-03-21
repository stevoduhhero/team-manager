<?php
  include 'includes.php';
  include 'header.html';

	//latest teams
	echo '<h2>Latest Teams:</h2>';
	echo '<div class="ul-teams">';
	$sql = "SELECT * FROM teams ORDER BY id DESC LIMIT 10";
	$query = mysql_query($sql) or die(mysql_error());
	while($array = mysql_fetch_array($query)) {
		$teamname = htmlspecialchars($array['teamname']);
		$made = $array['date'];
		$id = $array['id'];
		$author = $array['user_id'];
		$author = htmlspecialchars(sqlsingle("SELECT username FROM users WHERE id='$author'"));
		echo '<a href="/', $foldername, '/view?id=', $id, '" class="nunderline"><div class="li-team"><span class="right">Posted on ', $made, '<div>By: ', $author, '</div></span>"', $teamname ,'"<div>&nbsp;</div></div></a>';
	}
	echo '</div>';
  
  //online users
  $list = "";
  $sql = "SELECT * FROM users WHERE online='1' ORDER BY username";
  $query = mysql_query($sql) or die(mysql_error());
  while($array = mysql_fetch_array($query)) {
	$cusername = htmlspecialchars($array['username']);
	$cuserid = $array['id'];
	$cauthority = $array['authority'];
	$list = $list . '<a href="./teams?id=' . $cuserid . '">' . $cusername . '</a>';
  }
  echo '<div class="user-list">', $list, '</div>';
  echo '<div>&nbsp;</div>';
  
  include 'footer.html';
?>