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
      
      foreach ($_POST as $key => $value) {
            $output .=  "&#36;_POST['";
            $output .=  $key;
            $output .=  "'] ";
            $output .=  $value;
            $output .=  "<br>";
        }
      echo $output;
      
      //Scores
      $updateQueryString  = "UPDATE `basescores` SET `Value` = '" . intval($_POST['Rescued_A_Hostage']) .   "' WHERE `basescores`.`BaseScore` = 'Rescued_A_Hostage';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Hostage_Damage']) .      "' WHERE `basescores`.`BaseScore` = 'Hostage_Damage';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Planted_The_Bomb']) .    "' WHERE `basescores`.`BaseScore` = 'Planted_The_Bomb';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Successful']) .     "' WHERE `basescores`.`BaseScore` = 'Bomb_Successful';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Defusal']) .        "' WHERE `basescores`.`BaseScore` = 'Bomb_Defusal';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Team_Kill']) .           "' WHERE `basescores`.`BaseScore` = 'Team_Kill';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Suicide']) .             "' WHERE `basescores`.`BaseScore` = 'Suicide';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Assist']) .         "' WHERE `basescores`.`BaseScore` = 'Kill_Assist';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + intval($_POST['Headshot'])) .          "' WHERE `basescores`.`BaseScore` = 'Headshot';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + intval($_POST['Penetrated'])) .        "' WHERE `basescores`.`BaseScore` = 'Penetrated';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + (intval($_POST['Headshot']) + intval($_POST['Penetrated']))) . "' WHERE `basescores`.`BaseScore` = 'Headshot Penetrated';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Base']) .           "' WHERE `basescores`.`BaseScore` = 'Kill_Base';";

      //Weapon Weighting
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['ak47']) .          "' WHERE `itemdetails`.`Weapon` = 'ak47';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['aug']) .           "' WHERE `itemdetails`.`Weapon` = 'aug';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['awp']) .           "' WHERE `itemdetails`.`Weapon` = 'awp';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['bizon']) .         "' WHERE `itemdetails`.`Weapon` = 'bizon';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['cz75a']) .         "' WHERE `itemdetails`.`Weapon` = 'cz75a';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['deagle']) .        "' WHERE `itemdetails`.`Weapon` = 'deagle';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['decoy']) .         "' WHERE `itemdetails`.`Weapon` = 'decoy';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['elite']) .         "' WHERE `itemdetails`.`Weapon` = 'elite';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['famas']) .         "' WHERE `itemdetails`.`Weapon` = 'famas';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['fieseven']) .      "' WHERE `itemdetails`.`Weapon` = 'fieseven';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['g3sg1']) .         "' WHERE `itemdetails`.`Weapon` = 'g3sg1';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['galilar']) .       "' WHERE `itemdetails`.`Weapon` = 'galilar';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['glock']) .         "' WHERE `itemdetails`.`Weapon` = 'glock';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['hegrenade']) .     "' WHERE `itemdetails`.`Weapon` = 'hegrenade';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['hkp2000']) .       "' WHERE `itemdetails`.`Weapon` = 'hkp2000';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['inferno']) .       "' WHERE `itemdetails`.`Weapon` = 'inferno';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['knife']) .         "' WHERE `itemdetails`.`Weapon` = 'knife';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['knifegg']) .       "' WHERE `itemdetails`.`Weapon` = 'knifegg';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['m249']) .          "' WHERE `itemdetails`.`Weapon` = 'm249';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['m4a1']) .          "' WHERE `itemdetails`.`Weapon` = 'm4a1';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['m4a1_silencer']) . "' WHERE `itemdetails`.`Weapon` = 'm4a1_silencer';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['mac10']) .         "' WHERE `itemdetails`.`Weapon` = 'mac10';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['mag7']) .          "' WHERE `itemdetails`.`Weapon` = 'mag7';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['mp5sd']) .         "' WHERE `itemdetails`.`Weapon` = 'mp5sd';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['mp7']) .           "' WHERE `itemdetails`.`Weapon` = 'mp7';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['mp9']) .           "' WHERE `itemdetails`.`Weapon` = 'mp9';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['negev']) .         "' WHERE `itemdetails`.`Weapon` = 'negev';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['nova']) .          "' WHERE `itemdetails`.`Weapon` = 'nova';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['p250']) .          "' WHERE `itemdetails`.`Weapon` = 'p250';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['p90']) .           "' WHERE `itemdetails`.`Weapon` = 'p90';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['revolver']) .      "' WHERE `itemdetails`.`Weapon` = 'revolver';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['sawedoff']) .      "' WHERE `itemdetails`.`Weapon` = 'sawedoff';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['scar20']) .        "' WHERE `itemdetails`.`Weapon` = 'scar20';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['sg556']) .         "' WHERE `itemdetails`.`Weapon` = 'sg556';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['ssg08']) .         "' WHERE `itemdetails`.`Weapon` = 'ssg08';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['taser']) .         "' WHERE `itemdetails`.`Weapon` = 'taser';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['tec9']) .          "' WHERE `itemdetails`.`Weapon` = 'tec9';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['ump45']) .         "' WHERE `itemdetails`.`Weapon` = 'ump45';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['usp_silencer']) .  "' WHERE `itemdetails`.`Weapon` = 'usp_silencer';"; 
      $updateQueryString  .= "UPDATE `itemdetails` SET `Weighting` = '" . floatval($_POST['xm1014']) .        "' WHERE `itemdetails`.`Weapon` = 'xm1014';"; 
      
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