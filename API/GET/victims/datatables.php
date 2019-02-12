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
  $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY kills DESC";
} else if ($hide == 'humans'){
  $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable NOT LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY kills DESC";
} else {
  $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' GROUP BY `EventVariable` ORDER BY kills DESC";
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
  $KDArray[$identifier] = array('steamID'=>$killsResult['VictimSteamID'],'kills'=>$killsResult['kills'],'deaths'=>'0','KD'=>'0','ishuman'=>$ishuman);
}

//$KD = number_format(@(intval($killsResult['kills']) / @intval($killsResult['deaths'])),2);

if($hide == 'bots'){
  $QueryString = "SELECT `SteamID` as KillerSteamID, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' AND `SteamID` LIKE 'STEAM_%' GROUP BY `SteamID` ORDER BY deaths DESC";
} else if ($hide == 'humans'){
  $QueryString = "SELECT `SteamID` as KillerSteamID, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` NOT LIKE '$SteamID' AND `SteamID` LIKE 'STEAM_%' GROUP BY `SteamID` ORDER BY deaths DESC";
} else {
  $QueryString = "SELECT `SteamID` as KillerSteamID, count(`EventType`) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' GROUP BY `SteamID` ORDER BY deaths DESC";
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
  $KDArray[$identifier] = array('steamID'=>$deathssResult['KillerSteamID'],'kills'=>$killsValue,'deaths'=>$deathssResult['deaths'],'KD'=>$KD,'ishuman'=>$ishuman);
}

//echo PHP_EOL . 'Dumping complete array' . PHP_EOL;

//echo var_export($KDArray, true); //data finding mission.


$i = 0;
$datatableOutput = '{ "data": [';

foreach($KDArray as $KDResult){

  if($i>0){
    $datatableOutput .= ',';
  }

  if($KDResult['ishuman'] == 'No') {
    $name = "<img style='vertical-align:middle;width:32px;height:32px;' src='resources/images/UI/noavatar.jpg' /> <img style='vertical-align:text-bottom;' src='resources/images/UI/bot.gif' /> ".$KDResult['steamID'];
  } else {
    if(isset($_SESSION[$KDResult['steamID']. 'name']) && isset($_SESSION[$KDResult['steamID'] . 'avatar'])){
      
      $name = "<div style='cursor:pointer' onclick='openStats(`".$_SESSION[$KDResult['steamID'] . 'name']."`,`".$KDResult['steamID']."`)'><img style='vertical-align:middle;width:32px;height:32px;' src='".$_SESSION[$KDResult['steamID']. 'avatar']."' /> ".$_SESSION[$KDResult['steamID'] . 'name']."</div>";
    } else {
      try
      {
        // Constructor also accepts Steam3 and Steam2 representations
        $s = new SteamID( $KDResult['steamID'] );
      }
      catch( InvalidArgumentException $e )
      {
        echo 'Given SteamID could not be parsed.';
      }
      $SteamProfile = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$SteamAPI.'&steamids='.$s->ConvertToUInt64()), TRUE);
      $name = "<div style='cursor:pointer' onclick='openStats(`" . $SteamProfile['response']['players'][0]['personaname']. '`,`' . $KDResult['steamID'] . "`)'><img style='vertical-align:middle;width:32px;height:32px;' src='".$SteamProfile['response']['players'][0]['avatar']."' /> ".$SteamProfile['response']['players'][0]['personaname']."</div>";
      $_SESSION[$KDResult['steamID'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];
      $_SESSION[$KDResult['steamID'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatarmedium'];
    }

  }
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