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
		
		$batting_innings_query = mysqli_query($con, "SELECT * FROM battinginnings WHERE ({$filter})");
	} else {
	$batting_innings_query = mysqli_query($con, "SELECT * FROM battinginnings");}


while($row_batting_innings = mysqli_fetch_assoc($batting_innings_query))
{

$player[$row_batting_innings['name']]['battinginnings'][] = $row_batting_innings;
}






?>


<!DOCTYPE html>
<html>
<head>
	<title>IPL batting records -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="assets/t20.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/dragtable.mod.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Batting stats for the ipl.">
	
	<script src="assets/t20.js"></script>
	
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.min.js"></script> 
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.widgets.min.js"></script> 
</head>
<body>
    

    
	<h5 <?php if (isset($filters)) {echo "class='hide'";} ?>><A HREF="#stats">Jump to stats filters</A></h5>
	<h5 <?php if (!isset($filters)) {echo "class='hide'";} ?>><A HREF="http:localhost/ipl/iplbattingstats.php">Back to main stats page</A></h5>
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
	<tr style="font-weight: bold;"><td>Name ↕</td><td>Inn ↕</td><td class='desktop'>NO ↕</td><td>Runs ↕</td><td class='desktop'>HS ↕</td><td>Ave ↕</td><td class='desktop'>BF ↕</td><td>SR ↕</td><td class='desktop'>100s ↕</td><td class='desktop'>50s ↕</td><td class='desktop'>0s ↕</td><td class='desktop'>1s ↕</td><td class='desktop'>2s ↕</td><td class='desktop'>3s ↕</td><td class='desktop'>4s ↕</td><td class='desktop'>6s ↕</td></tr>
    </thead>
    <tbody>
<?php

	$counter =0;
$opposition_array = array();
		$years_array = array();
		$batting_position_array = array();
		$results_array = array("won","lost","tied","no result");
		$innings_array = array("1","2");
		$venue_array = array();
		$team_array = array();
foreach ($players as $key => $value) {
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
		
		


if (isset($player[$value]['battinginnings'])) {
	# code...

$innings_counter = count($player[$value]['battinginnings']);}
$counting = 0;
if (isset($innings_counter)) {
while ($counting <= $innings_counter) {
	if (isset($player[$value]['battinginnings'][$counting])) {
		# code...
	
	$statline = explode(",", $player[$value]['battinginnings'][$counting]['statline']);
	$runs_scored = $runs_scored + $statline[0];
	$balls_faced = $balls_faced + $statline[1];
	$zeros_scored = $zeros_scored + $statline[2];
	$ones_scored = $ones_scored + $statline[3];
	$twos_scored = $twos_scored + $statline[4];
	$threes_scored = $threes_scored + $statline[5];
	$fours_scored = $fours_scored + $statline[6];
	$sixes_scored = $sixes_scored + $statline[7];
	$year = substr($player[$value]['battinginnings'][$counting]['date'], -10, 4);
	if ($statline[1] > 0) {
		$innings_batted++;
		if ($player[$value]['battinginnings'][$counting]['team'] == 'Rising Pune Supergiant') {
			$player[$value]['battinginnings'][$counting]['team'] = 'Rising Pune Supergiants';
		}

		if ($player[$value]['battinginnings'][$counting]['team'] == 'Delhi Daredevils') {
			$player[$value]['battinginnings'][$counting]['team'] = 'Delhi Capitals';
		}
		if (!in_array($player[$value]['battinginnings'][$counting]['team'], $team_array)) {
            array_push($team_array, $player[$value]['battinginnings'][$counting]['team']);
        }
	}

	if ($statline[1] == 0) {
		
		if ($player[$value]['battinginnings'][$counting]['dissmissal'] !=='not out') {
		$innings_batted++;
	}
	}

	




	if ($player[$value]['battinginnings'][$counting]['opposition'] == 'Delhi Daredevils') {
		$player[$value]['battinginnings'][$counting]['opposition'] = 'Delhi Capitals';
	}
	if (!in_array($player[$value]['battinginnings'][$counting]['position'], $batting_position_array)) {
            array_push($batting_position_array, $player[$value]['battinginnings'][$counting]['position']);
        }
    if (!in_array($player[$value]['battinginnings'][$counting]['ground'], $venue_array)) {
            array_push($venue_array, $player[$value]['battinginnings'][$counting]['ground']);
        }


     

		

	if (!in_array($player[$value]['battinginnings'][$counting]['opposition'], $opposition_array)) {
            array_push($opposition_array, $player[$value]['battinginnings'][$counting]['opposition']);
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
		
	 if ($player[$value]['battinginnings'][$counting]['dissmissal'] == 'not out') {
		$not_outs = $not_outs + 1;
	}

     $batting_innings_array[$index] = $player[$value]['battinginnings'];}}
	$counting++;

}}
    
    if ($runs_scored >0) {
		if ($innings_batted-$not_outs != 0) {
			$batting_ave = $runs_scored / ($innings_batted-$not_outs);
			$batting_ave = floor($batting_ave * 100) / 100;
		} else {
			$batting_ave = "-";
		}
		
	
	$battingSR = $runs_scored * 100 / $balls_faced;
	$battingSR = floor($battingSR * 100) / 100;
	}

	if (!isset($battingSR)) {
		$battingSR = 0;
	    $batting_ave = 0;}
	if ($innings_batted > $min - 1) {
		# code...
	$link =str_replace(" ","_",$value);
	
	                         
	
	
	$link = "http://localhost/ipl/player/{$link}";

	 echo " 
	<tr><td><a href='{$link}'>{$value}</a></td><td>{$innings_batted}</td><td class='desktop'>{$not_outs}</td><td>{$runs_scored}</td><td class='desktop'>{$high_score}</td><td>{$batting_ave}</td><td class='desktop'>{$balls_faced}</td><td>{$battingSR}</td><td class='desktop'>{$centuries_scored}</td><td class='desktop'>{$fifties_scored}</td><td class='desktop'>{$zeros_scored}</td><td class='desktop'>{$ones_scored}</td><td class='desktop'>{$twos_scored}</td><td class='desktop'>$threes_scored</td><td class='desktop'>{$fours_scored}</td><td class='desktop'>{$sixes_scored}</td></tr>";}

	
}


	?>
</tbody>
</table>
  <script type="text/javascript">

 $(function() {
  $("#myTable").tablesorter({ sortList: [[3,1]] });
});
  </script>
 <A NAME="stats">
<form <?php if (isset($filters)) {echo "class='hide'";} ?>action="<?php echo "http://localhost/ipl/iplbattingstats.php"; ?>">
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