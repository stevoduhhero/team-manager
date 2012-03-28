<?php
  include '../includes.php';
  include '../header.html';

  $private = clean($_POST['private']);
  if ($private != 0) {
	$private = 1;
  }
  $textfile = "";
  function dust($txt) {
	$count = substr_count($txt, ".");
	if ($count > 0) {
		$txt = explode(".", $txt);
		$txt = $txt[0];
	}
	return $txt;
  }
  function ability($id) {
	$abilities = nl2br(file_get_contents("abilities.txt"));
	$splinter = explode("<br />", $abilities);
	return $splinter[$id];
  }
  function berry($id) {
	$id = $id-8000;
  	$berries = nl2br(file_get_contents("berries.txt"));
  	$splinter = explode("<br />", $berries);
  	return $splinter[$id];
  }
  function item($id) {
	if ($id > 7999) {
  		return berry($id);
  	}
	$items = nl2br(file_get_contents("items.txt"));
	$splinter = explode("<br />", $items);
	return $splinter[$id];
  }
  function move($id) {
	$moves = nl2br(file_get_contents("moves.txt"));
	$splinter = explode("<br />", $moves);
	return $splinter[$id];
  }
  function nature($id) {
	$natures = nl2br(file_get_contents("nature.txt"));
	$splinter = explode("<br />", $natures);
	return $splinter[$id];
  }
  function pokemon($id, $forme) {
	$pokemons = nl2br(file_get_contents("pokemons.txt"));
	$splinter = explode($id . ":" . $forme . " ", $pokemons);
	$pokemonname = explode("<br />", $splinter[1]);
	$pokemonname = $pokemonname[0];
	if (!$pokemonname) {
		$splinter = explode($id . ":" . $forme . ":H ", $pokemons);
		$pokemonname = explode("<br />", $splinter[1]);
		$pokemonname = $pokemonname[0];
	}
	return $pokemonname;
  }
  if (isset($_POST['filecount'])) {
	  $fnames = $_FILES["file"]["name"][0];
	  $filecount = $_POST['filecount'];
  }
  if (isset($filecount)) {
	  for ($i = 0; $i < $filecount; $i++) {
		$c_tempname = $_FILES["file"]["tmp_name"][$i];
		$c_filename = dust($_FILES["file"]["name"][$i]);
		move_uploaded_file($c_tempname, "temp/" . $c_filename);
		$fc = file_get_contents("temp/" . $c_filename);
		$splinter = explode("<Pokemon", $fc);
		$count = substr_count($fc, "<Pokemon");
		for ($x = 1; $x < $count+1; $x++) {
			$c = $splinter[$x];
			$forme = explode('Forme="', $c);
			$forme = explode('"', $forme[1]);
			$forme = $forme[0];
			$pokename = explode('Num="', $c);
			$pokename = explode('"', $pokename[1]);
			$pokename = pokemon($pokename[0], $forme);
			$itemname = explode('Item="', $c);
			$itemname = explode('"', $itemname[1]);
			$itemname = item($itemname[0]);
			$ability = explode('Ability="', $c);
			$ability = explode('"', $ability[1]);
			$ability = ability($ability[0]);
			/* evs */
			$evs = "";
			for ($y = 1; $y < 7; $y++) {
				if ($y == 1) {$cev = "HP";}
				if ($y == 2) {$cev = "Atk";}
				if ($y == 3) {$cev = "Def";}
				if ($y == 4) {$cev = "SAtk";}
				if ($y == 5) {$cev = "SDef";}
				if ($y == 6) {$cev = "Spd";}
				$cv = explode('<EV>', $c);
				$cv = explode('</EV>', $cv[$y]);
				$cv = $cv[0];
				if ($cv != 0) {
					$extra = "";
					if ($y != 6) {
						$extra = " / ";
					}
					$evs = $evs . $cv . " " . $cev . $extra;
				}				
			}
			if (substr($evs, -1) == " ") {
				$evs = substr_replace($evs, "", -1);
				$evs = substr_replace($evs, "", -1);
				$evs = substr_replace($evs, "", -1);
			}
			/* evs */
			$nature = explode('Nature="', $c);
			$nature = explode('"', $nature[1]);
			$nature = nature($nature[0]);
			$move1 = explode('<Move>', $c);
			$move1 = explode('</Move>', $move1[1]);
			$move1 = move($move1[0]);
			$move2 = explode('<Move>', $c);
			$move2 = explode('</Move>', $move2[2]);
			$move2 = move($move2[0]);
			$move3 = explode('<Move>', $c);
			$move3 = explode('</Move>', $move3[3]);
			$move3 = move($move3[0]);
			$move4 = explode('<Move>', $c);
			$move4 = explode('</Move>', $move4[4]);
			$move4 = move($move4[0]);
			$stuff = $pokename . ' @ ' . $itemname . '<br />Trait: ' . $ability . '<br />EVs: ' . $evs . '<br />' . $nature . ' Nature<br />- ' . $move1 . '<br />- ' . $move2 . '<br />- ' . $move3 . '<br />- ' . $move4 . '<br /><br />';
			$textfile = $textfile . str_replace("<br />", "\n", str_replace("\n", "", $stuff));
		}
		$c_filenameclean = clean($c_filename);
		$count = sqlcount("SELECT * FROM teams WHERE teamname='$c_filenameclean' AND user_id='$user_id'");
		if ($count == 0) {
			$sql = "INSERT INTO teams (id, user_id, date, teamname, text, description, public) VALUES ('', '$user_id', '$date', '$c_filenameclean', '$textfile', '', '$private')";
			mysql_query($sql) or die(mysql_error());
		}
		else {
			$sql = "UPDATE teams SET date='$date', text='$textfile', description='' WHERE teamname='$c_filenameclean' AND user_id='$user_id'";
			mysql_query($sql) or die(mysql_error());
		}
		unlink("temp/" . $c_filename);
		$textfile = "";
	  }
	  echo "<div class=\"box\"><h2>Uploaded the file(s) successfully.<div><a href=\"./?id=$user_id\">Click here to visit your team manager.</a></div></h2></div>";
  }
  
  include '../footer.html';
?>