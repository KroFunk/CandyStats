<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
require_once('../../../resources/SteamID/SteamID.php');

$i = 0;
$datatableOutput = '{ "data": [';




//Persistent, most kills
$queryString = "SELECT `name`, `SteamID`, count(*) as Kills FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `SteamID` ORDER BY `Kills` DESC Limit 1";
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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".'resources/images/awards/JPA3-32x32.png'."'".' /> Persistent","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most kills: '.$result['Kills'].'"], ';








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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/robin-32x32.png'."'".' /> Robin","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most kill assists: '.$result['Assists'].'"],';












//Immortal award, Highest KD
//This query includes bot! $queryString = "SELECT n.SteamID, COALESCE(t1.kill_cnt, 0) AS kills, COALESCE(t2.death_cnt, 0) AS deaths, CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN ( SELECT SteamID, COUNT(*) AS kill_cnt FROM logdata WHERE EventType = 'killed' GROUP BY SteamID ) t1 ON n.SteamID = t1.SteamID LEFT JOIN ( SELECT EventVariable AS SteamID, COUNT(*) AS death_cnt FROM logdata WHERE EventType = 'killed' GROUP BY EventVariable ) t2 ON n.SteamID = t2.SteamID WHERE t1.kill_cnt > 0 or t2.death_cnt > 0 ORDER BY `ratio` DESC LIMIT 1";
$queryString = "SELECT n.SteamID, COALESCE(t1.kill_cnt, 0) AS kills, COALESCE(t2.death_cnt, 0) AS deaths, CASE WHEN t2.death_cnt > 0 THEN CAST(t1.kill_cnt / t2.death_cnt AS CHAR(50)) WHEN t1.kill_cnt = 0 THEN '0' ELSE 'Infinite' END AS ratio FROM ( SELECT DISTINCT SteamID FROM logdata ) n LEFT JOIN ( SELECT SteamID, COUNT(*) AS kill_cnt FROM logdata WHERE EventType = 'killed' GROUP BY SteamID ) t1 ON n.SteamID = t1.SteamID LEFT JOIN ( SELECT EventVariable AS SteamID, COUNT(*) AS death_cnt FROM logdata WHERE EventType = 'killed' GROUP BY EventVariable ) t2 ON n.SteamID = t2.SteamID WHERE (t1.kill_cnt > 0 or t2.death_cnt > 0) AND n.SteamID LIKE 'STEAM%' ORDER BY `ratio` DESC LIMIT 1";
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
  $winnerName = $result['SteamID'];
  $winnerAvatar = "resources/images/UI/noavatar.jpg";
}
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/immortal-32x32.png'."'".' /> Immortal","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Highest KD: '.number_format($result['ratio'],2).'"]';















$datatableOutput .= '] }';

echo $datatableOutput;
?>