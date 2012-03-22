<?php
  include 'includes.php';
  include 'header.html';
?>
<form>
<center>
<input type="text" class="search" value="Search..." name="s" />
<button class="squared">Search</button>
</form>
</center>
<script type="text/javascript">
$(document).ready(function() {
	$(".search").focus(function() {
		if (this.value == "Search...") {
			this.value = "";
			this.style.color = "#000000";
		}
	});
	$(".search").blur(function() {
		if (this.value == "") {
			this.value = "Search...";
			this.style.color = "#b6b6b6";
		}
	});
	$(".search").focus();
});
</script>
<div class="box"><h2>Search results</h2></div>
<?php
  if (isset($_GET['s'])) {
	$search = clean($_GET['s']);
	$sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
	$query = mysql_query($sql) or die(mysql_error());
	while($array = mysql_fetch_array($query)) {
		$cusername = htmlspecialchars($array['username']);
		$cid = $array['id'];
		echo '<a href="/', $foldername, '/teams?id=', $cid, '" class="search-result">', $cusername ,'</a>';
	}
	echo '<script type="text/javascript">$(".search").val("', htmlspecialchars($_GET['s']), '").css({"color" : "#000000"});</script>';
  }
  
  include 'footer.html';
?>