<?php  


$q = 1178416; 
require_once "spyc.php";

while ($q <= 1181768) {
    # code...


$iplArray = Spyc::YAMLLoad("yaml/{$q}.yaml");



$city = $iplArray["info"]["city"];  
$competition = $iplArray["info"]["competition"];  

if (isset($iplArray["info"]["dates"][0])) {

$dates = $iplArray["info"]["dates"][0];  } 

else {$dates = $iplArray["info"][0]; }


if (isset($iplArray["info"]["outcome"]["by"]["runs"])) {
     $outcome = "won by {$iplArray["info"]["outcome"]["by"]["runs"]} runs"; 
 } 
if (isset($iplArray["info"]["outcome"]["by"]["wickets"])) {
     $outcome = "won by {$iplArray["info"]["outcome"]["by"]["wickets"]} wickets "; 
 } 

if (isset($iplArray["info"]["outcome"]["eliminator"])) {
     $outcome = "Match tied {$iplArray["info"]["outcome"]["eliminator"]} won the eliminator"; 
 } 

if (isset($iplArray["info"]["outcome"]["result"])) {
$outcome = $iplArray["info"]["outcome"]["result"];}


 
if (isset($iplArray["info"]["outcome"]["winner"])) {
$winner = $iplArray["info"]["outcome"]["winner"]; }

$overs = $iplArray["info"]["overs"];




if (isset($iplArray["info"]["player_of_match"][0])){
$player_of_match = $iplArray["info"]["player_of_match"][0];} 
elseif (isset($iplArray["info"]['3'])) {
    $player_of_match = $iplArray["info"][3];
}

else {$player_of_match = 'none';}

if (isset($iplArray["info"]["teams"][0])) {

$team1 = $iplArray["info"]["teams"][0];
$team2 = $iplArray["info"]["teams"][1];}
else {$team1 = $iplArray["info"][1];
      $team2 = $iplArray["info"][2]; }

$venue = $iplArray["info"]["city"];
$toss = $iplArray["info"]["toss"]["winner"];
$decision = $iplArray["info"]["toss"]["decision"];
$venues = $iplArray["info"]["city"];

$venues = str_replace("'","",$venues);

if (isset($winner)) {
	if($winner==$team1) {
	$loser = $team2;
} else {
	$loser = $team1;
}
}


if (isset($iplArray["innings"][0]["1st innings"]["team"])) {
$battingfirst = $iplArray["innings"][0]["1st innings"]["team"];}
else {
    $battingfirst = $iplArray[0]["1st innings"]["team"];
}

if (isset($iplArray["innings"][1]["2nd innings"]["team"])){

$battingsecond = $iplArray["innings"][1]["2nd innings"]["team"];}

elseif (isset($iplArray[1]["2nd innings"]["team"])) {
     $battingsecond = $iplArray[1]["2nd innings"]["team"];
 } 

if ($battingfirst == $team1) {
    $battingsecond = $team2;
} else {
    $battingsecond = $team1;
} 


    


//innings details

$legbyesFIRSTINNINGS = 0;
$byesFIRSTINNINGS = 0;
$widesFIRSTINNINGS = 0;
$nbFIRSTINNINGS=0;
$totalwicketsFIRSTINNINGS = 0;
$totalrunsFIRSTINNINGS = 0;
$totalballsFIRSTINNINGS = 0;

$batsmanFIRSTINNINGS = array( 

); 
 
$bowlerFIRSTINNINGS = array( 

); 

$fowFIRSTINNINGS = array( 

); 


//details for the loops


if (isset($iplArray["innings"][0]["1st innings"]["deliveries"])) {
    $deliveriesFIRSTINNINGS = $iplArray["innings"][0]["1st innings"]["deliveries"];
    $totaldeliveriesFIRSTINNINGS = array_keys($iplArray["innings"][0]["1st innings"]["deliveries"]);
} else {
    $deliveriesFIRSTINNINGS = $iplArray[0]["1st innings"];
    $totaldeliveriesFIRSTINNINGS = array_keys($iplArray[0]["1st innings"]);
}



//  create the batting order



for($i = 0; $i < count($totaldeliveriesFIRSTINNINGS); $i++){
	foreach($deliveriesFIRSTINNINGS[$totaldeliveriesFIRSTINNINGS[$i]] as $key => $value) {
    
        if (!in_array($value['batsman'], $batsmanFIRSTINNINGS)) {


            array_push($batsmanFIRSTINNINGS, $value['batsman']);
        }
       
    		
    	if (!in_array($value['non_striker'], $batsmanFIRSTINNINGS)) {
            array_push($batsmanFIRSTINNINGS, $value['non_striker']);
        }

        if (!in_array($value['bowler'], $bowlerFIRSTINNINGS)) {
            array_push($bowlerFIRSTINNINGS, $value['bowler']);
        }



        if (!empty($value["extras"]["legbyes"])){
                
        $legbyesFIRSTINNINGS = $legbyesFIRSTINNINGS + $value["extras"]["legbyes"]; }

        if (!empty($value["extras"]["byes"])){
                
        $byesFIRSTINNINGS = $byesFIRSTINNINGS + $value["extras"]["byes"]; }

        if (!empty($value["extras"]["wides"])){
                
        $widesFIRSTINNINGS = $widesFIRSTINNINGS + $value["extras"]["wides"]; }

        if (!empty($value["runs"]["total"])){
                
            $totalrunsFIRSTINNINGS = $totalrunsFIRSTINNINGS + $value["runs"]["total"]; }
        if (!empty($value["wicket"])){
                
            $totalwicketsFIRSTINNINGS = $totalwicketsFIRSTINNINGS + 1; }
                
        if (!empty($value["extras"]["noballs"])){
                
        $nbFIRSTINNINGS = $nbFIRSTINNINGS + 1; }


    }
}

//turn into multidimenional array

foreach ($batsmanFIRSTINNINGS as $key => $value) {
    $resulta[$key]['name'] = $value;
    $resulta[$key]['out'] = 'not out';
    $resulta[$key]['r'] = 0;
    $resulta[$key]['b'] = 0;
    $resulta[$key]['d'] = 0;
    $resulta[$key]['1s'] = 0;
    $resulta[$key]['2s'] = 0;
    $resulta[$key]['3s'] = 0;
    $resulta[$key]['4s'] = 0;
    $resulta[$key]['6s'] = 0;
    $resulta[$key]['SR'] = 0;
}
$batsmanFIRSTINNINGS=$resulta;


foreach ($bowlerFIRSTINNINGS as $key => $value) {
    $resultb[$key]['name'] = $value;
    $resultb[$key]['wickets'] = 0;
    $resultb[$key]['r'] = 0;
    $resultb[$key]['b'] = 0;
    $resultb[$key]['d'] = 0;
    $resultb[$key]['1s'] = 0;
    $resultb[$key]['2s'] = 0;
    $resultb[$key]['3s'] = 0;
    $resultb[$key]['4s'] = 0;
    $resultb[$key]['6s'] = 0;
    $resultb[$key]['wd'] = 0;
    $resultb[$key]['nb'] = 0;
    $resultb[$key]['m'] = 0;
    $resultb[$key]['economy'] = 0;
    $resultb[$key]['o'] = 0;
}
$bowlerFIRSTINNINGS=$resultb;

$currentbowler = "";
$maidencount = 0;

//inserting stats

for($i = 0; $i < count($totaldeliveriesFIRSTINNINGS); $i++){
    foreach($deliveriesFIRSTINNINGS[$totaldeliveriesFIRSTINNINGS[$i]] as $key => $value) {
    
    if ($currentbowler != $value['bowler']) {
    	$currentbowler = $value['bowler']; 
    	$maidencount = 0; 

    }

    $battingorder = array_search($value['batsman'], array_column($batsmanFIRSTINNINGS, 'name'));
    $bowlingorder = array_search($value['bowler'], array_column($bowlerFIRSTINNINGS, 'name'));

    $battingordernonsr = array_search($value['non_striker'], array_column($batsmanFIRSTINNINGS, 'name'));

    $batsmanFIRSTINNINGS[$battingorder]["r"] = $value["runs"]["batsman"] + $batsmanFIRSTINNINGS[$battingorder]["r"];
    $bowlerFIRSTINNINGS[$bowlingorder]["r"] = $value["runs"]["batsman"] + $bowlerFIRSTINNINGS[$bowlingorder]["r"];
    if (empty($value["extras"]["wides"])) {
        $batsmanFIRSTINNINGS[$battingorder]["b"] = $batsmanFIRSTINNINGS[$battingorder]["b"] + 1;
    if (empty($value["extras"]["noballs"])) {
        $bowlerFIRSTINNINGS[$bowlingorder]["b"] = $bowlerFIRSTINNINGS[$bowlingorder]["b"] + 1;
        $bowlerFIRSTINNINGS[$bowlingorder]["o"] = $bowlerFIRSTINNINGS[$bowlingorder]["o"] + .1;
        
    }}
    if (empty($value["extras"]["wides"])) {
        if (empty($value["extras"]["noballs"])) {
        	$totalballsFIRSTINNINGS = $totalballsFIRSTINNINGS + 1;
    if ($value["runs"]["batsman"]== 0) {
         $batsmanFIRSTINNINGS[$battingorder]["d"] = $batsmanFIRSTINNINGS[$battingorder]["d"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["d"] = $bowlerFIRSTINNINGS[$bowlingorder]["d"] + 1;
         $maidencount = $maidencount + 1; 


    }}}



    if ($value["runs"]["batsman"]==1) {
         $batsmanFIRSTINNINGS[$battingorder]["1s"] = $batsmanFIRSTINNINGS[$battingorder]["1s"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["1s"] = $bowlerFIRSTINNINGS[$bowlingorder]["1s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==2) {
         $batsmanFIRSTINNINGS[$battingorder]["2s"] = $batsmanFIRSTINNINGS[$battingorder]["2s"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["2s"] = $bowlerFIRSTINNINGS[$bowlingorder]["2s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==3) {
         $batsmanFIRSTINNINGS[$battingorder]["3s"] = $batsmanFIRSTINNINGS[$battingorder]["3s"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["3s"] = $bowlerFIRSTINNINGS[$bowlingorder]["3s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==4) {
         $batsmanFIRSTINNINGS[$battingorder]["4s"] = $batsmanFIRSTINNINGS[$battingorder]["4s"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["4s"] = $bowlerFIRSTINNINGS[$bowlingorder]["4s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==6) {
         $batsmanFIRSTINNINGS[$battingorder]["6s"] = $batsmanFIRSTINNINGS[$battingorder]["6s"] + 1;
         $bowlerFIRSTINNINGS[$bowlingorder]["6s"] = $bowlerFIRSTINNINGS[$bowlingorder]["6s"] + 1;
         $maidencount = 7;
    }

    if (!empty($value["wicket"])) {

        if ($value["wicket"]["kind"]=="hit wicket"){
            $batsmanFIRSTINNINGS[$battingorder]["out"] = "hit wicket b  {$value["bowler"]}";
            $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
        }
        
        if ($value["wicket"]["kind"]=="caught"){
                    if (isset($value["wicket"]["fielders"][0])) {
                        $batsmanFIRSTINNINGS[$battingorder]["out"] = "c  {$value["wicket"]["fielders"][0]} b  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
                    } else {
                        $batsmanFIRSTINNINGS[$battingorder]["out"] = "c  {$value["wicket"][0]} b  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
                    }
                    
                
        }
        if ($value["wicket"]["kind"]=="bowled"){
                    $batsmanFIRSTINNINGS[$battingorder]["out"] = "b  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
        }
        if ($value["wicket"]["kind"]=="lbw"){
                    $batsmanFIRSTINNINGS[$battingorder]["out"] = "lbw  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
        }
        if ($value["wicket"]["kind"]=="caught and bowled"){
                    $batsmanFIRSTINNINGS[$battingorder]["out"] = "c & b {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
                    
        }
        if ($value["wicket"]["kind"]=="stumped"){
                    if (isset($value["wicket"]["fielders"][0])) {
                        $batsmanFIRSTINNINGS[$battingorder]["out"] = "st  {$value["wicket"]["fielders"][0]} b  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
                    } else {
                        $batsmanFIRSTINNINGS[$battingorder]["out"] = "st  {$value["wicket"][0]} b  {$value["bowler"]}";
                    $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
                    }
                    
        }
        if ($value["wicket"]["kind"]=="obstructing the field"){
                    if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingorder]['name']) {
        		$batsmanFIRSTINNINGS[$battingorder]["out"] = "obstructing the field";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingordernonsr]['name']) {
        		$batsmanFIRSTINNINGS[$battingordernonsr]["out"] = "obstructing the field";
        	}
                    
        }
        if ($value["wicket"]["kind"]=="hit the ball twice"){
                    $batsmanFIRSTINNINGS[$battingorder]["out"] = "hit the ball twice";
        }
        if ($value["wicket"]["kind"]=="retired hurt"){
                    if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingorder]['name']) {
        		$batsmanFIRSTINNINGS[$battingorder]["out"] = "retired hurt";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingordernonsr]['name']) {
        		$batsmanFIRSTINNINGS[$battingordernonsr]["out"] = "retired hurt";
        	}
        }
        if ($value["wicket"]["kind"]=="handled the ball"){
                    $batsmanFIRSTINNINGS[$battingorder]["out"] = "handled the ball";
        }
        if ($value["wicket"]["kind"]=="timed out"){
                    if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingorder]['name']) {
        		$batsmanFIRSTINNINGS[$battingorder]["out"] = "timed out";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingordernonsr]['name']) {
        		$batsmanFIRSTINNINGS[$battingordernonsr]["out"] = "timed out";
        	}
        }
        if ($value["wicket"]["kind"]=="run out"){
        	if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingorder]['name']) {
        		$batsmanFIRSTINNINGS[$battingorder]["out"] = "run out";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanFIRSTINNINGS[$battingordernonsr]['name']) {
        		$batsmanFIRSTINNINGS[$battingordernonsr]["out"] = "run out";
        	}


                    
        }

    }
    if (!empty($value["extras"]["wides"])) {
                $bowlerFIRSTINNINGS[$bowlingorder]["r"] = $value["extras"]["wides"] + $bowlerFIRSTINNINGS[$bowlingorder]["r"];
                $bowlerFIRSTINNINGS[$bowlingorder]["wd"] = 1 + $bowlerFIRSTINNINGS[$bowlingorder]["wd"];
                $maidencount = 7;
            }
            if (!empty($value["extras"]["noballs"])) {
                $bowlerFIRSTINNINGS[$bowlingorder]["r"] = 1 + $bowlerFIRSTINNINGS[$bowlingorder]["r"];
                $bowlerFIRSTINNINGS[$bowlingorder]["nb"] = 1 + $bowlerFIRSTINNINGS[$bowlingorder]["nb"];
                $maidencount = 7;
            }



       if ($batsmanFIRSTINNINGS[$battingorder]["b"] > 0) {
           # code...
       

       $batsmanFIRSTINNINGS[$battingorder]["SR"] = $batsmanFIRSTINNINGS[$battingorder]["r"] * 100 / $batsmanFIRSTINNINGS[$battingorder]["b"];

       }


       
       $bowlerFIRSTINNINGS[$bowlingorder]['o'] = 	floor($bowlerFIRSTINNINGS[$bowlingorder]['b']/6) + ($bowlerFIRSTINNINGS[$bowlingorder]['b'] % 6) /10;
       if ($bowlerFIRSTINNINGS[$bowlingorder]['o'] > 0) {
       $bowlerFIRSTINNINGS[$bowlingorder]['economy'] = $bowlerFIRSTINNINGS[$bowlingorder]['r'] / $bowlerFIRSTINNINGS[$bowlingorder]['o'];}



       if ($maidencount == 6) {
       	$bowlerFIRSTINNINGS[$bowlingorder]['m'] = $bowlerFIRSTINNINGS[$bowlingorder]['m'] + 1;
       	$maidencount = 0;
       }




    
    }
}
$totalextrasFIRSTINNINGS = $legbyesFIRSTINNINGS + $byesFIRSTINNINGS + $widesFIRSTINNINGS + $nbFIRSTINNINGS;
$totaloversFIRSTINNINGS = floor($totalballsFIRSTINNINGS/6) + ($totalballsFIRSTINNINGS % 6) /10;






