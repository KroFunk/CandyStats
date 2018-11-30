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

  <link rel="stylesheet" href="resources/styles/style.css.php">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="resources/js/scripts.js"></script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Upload Log</div>
    <div class='menuButton'><img src="resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='upload/'>Upload Log</a><a href='login/'>Login</a></div>  
  </div>

  <center>
    <h1>Global Stats</h1>
    <p class='h1Subheading'>Below are general stats from all sessions</p>
  </center>
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
    <td>
        <?php
          $KDArray = array();

          //$killsQueryString = "SELECT `Name`,`SteamID`,count(`EventType`) FROM `logdata` WHERE `EventType` = 'killed' GROUP BY `EventType`, `Name` ORDER BY `count(``EventType``)` DESC";
          //$deathsQueryString = "SELECT `EventVariable`,count(`EventType`) FROM `logdata` WHERE `EventType` = 'killed' GROUP By `EventVariable` ORDER BY `count(``EventType``)` DESC";

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
          echo 'KDArray';
          echo '<pre>' . var_export($KDArray, true) . '</pre>'; //array check

        ?>
      <!--Leaderboard Table-->
      <table>
        <tr><td></td><td>Name</td><td>Kills</td></tr>
        
      </table>
      <input type='checkbox'>Tick this box to include BOTS!
    </td>
    <td>

      <!--Award Table-->

    </td>
    </tr>
  </table>

  <center>
    <h1>Sessions</h1>
    <p class='h1Subheading'>Below are are all the sessions uploaded to CandyStats.</p>
  </center>
  <table style='width:100%;'>
    <tr>
      <td style='width:48%;padding-left:10px;'>
        <center><h2>Available</h2></center>
      </td>
      <td>
      </td>
      <td style='width:48%;padding-right:10px;'>
        <center><h2>Selected</h2></center>
      </td>
    </tr>
    <tr>
      <td style='padding-left:10px;'>
        <div class='SelectionDiv'>
          <br>
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
        <div class='SelectionDiv SelectionButton'>>|</div>
        <div class='SelectionDiv SelectionButton'>></div>
        <div class='SelectionDiv SelectionButton'><</div>
        <div class='SelectionDiv SelectionButton'>|<</div>

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
        <br>
        </div>
      </td>
    </tr>
    <tr>
  </table>

<hr>
<center><small>Made Possible by Robin Wright @KroFunk and Ian Arnold @Naiboss. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>