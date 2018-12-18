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
      $updateQueryString  = "UPDATE `basescores` SET `Value` = '" . intval($_POST['Hostage_Rescued']) .   "' WHERE `basescores`.`BaseScore` = 'Hostage_Rescued';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Hostage_Damage']) .    "' WHERE `basescores`.`BaseScore` = 'Hostage_Damage';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Planted']) .      "' WHERE `basescores`.`BaseScore` = 'Bomb_Planted';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Successful']) .   "' WHERE `basescores`.`BaseScore` = 'Bomb_Successful';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Bomb_Defusal']) .      "' WHERE `basescores`.`BaseScore` = 'Bomb_Defusal';"; 
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Team_Kill']) .         "' WHERE `basescores`.`BaseScore` = 'Team_Kill';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Suicide']) .           "' WHERE `basescores`.`BaseScore` = 'Suicide';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Assist']) .       "' WHERE `basescores`.`BaseScore` = 'Kill_Assist';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + intval($_POST['Headshot'])) .          "' WHERE `basescores`.`BaseScore` = 'Headshot';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + intval($_POST['Penetration'])) .       "' WHERE `basescores`.`BaseScore` = 'Penetration';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . (intval($_POST['Kill_Base']) + (intval($_POST['Headshot']) + intval($_POST['Penetration']))) . "' WHERE `basescores`.`BaseScore` = 'Headshot Penetration';";
      $updateQueryString .= "UPDATE `basescores` SET `Value` = '" . intval($_POST['Kill_Base']) .         "' WHERE `basescores`.`BaseScore` = 'Kill_Base';";

      //Weapon Weighting
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['ak47']) .          "' WHERE `weaponweighting`.`Weapon` = 'ak47';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['aug']) .           "' WHERE `weaponweighting`.`Weapon` = 'aug';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['awp']) .           "' WHERE `weaponweighting`.`Weapon` = 'awp';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['bizon']) .         "' WHERE `weaponweighting`.`Weapon` = 'bizon';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['cz75a']) .         "' WHERE `weaponweighting`.`Weapon` = 'cz75a';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['deagle']) .        "' WHERE `weaponweighting`.`Weapon` = 'deagle';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['decoy']) .         "' WHERE `weaponweighting`.`Weapon` = 'decoy';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['elite']) .         "' WHERE `weaponweighting`.`Weapon` = 'elite';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['famas']) .         "' WHERE `weaponweighting`.`Weapon` = 'famas';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['fieseven']) .      "' WHERE `weaponweighting`.`Weapon` = 'fieseven';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['g3sg1']) .         "' WHERE `weaponweighting`.`Weapon` = 'g3sg1';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['galilar']) .       "' WHERE `weaponweighting`.`Weapon` = 'galilar';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['glock']) .         "' WHERE `weaponweighting`.`Weapon` = 'glock';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['hegrenade']) .     "' WHERE `weaponweighting`.`Weapon` = 'hegrenade';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['hkp2000']) .       "' WHERE `weaponweighting`.`Weapon` = 'hkp2000';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['inferno']) .       "' WHERE `weaponweighting`.`Weapon` = 'inferno';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['knife']) .         "' WHERE `weaponweighting`.`Weapon` = 'knife';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['knifegg']) .       "' WHERE `weaponweighting`.`Weapon` = 'knifegg';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['m249']) .          "' WHERE `weaponweighting`.`Weapon` = 'm249';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['m4a1']) .          "' WHERE `weaponweighting`.`Weapon` = 'm4a1';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['m4a1_silencer']) . "' WHERE `weaponweighting`.`Weapon` = 'm4a1_silencer';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['mac10']) .         "' WHERE `weaponweighting`.`Weapon` = 'mac10';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['mag7']) .          "' WHERE `weaponweighting`.`Weapon` = 'mag7';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['mp5sd']) .         "' WHERE `weaponweighting`.`Weapon` = 'mp5sd';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['mp7']) .           "' WHERE `weaponweighting`.`Weapon` = 'mp7';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['mp9']) .           "' WHERE `weaponweighting`.`Weapon` = 'mp9';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['negev']) .         "' WHERE `weaponweighting`.`Weapon` = 'negev';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['nova']) .          "' WHERE `weaponweighting`.`Weapon` = 'nova';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['p250']) .          "' WHERE `weaponweighting`.`Weapon` = 'p250';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['p90']) .           "' WHERE `weaponweighting`.`Weapon` = 'p90';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['revolver']) .      "' WHERE `weaponweighting`.`Weapon` = 'revolver';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['sawedoff']) .      "' WHERE `weaponweighting`.`Weapon` = 'sawedoff';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['scar20']) .        "' WHERE `weaponweighting`.`Weapon` = 'scar20';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['sg556']) .         "' WHERE `weaponweighting`.`Weapon` = 'sg556';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['ssg08']) .         "' WHERE `weaponweighting`.`Weapon` = 'ssg08';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['taser']) .         "' WHERE `weaponweighting`.`Weapon` = 'taser';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['tec9']) .          "' WHERE `weaponweighting`.`Weapon` = 'tec9';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['ump45']) .         "' WHERE `weaponweighting`.`Weapon` = 'ump45';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['usp_silencer']) .  "' WHERE `weaponweighting`.`Weapon` = 'usp_silencer';"; 
      $updateQueryString  .= "UPDATE `weaponweighting` SET `Weighting` = '" . floatval($_POST['xm1014']) .        "' WHERE `weaponweighting`.`Weapon` = 'xm1014';"; 
      
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