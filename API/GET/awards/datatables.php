<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
if(isset($_GET['hide'])){
  $hide = $_GET['hide'];
} else {
  $hide = '';
}
if($hide == 'bots'){
  $QueryString = "SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE 'STEAM%' GROUP BY `EventType`, `Name` ORDER BY kills DESC";
} else if ($hide == 'humans'){
  $QueryString = "SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` NOT LIKE 'STEAM%' GROUP BY `EventType`, `Name` ORDER BY kills DESC";
} else {
  $QueryString = "SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `EventType`, `Name` ORDER BY kills DESC";
}
$killsQuery = mysqli_query($con,$QueryString);
while($killsResult = mysqli_fetch_array($killsQuery)){
  //echo '<pre>' . var_export($killsResult, true) . '</pre>'; //data finding mission.
  $identifier = $killsResult['PlayerID'];
  if(stripos($identifier,'STEAM') !== false) {
    $ishuman = 'Yes';
  } else {
    $identifier = $killsResult['Name'];
    $ishuman = 'No';
  }
  $KD = number_format(@(intval($killsResult['kills']) / intval($killsResult['deaths'])),2);
  $KDArray[$identifier] = array('name'=>$killsResult['Name'],'kills'=>$killsResult['kills'],'deaths'=>$killsResult['deaths'],'KD'=>$KD,'ishuman'=>$ishuman);
}
$i = 0;
$datatableOutput = '{ "data": [';

foreach($KDArray as $KDResult){
  if($i>0){
    $datatableOutput .= ',';
  }
  if($KDResult['ishuman'] == 'No') {
    $name = "<img src='resources/images/UI/bot.gif' /> ".$KDResult['name'];
  } else {
    $name = $KDResult['name'];
  }
  $datatableOutput .= '[ "'.$name.'","'.$KDResult['kills'].'","'.$KDResult['deaths'].'","'.$KDResult['KD'].'"]';
  $i++;
}

$datatableOutput .= '] }';

echo $datatableOutput;
?>