foreach ($batsmanFIRSTINNINGS as $key => $value) {
    $sr = floor($value['SR'] * 100) / 100;

    

    
}




foreach ($bowlerFIRSTINNINGS as $key => $value) {
    if (isset($value["economy"])) {
        # code...
    
    $sr = floor($value["economy"] * 100) / 100;}
 if (isset($value["o"])) {
     # code...
 	$ovr = floor($value["o"] * 10) / 10;
    if ($value["o"]>0) {
        
    }}
    

    
}




////////////////2ND INNINGS START
if (isset($battingsecond)){
$legbyesSECONDINNINGS = 0;
$byesSECONDINNINGS = 0;
$widesSECONDINNINGS = 0;
$nbSECONDINNINGS=0;
$totalwicketsSECONDINNINGS = 0;
$totalrunsSECONDINNINGS = 0;
$totalballsSECONDINNINGS = 0;

$batsmanSECONDINNINGS = array( 

); 
 
$bowlerSECONDINNINGS = array( 

); 






//details for the loops
if (isset($iplArray["innings"][1]["2nd innings"]["deliveries"])) {
    $deliveriesSECONDINNINGS = $iplArray["innings"][1]["2nd innings"]["deliveries"];
    $totaldeliveriesSECONDINNINGS = array_keys($iplArray["innings"][1]["2nd innings"]["deliveries"]);
} else {
    $deliveriesSECONDINNINGS = $iplArray[1]["2nd innings"];
    $totaldeliveriesSECONDINNINGS = array_keys($iplArray[1]["2nd innings"]);
}


//  create the batting order

for($i = 0; $i < count($totaldeliveriesSECONDINNINGS); $i++){
    foreach($deliveriesSECONDINNINGS[$totaldeliveriesSECONDINNINGS[$i]] as $key => $value) {
    
        if (!in_array($value['batsman'], $batsmanSECONDINNINGS)) {


            array_push($batsmanSECONDINNINGS, $value['batsman']);
        }
       
            
        if (!in_array($value['non_striker'], $batsmanSECONDINNINGS)) {
            array_push($batsmanSECONDINNINGS, $value['non_striker']);
        }

        if (!in_array($value['bowler'], $bowlerSECONDINNINGS)) {
            array_push($bowlerSECONDINNINGS, $value['bowler']);
        }



        if (!empty($value["extras"]["legbyes"])){
                
        $legbyesSECONDINNINGS = $legbyesSECONDINNINGS + $value["extras"]["legbyes"]; }

        if (!empty($value["extras"]["byes"])){
                
        $byesSECONDINNINGS = $byesSECONDINNINGS + $value["extras"]["byes"]; }

        if (!empty($value["extras"]["wides"])){
                
        $widesSECONDINNINGS = $widesSECONDINNINGS + $value["extras"]["wides"]; }

        if (!empty($value["runs"]["total"])){
                
            $totalrunsSECONDINNINGS = $totalrunsSECONDINNINGS + $value["runs"]["total"]; }
        if (!empty($value["wicket"])){
                
            $totalwicketsSECONDINNINGS = $totalwicketsSECONDINNINGS + 1; }
                
        if (!empty($value["extras"]["noballs"])){
                
        $nbSECONDINNINGS = $nbSECONDINNINGS + 1; }


    }
}

//turn into multidimenional array

foreach ($batsmanSECONDINNINGS as $key => $value) {
    $resultc[$key]['name'] = $value;
    $resultc[$key]['out'] = 'not out';
    $resultc[$key]['r'] = 0;
    $resultc[$key]['b'] = 0;
    $resultc[$key]['d'] = 0;
    $resultc[$key]['1s'] = 0;
    $resultc[$key]['2s'] = 0;
    $resultc[$key]['3s'] = 0;
    $resultc[$key]['4s'] = 0;
    $resultc[$key]['6s'] = 0;
    $resultc[$key]['SR'] = 0;
}
$batsmanSECONDINNINGS=$resultc;


foreach ($bowlerSECONDINNINGS as $key => $value) {
    $resultd[$key]['name'] = $value;
    $resultd[$key]['wickets'] = 0;
    $resultd[$key]['r'] = 0;
    $resultd[$key]['b'] = 0;
    $resultd[$key]['d'] = 0;
    $resultd[$key]['1s'] = 0;
    $resultd[$key]['2s'] = 0;
    $resultd[$key]['3s'] = 0;
    $resultd[$key]['4s'] = 0;
    $resultd[$key]['6s'] = 0;
    $resultd[$key]['wd'] = 0;
    $resultd[$key]['nb'] = 0;
    $resultd[$key]['m'] = 0;
    $resultd[$key]['economy'] = 0;
    $resultd[$key]['o'] = 0;
}
$bowlerSECONDINNINGS=$resultd;





//inserting stats

for($i = 0; $i < count($totaldeliveriesSECONDINNINGS); $i++){
    foreach($deliveriesSECONDINNINGS[$totaldeliveriesSECONDINNINGS[$i]] as $key => $value) {

    if ($currentbowler != $value['bowler']) {
    	$currentbowler = $value['bowler']; 
    	$maidencount = 0; 

    }
    

    $battingorder = array_search($value['batsman'], array_column($batsmanSECONDINNINGS, 'name'));
    $bowlingorder = array_search($value['bowler'], array_column($bowlerSECONDINNINGS, 'name'));
    $battingordernonsr = array_search($value['non_striker'], array_column($batsmanSECONDINNINGS, 'name'));

    $batsmanSECONDINNINGS[$battingorder]["r"] = $value["runs"]["batsman"] + $batsmanSECONDINNINGS[$battingorder]["r"];
    $bowlerSECONDINNINGS[$bowlingorder]["r"] = $value["runs"]["batsman"] + $bowlerSECONDINNINGS[$bowlingorder]["r"];
    if (empty($value["extras"]["wides"])) {
        $batsmanSECONDINNINGS[$battingorder]["b"] = $batsmanSECONDINNINGS[$battingorder]["b"] + 1;
    if (empty($value["extras"]["noballs"])) {
        $bowlerSECONDINNINGS[$bowlingorder]["b"] = $bowlerSECONDINNINGS[$bowlingorder]["b"] + 1;
        $bowlerSECONDINNINGS[$bowlingorder]["o"] = $bowlerSECONDINNINGS[$bowlingorder]["o"] + .1;

        
    }}
    if (empty($value["extras"]["wides"])) {
        if (empty($value["extras"]["noballs"])) {
        	$totalballsSECONDINNINGS = $totalballsSECONDINNINGS + 1;
    if ($value["runs"]["batsman"] == 0) {

         $batsmanSECONDINNINGS[$battingorder]["d"] = $batsmanSECONDINNINGS[$battingorder]["d"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["d"] = $bowlerSECONDINNINGS[$bowlingorder]["d"] + 1;
         $maidencount = $maidencount + 1;
    }}}
    if ($value["runs"]["batsman"]==1) {
         $batsmanSECONDINNINGS[$battingorder]["1s"] = $batsmanSECONDINNINGS[$battingorder]["1s"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["1s"] = $bowlerSECONDINNINGS[$bowlingorder]["1s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==2) {
         $batsmanSECONDINNINGS[$battingorder]["2s"] = $batsmanSECONDINNINGS[$battingorder]["2s"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["2s"] = $bowlerSECONDINNINGS[$bowlingorder]["2s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==3) {
         $batsmanSECONDINNINGS[$battingorder]["3s"] = $batsmanSECONDINNINGS[$battingorder]["3s"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["3s"] = $bowlerSECONDINNINGS[$bowlingorder]["3s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==4) {
         $batsmanSECONDINNINGS[$battingorder]["4s"] = $batsmanSECONDINNINGS[$battingorder]["4s"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["4s"] = $bowlerSECONDINNINGS[$bowlingorder]["4s"] + 1;
         $maidencount = 7;
    }
    if ($value["runs"]["batsman"]==6) {
         $batsmanSECONDINNINGS[$battingorder]["6s"] = $batsmanSECONDINNINGS[$battingorder]["6s"] + 1;
         $bowlerSECONDINNINGS[$bowlingorder]["6s"] = $bowlerSECONDINNINGS[$bowlingorder]["6s"] + 1;
         $maidencount = 7;
    }

    if (!empty($value["wicket"])) {

        if ($value["wicket"]["kind"]=="hit wicket"){
            $batsmanSECONDINNINGS[$battingorder]["out"] = "hit wicket b  {$value["bowler"]}";
            $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerFIRSTINNINGS[$bowlingorder]["wickets"] + 1;
        }
        
        if ($value["wicket"]["kind"]=="caught"){
                          if (isset($value["wicket"]["fielders"][0])) {
                        $batsmanSECONDINNINGS[$battingorder]["out"] = "c  {$value["wicket"]["fielders"][0]} b  {$value["bowler"]}";
                        $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
                    } else {
                        $batsmanSECONDINNINGS[$battingorder]["out"] = "c  {$value["wicket"][0]} b  {$value["bowler"]}";
                        $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
                    }
        }
        if ($value["wicket"]["kind"]=="bowled"){
                    $batsmanSECONDINNINGS[$battingorder]["out"] = "b {$value["bowler"]}";
                    $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
        }
        if ($value["wicket"]["kind"]=="lbw"){
                    $batsmanSECONDINNINGS[$battingorder]["out"] = "lbw {$value["bowler"]}";
                    $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
        }

        if ($value["wicket"]["kind"]=="caught and bowled"){
                    $batsmanSECONDINNINGS[$battingorder]["out"] = "c & b {$value["bowler"]}";
                    $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
        }
        if ($value["wicket"]["kind"]=="stumped"){
                    if (isset($value["wicket"]["fielders"][0])) {
                        $batsmanSECONDINNINGS[$battingorder]["out"] = "st  {$value["wicket"]["fielders"][0]} b  {$value["bowler"]}";
                        $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
                    } else {
                        $batsmanSECONDINNINGS[$battingorder]["out"] = "st  {$value["wicket"][0]} b  {$value["bowler"]}";
                        $bowlerSECONDINNINGS[$bowlingorder]["wickets"] = $bowlerSECONDINNINGS[$bowlingorder]["wickets"] + 1;
                    }
        }
        if ($value["wicket"]["kind"]=="obstructing the field"){
                     if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingorder]['name']) {
        		$batsmanSECONDINNINGS[$battingorder]["out"] = "obstructing the field";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingordernonsr]['name']) {
        		$batsmanSECONDINNINGS[$battingordernonsr]["out"] = "obstructing the field";
        	}


        }
        if ($value["wicket"]["kind"]=="hit the ball twice"){
                    $batsmanSECONDINNINGS[$battingorder]["out"] = "hit the ball twice";
        }
        if ($value["wicket"]["kind"]=="retired hurt"){
                    if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingorder]['name']) {
        		$batsmanSECONDINNINGS[$battingorder]["out"] = "retired hurt";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingordernonsr]['name']) {
        		$batsmanSECONDINNINGS[$battingordernonsr]["out"] = "retired hurt";
        	}
        }
        if ($value["wicket"]["kind"]=="handled the ball"){
                    $batsmanSECONDINNINGS[$battingorder]["out"] = "handled the ball";
        }
        if ($value["wicket"]["kind"]=="timed out"){
                    if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingorder]['name']) {
        		$batsmanSECONDINNINGS[$battingorder]["out"] = "timed out";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingordernonsr]['name']) {
        		$batsmanSECONDINNINGS[$battingordernonsr]["out"] = "timed out";
        	}
        }
       if ($value["wicket"]["kind"]=="run out"){
        	if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingorder]['name']) {
        		$batsmanSECONDINNINGS[$battingorder]["out"] = "run out";
        	}
        	if ($value["wicket"]["player_out"] == $batsmanSECONDINNINGS[$battingordernonsr]['name']) {
        		$batsmanSECONDINNINGS[$battingordernonsr]["out"] = "run out";
        	}
        	
        	
                    
        }

    }
    if (!empty($value["extras"]["wides"])) {
                $bowlerSECONDINNINGS[$bowlingorder]["r"] = $value["extras"]["wides"] + $bowlerSECONDINNINGS[$bowlingorder]["r"];
                $bowlerSECONDINNINGS[$bowlingorder]["wd"] = 1 + $bowlerSECONDINNINGS[$bowlingorder]["wd"];
                $maidencount = 7;
            }
            if (!empty($value["extras"]["noballs"])) {
                $bowlerSECONDINNINGS[$bowlingorder]["r"] = 1 + $bowlerSECONDINNINGS[$bowlingorder]["r"];
                $bowlerSECONDINNINGS[$bowlingorder]["nb"] = 1 + $bowlerSECONDINNINGS[$bowlingorder]["nb"];
                $maidencount = 7;
            }



       if ($batsmanSECONDINNINGS[$battingorder]["b"] > 0) {
           # code...
       

       $batsmanSECONDINNINGS[$battingorder]["SR"] = $batsmanSECONDINNINGS[$battingorder]["r"] * 100 / $batsmanSECONDINNINGS[$battingorder]["b"];

       }



       $bowlerSECONDINNINGS[$bowlingorder]['o'] = 	floor($bowlerSECONDINNINGS[$bowlingorder]['b']/6) + ($bowlerSECONDINNINGS[$bowlingorder]['b'] % 6) /10;	
       if ($bowlerSECONDINNINGS[$bowlingorder]['o'] > 0) {
       $bowlerSECONDINNINGS[$bowlingorder]['economy'] = $bowlerSECONDINNINGS[$bowlingorder]['r'] / $bowlerSECONDINNINGS[$bowlingorder]['o'];}



       if ($maidencount == 6) {
       	$bowlerSECONDINNINGS[$bowlingorder]['m'] = $bowlerFIRSTINNINGS[$bowlingorder]['m'] + 1;
       	$maidencount = 0;
       }



       	




    
    }
}
$totalextrasSECONDINNINGS = $legbyesSECONDINNINGS + $byesSECONDINNINGS + $widesSECONDINNINGS + $nbSECONDINNINGS;

