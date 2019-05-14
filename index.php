<?php
  require "resources/config.php";
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Candy Stats</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">
  <link rel="stylesheet" href="resources/styles/style.css.php">
  <link rel="stylesheet" type="text/css" href="resources/styles/jquery.dataTables.dark.css">
  
  <script src="resources/js/jquery-1.10.2.js"></script>
  <script type="text/javascript" charset="utf8" src="resources/js/jquery.dataTables.js"></script>
  <script src="resources/js/scripts.js"></script>
  
  <script>
  $(document).ready( function () {
    leaderboard = $('#globalLeaderboard').DataTable( {
      'columnDefs': [
        {
            "targets": 0,
            "className": "text-left"
        },
        {
            "targets": 1,
            "width":"15%",
            "className": "text-right"
        },
        {
            "targets": 2,
            "width":"15%",
            "className": "text-right"
        },
        {
            "targets": 3, 
            "width":"15%",
            "className": "text-right"
        },
        {
            "targets": 4, 
            "width":"15%",
            "className": "text-right"
        }
      ],
      "order": [[ 4, "desc" ]],
      "lengthChange": false,
      "ajax": 'API/GET/leaderboard/datatables.php?hide=bots'
    });
  } );

    $(document).ready( function () {
    awards = $('#awards').DataTable( {
      "ordering": false,
      "paging": false,
      "info": false,
      "ajax": 'API/GET/awards/datatables.php'
    });
  } );

  function showHideBots(checkvalue) {
    if(checkvalue=='Show BOTS!'){
      leaderboard.clear();
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php' ).load();
      document.getElementById('showHideBotsButton').value = 'Hide BOTS!';
    } else {
      leaderboard.clear();
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php?hide=bots' ).load();
      document.getElementById('showHideBotsButton').value = 'Show BOTS!';
    }
  }

    function fullList(checkvalue) {
    if(checkvalue=='Show all players!'){
      leaderboard.page.len(-1).draw();
      document.getElementById('fullListButton').value = 'Show Top 10!';
    } else {
      leaderboard.page.len(10).draw();
      document.getElementById('fullListButton').value = 'Show all players!';

    }
  }
  
  function fullPSList(checkvalue) {
    if(checkvalue=='Show all Stats!'){
      playerleaderboard.page.len(-1).draw();
      document.getElementById('fullListButton').value = 'Show Top 10!';
    } else {
      playerleaderboard.page.len(10).draw();
      document.getElementById('fullListButton').value = 'Show all Stats!';

    }
  }

  function weapons(checkvalue,steamID) {
    if(checkvalue=='Weapons'){
      playerleaderboard.clear();
      playerleaderboard.ajax.url( 'API/GET/weapon-use/datatables.php?hide=bots&ID='+steamID ).load();
      document.getElementById('showHideBotsButton').value = 'Victims';
    } else {
      playerleaderboard.clear();
      playerleaderboard.ajax.url( 'API/GET/victims/datatables.php?hide=bots&ID='+steamID ).load();
      document.getElementById('showHideBotsButton').value = 'Weapons';
    }
  }

  </script>
</head>

<body>

<div class='menuBar' id='menuBar'>
  <div class='logo'>CandyStats : Global Overview</div>
  <div class='menuButton'><img src="resources/images/UI/login-nograd.png" /></div>
  <div class='menuLink'><a href='team_calculator/'>Team Calculator</a><a href='config/'>Config Variables</a><a href='upload/'>Upload Log</a>|&nbsp;&nbsp;<a href='login/'>Login</a></div>  
</div>

<div class='fullWidthSection'>

