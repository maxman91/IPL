<?php  
require 'header.php';

if (isset($_GET['name'])) {
	$name = mysqli_real_escape_string($con, $_GET['name']);
	$name = str_replace("_"," ",$name);
	

	$player_query = mysqli_query($con, "SELECT * FROM player WHERE name='$name'");
	$player_array = mysqli_fetch_array($player_query);

}
    

    if (isset($_GET['year'])) {
    	$year = $_GET['year'];
    	foreach ($year as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		if (isset($filter)) {
    			$filter = "{$filter} date like '$value%' OR";
    		} else {
    		$filter =  "date like '$value%' OR";
    		}
    	}
    $filter = substr($filter, 0, -2);
    }
    
    

    if (isset($_GET['opposition'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$opposition = $_GET['opposition'];
    	foreach ($opposition as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} opposition='{$value}' OR";
    		} else {
    		$filter =  "opposition='$value' OR";
    		}
    	}
    	$filter = substr($filter, 0, -2);
    }

    

   


    if (isset($_GET['results'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$results = $_GET['results'];
    	foreach ($results as $key => $value) {
    	   $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} result='{$value}' OR";
    		} else {
    		$filter =  "result='$value' OR";
    		}
    	}
    $filter = substr($filter, 0, -2);
    }

    

    if (isset($_GET['innings'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$innings = $_GET['innings'];
    	foreach ($innings as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} innings='{$value}' OR";
    		} else {
    		$filter =  "innings='$value' OR";
    		}
    	}
    	$filter = substr($filter, 0, -2);
    }

   

    if (isset($_GET['venue'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$venue = $_GET['venue'];
    	foreach ($venue as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} ground='{$value}' OR";
    		} else {
    		$filter =  "ground='$value' OR";
    		}
    	}
    	$filter = substr($filter, 0, -2);
    }

    

    if (isset($_GET['team'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$team = $_GET['team'];
    	foreach ($team as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} team='{$value}' OR";
    		} else {
    		$filter =  "team='$value' OR";
    		}
    	}
    	$filter = substr($filter, 0, -2);
    }

    

    if (isset($_GET['batting_position'])) {
    if (isset($filter)) {
    	$filter = "{$filter} AND";
    }
    	$batting_position = $_GET['batting_position'];
    	foreach ($batting_position as $key => $value) {
    	    $value = mysqli_real_escape_string($con, $value);
    		
    		if (isset($filter)) {
    			$filter = "{$filter} position='{$value}' OR";
    		} else {
    		$filter =  "position='$value' OR";
    		}
    	}
    	$filter = substr($filter, 0, -2);

    }

    


    

