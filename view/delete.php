<?php
  include '../includes.php';
  include '../header.html';
?>
<div class="box">
<h1>Are you sure you want to delete this team?</h1>
<form>
<button style="color: green;background: white;">Yes This Team Really Sucks</button> <button style="color: red;background: white;">NO NO NO!! FALSE! LET ME GO BACK</button>
<input type="hidden" name="teamid" value="<?php echo $_GET['id']; ?>" />
</form>
</div>
<?php
  if (isset($_GET['teamid'])) {
	$teamid = clean($_GET['teamid']);
	$teamowner = sqlsingle("SELECT user_id FROM teams WHERE id='$teamid'");
	$auth = sqlsingle("SELECT authority FROM users WHERE id='$user_id'");
	if ($user_id == $teamowner || $auth == "admin") {
		$sql = "DELETE FROM teams WHERE id='$teamid'";
		mysql_query($sql) or die(mysql_error());
		echo "<script type=\"text/javascript\">window.location.href = '/$foldername/teams?id=$user_id';</script>";
	}
	else {
		echo "<div class=\"box\"><h1>This isn't your team!!!</h1></div>";
	}
  }
  
  include '../footer.html';
?>