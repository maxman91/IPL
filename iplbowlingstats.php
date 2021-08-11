<?php  

require 'header.php'; 

$players_query = mysqli_query($con, "SELECT * FROM player");
$players = array();

$min = 50;



while($row_search_player = mysqli_fetch_assoc($players_query)){
	$row_search_player['name'];
	
	array_push($players, $row_search_player['name']);



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

   

    //if (isset($_GET['bowling_position'])) {
   // if (isset($filter)) {
    //	$filter = "{$filter} AND";
    //}
    //	$bowling_position = $_GET['bowling_position'];
    //	foreach ($bowling_position as $key => $value) {
    		
    //		if (isset($filter)) {
    //			$filter = "{$filter} position='{$value}' OR";
    //		} else {
    //		$filter =  "position='$value' OR";
    //		}
    //	}
    //	$filter = substr($filter, 0, -2);

    //}

    if (isset($filter)) {
    	$min = 1;
    }
    if (isset($_GET['min_innings'])) {
 	$min = $value = mysqli_real_escape_string($con, $_GET['min_innings']);
 	$filters ="is now set";
 	
 }

   if (isset($filter)) {
   	$filters ="is now set";
   }
 if (isset($filter)) {
    	$filter = str_replace('AND', ' ) AND ( ', $filter);
    	$filter = '('.$filter .')';
    	$bowling_filter = $filter;
    	

    }

if (isset($filter)) {
		
		$bowling_innings_query = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE ({$filter})");
	} else {
	$bowling_innings_query = mysqli_query($con, "SELECT * FROM bowlinginnings");}


while($row_bowling_innings = mysqli_fetch_assoc($bowling_innings_query))
{

$player[$row_bowling_innings['name']]['bowlinginnings'][] = $row_bowling_innings;
}




?>


<!DOCTYPE html>
<html>
<head>
	<title>IPL bowling records -t20statsdump.com<</title>
	<link rel="stylesheet" type="text/css" href="assets/t20.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/dragtable.mod.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	     <meta name="description" content="Scores for every IPL match ever played.">
	
	<script src="assets/t20.js"></script>
	
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.min.js"></script> 
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.widgets.min.js"></script> 
	     
</head>
<body>
    
    


    
    
	<h5 <?php if (isset($filters)) {echo "class='hide'";} ?>><A HREF="#stats">Jump to stats filters</A></h5>
	<h5 <?php if (!isset($filters)) {echo "class='hide'";} ?>><A HREF="http://localhost/ipl/iplbowlingstats.php">Back to main stats page</A></h5>
<?php 
if (isset($filter)) {

 	
 		$filter_string = str_replace("date like ", " year is ", $filter);
 	$filter_string = str_replace("'", "", $filter_string);
 	$filter_string = str_replace("%", "", $filter_string);
 	$filter_string = str_replace("OR", "or", $filter_string);
 	$filter_string = str_replace(")", "", $filter_string);
 	$filter_string = str_replace("(", "", $filter_string);
 	$filter_string = str_replace("=", " is ", $filter_string);
 	$filter_string = str_replace(" AND ", "<br>and", $filter_string);


 	  
 	echo "<p>Filter:{$filter_string}</p>"; } 
if (isset($min)) {
	if ($min > 1) {
		echo "<p>Minimum innings:{$min}</p>";
	}
	
}




 	?>
	
<table id="myTable" class="infocard stats tablesorter"> 
	<thead>
	<tr style="font-weight: bold;"><td>Name ↕</td><td>Inn ↕</td><td class='desktop'>Balls ↕</td><td class='desktop'>Maidens ↕</td><td class='desktop'>Runs ↕</td><td>Wkts ↕</td><td class='desktop'>BBI ↕</td><td>Ave ↕</td><td>Econ ↕</td><td class='desktop'>SR ↕</td><td class='desktop'>0s ↕</td><td class='desktop'>1s ↕</td><td class='desktop'>2s ↕</td><td class='desktop'>3s ↕</td><td class='desktop'>4s ↕</td><td class='desktop'>6s ↕</td></tr>
    </thead>
    <tbody>
<?php
$counter =0;
        $opposition_array = array();
		$years_array = array();
		$bowling_position_array = array();
		$results_array = array("won","lost","tied","no result");
		$innings_array = array("1","2");
		$venue_array = array();
		$team_array = array();
	



	foreach ($players as $key => $value) {
	
	# code...

    
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
	 
	$innings_bowled = 0;

		
			# code...
		
	if (isset($player[$value]['bowlinginnings'])) {
	$innings_counter = count($player[$value]['bowlinginnings']);}
    $counting = 0;
    if (isset($innings_counter)) {
    while ($counting <= $innings_counter) {
	if (isset($player[$value]['bowlinginnings'][$counting])) {

	$statline = explode(",", $player[$value]['bowlinginnings'][$counting]['statline']);
	
	




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
	$year = substr($player[$value]['bowlinginnings'][$counting]['date'], -10, 4);

	if ($statline[2] > 1) {
		$innings_bowled++;
	}

	if ($player[$value]['bowlinginnings'][$counting]['opposition'] == 'Rising Pune Supergiant') {
			$player[$value]['bowlinginnings'][$counting]['opposition'] = 'Rising Pune Supergiants';
		}
		if ($player[$value]['bowlinginnings'][$counting]['opposition'] == 'Delhi Daredevils') {
			$player[$value]['bowlinginnings'][$counting]['opposition'] = 'Delhi Capitals';
		}

	if ($statline[2] > 0) {
		if ($player[$value]['bowlinginnings'][$counting]['team'] == 'Rising Pune Supergiant') {
			$player[$value]['bowlinginnings'][$counting]['team'] = 'Rising Pune Supergiants';
		}
		if ($player[$value]['bowlinginnings'][$counting]['team'] == 'Delhi Daredevils') {
			$player[$value]['bowlinginnings'][$counting]['team'] = 'Delhi Capitals';
		}
		if (!in_array($player[$value]['bowlinginnings'][$counting]['team'], $team_array)) {
            array_push($team_array, $player[$value]['bowlinginnings'][$counting]['team']);
        }
	}

	




	if ($player[$value]['bowlinginnings'][$counting]['opposition'] == 'Delhi Daredevils') {
		$player[$value]['bowlinginnings'][$counting]['opposition'] = 'Delhi Capitals';
	}
	

	if (!in_array($player[$value]['bowlinginnings'][$counting]['position'], $bowling_position_array)) {
            array_push($bowling_position_array, $player[$value]['bowlinginnings'][$counting]['position']);
        }
    if (!in_array($player[$value]['bowlinginnings'][$counting]['ground'], $venue_array)) {
            array_push($venue_array, $player[$value]['bowlinginnings'][$counting]['ground']);
        }


     if ($player[$value]['bowlinginnings'][$counting]['opposition'] == 'Rising Pune Supergiant') {
			$player[$value]['bowlinginnings'][$counting]['opposition'] = 'Rising Pune Supergiants';
		}

		if ($player[$value]['bowlinginnings'][$counting]['opposition'] == 'Delhi Daredevils') {
			$player[$value]['bowlinginnings'][$counting]['opposition'] = 'Delhi Capitals';
		}

	if (!in_array($player[$value]['bowlinginnings'][$counting]['opposition'], $opposition_array)) {
            array_push($opposition_array, $player[$value]['bowlinginnings'][$counting]['opposition']);
        }

    if (!in_array($year, $years_array)) {
            array_push($years_array, $year);
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

	

	
	}
		# code...
	$counting++; }}
		# code...
	

	if ($balls_bowled > 0) {
	  
	if ($wickets_taken > 0) {
		# code...
	
	$bowling_ave = $runs_conceded/ ($wickets_taken);
	$bowling_ave = floor($bowling_ave * 100) / 100;
$bowling_sr = $balls_bowled / $wickets_taken;
	$bowling_sr = floor($bowling_sr * 1) / 1; } 
	else {$bowling_ave= '-';
		$runs_conceded_least = 0;
		$bowling_sr = '-';
	}
	
	$ovr = floor($balls_bowled/6) + ($balls_bowled % 6) /10;
	$econ = $runs_conceded / $ovr;
	$econ = floor($econ * 100) / 100;
	
	if ($innings_bowled > $min - 1) {
	 
	$link =str_replace(" ","_",$value);
	
	$link = "http://localhost/ipl/player/{$link}";


	 echo " 
	<tr><td><a href='{$link}'>{$value}</a></td><td>{$innings_bowled}</td><td class='desktop'>{$balls_bowled}</td><td class='desktop'>{$maidens}</td><td class='desktop'>{$runs_conceded}</td><td>{$wickets_taken}</td><td class='desktop'>{$most_wickets}/{$runs_conceded_least}</td><td>{$bowling_ave}</td><td>{$econ}</td><td class='desktop'>{$bowling_sr}</td><td class='desktop'>{$zeros_conceded}</td><td class='desktop'>{$ones_conceded}</td><td class='desktop'>{$twos_conceded}</td><td class='desktop'>$threes_conceded</td><td class='desktop'>{$fours_conceded}</td><td class='desktop'>{$sixes_conceded}</td></tr>";} }

	
}


	?>
</tbody>
</table>
  <script type="text/javascript">

 $(function() {
  $("#myTable").tablesorter({ sortList: [[5,1]] });
});
  </script>
 <A NAME="stats">
<form <?php if (isset($filters)) {echo "class='hide'";} ?>action="<?php echo "http://localhost/ipl/iplbowlingstats.php"; ?>">
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

<?php  
//if (isset($bowling_position_array)) {
//	asort($bowling_position_array);

//foreach ($bowling_position_array as $key => $value) {
//	echo "<td><input type='checkbox' name='bowling_position[]' value='{$value}'> {$value}</td>";

//}}


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

<tr><th>Minimum Innings</th>
<?php  
 $min_innings_array = array(1,5,10,20,50,100,150);
foreach ($min_innings_array as $key => $value) {
	echo "<td><input type='radio' name='min_innings' value='{$value}'> {$value}</td>";

}


?>
</tr>

</table>
 <input type="submit" class="button" value="Filter"> 
</form>
</body>
</html>