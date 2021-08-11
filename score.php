<?php  

require 'header.php';

if (isset($_GET['scorecard'])) {
	$scorecard = $_GET['scorecard'];
	$scorecard = str_replace("_"," ",$scorecard);
	
	$date = substr($scorecard, -10);

	$rivals = substr($scorecard, 0, -10);

	$scorecard_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date='$date' AND result like '$rivals%' OR result='$rivals'");
	$scorecard_array = mysqli_fetch_array($scorecard_query);

	$keynumber = $scorecard_array[1];

}




if (!isset($keynumber)){
	header("Location: http://localhost/ipl");
}

$batting_query = mysqli_query($con, "SELECT * FROM battinginnings WHERE matchid='$keynumber'");

while ($batting = mysqli_fetch_assoc($batting_query)) {
	$battinginnings[$batting['innings']][$batting['position']] = $batting;
}

$bowling_query = mysqli_query($con, "SELECT * FROM bowlinginnings WHERE matchid='$keynumber'");

while ($bowling = mysqli_fetch_assoc($bowling_query)) {
	$bowlinginnings[$bowling['innings']][$bowling['position']] = $bowling;
}




$results = explode("won", $scorecard_array[9]);
$victors = explode("beat", $results[0]);
$winner  = $victors[0];

if (isset($victors[1])) {
	# code...

$loser  = $victors[1];

$outcome = $results = explode(" ", $results[1]);







if ($outcome[2] == 1) {
	if ($outcome[3] == "runs") {
		
		$outcome[3] = "run";
		
	}
	if ($outcome[3] == "wickets") {
		
		$outcome[3] = "wicket";
		
	}
}

$outcome = "{$outcome[1]} {$outcome[2]} {$outcome[3]}";}



$teambattingfirst = $battinginnings[1][1]['team'];
$teambattingsecond = $battinginnings[2][1]['team'];
$firstinningstotal = explode(" ", $scorecard_array[2]);



$firstinningstotalruns = "{$firstinningstotal[0]} ({$firstinningstotal[2]})";
$firstinningstotal[3] = substr($firstinningstotal[3], 7);
$firstinningstotalextras = "{$firstinningstotal[3]} {$firstinningstotal[4]} {$firstinningstotal[5]} {$firstinningstotal[6]}";




$secondinningstotal = explode(" ", $scorecard_array[3]);



$secondinningstotalruns = "{$secondinningstotal[0]} ({$secondinningstotal[2]})";
$secondinningstotal[3] = substr($secondinningstotal[3], 7);
$secondinningstotalextras = "{$secondinningstotal[3]} {$secondinningstotal[4]} {$secondinningstotal[5]} {$secondinningstotal[6]}";

if (strpos($rivals, 'beat') == false) {
	if (strpos($rivals, 'tied') == false) {
    $rivals = 'No result';}
}
$rivalse =str_replace("won", "and won", $rivals);

?>


<!DOCTYPE html>
<html>
<head>
	<title><?php echo $rivals;?> -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="../assets/t20.css">
	<meta name="description" content="Detailed scorecard for when <?php echo $rivalse;?>">
	
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<div class="background">

<table class="battingcard">
	
	<tr><th colspan="11" style="text-align: center; background-color: #192a56;">
	<?php if (isset($outcome)) {
		# code...
	
		echo "{$winner} won {$outcome}"; }
	else { echo $rivals;}


	?></th></tr>
	<tr class="header"><th colspan="3"><?php echo "{$teambattingfirst} Innings";?></th><th colspan="5" class='desktop'></th><th colspan="3" style="text-align: right;"><?php echo $firstinningstotalruns;?></th></tr>
	<tr><th>Batsman</th><th></th><th>Runs</th><th>Balls</th><th>SR</th><th class='desktop'>0s</th><th class='desktop'>1s</th><th class='desktop'>2s</th><th class='desktop'>3s</th><th class='desktop'>4s</th><th class='desktop'>6s</th></tr>

<?php  
$i = 1;
while ( $i <= 11) {

	if (isset($battinginnings[1][$i])) {


	$statline = explode(",", $battinginnings[1][$i]['statline']);
	
	if (isset($statline[1])) {
		# code...
	

	if ($statline[1] > 0) {
		# code...
	

	$sr = $statline[0] * 100 / $statline[1];
	$sr = floor($sr * 100) / 100;

	$player =str_replace(" ","_",$battinginnings[1][$i]['name']);
	
	$link = "../player/{$player}";
	

	echo "<tr><td><a href='{$link}'>{$battinginnings[1][$i]['name']}</a></td><td>{$battinginnings[1][$i]['dissmissal']}</td><td>{$statline[0]}</td><td>{$statline[1]}</td><td>{$sr}</td><td class='desktop'>{$statline[2]}</td><td class='desktop'>{$statline[3]}</td><td class='desktop'>{$statline[4]}</td><td class='desktop'>{$statline[5]}</td><td class='desktop'>{$statline[6]}</td><td class='desktop'>{$statline[7]}</td></tr>";}}}
	
	
	$i++;
}
echo "<tr><td>Extras</td><td colspan='10' style='text-align: right;'>{$firstinningstotalextras}</td></tr>";
echo "</table><table class='bowlingcard'><tr><th>Bowler</th><th>O</th><th class='desktop'>M</th><th>R</th><th>W</th><th>E</th><th class='desktop'>Os</th><th class='desktop'>1s</th><th class='desktop'>2s</th><th class='desktop'>3s</th><th class='desktop'>4s</th><th class='desktop'>6s</th><th class='desktop'>WD</th><th class='desktop'>NB</th></tr>";
$i = 1;
while ( $i <= 11) {
if (isset($bowlinginnings[1][$i])) {
		# code...
	
	$statline = explode(",", $bowlinginnings[1][$i]['statline']);
if (isset($statline[2])) {
	# code...

	if ($statline[2] >0) {
		# code...
	
	$ovr = floor($statline[2]/6) + ($statline[2] % 6) /10;
	$sr = $statline[1] / $ovr;
	$sr = floor($sr * 100) / 100;

	$player =str_replace(" ","_",$bowlinginnings[1][$i]['name']);
	
	$link = "../player/{$player}";

	echo "<tr><td><a href ='{$link}'>{$bowlinginnings[1][$i]['name']}</a></td><td>{$ovr}</td><td class='desktop'>{$statline[4]}</td><td>{$statline[1]}</td><td>{$statline[0]}</td><td>{$sr}</td><td class='desktop'>{$statline[3]}</td><td class='desktop'>{$statline[5]}</td><td class='desktop'>{$statline[6]}</td><td class='desktop'>{$statline[7]}</td><td class='desktop'>{$statline[8]}</td><td class='desktop'>{$statline[9]}</td><td class='desktop'>{$statline[10]}</td><td class='desktop'>{$statline[11]}</td></tr>";
}}}

	
	$i++;
}

