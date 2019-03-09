<?php
  require "resources/config.php";

  //Pulling the player stats
  $HTMLSteamID = htmlentities($_POST['SteamID'],ENT_QUOTES);

  //Total kills
  $queryString = "SELECT count(*) as 'TotalKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $totalKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalKills'];

  //Total Deaths
  $queryString = "SELECT count(*) as 'TotalDeaths' FROM `logdata` WHERE `EventType` = 'killed' AND `EventVariable` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $totalDeaths = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalDeaths'];

  //Total headshot kills
  $queryString = "SELECT count(*) as 'Totalheadshots' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_3` LIKE '%headshot%' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $Totalheadshots = mysqli_fetch_array(mysqli_query($con,$queryString))['Totalheadshots'];

  //Total knife kills
  $queryString = "SELECT count(*) as 'TotalKnifeKills' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_1` LIKE '%knife%' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $totalKnifeKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalKnifeKills'];

  //Total grenades thrown
  $queryString = "SELECT count(*) as 'TotalObjectsThrown' FROM `logdata` WHERE `EventType` = 'threw' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $TotalObjectsThrown = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalObjectsThrown'];

  //Total CT kills
  $queryString = "SELECT count(*) as 'TotalCTKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '" . $HTMLSteamID . "' AND `Team` = 'CT' GROUP BY `EventType`";
  $totalCTKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalCTKills'];
  
  //Total T kills
  $queryString = "SELECT count(*) as 'TotalTKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE '" . $HTMLSteamID . "' AND `Team` = 'TERRORIST' GROUP BY `EventType`";
  $totalTKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalTKills'];

  //Total Matches Played
  $queryString = "SELECT count(*) as 'TotalMatches' FROM `logdata` WHERE `EventType` = 'Triggered' AND `EventVariable` = 'Match_Start' GROUP BY `EventType`";
  $TotalMatches = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalMatches'];
  
  //Total Rounds Played
  $queryString = "SELECT count(*) as 'TotalRounds' FROM `logdata` WHERE `EventType` = 'Triggered' AND `EventVariable` = 'Round_Start' GROUP BY `EventType`";
  $TotalRounds = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalRounds'];

  //Total items purchased
  $queryString = "SELECT count(*) as `TotalPurchases` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $TotalPurchases = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalPurchases'];

  //Total cash spent
  $queryString = "SELECT sum(`itempricing`.`Price`) as `TotalSpent` FROM `logdata` LEFT JOIN `itempricing` on `logdata`.`EventVariable` = `itempricing`.`item` WHERE `EventType` = 'purchased' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventType`";
  $TotalSpent = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalSpent'];
  
  //Most purchased item
  $queryString = "SELECT `EventVariable`, count(*) as `MostPurchased` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventVariable` ORDER BY `MostPurchased` DESC LIMIT 1";
  $MostPurchasedArray = mysqli_fetch_array(mysqli_query($con,$queryString));
  $MostPurchasedItem = $MostPurchasedArray['EventVariable'];
  $MostPurchasedItemCount = $MostPurchasedArray['MostPurchased'];

  //Least purchased item
  $queryString = "SELECT `EventVariable`, count(*) as `LeastPurchased` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventVariable` ORDER BY `LeastPurchased` ASC LIMIT 1";
  $LeastPurchasedArray = mysqli_fetch_array(mysqli_query($con,$queryString));
  $LeastPurchasedItem = $LeastPurchasedArray['EventVariable'];
  $LeastPurchasedItemCount = $LeastPurchasedArray['LeastPurchased'];
  
  //Total bombs planted
  $queryString = "SELECT count(*) as 'BombsPlanted' FROM `logdata` WHERE `Misc_3` = 'Planted_The_Bomb' AND `SteamID` LIKE '" . $HTMLSteamID . "'";
  $BombsPlanted = mysqli_fetch_array(mysqli_query($con,$queryString))['BombsPlanted'];
  
  //Total bombs successful
  $queryString = "SELECT count(*) as 'BombSuccessful' FROM `logdata` WHERE `Misc_3` = 'Bomb_Successful' AND `SteamID` LIKE '" . $HTMLSteamID . "'";
  $BombSuccessful = mysqli_fetch_array(mysqli_query($con,$queryString))['BombSuccessful'];

  //Total bombs defused
  //Proper query: $queryString = "SELECT count(*) as 'BombDefused' FROM `logdata` WHERE `Misc_3` = 'Bomb_Defusal' AND `SteamID` LIKE '" . $HTMLSteamID . "'";
  //Temporary fix:
  $queryString = "SELECT count(*) as 'BombDefused' FROM `logdata` WHERE `EventVariable` = 'Defused_The_Bomb' AND `SteamID` LIKE '" . $HTMLSteamID . "'";
  $BombDefused = mysqli_fetch_array(mysqli_query($con,$queryString))['BombDefused'];
  
  //Total bombs dropped
  $queryString = "SELECT COUNT(*) as 'BombDrops' FROM `logdata` WHERE `EventVariable` LIKE 'Dropped_The_Bomb' AND `SteamID` LIKE '" . $HTMLSteamID . "' GROUP BY `EventVariable`";
  $BombDrops = mysqli_fetch_array(mysqli_query($con,$queryString))['BombDrops'];

  //Total chickens murdered
  $queryString = "SELECT count(*) as 'MurderedChickens' FROM `logdata` WHERE `EventVariable` LIKE 'chicken%' AND `SteamID` LIKE '" . $HTMLSteamID . "'";
  $MurderedChickens = mysqli_fetch_array(mysqli_query($con,$queryString))['MurderedChickens'];

  //Total hostages rescued
  $queryString = "SELECT COUNT(*) as 'HostagesRescued' FROM `logdata` WHERE `Misc_3` LIKE 'Rescued_A_Hostage' GROUP BY `Misc_3`";
  $HostagesRescued = mysqli_fetch_array(mysqli_query($con,$queryString))['HostagesRescued'];

  $KD = number_format(@(intval($totalKills) / @intval($totalDeaths)),2)

  ?>

