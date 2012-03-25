<?php
  include '../includes.php';
  include '../header.html';
  
  function dust($text) {
	$find = array(" ", "<div>", "(M)", "(F)");
	$replace = array("", "", "", "");
	return htmlspecialchars(strtolower(str_replace($find, $replace, $text)));
  }
  
  $id = clean($_GET['id']);
  $teamname = sqlsingle("SELECT teamname FROM teams WHERE id='$id'");
  $description = sqlsingle("SELECT description FROM teams WHERE id='$id'");
  $author1 = sqlsingle("SELECT user_id FROM teams WHERE id='$id'");
  $author = sqlsingle("SELECT username FROM users WHERE id='$author1'");
  $when = sqlsingle("SELECT date FROM teams WHERE id='$id'");
  $text = sqlsingle("SELECT text FROM teams WHERE id='$id'");
  $count = substr_count($text, "\n");
  $splinter = explode("\n", $text);
  $html = "";
  for ($i = 0; $i < $count; $i++) {
	$current = $splinter[$i];
	$html = $html . "<div>" . $current . "&nbsp;</div>";
  }
  $count = substr_count($html, "@");
  $explode = explode("@", $html);
    
  $p = array("", "", "", "", "", "");
  for ($i = 0; $i < $count; $i++) {
	if ($i == 0) {
		$p[0] = dust($explode[0]);
	}
	else {
		$p[$i] = explode("</div><div>", $explode[$i]);
		$p[$i] = dust($p[$i][9]);
	}
  }
  
  $glance = "";
  for ($i = 0; $i < $count; $i++) {
	$explosion = explode("(", $p[$i]);
	$count2 = substr_count($p[$i], "(");
	if ($count2 > 0) {
		$add = $explosion[1];
		$explosion2 = explode(")", $add);
		$add = $explosion2[0];
	}
	else {
		$add = $p[$i];
	}
	//problematicstuff
		//since PS doesn't have animated sprites for any arceus other than the original we have to make sure we use that one for each arceus
		$count3 = substr_count($add, "arceus");
		if ($count3 > 0) {
			$add = "arceus";
		}
	$f = array("ho-oh");
	$r = array("hooh");
	$add = str_replace($f, $r, $add);
	$currentglance = '<img src="http://play.pokemonshowdown.com/sprites/bwani/' . $add . '.gif">';
	$glance = $glance . $currentglance;
	$p[$i] = $currentglance;
  }
  echo '<div class="box"><h1>At a Glance</h1><div>', $glance, '</div></div>';
  
  echo '<div class="team"><div class="team-header"><div><h3>"', $teamname, '"</h3><span class="right">Posted on ', $when, '</span></div><div>By: ', $author, '</div></div><div class="team-cont" contenteditable="true">', $html, '</div></div><div class="team-desc-h">Team Description</div><div class="team-desc">', $description, '</div>';
  
  if ($user_id == $author1) {
	echo '<div>&nbsp;</div><h1><center><a href="edit.php?id=', $id, '">Edit Team</a> || <a href="delete.php?id=', $id, '">Delete Team</a></center></h1>';
  }
  
  echo '<div class="comments">';
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
  echo '</div>';
  
  if (isset($_SESSION['username'])) {
	include '../comment.html';
  }
  
  echo '<div>&nbsp;</div>';
  
  include '../footer.html';
?>