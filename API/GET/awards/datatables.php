<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');
require_once('../../../resources/SteamID/SteamID.php');

$i = 0;
$datatableOutput = '{ "data": [';




//Slayer - most kills
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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".'resources/images/awards/JPA3-32x32.png'."'".' /> Slayer","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most kills: '.$result['Kills'].'"], ';





//Corpse - most deaths
$queryString = "SELECT `Misc_2`, `EventVariable`, count(*) as Deaths FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `EventVariable` ORDER BY `Deaths` DESC Limit 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
if(stripos($result['EventVariable'], 'STEAM') !== false) {
  //its a human! ...probably
  if(isset($_SESSION[$result['EventVariable'] . 'name']) && isset($_SESSION[$result['EventVariable'] . 'avatar'])){
    $winnerName = $_SESSION[$result['EventVariable'] . 'name'];
    $winnerAvatar = $_SESSION[$result['EventVariable'] . 'avatar'];
  } else {
    try
    {
      // Constructor also accepts Steam3 and Steam2 representations
      $s = new SteamID( $result['EventVariable'] );
    }
    catch( InvalidArgumentException $e )
    {
      echo 'Given SteamID could not be parsed.';
    }
    $SteamProfile = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$SteamAPI.'&steamids='.$s->ConvertToUInt64()), TRUE);

    $winnerName = $SteamProfile['response']['players'][0]['personaname'];
    $_SESSION[$result['EventVariable'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];

    $winnerAvatar = $SteamProfile['response']['players'][0]['avatar'];
    $_SESSION[$result['EventVariable'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatar'];
  }
  
} else {
  $winnerName = $result['name'];
  $winnerAvatar = "resources/images/UI/noavatar.jpg";
}
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/Corpse-32x32.png'."'".' /> Corpse","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most deaths: '.$result['Deaths'].'"], ';





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





//Brainiac - most headshots
$queryString = "SELECT `name`, `SteamID`, count(*) as 'Totalheadshots' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_3` LIKE '%headshot%' GROUP BY `SteamID` ORDER BY Totalheadshots DESC LIMIT 1";
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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/brainiac-32x32.png'."'".' /> Brainiac","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most headsots: '.$result['Totalheadshots'].'"], ';





//Big Head - most deaths by headshots
$queryString = "SELECT `Misc_2`, `EventVariable`, count(*) as 'Headshotdeaths' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_3` LIKE '%headshot%' GROUP BY `EventVariable` ORDER BY Headshotdeaths DESC Limit 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
if(stripos($result['EventVariable'], 'STEAM') !== false) {
  //its a human! ...probably
  if(isset($_SESSION[$result['EventVariable'] . 'name']) && isset($_SESSION[$result['EventVariable'] . 'avatar'])){
    $winnerName = $_SESSION[$result['EventVariable'] . 'name'];
    $winnerAvatar = $_SESSION[$result['EventVariable'] . 'avatar'];
  } else {
    try
    {
      // Constructor also accepts Steam3 and Steam2 representations
      $s = new SteamID( $result['EventVariable'] );
    }
    catch( InvalidArgumentException $e )
    {
      echo 'Given SteamID could not be parsed.';
    }
    $SteamProfile = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$SteamAPI.'&steamids='.$s->ConvertToUInt64()), TRUE);

    $winnerName = $SteamProfile['response']['players'][0]['personaname'];
    $_SESSION[$result['EventVariable'] . 'name'] = $SteamProfile['response']['players'][0]['personaname'];

    $winnerAvatar = $SteamProfile['response']['players'][0]['avatar'];
    $_SESSION[$result['EventVariable'] . 'avatar'] = $SteamProfile['response']['players'][0]['avatar'];
  }
  
} else {
  $winnerName = $result['name'];
  $winnerAvatar = "resources/images/UI/noavatar.jpg";
}
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/bighead-32x32.png'."'".' /> Big Head","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most deaths by headshot: '.$result['Headshotdeaths'].'"], ';





//Creeper - Most successful bombings
$queryString = "SELECT `name`, `SteamID`, count(*) as 'BombSuccessful' FROM `logdata` WHERE `Misc_3` = 'Bomb_Successful' GROUP BY `SteamID` ORDER BY BombSuccessful DESC Limit 1";
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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/deafasapost-32x32.png'."'".' /> Creeper","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most successful bombings: '.$result['BombSuccessful'].'"], ';





//Bomb Squad - Most defusals
 $queryString = "SELECT `name`, `SteamID`, count(*) as 'BombDefused' FROM `logdata` WHERE `Misc_3` = 'Bomb_Defusal' GROUP BY `SteamID` ORDER BY BombDefused DESC Limit 1 ";
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
$datatableOutput .= '[ "<img style='."'vertical-align:middle;'".' src='."'".'resources/images/awards/bombsquad-32x32.png'."'".' /> Bomb Squad","<img style='."'vertical-align:middle;width:32px;height:32px;'".' src='."'".$winnerAvatar."'".' /> '.$winnerName.'","Most bomb defusals: '.$result['BombDefused'].'"], ';







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


//TO DO

//The Fool - Most suicides

//Turncoat - Most team kills

//Humanitarian - Most hostage rescues



$datatableOutput .= '] }';

echo $datatableOutput;
?>