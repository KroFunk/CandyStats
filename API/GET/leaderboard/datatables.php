<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
require_once('../../../resources/SteamID/SteamID.php');

if(isset($_GET['hide'])){
  $hide = $_GET['hide'];
} else {
  $hide = '';
}
if($hide == 'bots'){
  //SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE 'STEAM%' GROUP BY `EventType`, `Name` ORDER BY kills DESC
  $QueryString = "SELECT n.SteamID, COALESCE(t1.kill_cnt, 0) AS kills, COALESCE(t2.death_cnt, 0) AS deaths, CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN ( SELECT SteamID, COUNT(*) AS kill_cnt FROM logdata WHERE EventType = 'killed' GROUP BY SteamID ) t1 ON n.SteamID = t1.SteamID LEFT JOIN ( SELECT EventVariable AS SteamID, COUNT(*) AS death_cnt FROM logdata WHERE EventType = 'killed' GROUP BY EventVariable ) t2 ON n.SteamID = t2.SteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) AND n.SteamID LIKE 'STEAM%' ORDER BY `ratio` DESC";
} else if ($hide == 'humans'){
  //SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` NOT LIKE 'STEAM%' GROUP BY `EventType`, `Name` ORDER BY kills DESC
  $QueryString = "SELECT n.SteamID, COALESCE(t1.kill_cnt, 0) AS kills, COALESCE(t2.death_cnt, 0) AS deaths, CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN ( SELECT SteamID, COUNT(*) AS kill_cnt FROM logdata WHERE EventType = 'killed' GROUP BY SteamID ) t1 ON n.SteamID = t1.SteamID LEFT JOIN ( SELECT EventVariable AS SteamID, COUNT(*) AS death_cnt FROM logdata WHERE EventType = 'killed' GROUP BY EventVariable ) t2 ON n.SteamID = t2.SteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) AND n.SteamID NOT LIKE 'STEAM%' ORDER BY `ratio` DESC";
} else {
  //SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `EventType`, `Name` ORDER BY kills DESC
  $QueryString = "SELECT n.SteamID, COALESCE(t1.kill_cnt, 0) AS kills, COALESCE(t2.death_cnt, 0) AS deaths, CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN ( SELECT SteamID, COUNT(*) AS kill_cnt FROM logdata WHERE EventType = 'killed' GROUP BY SteamID ) t1 ON n.SteamID = t1.SteamID LEFT JOIN ( SELECT EventVariable AS SteamID, COUNT(*) AS death_cnt FROM logdata WHERE EventType = 'killed' GROUP BY EventVariable ) t2 ON n.SteamID = t2.SteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) ORDER BY `ratio` DESC";
}
$killsQuery = mysqli_query($con,$QueryString);
while($killsResult = mysqli_fetch_array($killsQuery)){
  //echo '<pre>' . var_export($killsResult, true) . '</pre>'; //data finding mission.
  $identifier = $killsResult['SteamID'];
  if(stripos($identifier,'STEAM') !== false) {
    $ishuman = 'Yes';
  } else {
    //$identifier = $killsResult['Name'];
    $ishuman = 'No';
  }
  $KD = number_format(@(intval($killsResult['kills']) / intval($killsResult['deaths'])),2);
  $KDArray[$identifier] = array('steamID'=>$killsResult['SteamID'],'name'=>$killsResult['Name'],'kills'=>$killsResult['kills'],'deaths'=>$killsResult['deaths'],'KD'=>$KD,'ishuman'=>$ishuman);
}
$i = 0;
$datatableOutput = '{ "data": [';

foreach($KDArray as $KDResult){
  if($i>0){
    $datatableOutput .= ',';
  }
  if($KDResult['ishuman'] == 'No') {
    $name = "<img style='vertical-align:middle;width:32px;height:32px;' src='resources/images/UI/noavatar.jpg' /> <img style='vertical-align:text-bottom;' src='resources/images/UI/bot.gif' /> ".$KDResult['name'];
  } else {
    if(isset($_SESSION[$KDResult['steamID']. 'name']) && isset($_SESSION[$KDResult['steamID'] . 'avatar'])){
      $name = "<img style='vertical-align:middle;width:32px;height:32px;' src='".$_SESSION[$KDResult['steamID']. 'avatar']."' /> ".$_SESSION[$KDResult['steamID'] . 'name'];
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
      $name = "<img style='vertical-align:middle;width:32px;height:32px;' src='".$SteamProfile['response']['players'][0]['avatar']."' /> ".$SteamProfile['response']['players'][0]['personaname'];
      $_SESSION[$KDResult['steamID'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];
      $_SESSION[$KDResult['steamID'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatar'];
    }
  }
  $datatableOutput .= '[ "'.$name.'","'.$KDResult['kills'].'","'.$KDResult['deaths'].'","'.$KDResult['KD'].'"]';
  $i++;
}

$datatableOutput .= '] }';

echo $datatableOutput;
?>