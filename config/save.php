<?php
require('../resources/config.php');
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>CandyStats : Config</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link rel="stylesheet" href="../resources/styles/style.css.php">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="../resources/js/scripts.js?random=<?php echo rand(0,10000); ?>"></script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Config Variables</div>
    <div class='menuButton'><img src="../resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='../team_calculator/'>Team Calculator</a><a href='../config/'>Config Variables</a><a href='../upload/'>Upload Log</a>|&nbsp;&nbsp;<a href='../login/'>Login</a></div>  
  </div>

  <div id='PleaseWait' style='display:none;'>
        <p>Please wait while the magic happens...</p>
        <img src='../resources/images/UI/please_wait.gif' />
  </div>

  <?php 
    if(isset($_POST['save'])) {
      /*
      foreach ($_POST as $key => $value) {
            $output .=  "&#36;_POST['";
            $output .=  $key;
            $output .=  "'] ";
            $output .=  $value;
            $output .=  "<br>";
        }
      echo $output;
      */
    
      $updateQueryString = "UPDATE `basescores` SET `Value` = '" . intval($_POST['Hostage_Rescued']) . "' WHERE `basescores`.`BaseScore` = 'Hostage_Rescued'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Hostage_Damage']) . "' WHERE `basescores`.`BaseScore` = 'Hostage_Damage'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Planted']) . "' WHERE `basescores`.`BaseScore` = 'Bomb_Planted'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Successful']) . "' WHERE `basescores`.`BaseScore` = 'Bomb_Successful'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Defusal']) . "' WHERE `basescores`.`BaseScore` = 'Bomb_Defusal'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Team_Kill']) . "' WHERE `basescores`.`BaseScore` = 'Team_Kill'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Suicide']) . "' WHERE `basescores`.`BaseScore` = 'Suicide'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Assist']) . "' WHERE `basescores`.`BaseScore` = 'Kill_Assist'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Headshot']) . "' WHERE `basescores`.`BaseScore` = 'Headshot'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Penetration']) . "' WHERE `basescores`.`BaseScore` = 'Penetration'; 
      UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Base']) . "' WHERE `basescores`.`BaseScore` = 'Kill_Base';";
      //echo $queryString;
      $basescoresmysql = mysqli_multi_query($con, $updateQueryString) or die(mysqli_error($con).PHP_EOL.$updateQueryString);
      if($basescoresmysql == true){
        echo "<script>window.location.replace('../config/?success=1');</script>";
      } else {
        echo "<script>window.location.replace('../config/?success=0');</script>";
      }
    }
    
  ?>


  </div>

  <hr>
  <center><small>Made Possible by Robin Wright @KroFunk and Ian Arnold @Naiboss. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>