<center>
    <h1>Global Overview</h1>
    <p class='h1Subheading'>Below are general stats from all sessions</p>
  </center>
  
  <?php
  //Pulling the global stats

  //Total kills
  $queryString = "SELECT count(*) as 'TotalKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $totalKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalKills'];

  //Total headshot kills
  $queryString = "SELECT count(*) as 'Totalheadshots' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_3` LIKE '%headshot%' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $Totalheadshots = mysqli_fetch_array(mysqli_query($con,$queryString))['Totalheadshots'];

  //Total knife kills
  $queryString = "SELECT count(*) as 'TotalKnifeKills' FROM `logdata` WHERE `EventType` = 'killed' AND `Misc_1` LIKE '%knife%' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $totalKnifeKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalKnifeKills'];

  //Total grenades thrown
  $queryString = "SELECT count(*) as 'TotalObjectsThrown' FROM `logdata` WHERE `EventType` = 'threw' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $TotalObjectsThrown = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalObjectsThrown'];

  //Total CT kills
  $queryString = "SELECT count(*) as 'TotalCTKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE 'STEAM_%' AND `Team` = 'CT' GROUP BY `EventType`";
  $totalCTKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalCTKills'];
  
  //Total T kills
  $queryString = "SELECT count(*) as 'TotalTKills' FROM `logdata` WHERE `EventType` = 'killed' AND `SteamID` LIKE 'STEAM_%' AND `Team` = 'TERRORIST' GROUP BY `EventType`";
  $totalTKills = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalTKills'];

  //Total Matches Played
  $queryString = "SELECT count(*) as 'TotalMatches' FROM `logdata` WHERE `EventType` = 'Triggered' AND `EventVariable` = 'Match_Start' GROUP BY `EventType`";
  $TotalMatches = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalMatches'];
  
  //Total Rounds Played
  $queryString = "SELECT count(*) as 'TotalRounds' FROM `logdata` WHERE `EventType` = 'Triggered' AND `EventVariable` = 'Round_Start' GROUP BY `EventType`";
  $TotalRounds = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalRounds'];

  //Total items purchased
  $queryString = "SELECT count(*) as `TotalPurchases` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $TotalPurchases = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalPurchases'];

  //Total cash spent
  $queryString = "SELECT sum(`itempricing`.`Price`) as `TotalSpent` FROM `logdata` LEFT JOIN `itempricing` on `logdata`.`EventVariable` = `itempricing`.`item` WHERE `EventType` = 'purchased' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventType`";
  $TotalSpent = mysqli_fetch_array(mysqli_query($con,$queryString))['TotalSpent'];
  
  //Most purchased item
  $queryString = "SELECT `EventVariable`, count(*) as `MostPurchased` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY `MostPurchased` DESC LIMIT 1";
  $MostPurchasedArray = mysqli_fetch_array(mysqli_query($con,$queryString));
  $MostPurchasedItem = $MostPurchasedArray['EventVariable'];
  $MostPurchasedItemCount = $MostPurchasedArray['MostPurchased'];

  //Least purchased item
  $queryString = "SELECT `EventVariable`, count(*) as `LeastPurchased` FROM `logdata` WHERE `EventType` = 'purchased' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY `LeastPurchased` ASC LIMIT 1";
  $LeastPurchasedArray = mysqli_fetch_array(mysqli_query($con,$queryString));
  $LeastPurchasedItem = $LeastPurchasedArray['EventVariable'];
  $LeastPurchasedItemCount = $LeastPurchasedArray['LeastPurchased'];
  
  //Total bombs planted
  $queryString = "SELECT count(*) as 'BombsPlanted' FROM `logdata` WHERE `Misc_3` = 'Planted_The_Bomb' AND `SteamID` LIKE 'STEAM_%'";
  $BombsPlanted = mysqli_fetch_array(mysqli_query($con,$queryString))['BombsPlanted'];
  
  //Total bombs successful
  $queryString = "SELECT count(*) as 'BombSuccessful' FROM `logdata` WHERE `Misc_3` = 'Bomb_Successful' AND `SteamID` LIKE 'STEAM_%'";
  $BombSuccessful = mysqli_fetch_array(mysqli_query($con,$queryString))['BombSuccessful'];

  //Total bombs defused
  //Proper query: $queryString = "SELECT count(*) as 'BombDefused' FROM `logdata` WHERE `Misc_3` = 'Bomb_Defusal' AND `SteamID` LIKE 'STEAM_%'";
  //Temporary fix:
  $queryString = "SELECT count(*) as 'BombDefused' FROM `logdata` WHERE `EventVariable` = 'Defused_The_Bomb' AND `SteamID` LIKE 'STEAM_%'";
  $BombDefused = mysqli_fetch_array(mysqli_query($con,$queryString))['BombDefused'];
  
  //Total bombs dropped
  $queryString = "SELECT COUNT(*) as 'BombDrops' FROM `logdata` WHERE `EventVariable` LIKE 'Dropped_The_Bomb' AND `SteamID` LIKE 'STEAM_%' GROUP BY `EventVariable`";
  $BombDrops = mysqli_fetch_array(mysqli_query($con,$queryString))['BombDrops'];

  //Total chickens murdered
  $queryString = "SELECT count(*) as 'MurderedChickens' FROM `logdata` WHERE `EventVariable` LIKE 'chicken%' AND `SteamID` LIKE 'STEAM_%'";
  $MurderedChickens = mysqli_fetch_array(mysqli_query($con,$queryString))['MurderedChickens'];

  //Total hostages rescued
  $queryString = "SELECT COUNT(*) as 'HostagesRescued' FROM `logdata` WHERE `Misc_3` LIKE 'Rescued_A_Hostage' GROUP BY `Misc_3`";
  $HostagesRescued = mysqli_fetch_array(mysqli_query($con,$queryString))['HostagesRescued'];
  ?>

  <div style='font-size:13px;'>

  <center>
    <div id='CT-Card' class='card'>
    <div class='cardImage'><img src='resources/images/UI/CT.jpg' /></div>
    <h3>CTs</h3>
    <table width='100%'>

      <tr><td align='right' width='175'>Total CT kills:</td><td><strong><?php echo $totalCTKills; ?></strong></td></tr>
      <tr><td align='right' width='175'>Bombs defused:</td><td><strong><?php echo $BombDefused; ?></strong></td></tr>
      <tr><td align='right' width='175'>Bombs dropped:</td><td><strong><?php echo $BombDrops; ?></strong></td></tr>
      <tr><td align='right' width='175'>Hostages rescued:</td><td><strong><?php echo $HostagesRescued; ?></strong></td></tr>
      
    </table>
    </div>

    <div id='T-Card' class='card'>
    <div class='cardImage'><img src='resources/images/UI/T.jpg' /></div>
    <h3>Ts</h3>
    <table width='100%'>

      <tr><td align='right' width='175'>Total Terrorist kills:</td><td><strong><?php echo $totalTKills; ?></strong></td></tr>
      <tr><td align='right' width='175'>Bombs planted:</td><td><strong><?php echo $BombsPlanted; ?></strong></td></tr>
      <tr><td align='right' width='175'>Bombs exploded:</td><td><strong><?php echo $BombSuccessful; ?></strong></td></tr>
      <tr><td align='right' width='175'>Hostages harmed:</td><td><strong><?php echo $BombDefused; ?></strong></td></tr>
      
    </table>
    </div>

    <div id='Misc-Card' class='card'>
    <div class='cardImage'><img src='resources/images/UI/buy.jpg' /></div>
    <h3>Misc</h3>
    <table width='100%'>
      
    <tr><td align='right' width='175'>Total Matches Played:</td><td><strong><?php echo $TotalMatches; ?></strong></td></tr>
    <tr><td align='right' width='175'>Total Rounds Played:</td><td><strong><?php echo $TotalRounds; ?></strong></td></tr>
    <tr><td align='right' valign='top' width='140'>Total purchases:</td><td valign='top'><strong><?php echo $TotalPurchases; ?></strong></td></tr>
    <tr><td align='right' valign='top' width='140'>Cash spent:</td><td valign='top'><strong>&#36;<!--Because Murica--><?php echo number_format($TotalSpent,0,'.',','); ?></strong></td></tr>
    <tr><td align='right' valign='top' width='140'>Most purchased:</td><td valign='top'><strong><?php echo $MostPurchasedItem . ' (' . $MostPurchasedItemCount . ')'; ?></strong></td></tr>
    <tr><td align='right' valign='top' width='140'>Least purchased:</td><td valign='top'><strong><?php echo $LeastPurchasedItem . ' (' . $LeastPurchasedItemCount . ')'; ?></strong></td></tr>
      
    </table>
    </div>

    <div id='Kill-Card' class='card'>
    <div class='cardImage'><img src='resources/images/UI/chckenCT.jpg' /></div>
    <h3>Totals</h3>
    <table width='100%'>
      
    <tr><td align='right' width='175'>Total kills:</td><td><strong><?php echo $totalKills; ?></strong></td></tr>
    <tr><td align='right' width='175'>Headshots:</td><td><strong><?php echo $Totalheadshots; ?></strong></td></tr>
    <tr><td align='right' width='175'>Total knife kills:</td><td><strong><?php echo $totalKnifeKills; ?></strong></td></tr>
    <tr><td align='right' width='175'>Grenades thrown:</td><td><strong><?php echo $TotalObjectsThrown; ?></strong></td></tr>
    <tr><td align='right' width='175'>Chickens murdered:</td><td><strong><?php echo $MurderedChickens; ?></strong></td></tr>
      
    </table>
    </div>

  </center>

  </div>