$totaloversSECONDINNINGS = floor($totalballsSECONDINNINGS/6) + ($totalballsSECONDINNINGS % 6) /10;






foreach ($batsmanSECONDINNINGS as $key => $value) {
    $sr = floor($value['SR'] * 100) / 100;

    if ($value['b']>0) {

    
}}





foreach ($bowlerSECONDINNINGS as $key => $value) {
    if (isset($value["economy"])) {
        # code...
    
    $sr = floor($value["economy"] * 100) / 100;}
 if (isset($value["o"])) {
     # code...
 	$ovr = floor($value["o"] * 10) / 10;
    if ($value["o"]>0) {
        
    }}
    

    }
}





//establish connection
$con = mysqli_connect("localhost", "root", "", "t20");
//prevent duplicate data
 $result = mysqli_query($con,"SELECT * FROM scorecard WHERE matchid='$q'");
 $numrows = mysqli_num_rows($result);
 
 $firstinningsstatline = "{$totalrunsFIRSTINNINGS}/{$totalwicketsFIRSTINNINGS} in {$totaloversFIRSTINNINGS} extras:{$totalextrasFIRSTINNINGS}(legbyes:{$legbyesFIRSTINNINGS}, byes:{$byesFIRSTINNINGS}, wides:{$widesFIRSTINNINGS}, noballs:{$nbFIRSTINNINGS})";

 $secondinningsstatline = "{$totalrunsSECONDINNINGS}/{$totalwicketsSECONDINNINGS} in {$totaloversSECONDINNINGS} extras:{$totalextrasSECONDINNINGS}(legbyes:{$legbyesSECONDINNINGS}, byes:{$byesSECONDINNINGS}, wides:{$widesSECONDINNINGS}, noballs:{$nbSECONDINNINGS})";
