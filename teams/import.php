<?php
  include '../includes.php';
  include '../header.html';

  if (isset($_POST['team_name'])) {
	$teamname = clean($_POST['team_name']);
  }
  else {
	$teamname = "";
  }
  if (isset($_POST['import'])) {
	$import = clean($_POST['import']);
  }
  else {
	$import = "";
  }
  if (!$import || !$teamname || $import == "Team exported to text..." || $teamname == "Team name...") {
	echo '<div class="box">';
	if (!$teamname) {
		echo "<div>You didn't enter a team name.</div>";
	}
	if (!$import) {
		echo "<div>You didn't paste your team exported to text.</div>";
	}
	echo "<div><a href=\"./?id=$user_id\">Click here to try again.</a></div>";
	echo "</div>";
  }
  else {
	//check if another team with the same name exists
	$count = sqlcount("SELECT * FROM teams WHERE teamname='$teamname'");
	if ($count == 0) {
		$sql = "INSERT INTO teams (id, user_id, date, teamname, text, description) VALUES ('', '$user_id', '$date', '$teamname', '$import', '')";
		mysql_query($sql) or die(mysql_error());
		$team_id = sqlsingle("SELECT MAX(id) FROM teams");
	}
	else {
		$sql = "UPDATE teams SET text='$import', description='', date='$date' WHERE teamname='$teamname' AND user_id='$user_id'";
		mysql_query($sql) or die(mysql_error());
		$team_id = sqlsingle("SELECT id FROM teams WHERE teamname='$teamname' AND user_id='$user_id'");
	}
	echo '<div class="box"><div>Your team has been uploaded successfully.</div><div><a href="/', $foldername, '/view?id=', $team_id ,'">Click here to view your team.</a></div></div>';
  }
  
  include '../footer.html';
?>