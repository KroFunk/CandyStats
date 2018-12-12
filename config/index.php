<?php
require('../resources/config.php');
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Candy Stats</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link rel="stylesheet" href="../resources/styles/style.css.php">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="../resources/js/scripts.js?random=<?php echo rand(0,10000); ?>"></script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Upload Log</div>
    <div class='menuButton'><img src="../resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='../team_calculator/'>Team Calculator</a><a href='../config/'>Config Variables</a><a href='../upload/'>Upload Log</a>|&nbsp;&nbsp;<a href='../login/'>Login</a></div>  
  </div>

  <div class='contentDiv'>
    <a href='../'>Click here to go back to Global Overview</a>
    <center>
      <h1>Config Variables</h1>
      <p class='h1Subheading'>Settings that allow you to customise CandyStats.</p>
    </center>
    
    
    <h2>Scores.</h2>

    <?php
    $baseScores = array();
      $queryString = "SELECT * FROM `basescores`";
      $query = mysqli_query($con,$queryString);
      while($result = mysqli_fetch_array($query)){
        $baseScores[$result['BaseScore']] = $result['Value'];
      }
    ?>

    <p class='h1Subheading'>Scores are calculated when logs are uploaded using the values below.</p>
    <table>

    <tr>
      <td width='155px' align='right'>Hostage rescued</td><td><input class='configNumber' name='Hostage_Rescued' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Hostage_Rescued']?>' /></td>
      <td width='175px' align='right'>Team Kill</td><td><input class='configNumber' name='Team_Kill' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Team_Kill']?>' /></td>
      <td width='165px' align='right'>Headshot</td><td><input class='configNumber' name='Headshot' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Headshot']?>' /></td>

    </tr>

    <tr>
      <td align='right'>Hostage damage</td><td><input name='Hostage_Damage' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Hostage_Damage']?>' /></td>
      <td align='right'>Suicide</td><td><input name='Suicide' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Suicide']?>' /></td>
      <td align='right'>Penetration</td><td><input name='Penetration' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Penetration']?>' /></td>
      
    </tr>

    <tr>
      <td align='right'>Bomb planted</td><td><input name='Bomb_Planted' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Bomb_Planted']?>' /></td>
      <td align='right'>Kill assist</td><td><input name='Kill_Assist' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Kill_Assist']?>' /></td>
      <td></td><td></td>

    </tr>

    <tr>
      <td align='right'>Bomb exploded</td><td><input name='Bomb_Successful' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Bomb_Successful']?>' /></td>
      <td align='right'>Kill Base Score</td><td><input name='Kill_Base' class='configNumber' type='number' value='<?php echo $baseScores['Kill_Base']?>' /></td
      ><td></td><td></td>

    </tr>

    <tr>
      <td align='right'>Bomb defused</td><td><input name='Bomb_Defusal' class='configNumber' type='number' min='-9999' max='9999' value='<?php echo $baseScores['Bomb_Defusal']?>' /></td>
      <td></td><td></td>
      <td></td><td></td>

    </tr>

    </table>

    <p>Kills have a base score (+ headshot/penetration), multiplied by the weapon weightings below.</p>


    <table width='100%'>
    <tr>
      <td align='right' width='160px'><img src='../resources/images/weapons/Ak47go.png' class='gunIcon' /> AK47</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right' width='180px'><img src='../resources/images/weapons/Auggo.png' class='gunIcon' /> Aug</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right' width='170px'><img src='../resources/images/weapons/Awpgo.png' class='gunIcon' /> Awp</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right' width='170px'><img src='../resources/images/weapons/Pp19.png' class='gunIcon' /> Bizon</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/CZ75go.png' class='gunIcon' /> CZ75A</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Weapon_deagle.png' class='gunIcon' /> Deagle</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Decoyhud_csgo.png' class='gunIcon' /> Decoy</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Elitego.png' class='gunIcon' /> Elites</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Famasgo.png' class='gunIcon' /> Famas</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/57go.png' class='gunIcon' /> FiveSeven</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/G3.png' class='gunIcon' /> G3SG1</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Galilar.png' class='gunIcon' /> Galil AR</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Glockgo.png' class='gunIcon' /> Glock</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Hegrenadehud_csgo.png' class='gunIcon' /> HE Grenade</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/P2000go.png' class='gunIcon' /> P2000</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Incgrenadehud_csgo.png' class='gunIcon' /> Inferno</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Knife_csgo.png' class='gunIcon' /> Knife</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Gold_Knife.png' class='gunIcon' /> G-Knife</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/CSGO_M249.png' class='gunIcon' /> M249</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/M4a4.png' class='gunIcon' /> M4A1</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/M4a1-s.png' class='gunIcon' /> M4A1-S</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Mac10go.png' class='gunIcon' /> MAC-10</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Mag7.png' class='gunIcon' /> MAG-7</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Csgo_weapon_mp5sd.png' class='gunIcon' /> MP5</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Mp7.png' class='gunIcon' /> MP7</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Mp9.png' class='gunIcon' /> MP9</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/CSGO_Negev_Inventory.png' class='gunIcon' /> Negev</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Nova.png' class='gunIcon' /> Nova</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/P250go.png' class='gunIcon' /> P250</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/P90go.png' class='gunIcon' /> P90</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Csgo-weapon-revolver.png' class='gunIcon' /> Revolver</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Sawedoff.png' class='gunIcon' /> Sawed-Off</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Scar20.png' class='gunIcon' /> SCAR-20</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Sg556.png' class='gunIcon' /> SG 553</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Ssg08.png' class='gunIcon' /> SSG 08</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Taserhud.png' class='gunIcon' /> Zeus(Taser)</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    <tr>
      <td align='right'><img src='../resources/images/weapons/Tec9.png' class='gunIcon' /> TEC-9</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/Ump45go.png' class='gunIcon' /> UMP-45</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/CSGO_USP-S_Inventory.png' class='gunIcon' /> USP</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>
      <td align='right'><img src='../resources/images/weapons/CSGO_XM1014_Inventory.png' class='gunIcon' /> XM1014</td><td width='70px'><input class='configNumber' onchange='setOneNumberDecimal(this)' type='number' min='0.1' max='2' step='0.1'  /></td>    
    </tr>
    </table>
    <p><i>Changes to base scores and weapon weightings will only affect new logs added to CandyStats. Existing scores will not be updated!</i></p>
    <div style='text-align:right;'><input type="submit" class="glossyButton" value="Save Config"></div>

  </div>

  <hr>
  <center><small>Made Possible by Robin Wright @KroFunk and Ian Arnold @Naiboss. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>