echo "</table><br>";
 ?>
 

<table class="battingcard">
	
	<tr class="header"><th colspan="3"><?php echo "{$teambattingsecond} Innings";?></th><th class='desktop' colspan="5"></th><th colspan="3" style="text-align: right;"><?php echo $secondinningstotalruns;?></th></tr>
	<tr><th>Batsman</th><th></th><th>Runs</th><th>Balls</th><th>SR</th><th class='desktop'>0s</th><th class='desktop'>1s</th><th class='desktop'>2s</th><th class='desktop'>3s</th><th class='desktop'>4s</th><th class='desktop'>6s</th></tr>

<?php  
$i = 1;
while ( $i <= 11) {

if (isset($battinginnings[2][$i])) {
	$statline = explode(",", $battinginnings[2][$i]['statline']);
	
	if (isset($statline[1])) {
		# code...
	

	if ($statline[1] > 0) {
		# code...
	

	$sr = $statline[0] * 100 / $statline[1];
	$sr = floor($sr * 100) / 100;
	 
	 $player =str_replace(" ","_",$battinginnings[2][$i]['name']);
	
	 $link = "../player/{$player}";

	

	echo "<tr><td><a href='{$link}'>{$battinginnings[2][$i]['name']}</a></td><td>{$battinginnings[2][$i]['dissmissal']}</td><td>{$statline[0]}</td><td>{$statline[1]}</td><td>{$sr}</td><td class='desktop'>{$statline[2]}</td><td class='desktop'>{$statline[3]}</td><td class='desktop'>{$statline[4]}</td><td class='desktop'>{$statline[5]}</td><td class='desktop'>{$statline[6]}</td><td class='desktop'>{$statline[7]}</td></tr>";}}}
	
	
	$i++;
}
echo "<tr><td>Extras</td><td colspan='10' style='text-align: right;'>{$secondinningstotalextras}</td></tr>";
echo "</table><table class='bowlingcard'><tr><th>Bowler</th><th>O</th><th class='desktop'>M</th><th>R</th><th>W</th><th>E</th><th class='desktop'>Os</th><th class='desktop'>1s</th><th class='desktop'>2s</th><th class='desktop'>3s</th><th class='desktop'>4s</th><th class='desktop'>6s</th><th class='desktop'>WD</th><th class='desktop'>NB</th></tr>";
$i = 1;
while ( $i <= 11) {

	
	if (isset($bowlinginnings[2][$i])) {
	
	$statline = explode(",", $bowlinginnings[2][$i]['statline']);
if (isset($statline[2])) {
	# code...

	if ($statline[2] >0) {
		# code...
	
	$ovr = floor($statline[2]/6) + ($statline[2] % 6) /10;
	$sr = $statline[1] / $ovr;
	$sr = floor($sr * 100) / 100;

	$player =str_replace(" ","_",$bowlinginnings[2][$i]['name']);
	
	 $link = "../player/{$player}";


	echo "<tr><td><a href='{$link}'>{$bowlinginnings[2][$i]['name']}</a></td><td>{$ovr}</td><td class='desktop'>{$statline[4]}</td><td>{$statline[1]}</td><td>{$statline[0]}</td><td>{$sr}</td><td class='desktop'>{$statline[3]}</td><td class='desktop'>{$statline[5]}</td><td class='desktop'>{$statline[6]}</td><td class='desktop'>{$statline[7]}</td><td class='desktop'>{$statline[8]}</td><td class='desktop'>{$statline[9]}</td><td class='desktop'>{$statline[10]}</td><td class='desktop'>{$statline[11]}</td></tr>";
}}}
	

	
	$i++;
}

echo "</table>";

echo "<table class='infocard'><tr><th colspan='2'>Match info</th></tr><tr><td>Toss</td><td>{$scorecard_array[7]}</td></tr><tr><td>City</td><td>{$scorecard_array[4]}</td></tr><tr><td>Date</td><td>{$scorecard_array[6]}</td></tr><tr><tr><td>Man of the Match</td><td>{$scorecard_array[8]}</td></tr>";



?>




</div>

</body>
</html>