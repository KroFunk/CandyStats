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
  //ORIGINAL - $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY kills DESC";
  $QueryString = "SELECT n.steamID,COALESCE(t1.kill_cnt, 0) AS kills,COALESCE(t2.death_cnt, 0) AS deaths,CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN (SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kill_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' GROUP BY `EventVariable`) t1 ON n.steamID=t1.VictimSteamID LEFT JOIN (SELECT `SteamID` as KillerSteamID, count(`EventType`) as death_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' GROUP BY `SteamID`) t2 ON n.steamID=t2.KillerSteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) AND n.steamID LIKE 'STEAM%' ORDER BY `ratio` DESC;";
} else if ($hide == 'humans'){
  //ORIGINAL - $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' AND EventVariable NOT LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY kills DESC";
$QueryString = "SELECT n.steamID,COALESCE(t1.kill_cnt, 0) AS kills,COALESCE(t2.death_cnt, 0) AS deaths,CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN (SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kill_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' GROUP BY `EventVariable`) t1 ON n.steamID=t1.VictimSteamID LEFT JOIN (SELECT `SteamID` as KillerSteamID, count(`EventType`) as death_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' GROUP BY `SteamID`) t2 ON n.steamID=t2.KillerSteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) AND n.steamID NOT LIKE 'STEAM%' ORDER BY `ratio` DESC;";
  } else {
  //ORIGINAL - $QueryString = "SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kills FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' GROUP BY `EventVariable` ORDER BY kills DESC";
$QueryString = "SELECT n.steamID,COALESCE(t1.kill_cnt, 0) AS kills,COALESCE(t2.death_cnt, 0) AS deaths,CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN (SELECT `EventVariable` as VictimSteamID, count(`EventType`) as kill_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '$SteamID' GROUP BY `EventVariable`) t1 ON n.steamID=t1.VictimSteamID LEFT JOIN (SELECT `SteamID` as KillerSteamID, count(`EventType`) as death_cnt FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '$SteamID' GROUP BY `SteamID`) t2 ON n.steamID=t2.KillerSteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) ORDER BY `ratio` DESC;";
  }
$killsQuery = mysqli_query($con,$QueryString);
while($killsResult = mysqli_fetch_array($killsQuery)){
  //echo '<pre>' . var_export($killsResult, true) . '</pre>'; //data finding mission.
  $identifier = $killsResult['steamID'];
  if(stripos($identifier,'STEAM') !== false) {
    $ishuman = 'Yes';
  } else {
    $ishuman = 'No';
  }
  
  if(is_numeric($killsResult['ratio'])){
    $ratio = number_format($killsResult['ratio'],2);
  } else {
    $ratio = $killsResult['ratio'];
  }
  //build kill section of array
  //ORIGINAL - $KDArray[$identifier] = array('steamID'=>$killsResult['VictimSteamID'],'kills'=>$killsResult['kills'],'deaths'=>'0','KD'=>'0','ishuman'=>$ishuman);
  $KDArray[$identifier] = array('steamID'=>$killsResult['steamID'],'kills'=>$killsResult['kills'],'deaths'=>$killsResult['deaths'],'KD'=>$ratio,'ishuman'=>$ishuman);
}

//$KD = number_format(@(intval($killsResult['kills']) / @intval($killsResult['deaths'])),2);

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