if (isset($filter)) {
    	$filter = str_replace('AND', ' ) AND ( ', $filter);
    	$filter = '('.$filter .')';
    	$bowling_filter = $filter;
    	

    }
    

	$batting_innings_array = array();
	
	
	
	if (isset($filter)) {
	
		$batting_innings_query = mysqli_query($con, "SELECT * FROM battinginnings WHERE name='$name' AND ({$filter})");
	} else {


	$batting_innings_query = mysqli_query($con, "SELECT * FROM battinginnings WHERE name='$name'");}
	
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$opposition_array = array();
	$years_array = array();
	$batting_position_array = array();
	$results_array = array("won","lost","tied","no result");
	$innings_array = array("1","2");
	$venue_array = array();
	$team_array = array();
	$innings_batted = 0;
	
	
	
	while($row_batting_innings = mysqli_fetch_assoc($batting_innings_query)){
	$statline = explode(",", $row_batting_innings['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($row_batting_innings['team'] == 'Rising Pune Supergiant') {
			$row_batting_innings['team'] = 'Rising Pune Supergiants';
		}

		if ($row_batting_innings['team'] == 'Delhi Daredevils') {
			$row_batting_innings['team'] = 'Delhi Capitals';
		}
		if (!in_array($row_batting_innings['team'], $team_array)) {
            array_push($team_array, $row_batting_innings['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($row_batting_innings['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($row_batting_innings['opposition'] == 'Delhi Daredevils') {
		$row_batting_innings['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($row_batting_innings['position'], $batting_position_array)) {
            array_push($batting_position_array, $row_batting_innings['position']);
        }
    if (!in_array($row_batting_innings['ground'], $venue_array)) {
            array_push($venue_array, $row_batting_innings['ground']);
        }


     if ($row_batting_innings['opposition'] == 'Rising Pune Supergiant') {
			$row_batting_innings['opposition'] = 'Rising Pune Supergiants';
		}

		if ($row_batting_innings['opposition'] == 'Delhi Daredevils') {
			$row_batting_innings['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($row_batting_innings['opposition'], $opposition_array)) {
            array_push($opposition_array, $row_batting_innings['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($row_batting_innings['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}

	$bowling_innings_array = array();
	
	if (isset($bowling_filter)) {
		$bowling_innings_query = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE name='$name' AND ({$bowling_filter})");
	} else {


	$bowling_innings_query = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE name='$name'");}

	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	$statline = explode(",", $row_bowling_innings['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($row_bowling_innings['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($row_bowling_innings['opposition'] == 'Rising Pune Supergiant') {
			$row_bowling_innings['opposition'] = 'Rising Pune Supergiants';
		}
		if ($row_bowling_innings['opposition'] == 'Delhi Daredevils') {
			$row_bowling_innings['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($row_bowling_innings['team'] == 'Rising Pune Supergiant') {
			$row_bowling_innings['team'] = 'Rising Pune Supergiants';
		}
		if ($row_bowling_innings['team'] == 'Delhi Daredevils') {
			$row_bowling_innings['team'] = 'Delhi Capitals';
		}
		if (!in_array($row_bowling_innings['team'], $team_array)) {
            array_push($team_array, $row_bowling_innings['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($row_bowling_innings['opposition'], $opposition_array)) {
            array_push($opposition_array, $row_bowling_innings['opposition']);
        }

    if (!in_array($row_bowling_innings['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $row_bowling_innings['position']);
        }
    if (!in_array($row_bowling_innings['ground'], $venue_array)) {
            array_push($venue_array, $row_bowling_innings['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}
  	
  	if (isset($filter)) {
  		$batting_innings_query2 = mysqli_query($con, "SELECT * FROM battinginnings WHERE name='$name' AND ({$filter}) ORDER BY date DESC");
  	} else {

	$batting_innings_query2 = mysqli_query($con, "SELECT * FROM battinginnings WHERE name='$name' ORDER BY date DESC");}

	
	if (isset($bowling_filter)) {
		$bowling_innings_query2 = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE name='$name' AND ({$bowling_filter}) ORDER BY date DESC");
	} else {

	$bowling_innings_query2 = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE name='$name' ORDER BY date DESC");}

	
while($row_batting_innings = mysqli_fetch_assoc($batting_innings_query2)){
	
	

	


	
	$batting_innings[$row_batting_innings['name']][] = $row_batting_innings;
	
}
while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query2)){
	
	

	


	
	$bowling_innings[$row_bowling_innings['name']][] = $row_bowling_innings;
	
}
    

 	
 	
	
?>



<!DOCTYPE html>
<html>
<head>
	<title><?php echo $name; ?>'s stats -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="../assets/t20.css">
	<script src="../assets/t20.js"></script>
	<meta name="description" content="Advanced IPL stats page for <?php echo $name; ?>">
	
<meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>
<body onload="load()">

<?php 
if (isset($filter)) {
 	echo "<h3>{$name}'s Filtered stats page</h3>";
 	$link = str_replace(" ", "_", $name);
 	$filter_string = str_replace("date like ", " year is ", $filter);
 	$filter_string = str_replace("'", "", $filter_string);
 	$filter_string = str_replace("OR", "or", $filter_string);
 	$filter_string = str_replace(")", "", $filter_string);
 	$filter_string = str_replace("(", "", $filter_string);
 	$filter_string = str_replace("%", "", $filter_string);
 	$filter_string = str_replace("=", " is ", $filter_string);
 	$filter_string = str_replace(" AND ", "<br>and", $filter_string);

 	  
 	echo "<p>Filter:{$filter_string}</p>";


 	echo "<a href='{$link}'>Main stats page</a>";
 } else {
 	echo "<h3>{$name}'s stats page</h3>";
 }


if (!isset($_GET['detailed'])) {
	echo "<br><a href='http://localhost/ipl/player/{$_GET['name']}?detailed=batting'>Detailed IPL batting stats<a/><br>";
 	echo "<a href='http://localhost/ipl/player/{$_GET['name']}?detailed=bowling'>Detailed IPL bowling stats<a/>";


}


if (isset($_GET['detailed'])) {
	echo "<a href='http://localhost/ipl/player/{$_GET['name']}'> {$name}'s main stats page<a/>";
	echo "<div class='hide'>";


}




?>

<table class="infocard stats"> 
	<tr><th colspan="16" style="text-align: left;" >Batting stats</th></tr>
	<tr style="font-weight: bold;"><td>Comp</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>
	

	<?php 

	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>IPL</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";?>
</table>
<br>
<table class="infocard stats">
			<tr><th style="text-align: left;" colspan="16">Bowling stats</th></tr>
	<tr style="font-weight: bold;"><td>Comp</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>
	

	<?php 
	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>IPL</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";} else{

		echo " 
	<tr><td>IPL</td><td>0</td><td>0</td><td>0</td><td>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td><td class='desktop'>0</td></tr>";
	}

	?>
</table>
<a href = "#" id="hidebowling" class="bowling_link" onclick="hidebowling()">Hide bowling innings list</a>

<a href = "#" id="showbowling" class="bowling_link" onclick="showbowling()">Show bowling innings list</a>

<a href = "#" id="hidebatting" class="batting_link" onclick="hidebatting()">Hide batting innings list</a>

<a href = "#" id="showbatting" class="batting_link" onclick="showbatting()">Show batting innings list</a>
<br>
<table id="batting_list" class="battingcard batting_innings_list"
><tr><th colspan="5">Batting innings list</th></tr>
	<tr style="font-weight: bold; background-color: #f5f6fa;"><td>Runs</td><td>SR</td><td>Date</td></tr>
<?php 
if (isset($batting_innings[$name])) {

foreach ($batting_innings[$name] as $key => $value) {
$statline = explode(",", $value['statline']);
	$match_id = $value['matchid'];
	
	
	
	
	$link = "../redirect.php?match={$match_id}";


	if ($statline[1] > 0) {
		# code...
	

	if ($statline[0] > 0) {

	$battingSR = $statline[0] * 100 / $statline[1];
	$battingSR = floor($battingSR * 100) / 100;}
	else {$battingSR = 0;}

	if ($value['dissmissal'] == 'not out'){
		$astr = '*';
	} else { $astr = '';}

	echo "<tr><td><a href='{$link}'><b>{$statline[0]}{$astr}</b></a></td><td>{$battingSR}</td><td>{$value['date']}</td></tr>";
	
	
	} }	
}?>



	
</table>

<table id="bowling_list" class="battingcard bowling_innings_list">
	<tr><th colspan="5">Bowling innings list</th></tr>
	<tr style="font-weight: bold; background-color: #f5f6fa;"><td>Figues</td><td>Economy</td><td>Date</td></tr>
	<?php 
if (isset($bowling_innings[$name])) {
foreach ($bowling_innings[$name] as $key => $value) {
$statline = explode(",", $value['statline']);
	if ($statline[2] > 0) {
		# code...
	$ovr = floor($statline[2]/6) + ($statline[2] % 6) /10;
	$econ = $statline[1] / $ovr;
	$econ = floor($econ * 100) / 100;
	$match_id = $value['matchid'];
	
	$link = "../redirect.php?match={$match_id}";

	

	



	echo "<tr><td><a href='{$link}'><b>{$statline[0]}/{$statline[1]}</b></a></td><td>{$econ}</td><td>{$value['date']}</td></tr>";
	

	

	




	
	
	} }}?>
	
</table>
<br>
<form <?php if (isset($filter)) {echo "class='hide'";} ?>action="<?php echo $_GET['name']; ?>">
	<table class="filter_table"><tr><th>Filters</th></tr><tr><th>Year</th>
		
<?php  asort($years_array);
foreach ($years_array as $key => $value) {
	echo "<td><input type='checkbox' name='year[]' value='{$value}'> {$value}</td>";

}


?>
</tr>
<tr><th>Opposition</th>
<?php  
foreach ($opposition_array as $key => $value) {
	echo "<td><input type='checkbox' name='opposition[]' value='{$value}'> {$value}</td>";

}


?>
</tr>
<tr><th>Batting Position</th>
<?php  
if (isset($batting_position_array)) {
	asort($batting_position_array);

foreach ($batting_position_array as $key => $value) {
	echo "<td><input type='checkbox' name='batting_position[]' value='{$value}'> {$value}</td>";

}}


?>
</tr>

</tr>
<tr><th>Match Result</th>
<?php  
foreach ($results_array as $key => $value) {
	echo "<td><input type='checkbox' name='results[]' value='{$value}'> {$value}</td>";

}


?>
</tr>
<tr><th>Innings</th>
<?php  
foreach ($innings_array as $key => $value) {
	echo "<td><input type='checkbox' name='innings[]' value='{$value}'> {$value}</td>";

}


?>
</tr>
<tr><th>City</th>

<?php  
foreach ($venue_array as $key => $value) {
	echo "<td><input type='checkbox' name='venue[]' value='{$value}'> {$value}</td>";

}


?>
</tr>
<tr><th>Team</th>
<?php  
foreach ($team_array as $key => $value) {
	echo "<td><input type='checkbox' name='team[]' value='{$value}'> {$value}</td>";

}


?>
</tr>

</table>
 <input type="submit" class="button" value="Filter"> 
</form>
<?php  

if (isset($_GET['detailed'])) {
	echo "</div>";


if ($_GET['detailed'] == 'batting') {
	# code...

 if (isset($years_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by Year</th></tr>
	<tr style='font-weight: bold;'><td>Year</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	$batting_innings_query = mysqli_query($con, "SELECT * FROM battinginnings WHERE name='$name'");

while($row_batting_innings = mysqli_fetch_assoc($batting_innings_query)){
	
	$four =substr($row_batting_innings['date'], -10,4);

	


	$batting_year[$four][] = $row_batting_innings;
	$batting_position[$row_batting_innings['position']][] = $row_batting_innings;
	$batting_result[$row_batting_innings['result']][] = $row_batting_innings;
	$batting_ground[$row_batting_innings['ground']][] = $row_batting_innings;
	$batting_team[$row_batting_innings['team']][] = $row_batting_innings;
	$batting_opposition[$row_batting_innings['opposition']][] = $row_batting_innings;
}
	
	
	
foreach ($years_array as $key => $value) {
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_year[$value])) {
		# code...
	
	foreach ($batting_year[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($values['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $values;}

     $index++;
	}}
	if ($innings_batted > 0) {
		# code...
	
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}




}

if (isset($batting_position_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by batting position</th></tr>
	<tr style='font-weight: bold;'><td>Position</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
foreach ($batting_position_array as $key => $value) {
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_position[$value])) {
		# code...
	


	foreach ($batting_position[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}}
if ($innings_batted > 0) {
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}




        }


}

if (isset($venue_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by city</th></tr>
	<tr style='font-weight: bold;'><td>City</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
foreach ($venue_array as $key => $value) {
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_ground[$value])) {
		# code...
	
	foreach ($batting_ground[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}}
if ($innings_batted > 0) {
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}




        }


}



if (isset($results_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by result</th></tr>
	<tr style='font-weight: bold;'><td>Result</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
foreach ($results_array as $key => $value) {
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_result[$value])) {
		# code...
	
	foreach ($batting_result[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}}
if ($innings_batted > 0) {
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}





        }


}

if (isset($opposition_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by opposition</th></tr>
	<tr style='font-weight: bold;'><td>Opposition</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
foreach ($opposition_array as $key => $value) {
	
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_opposition[$value])) {
		# code...
	
	foreach ($batting_opposition[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}}
if ($innings_batted > 0) {
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}





        }


}

if (isset($team_array)) {
 	
 

echo "<table class='infocard stats'> 
	<tr><th colspan='16' style='text-align: left;' >IPL batting stats by team</th></tr>
	<tr style='font-weight: bold;'><td>Team</td><td>Inn</td><td class='desktop'>NO</td><td>Runs</td><td class='desktop'>HS</td><td>Ave</td><td class='desktop'>BF</td><td>SR</td><td class='desktop'>100s</td><td class='desktop'>50s</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
foreach ($team_array as $key => $value) {
	$runs_scored = 0;
	$balls_faced = 0;
	$zeros_scored = 0;
	$ones_scored = 0;
	$twos_scored = 0;
	$threes_scored = 0;
	$fours_scored = 0;
	$sixes_scored = 0;
	$not_outs = 0;
	$index = 0;
	$fifties_scored = 0;
	$centuries_scored = 0;
	$high_score = 0;
	$innings_batted = 0;
	if (isset($batting_team[$value])) {
		# code...
	
	foreach ($batting_team[$value] as $key => $values) {
		# code...
	
	$statline = explode(",", $values['statline']);
	
	




	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($row_batting_innings['date'], -10, 4);

	if ($statline[1] > 0) {
		$innings_batted++;
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}

		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($values['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($values['opposition'] == 'Delhi Daredevils') {
		$values['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($values['position'], $batting_position_array)) {
            array_push($batting_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }


     if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}

		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }

	if ($statline[0] >= 50) {
		if ($statline[0] < 100) {
			$fifties_scored = $fifties_scored + 1;
		}
	}

	if ($statline[0] >= 100) {
		
			$centuries_scored = $centuries_scored + 1;
		
	}

	if ($statline[0] > $high_score) {
		$high_score = $statline[0];
	}

	 
	


	if ($statline[1] != 0) {
		
	 if ($values['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $row_batting_innings;}

     $index++;
	}}
if ($innings_batted > 0) {
	if ($runs_scored >0 and $innings_batted-$not_outs > 0 ) {
	    if ($innings_batted-$not_outs > 0) {
		
	
	$batting_ave = $runs_scored / ($innings_batted-$not_outs);
	$batting_ave = floor($batting_ave * 100) / 100;}
	        
	    } else {
	        $batting_ave = "-";
	        
	    }
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	

	if (!isset($battingSR)) {
		$battingSR = "-";
	    $batting_ave = "-";}
	

	 echo " 
	<tr><td>{$value}</td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}




        }


}} //the batting stuff




	}

	if ($_GET['detailed'] == 'bowling') { 
		if (isset($years_array)) { 

$bowling_innings_query = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE name='$name'");

while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	
	$four =substr($row_bowling_innings['date'], -10,4);

	


	$bowling_year[$four][] = $row_bowling_innings;
	$bowling_position[$row_bowling_innings['position']][] = $row_bowling_innings;
	$bowling_result[$row_bowling_innings['result']][] = $row_bowling_innings;
	$bowling_ground[$row_bowling_innings['ground']][] = $row_bowling_innings;
	$bowling_team[$row_bowling_innings['team']][] = $row_bowling_innings;
	$bowling_opposition[$row_bowling_innings['opposition']][] = $row_bowling_innings;
}


			echo "<table class='infocard stats'>
			<tr><th style='text-align: left;' colspan='16'>IPL bowling stats by year</th></tr>
	<tr style='font-weight: bold;'><td>Year</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	foreach ($years_array as $key => $value) {
	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	if (isset($bowling_year[$value])) {
		# code...
	
	foreach ($bowling_year[$value] as $key => $values) {
	
	
	$statline = explode(",", $values['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($values['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}
		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}
		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($values['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}}


	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>{$value}</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";}









											}
											}
	if (isset($venue_array)) { 



			echo "<table class='infocard stats'>
			<tr><th style='text-align: left;' colspan='16'>IPL bowling stats by City</th></tr>
	<tr style='font-weight: bold;'><td>City</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	foreach ($venue_array as $key => $value) {
	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	if (isset($bowling_ground[$value])) {
		# code...
	
	foreach ($bowling_ground[$value] as $key => $values) {
	//while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	
	$statline = explode(",", $values['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($values['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}
		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}
		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($values['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}}


	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>{$value}</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";}









											}
											}
	if (isset($results_array)) { 



			echo "<table class='infocard stats'>
			<tr><th style='text-align: left;' colspan='16'>IPL bowling stats by Result</th></tr>
	<tr style='font-weight: bold;'><td>Result</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	foreach ($results_array as $key => $value) {
	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	if (isset($bowling_result[$value])) {
		# code...
	
	foreach ($bowling_result[$value] as $key => $values) {
	//while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	
	$statline = explode(",", $values['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($values['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}
		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}
		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($values['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}}


	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>{$value}</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";}









											}
											}
		if (isset($opposition_array)) { 



			echo "<table class='infocard stats'>
			<tr><th style='text-align: left;' colspan='16'>IPL bowling stats by Opponent</th></tr>
	<tr style='font-weight: bold;'><td>Opponent</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	foreach ($opposition_array as $key => $value) {
	
	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	if (isset($bowling_opposition[$value])) {
		# code...
	
	foreach ($bowling_opposition[$value] as $key => $values) {
	//while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	
	$statline = explode(",", $values['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($values['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}
		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}
		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($values['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}}


	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>{$value}</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";}









											}
											}


	if (isset($team_array)) { 



			echo "<table class='infocard stats'>
			<tr><th style='text-align: left;' colspan='16'>IPL bowling stats by team</th></tr>
	<tr style='font-weight: bold;'><td>Team</td><td>Inn</td><td class='desktop'>Balls</td><td class='desktop'>Maidens</td><td class='desktop'>Runs</td><td>Wkts</td><td class='desktop'>BBI</td><td>Ave</td><td>Econ</td><td class='desktop'>SR</td><td class='desktop'>0s</td><td class='desktop'>1s</td><td class='desktop'>2s</td><td class='desktop'>3s</td><td class='desktop'>4s</td><td class='desktop'>6s</td></tr>";
	foreach ($team_array as $key => $value) {
	$runs_conceded = 0;
	$balls_bowled = 0;
	$zeros_conceded = 0;
	$ones_conceded = 0;
	$twos_conceded = 0;
	$threes_conceded = 0;
	$fours_conceded = 0;
	$sixes_conceded = 0;
	$wickets_taken = 0;
	$maidens = 0;
	$most_wickets = 0;
	$bowling_position_array = array(); 
	$innings_bowled = 0;
	

	$index = 0;
	if (isset($bowling_team[$value])) {
		# code...
	
	foreach ($bowling_team[$value] as $key => $values) {
	//while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query)){
	
	$statline = explode(",", $values['statline']);

	$wickets_taken = $wickets_taken + $statline[0];
	$runs_conceded = $runs_conceded + $statline[1];
	$balls_bowled = $balls_bowled + $statline[2];
	$zeros_conceded = $zeros_conceded + $statline[3];
	$maidens = $maidens + $statline[4];
	$ones_conceded = $ones_conceded + $statline[5];
	$twos_conceded = $twos_conceded + $statline[6];
	$threes_conceded = $threes_conceded + $statline[7];
	$fours_conceded = $fours_conceded + $statline[8];
	$sixes_conceded = $sixes_conceded + $statline[9];
	$year = substr($values['date'], -10, 4);
	
	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($values['opposition'] == 'Rising Pune Supergiant') {
			$values['opposition'] = 'Rising Pune Supergiants';
		}
		if ($values['opposition'] == 'Delhi Daredevils') {
			$values['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($values['team'] == 'Rising Pune Supergiant') {
			$values['team'] = 'Rising Pune Supergiants';
		}
		if ($values['team'] == 'Delhi Daredevils') {
			$values['team'] = 'Delhi Capitals';
		}
		if (!in_array($values['team'], $team_array)) {
            array_push($team_array, $values['team']);
        }
	}



	

	if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
        }
         

	if (!in_array($values['opposition'], $opposition_array)) {
            array_push($opposition_array, $values['opposition']);
        }

    if (!in_array($values['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $values['position']);
        }
    if (!in_array($values['ground'], $venue_array)) {
            array_push($venue_array, $values['ground']);
        }
	


	if ($statline[0] > $most_wickets) {
		$most_wickets = $statline[0];
		
		$runs_conceded_least = $statline[1];
		
			
		
	}

	if ($statline[0] == $most_wickets) {
		
			if (isset($runs_conceded_least)) {
				if ($runs_conceded_least > $statline[1]) {
					$runs_conceded_least = $statline[1];
			}
		}
	}

	

	if ($statline[2] != 0) {
		
		

     $bowling_innings_array[$index] = $row_bowling_innings;
            }

     $index++;
	}}


	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= 0;
		$runs_conceded_least = 0;
		$bowling_sr = 0;
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	
	 
	 


	 echo " 
	<tr><td>{$value}</td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";}









											}
											}									







	}


}
?>
</body>
</html>