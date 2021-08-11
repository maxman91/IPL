<?php 
require 'headertwo.php';
if (isset($_GET['match'])) {
	$match_id = $_GET['match'];
	$scorecard_query = mysqli_query($con, "SELECT * FROM scorecard WHERE matchid='$match_id'");
	$scorecard_array = mysqli_fetch_array($scorecard_query);
	$scorecard = $scorecard_array['result'];
	$remove_array = array("won","by","runs","wickets","wicket");
	$scorecard = str_replace($remove_array,"",$scorecard);
	$scorecard = preg_replace('/[0-9]+/', '', $scorecard);
	$link = "{$scorecard}{$scorecard_array['date']}";
	$link = str_replace("    "," ",$link);
	$link = str_replace("  "," ",$link);
	$scorecard = str_replace(" ","_",$link);
	//$link = "https://www.t20statsdump.com/scorecard/{$scorecard}";
}

if (isset($scorecard)) {
	header("location:http://localhost/ipl/scorecard/{$scorecard}");
} else {
	header("location:http://localhost/ipl/");
	}
?>