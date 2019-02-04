<?php
  require "resources/config.php";
?>
<hr>
<div style='float:right; cursor:pointer; margin-top:10px;' onclick="document.getElementById('playerStats').className='playerStats invisible'"><span style='font-weight:600;font-size:20px;color:#FFF6EF'>Close </span> <img src='resources/images/UI/close.png' style='vertical-align:top;' /></div>
<h1 style='margin-top:0px;'><?php echo $_SESSION[$_POST['SteamID'] . 'name']; ?></h1>
<p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p><p>This is not data, nothing is being populated yet. Isn't testing things fun!</p>
<div style='height:850px;'><iframe src='PKPie.php?ID=<?php echo $_POST['SteamID']; ?>' style='width:100%; height:850px;' frameborder='0' scrolling='no'></iframe></div>
<hr class='clear'>