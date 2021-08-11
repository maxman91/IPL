
<?php

require 'header.php';

?>


<!DOCTYPE html>
<html>
<head>
	<title>IPL Matches -t20statsdump.com</title>
	<link rel="stylesheet" type="text/css" href="assets/t20.css">
  <meta name="description" content="Scores for every IPL match ever played.">
  
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<h2>IPL results</h2>
<h3>2019</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2019%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "http://localhost/ipl/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2018</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2018%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2017</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2017%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";
            

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2016</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2016%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2015</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2015%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2014</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2014%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2013</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2013%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2012</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2012%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2011</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2011%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2010</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2010%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2009</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2009%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>

<h3>2008</h3>
<?php


         $scorec_query = mysqli_query($con, "SELECT * FROM scorecard WHERE date like  '2008%'");

         while($row_scorecard = mysqli_fetch_assoc($scorec_query)){


    
        


            $link = "{$row_scorecard['result']}_{$row_scorecard['date']}";

            $link = str_replace(" ", "_", $link);

            $link = "https://www.t20statsdump.com/scorecard/{$link}";

           
           echo "<a href='{$link}'>{$row_scorecard['result']}</a> <br>";

           }
            





 ?>


</body>
</html>