</div>

<div class='bodyWrapper'>

  <div class='playerStats invisible' id='playerStats'>
    
  </div>

  <table style='width:100%;' cellspacing='0'>
    <tr>
      <td style='width:50%;'>
        <center><h2>Leaderboard</h2></center>
      </td>
      <td>
        <center><h2>Awards</h2></center>
      </td>
    </tr>
    <tr>
    <tr>
    <td valign='top'>

      <!--Leaderboard Table-->
      <div class='globalLeaderboard_wrapper_wrapper'>
        <div style="position: relative; z-index:1; width: 0; height: 0">
          <input type="button" id='fullListButton' style='cursor: pointer; position:absolute; top:0px; left:10px; width:115px;' class="smallglossyButton" value="Show all players!" onclick="fullList(this.value)">
          <input type="button" id='showHideBotsButton' style='cursor: pointer; position:absolute; top:0px; left:135px; width:115px;' class="smallglossyButton" value="Show BOTS!" onclick="showHideBots(this.value)">
        </div>
        <table id='globalLeaderboard' class='display'>
          <thead>
          <tr><td>Name</td><td>K</td><td>D</td><td>KD</td><td>Score</td></tr>
          </thead>
        </table>
      </div>

    </td>
    <td valign='top'>

      <!--Award Table-->

      <table id='awards' class='display'>
        <thead>
        <tr><td>Award</td><td>Winner</td><td>Value</td></tr>
        </thead>
      </table>

    </td>
    </tr>
  </table>

  <center>
    <h1>Data Selection</h1>
    <p class='h1Subheading'>Below are are all the sessions uploaded to CandyStats. Use the filters to refine your data selection!</p>
  </center>
  <table style='width:100%;'>
    <tr>
      <td style='width:31%;padding-left:10px;'>
        <center><h2>Uploaded Logs</h2></center>
      </td>
      <td>
      </td>
      <td style='width:31%;padding-right:10px;'>
        <center><h2>Maps</h2></center>
      </td>
      <td>
      </td>
      <td style='width:31%;padding-right:10px;'>
        <center><h2>Rounds</h2></center>
      </td>
    </tr>
    <tr>
      <td style='padding-left:10px;'>
        <div class='SelectionDiv'>
        <?php
            $queryString = "SELECT SessionID, TIMESTAMP, TAGS, COUNT(*) as Rounds FROM `logdata` WHERE EventVariable = 'Round_Start' GROUP BY SessionID";
            $query = mysqli_query($con,$queryString);
            $TAGDivs = '';
            $sessionDate = '';
            while($row = mysqli_fetch_array($query)){
              $TAGS = array();
              if(!empty($row['TAGS'])){
                $TAGS = json_decode(html_entity_decode($row['TAGS']));
                foreach($TAGS as $TAG){
                  $TAGDivs .= '<div class="tagdiv">' . $TAG . '</div>';
                }
              }
              if($sessionDate != date($DateFormat,strtotime($row['TIMESTAMP']))){
                if($sessionDate != ''){
                  echo '</div><!-- sessionDate' . $row['TIMESTAMP'] . ' -->';//close previous sessionDate div so long as it isn't the first row!
                }
                $sessionDate = date($DateFormat,strtotime($row['TIMESTAMP']));
                echo "<div class='sessionDate' id='sessionDate" . date('Ymd',strtotime($row['TIMESTAMP'])) . "' style='overflow:hidden; max-height:30px;'> <div> <div style='padding:5px; cursor:pointer; float:left; width:300px;' onclick='expandSessionDate(`" . date('Ymd',strtotime($row['TIMESTAMP'])) . "`)'><img style='vertical-align:middle;' id='sessionDateButton" . date('Ymd',strtotime($row['TIMESTAMP'])) . "' src='resources/images/UI/plus-small.png' /> $sessionDate </div> <img style='float:right; vertical-align:middle; padding:7px; cursor:pointer;' src='resources/images/UI/ui-check-box-uncheck.png' /></div>";
              }
              echo '<div class="SelectionDivItem ' . $sessionDate . '" id="'.$row['SessionID'].'"><div style="float:right;"><img style="cursor:pointer;" onclick="openwrapper('."'".'edit-session.php?id='.$row['SessionID']."'".',500,450,5);" src="resources/images/UI/editicon.png" /></div><div style="cursor:pointer;" onclick="selectSesssion(`'.$row['SessionID'].'`)">'. date($TimeFormat,strtotime($row['TIMESTAMP'])) .', ' . $row['Rounds'] . ' Rounds.<div>' . $TAGDivs . '</div></div><p class="clearP"></p></div>';
              $TAGDivs = '';
            }
            echo '</div>';//close final sessionDate div. 
        ?>
        
        </div> 
      </td>
      <td>
        <div><center><img src='resources/images/add.png' /></center></div>

      </td>
      <td>
        <div class='SelectionDiv'>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
      </td>
      <td>
        <div><center><img src='resources/images/add.png' /></center></div>

      </td>
      <td style='padding-right:10px;'>
        <div class='SelectionDiv'>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
      </td>
    </tr>
    <tr>
  </table>

<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>

<!-- yes, this script is supposed to be down here! http://krofunk.github.io/LightBox/ -->
<script type="text/javascript" src="resources/js/lightbox.wrapper.js"></script>
</body>

</html>