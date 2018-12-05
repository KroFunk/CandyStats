<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
require_once('../../../resources/SteamID/SteamID.php');

$i = 0;
$datatableOutput = '{ "data": [';





//Batman award, most assisted kills
$queryString = "SELECT `name`, `SteamID`, count(*) as AssistedKills FROM (SELECT `name`, `SteamID`, count(*) as assistedKills FROM `logdata` WHERE `EventType` = 'killed' OR `EventType` = 'assisted killing' GROUP BY `TIMESTAMP`, `EventVariable` HAVING count(*) >= 2) as assistedList GROUP BY `SteamID` ORDER BY `AssistedKills` DESC Limit 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
if(stripos($result['SteamID'], 'STEAM') !== false) {
  //its a human! ...probably
  if(isset($_SESSION[$result['SteamID'] . 'name']) && isset($_SESSION[$result['SteamID'] . 'avatar'])){
    $winnerName = $_SESSION[$result['SteamID'] . 'name'];
    $winnerAvatar = $_SESSION[$result['SteamID'] . 'avatar'];
  } else {
    try
    {
      // Constructor also accepts Steam3 and Steam2 representations
      $s = new SteamID( $result['SteamID'] );
    }
    catch( InvalidArgumentException $e )
    {
      echo 'Given SteamID could not be parsed.';
    }
    $SteamProfile = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$SteamAPI.'&steamids='.$s->ConvertToUInt64()), TRUE);

    $winnerName = $SteamProfile['response']['players'][0]['personaname'];
    $_SESSION[$result['SteamID'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];

    $winnerAvatar = $SteamProfile['response']['players'][0]['avatar'];
    $_SESSION[$result['SteamID'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatar'];
  }
  
} else {
  $winnerName = $result['name'];
  $winnerAvatar = "resources/images/UI/noavatar.jpg";
}
$datatableOutput .= '[ "<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".'resources/images/awards/batman-32x32.png'."'".' /> Batman","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most assisted kills: '.$result['AssistedKills'].'"], ';









//Robin award, most assists
$queryString = "SELECT `name`,`SteamID`,count(*) as Assists FROM `logdata` WHERE `EventType` LIKE 'assisted killing%' GROUP BY SteamID ORDER BY Assists DESC LIMIT 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
if(stripos($result['SteamID']) !== false) {
  //its a human! ...probably
  if(isset($_SESSION[$result['SteamID'] . 'name']) && isset($_SESSION[$result['SteamID'] . 'avatar'])){
    $winnerName = $_SESSION[$result['SteamID'] . 'name'];
    $winnerAvatar = $_SESSION[$result['SteamID'] . 'avatar'];
  } else {
    try
    {
      // Constructor also accepts Steam3 and Steam2 representations
      $s = new SteamID( $result['SteamID'] );
    }
    catch( InvalidArgumentException $e )
    {
      echo 'Given SteamID could not be parsed.';
    }
    $SteamProfile = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$SteamAPI.'&steamids='.$s->ConvertToUInt64()), TRUE);

    $winnerName = $SteamProfile['response']['players'][0]['personaname'];
    $_SESSION[$result['SteamID'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];

    $winnerAvatar = $SteamProfile['response']['players'][0]['avatar'];
    $_SESSION[$result['SteamID'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatar'];
  }
  
} else {
  $winnerName = $result['name'];
  $winnerAvatar = "resources/images/UI/noavatar.jpg";
}
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/robin-32x32.png'."'".' /> Robin","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most kill assists: '.$result['Assists'].'"]';











$datatableOutput .= '] }';

echo $datatableOutput;
?>