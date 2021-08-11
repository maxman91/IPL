
<?php

require 'header.php';

?>


<!DOCTYPE html>
<html>
<head>
	<title>IPL Players -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="assets/t20.css">
  <meta name="description" content="Scores for every IPL match ever played.">
  
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<h2>IPL Players</h2>
<?php


        $search_query = mysqli_query($con, "SELECT * FROM player");
        while($row_search_player = mysqli_fetch_assoc($search_query)){
    	$name = str_replace(" ", "_", $row_search_player['name']);
	   echo "<a href='http://localhost/ipl/player/{$name}'>{$row_search_player['name']}</a> <br>";



}
            





 ?>



</body>
</html>