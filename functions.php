<?php
  function clean($txt) {
	return mysql_real_escape_string($txt);
  }
  function sqlsingle($sql) {
	$query = mysql_query($sql);
	$array = mysql_fetch_array($query);
	return $array[0];
  }
  function sqlcount($sql) {
	$query = mysql_query($sql);
	return mysql_num_rows($query);
  }
?>