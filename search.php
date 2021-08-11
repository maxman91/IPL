<?php 
require 'header.php';
if (isset($_GET['player_search'])) {
	# code...

$search = mysqli_real_escape_string($con, $_GET['player_search']);

//$search = metaphone($search);
}

$search_query = mysqli_query($con, "SELECT * FROM player WHERE name like '_%$search'");

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Search -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="assets/t20.css">
	<meta name="description" content="Search for any player thats ever played in the IPL.">
	
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
	<br>

<?php 
if (mysqli_num_rows($search_query)==0) { 

	echo "No result. Please try using players last name.";

	 }

while($row_search_player = mysqli_fetch_assoc($search_query)){
	$name = str_replace(" ", "_", $row_search_player['name']);
	echo "<a href='http://localhost/ipl/player/{$name}'>{$row_search_player['name']}</a> <br>";



}



?>

</body>
</html>