$tosses = "{$toss} won the toss and elected to {$decision}";

    if (isset($iplArray["info"]["outcome"]["eliminator"])) {
    	$result = "{$team1} tied {$team2}";
    } elseif (isset($winner)) {
    	$result = "{$winner} beat {$loser} {$outcome}";
    }

    else {
    	$result = "{$team1} {$team2} no result";
	}

  



if (isset($dates)) {

//insertdata
if ($numrows == 0) {
 $query = mysqli_query($con, "INSERT INTO scorecard VALUES ('', '$q', '$firstinningsstatline', '$secondinningsstatline', '$city', '$venues', '$dates', '$tosses', '$player_of_match', '$result')");

foreach ($batsmanFIRSTINNINGS as $key => $value) {
 
 	
 	$name = $value['name'];
 	$result = mysqli_query($con,"SELECT * FROM player WHERE name='$name'");
    $numrows = mysqli_num_rows($result);
    if ($numrows == 0) { 
        $sound = metaphone($name);
    	$query = mysqli_query($con, "INSERT INTO player VALUES ('','$name','$sound')");
    }

    if (!isset($battingsecond)){
    	if ($battingsecond == $team1) {
    		$battingsecond = $team2; 
    	} elseif ($battingsecond == $team2) {
    		$battingsecond = $team1;
    	}
    }
    $order = $key + 1;

    if (isset($winner)) {
    	# code...
    
    if ($battingfirst == $winner) {
    	$matchresult = 'won';
    } elseif ($battingfirst == $loser) {
    	$matchresult = 'lost';
    } }


    if (isset($iplArray["info"]["outcome"]["eliminator"])) {
    	$matchresult = 'tied';
    }



    if ($outcome == 'no result'){
    	$matchresult = 'no result';
    }

    $outarray = explode(" ", $value['out']);
    $method = $outarray['0'];

    $r = $value['r'];
     $b = $value['b'];
      $d = $value['d'];
       $ones = $value['1s'];
        $twos = $value['2s'];
        $threes = $value['3s'];
         $fours = $value['4s'];
          $sixes = $value['6s'];
           $out = $value['out'];
           

    $battingstatlineFIRSTINNINGS = "{$r},{$b},{$d},{$ones},{$twos},{$threes},{$fours},{$sixes}";

 	$query = mysqli_query($con, "INSERT INTO battinginnings VALUES ('','$name','$q','$battingstatlineFIRSTINNINGS','$out','1','$order','$matchresult','$battingfirst','$dates','$battingsecond','$venue')");


    

}

foreach ($batsmanSECONDINNINGS as $key => $value) {
 
 	
 	$name = $value['name'];
 	$result = mysqli_query($con,"SELECT * FROM player WHERE name='$name'");
    $numrows = mysqli_num_rows($result);
    if ($numrows == 0) { 
        $sound = metaphone($name);
    	$query = mysqli_query($con, "INSERT INTO player VALUES ('','$name')");
    }

    if (!isset($battingsecond)){
    	if ($battingsecond == $team1) {
    		$battingsecond = $team2; 
    	} elseif ($battingsecond == $team2) {
    		$battingsecond = $team1;
    	}
    }
    $order = $key + 1;
    
    if (isset($winner)) {
    	# code...
    

    if ($battingfirst == $winner) {
    	$matchresult = 'lost';
    } elseif ($battingfirst == $loser) {
    	$matchresult = 'won';
    }} 


    if (isset($iplArray["info"]["outcome"]["eliminator"])) {
    	$matchresult = 'tied';
    } 


    if ($outcome == 'no result'){
    	$matchresult = 'no result';
    }

    $outarray = explode(" ", $value['out']);
    $method = $outarray['0'];

    $r = $value['r'];
     $b = $value['b'];
      $d = $value['d'];
       $ones = $value['1s'];
        $twos = $value['2s'];
        $threes = $value['3s'];
         $fours = $value['4s'];
          $sixes = $value['6s'];
           $out = $value['out'];
            $battingstatlineSECOND = "{$r},{$b},{$d},{$ones},{$twos},{$threes},{$fours},{$sixes}";

 	$query = mysqli_query($con, "INSERT INTO battinginnings VALUES ('','$name','$q','$battingstatlineSECOND','$out','2','$order','$matchresult','$battingsecond','$dates','$battingfirst','$venue')");


    

}


		foreach ($bowlerFIRSTINNINGS as $key => $value) {
			$name = $value['name'];
 			$result = mysqli_query($con,"SELECT * FROM player WHERE name='$name'");
   			 $numrows = mysqli_num_rows($result);
    		if ($numrows == 0) { 
                $sound = metaphone($name);
    			$query = mysqli_query($con, "INSERT INTO player VALUES ('','$name')");
    		}
    		$order = $key + 1;
    		$w = $value['wickets'];
    		$r = $value['r'];
     		$b = $value['b'];
      		$d = $value['d'];
      		$m = $value['m'];
       		$ones = $value['1s'];
        	$twos = $value['2s'];
        	$threes = $value['3s'];
         	$fours = $value['4s'];
          	$sixes = $value['6s'];
           	$wd = $value['wd']; 
           	$nb = $value['nb'];
           	if ($battingfirst == $winner) {
    		$matchresult = 'lost';
    		} elseif ($battingfirst == $loser) {
    			$matchresult = 'won';
    		} elseif (isset($iplArray["info"]["outcome"]["eliminator"])) {
    			$matchresult = 'tied';
    			} 


    	if ($outcome == 'no result'){
    	$matchresult = 'no result';
    }


         $bowlingstatlinefirst = "{$w},{$r},{$b},{$d},{$m},{$ones},{$twos},{$threes},{$fours},{$sixes},{$wd},{$nb}";

    	$query = mysqli_query($con, "INSERT INTO bowlinginnings VALUES ('','$name','$q','$bowlingstatlinefirst','$dates','$matchresult','$venue','$battingsecond','1','$battingfirst','$order')");

		}

	foreach ($bowlerSECONDINNINGS as $key => $value) {
			$name = $value['name'];
 			$result = mysqli_query($con,"SELECT * FROM player WHERE name='$name'");
   			 $numrows = mysqli_num_rows($result);
    		if ($numrows == 0) { 
                $sound = metaphone($name);
    			$query = mysqli_query($con, "INSERT INTO player VALUES ('','$name')");
    		}
    		$order = $key + 1;
    		$w = $value['wickets'];
    		$r = $value['r'];
     		$b = $value['b'];
      		$d = $value['d'];
      		$m = $value['m'];
       		$ones = $value['1s'];
        	$twos = $value['2s'];
        	$threes = $value['3s'];
         	$fours = $value['4s'];
          	$sixes = $value['6s'];
           	$wd = $value['wd']; 
           	$nb = $value['nb'];
           	

           	if (isset($winner)) {
           		# code...
           	
           	if ($battingfirst == $winner) {
    		$matchresult = 'won';
    		} elseif ($battingfirst == $loser) {
    			$matchresult = 'lost';
    		}} 


    		if (isset($iplArray["info"]["outcome"]["eliminator"])) {
    			$matchresult = 'tied';
    			} 


    	if ($outcome == 'no result'){
    	$matchresult = 'no result';
    }
			$bowlingstatlinefirst = "{$w},{$r},{$b},{$d},{$m},{$ones},{$twos},{$threes},{$fours},{$sixes},{$wd},{$nb}";

    	$query = mysqli_query($con, "INSERT INTO bowlinginnings VALUES ('','$name','$q','$bowlingstatlinefirst','$dates','$matchresult','$venue','$battingfirst','2','$battingsecond','$order')");

		}


    }
}



                $q = $q + 1;
                if ($q == 336041) {
                                    $q = 392181;
                                        }
                if ($q == 392240) {
                    $q = 419106;
                }
                if ($q == 419166) {
                    $q = 501198;
                }
                if ($q == 501272) {
                    $q = 548306;
                }
                if ($q == 548382) {
                    $q = 597998;
                } 

                if ($q == 598074) {
                    $q = 729279;
                }
                if ($q == 729318) {
                    $q = 733971;
                }
                if ($q == 734050) {
                    $q = 829705;
                }
                if ($q == 829824) {
                    $q = 980901;
                }
                if ($q == 981020) {
                    $q = 1082591;
                }
                if ($q == 1082651) {
                    $q = 1136561;
                }

                if ($q == 1136621) {
                    $q = 1175356;
                }
                if ($q == 1175373) {
                    $q = 1178393;
                }
                if ($q == 1178432) {
                    $q = 1181764;
                }
}
?>