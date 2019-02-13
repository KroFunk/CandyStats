<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
require_once('../../../resources/SteamID/SteamID.php');

$SteamID = '-';
$KDArray = array();
if(isset($_GET['ID'])){
  $SteamID = $_GET['ID'];
}

if(isset($_GET['hide'])){
  $hide = $_GET['hide'];
} else {
  $hide = '';
}

if($hide == 'bots'){
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable LIKE 'STEAM_%' GROUP BY `Misc_1` ORDER BY kills DESC";
} else if ($hide == 'humans'){
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable NOT LIKE 'STEAM_%' GROUP BY `Misc_1` ORDER BY kills DESC";
} else {
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND GROUP BY `Misc_1` ORDER BY kills DESC";
}
$killsQuery = mysqli_query($con,$QueryString);
while($killsResult = mysqli_fetch_array($killsQuery)){
  //echo '<pre>' . var_export($killsResult, true) . '</pre>'; //data finding mission.
  $identifier = $killsResult['VictimSteamID'];
  if(stripos($identifier,'STEAM') !== false) {
    $ishuman = 'Yes';
  } else {
    $ishuman = 'No';
  }
  //build kill section of array
  $KDArray[$identifier] = array('weapon'=>$killsResult['weapon'],'kills'=>$killsResult['kills'],'deaths'=>'0','KD'=>'0');
}


if($hide == 'bots'){
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' AND `SteamID` LIKE 'STEAM_%' GROUP BY `SteamID` ORDER BY deaths DESC";
} else if ($hide == 'humans'){
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' AND `SteamID` NOT LIKE 'STEAM_%' GROUP BY `SteamID` ORDER BY deaths DESC";
} else {
  $QueryString = "SELECT `Misc_1` as weapon, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' GROUP BY `SteamID` ORDER BY deaths DESC";
}
$deathsQuery = mysqli_query($con,$QueryString);
while($deathssResult = mysqli_fetch_array($deathsQuery)){
  //echo '<pre>' . var_export($deathssResult, true) . '</pre>'; //data finding mission.
  $identifier = $deathssResult['KillerSteamID'];
  if(stripos($identifier,'STEAM') !== false) {
    $ishuman = 'Yes';
  } else {
    $ishuman = 'No';
  }
  if(!empty($KDArray[$identifier]['kills'])){
    $killsValue = $KDArray[$identifier]['kills'];
  } else {
    $killsValue = '0';
  }

  $KD = '∞';
  if(intval($killsValue) > 0 && intval($deathssResult['deaths']) > 0){
    //echo $deathssResult['KillerSteamID'] . ' kills: ' . $killsValue . ' deaths: ' . $deathssResult['deaths'] . PHP_EOL;
    $KD = number_format((intval($killsValue) / intval($deathssResult['deaths'])),2);
  } else {
    $KD = '∞';   
  }

  if($KD == 0){
    $KD = '∞'; 
  }
  
  //build death section of array
  $KDArray[$identifier] = array('weapon'=>$deathssResult['weapon'],'kills'=>$killsValue,'deaths'=>$deathssResult['deaths'],'KD'=>$KD);
}


$i = 0;
$datatableOutput = '{ "data": [';

foreach($KDArray as $KDResult){

  if($i>0){
    $datatableOutput .= ',';
  }
  
  $name = "<img style='vertical-align:middle;width:32px;height:32px;' src='resources/images/UI/noavatar.jpg' /> <img style='vertical-align:text-bottom;' src='resources/images/UI/bot.gif' /> ".$KDResult['steamID'];
 
  if($KDResult['KD'] > 0){
    $KD = $KDResult['KD'];
  } else {
    $KD = '∞';   
  }
  $datatableOutput .= '[ "'.$name.'","'.$KDResult['kills'].'","'.$KDResult['deaths'].'","'.$KD.'"]';
  $i++;
}

$datatableOutput .= '] }';

echo $datatableOutput;
?>