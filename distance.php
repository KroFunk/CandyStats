<?php
  require "resources/config.php";
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Candy Stats Distance Test</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link rel="stylesheet" href="resources/styles/style.css.php">
  <link rel="stylesheet" type="text/css" href="resources/styles/jquery.dataTables.dark.css">

</head>

<body>

<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Global Overview</div>
    <div class='menuButton'><img src="resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='team_calculator/'>Team Calculator</a><a href='config/'>Config Variables</a><a href='upload/'>Upload Log</a>|&nbsp;&nbsp;<a href='login/'>Login</a></div>  
  </div>

  <center>
    <h1>Distancce Test</h1>
    <p class='h1Subheading'>Distance Test</p>
  </center>

  <div style='padding:20px;'>
  <p>Provide a CSID in the URL to break down the XYZ co-ordinates</p>






  <?PHP
  if(isset($_GET['CSID'])) { //Check to make sure a value has been provided...in production this is really dangerous and stupid. 
    $queryString = "SELECT `CSID`, `Name` as `Killer`, `XYZ_1` as `KillerXYZ`, `Misc_2` as `Victim`, `XYZ_2` as `VictimXYZ` FROM `logdata` WHERE `CSID` = " . $_GET['CSID'];
    echo '<p style="color:#efce58">' . $queryString . '</p>';

    $Query = mysqli_query($con,$queryString);
    while($Result = mysqli_fetch_array($Query)){ //We are only getting a single result in this case, but the loop will still work and is 'future proof'
      echo 'Killer:' . ' ' . $Result['Killer'] . '<br>';
      //We know the whole coordinate is in 'KillerXYZ'
      $KillerXYZ = explode(' ',$Result['KillerXYZ']); //This turns a string into an array
      echo 'X:' . ' ' . $KillerXYZ[0] . '<br>'; //We know the first part is X
      echo 'Y:' . ' ' . $KillerXYZ[1] . '<br>'; //The second is Y and so on. 
      echo 'Z:' . ' ' . $KillerXYZ[2] . '<br>';

      echo '<br><br>';

      echo 'Victim:' . ' ' . $Result['Victim'] . '<br>'; //Victim works the exact same way!
      $VictimXYZ = explode(' ',$Result['VictimXYZ']); 
      echo 'X:' . ' ' . $VictimXYZ[0] . '<br>';
      echo 'Y:' . ' ' . $VictimXYZ[1] . '<br>'; 
      echo 'Z:' . ' ' . $VictimXYZ[2] . '<br>';
	  
	  echo '<br><br>';
	  
	  echo 'Distance:' . ' ' . NUMBER_FORMAT(ABS((((($VictimXYZ[0] - $KillerXYZ[0]) * 2 + ($VictimXYZ[1] - $KillerXYZ[1]) * 2 + ($VictimXYZ[2] - $KillerXYZ[2]) * 2) / 2)*0.01904)),2) . ' ' . 'm';
    }
  } else {
      echo 'No CSID? No Go!';
      echo '<form method="GET"><input type="text" name="CSID" /><input type="submit" value="submit" /></form>';
  }
  
  ?>









  </div>
<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>

<!-- yes, this script is supposed to be down here! http://krofunk.github.io/LightBox/ -->
<script type="text/javascript" src="resources/js/lightbox.wrapper.js"></script>
</body>

</html>