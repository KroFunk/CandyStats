<?php
header('Content-Type: application/json');
require_once('../../../resources/config.php');


$i = 0;
$datatableOutput = '{ "data": [';

//Batman award, most assisted kills
$queryString = "SELECT `name`, `SteamID`, count(*) as AssistedKills FROM (SELECT `name`, `SteamID`, count(*) as assistedKills FROM `logdata` WHERE `EventType` = 'killed' OR `EventType` = 'assisted killing' GROUP BY `TIMESTAMP`, `EventVariable` HAVING count(*) >= 2) as assistedList GROUP BY `SteamID` ORDER BY `AssistedKills` DESC Limit 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
$datatableOutput .= '[ "<img src='."'".'resources/images/awards/batman-32x32.png'."'".' /> Batman","'.$result['name'].'","Most assisted kills: '.$result['AssistedKills'].'"], ';

//Robin award, most assists
$queryString = "SELECT `name`,count(*) as Assists FROM `logdata` WHERE `EventType` LIKE 'assisted killing%' GROUP BY SteamID ORDER BY Assists DESC LIMIT 1";
$result = mysqli_fetch_array(mysqli_query($con,$queryString));
$datatableOutput .= '[ "<img src='."'".'resources/images/awards/robin-32x32.png'."'".' /> Robin","'.$result['name'].'","Most kill assists: '.$result['Assists'].'"]';

$datatableOutput .= '] }';

echo $datatableOutput;
?>