<hr>
<div style='float:right; cursor:pointer; margin-top:10px;' onclick="document.getElementById('playerStats').className='playerStats invisible'">
  <span style='font-weight:600;font-size:20px;color:#FFF6EF'>Close </span> <img src='resources/images/UI/close.png' style='vertical-align:top;' />
</div>
<h1 style='margin-top:0px; display:table;'>
<span style='vertical-align:middle; display:table-cell;'><img style='border-radius:4px; width:64px;margin-top:20px;margin-right:5px;' src='<?php echo $_SESSION[$_POST['SteamID'] . 'avatar']; ?>' /></span>
<span style='vertical-align:middle; display:table-cell;'><?php echo $_SESSION[$_POST['SteamID'] . 'name']; ?> (<?php echo $KD ?>) (<?php echo $_POST['SteamID'] ?>)</span>
</h1>



<table style='width:100%;'>
<tr>
<td style='width:60%;' valign='top'>
<table style='font-size:13px;' style='width:100%;'>
  <tr>
    <td style='text-align:right;'>Kills:</td><td><?php echo $totalKills ?></td>
    <td style='text-align:right;'>Deaths:</td><td><?php echo $totalDeaths ?></td>
    <td style='text-align:right;'>Headshots:</td><td><?php echo $Totalheadshots ?></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Bombs planted:</td><td><?php echo $BombsPlanted ?></td>
    <td style='text-align:right;'>Bombs exploded:</td><td><?php echo $BombSuccessful ?></td>
    <td style='text-align:right;'>Bombs defused:</td><td><?php echo $BombDefused ?></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Hostages rescued:</td><td><?php echo $HostagesRescued ?></td>
    <td style='text-align:right;'>Hostages harmed:</td><td><?php echo '$' ?></td>
    <td style='text-align:right;'>Team kills:</td><td><?php echo '$' ?></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Total purchases:</td><td><?php echo $TotalPurchases ?> <img title='&#36;<?php echo number_format($TotalSpent,0,'.',','); ?>' src='resources/images/UI/money-coin.png'/></td>
    <td style='text-align:right;'>Most purchased:</td><td><?php echo $MostPurchasedItem ?></td>
    <td style='text-align:right;'>Least purchased:</td><td><?php echo $LeastPurchasedItem ?></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Matches played:</td><td><?php echo '$' ?></td>
    <td style='text-align:right;'>Rounds played:</td><td><?php echo '$' ?></td>
    <td style='text-align:right;'>Time online:</td><td><?php echo '$' ?></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Grenades thrown:</td><td><?php echo $TotalObjectsThrown ?></td>
    <td style='text-align:right;'>Knife kills:</td><td><?php echo $totalKnifeKills ?></td>
    <td style='text-align:right;'>Chickens murdered:</td><td><?php echo $MurderedChickens ?></td>
  </tr>
</table>

<table style='width:100%;'>
<tr>
  <td>
    <h3>Kills</h3>
    <iframe src='PKPie.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:265px;' frameborder='0' scrolling='no'></iframe>
  </td>
  <td>
    <h3>Deaths</h3>
    <iframe src='PDPie.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:265px;' frameborder='0' scrolling='no'></iframe>
  </td>
</tr>
</table>

<h3>Total Weapon Kills</h3>
<iframe src='WeaponBar.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:400px;' frameborder='0' scrolling='no'></iframe>

</td>
<td valign='top'>

<div class='globalLeaderboard_wrapper_wrapper'>
  <div style="position: relative; z-index:1; width: 0; height: 0">
    <input type="button" id='fullListButton' style='position:absolute; top:0px; left:10px; width:105px;' class="smallglossyButton" value="Victims" onclick="victims(this.value, '<?php echo $_POST['SteamID'] ?>')">
    <input type="button" id='showHideBotsButton' style='position:absolute; top:0px; left:125px; width:105px;' class="smallglossyButton" value="Weapons" onclick="weapons(this.value, '<?php echo $_POST['SteamID'] ?>')">
  </div>
  <table id='globalLeaderboardTEST' class='display'>
    <thead>
      <tr><td>Name</td><td>K</td><td>D</td><td>KD</td></tr>
    </thead>
  </table>
</div>

</td>
</table>




<hr class='clear'>