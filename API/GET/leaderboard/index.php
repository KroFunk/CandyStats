<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
$QueryString = "SELECT `Name`,`SteamID` as PlayerID, count(`EventType`) as kills, (SELECT count(`EventType`) FROM `logdata` WHERE (`EventVariable` = PlayerID AND `EventType` = 'killed') GROUP BY `EventVariable` ORDER BY `count(``EventType``)` DESC) as deaths FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `EventType`, `Name` ORDER BY kills DESC";
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
echo json_encode($KDArray, JSON_PRETTY_PRINT);
?>