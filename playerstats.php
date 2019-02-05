<?php
  require "resources/config.php";
?>
<hr>
<div style='float:right; cursor:pointer; margin-top:10px;' onclick="document.getElementById('playerStats').className='playerStats invisible'"><span style='font-weight:600;font-size:20px;color:#FFF6EF'>Close </span> <img src='resources/images/UI/close.png' style='vertical-align:top;' /></div>
<h1 style='margin-top:0px; display:table;'><span style='vertical-align:middle; display:table-cell;'><img style='border:2px solid #FFF6EF; border-radius:2px; width:40px;margin-top:20px;' src='<?php echo $_SESSION[$_POST['SteamID'] . 'avatar']; ?>' />&nbsp;</span><span style='vertical-align:middle; display:table-cell;'><?php echo $_SESSION[$_POST['SteamID'] . 'name']; ?> ()</span></h1>

<table>
<tr>
<td style='width:50%;' valign='top'>
<table style='font-size:13px;'>
  <tr>
    <td style='text-align:right;'>Kills:</td><td></td>
    <td style='text-align:right;'>Deaths:</td><td></td>
    <td style='text-align:right;'>Headshots:</td><td></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Bombs planted:</td><td></td>
    <td style='text-align:right;'>Bombs exploded:</td><td></td>
    <td style='text-align:right;'>Bombs defused:</td><td></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Hostages rescued:</td><td></td>
    <td style='text-align:right;'>Hostages harmed:</td><td></td>
    <td style='text-align:right;'>Team kills:</td><td></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Total purchases:</td><td></td>
    <td style='text-align:right;'>Most purchased:</td><td></td>
    <td style='text-align:right;'>Least purchased:</td><td></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Matches played:</td><td></td>
    <td style='text-align:right;'>Rounds played:</td><td></td>
    <td style='text-align:right;'>Time online:</td><td></td>
  </tr>
  <tr>
    <td style='text-align:right;'>Grenades thrown:</td><td></td>
    <td style='text-align:right;'>Knife kills:</td><td></td>
    <td style='text-align:right;'>Chickens murdered:</td><td></td>
  </tr>
</table>
<h3>Player Kills</h3>
<iframe src='PKPie.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:265px;' frameborder='0' scrolling='no'></iframe>
<h3>Deaths</h3>
<iframe src='PDPie.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:265px;' frameborder='0' scrolling='no'></iframe>

</td>
<td valign='top'>

<div class='globalLeaderboard_wrapper_wrapper'>
  <div style="position: relative; z-index:1; width: 0; height: 0">
    <input type="button" id='fullListButton' style='position:absolute; top:0px; left:10px; width:115px;' class="smallglossyButton" value="Victims" onclick="victims(this.value, '<?php echo $_POST['SteamID'] ?>')">
    <input type="button" id='showHideBotsButton' style='position:absolute; top:0px; left:135px; width:115px;' class="smallglossyButton" value="Weapons" onclick="weapons(this.value, '<?php echo $_POST['SteamID'] ?>')">
  </div>
  <table id='globalLeaderboardTEST' class='display'>
    <thead>
      <tr><td>Name</td><td>K</td><td>D</td><td>KD</td></tr>
    </thead>
  </table>
</div>

</td>
</table>

<h3>Total Weapon Kills</h3>
<iframe src='WeaponBar.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:400px;' frameborder='0' scrolling='no'></iframe>


<hr class='clear'>