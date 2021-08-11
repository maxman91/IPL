<?php 
require 'header.php';
$scorecard = array();


$scorecard_query = mysqli_query($con, "SELECT * FROM scorecard");



while($row_scorecard = mysqli_fetch_assoc($scorecard_query)){
        array_push($scorecard, $row_scorecard['matchid']);


    }


$player = array();

$player_query = mysqli_query($con, "SELECT * FROM player");

while($row_player = mysqli_fetch_assoc($player_query)){
        array_push($player, $row_player['name']);


    }
$i=0;
switch ($i) {
    case 0:
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
    case 2:
        echo "i equals 2";
}
?>





<!DOCTYPE html>
<html>
<head>
    <title>t20statsdump.com</title>
    <link rel="stylesheet" type="text/css" href="assets/t20.css">
    <meta name="description" content="A place to find detailed, filterable stats for the IPl.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="google-site-verification" content="HniqUpFP4bTkrcnE8KKkMlNpmHR4TKU1vGiJ_AUw08Q" />
</head>
<body>
   


<h4><a href="http://localhost/ipl/iplplayers.php">IPL Players</a></h4>

<h4><a href="http://localhost/ipl/iplbattingstats.php">IPL Batting stats</a></h4>

<h4><a href="http://localhost/ipl/iplbowlingstats.php">IPL Bowling stats</a></h4>

 <h4><a href="http://localhost/ipl/iplmatches.php">IPL scorecards</a></h4>





</body>
</html>