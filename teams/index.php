<?php
	include '../includes.php';
	include '../header.html';
	
	$id = clean($_GET['id']);
	$cusername = sqlsingle("SELECT username FROM users WHERE id='$id'");
	$online = sqlsingle("SELECT online FROM users WHERE id='$id'");
	$joined = sqlsingle("SELECT joindate FROM users WHERE id='$id'");
	$dependant = "";
	$dependant2 = "";
	if ($online == 1) {
		$dependant = "green";
		$dependant2 = "Online";
	}
	else {
		$dependant = "red";
		$dependant2 = "Offline";
	}
	echo '<div class="box"><h3>', $cusername ,'\'s Team Manager</h3><h5>Joined On: ', $joined, '</h5><h5>Status: <font color="', $dependant, '">', $dependant2 ,'</font></h5></div>';
	
	if ($id == $user_id) {
		echo '<h1 class="center" style="margin-top:5px;">Importer</h1><div class="box">Since you are on your own team manager you get access to the importer.</div>';
		include 'importer.html';
	}
	
	echo '<h1 class="center" style="margin-top:5px;">Teams</h1>';
	
	$count = sqlcount("SELECT * FROM teams WHERE user_id='$id' AND public='1'");
	if ($user_id == $id) {
		$count = sqlcount("SELECT * FROM teams WHERE user_id='$user_id'");
	}
	echo '<div class="box">In total ', $cusername ,' has <b>', $count , '</b> teams.</div>';
	
	echo '<div class="ul-teams">';
	$sql = "SELECT * FROM teams WHERE user_id='$id' AND public='1' ORDER BY id DESC";
	if ($user_id == $id) {
		$sql = "SELECT * FROM teams WHERE user_id='$id' ORDER BY id DESC";
	}
	$query = mysql_query($sql) or die(mysql_error());
	while($array = mysql_fetch_array($query)) {
		$teamname = htmlspecialchars($array['teamname']);
		$made = $array['date'];
		$id = $array['id'];
		echo '<a href="/', $foldername, '/view?id=', $id, '" class="nunderline"><div class="li-team">"', $teamname ,'" <span class="right"> Posted on ', $made, '</span></div></a>';
	}
	echo '</div>';
	echo '<div>&nbsp;</div>';
	
	include '../footer.html';
?>