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
  <link rel="stylesheet" type="text/css" href="resources/styles/jquery.dataTables.dark.css">
</head>

<body style='background-color:#171A1C !important;'>


<div class='bodyWrapper' style='padding-top:0px;'>

  <center>
    <h1 style='margin-top:0;padding-top:0;'>Edit Session</h1>
    <p class='h1Subheading'>Use this form to edit session tags or delete the session.</p>
  </center>
  <div style='padding-left:10px;padding-right:10px;'>
  <?php
  $querystring = "SELECT * FROM `logdata` WHERE `SessionID` = '". htmlentities($_GET['id'],ENT_QUOTES) ."' limit 1"; 
  $query = mysqli_query($con,$querystring);
  $row = mysqli_fetch_array($query);
  ?>
  <table>
    <tr>
      <td>SessionID:</td><td><b><?php echo $_GET['id']; ?></b></td>
    </tr>
    <tr>
      <td>TIMESTMAP:</td><td><b><?php echo date($DateFormat,strtotime($row['TIMESTAMP'])); ?></b></td>
    </tr>
  </table>
  <form method='POST' action='edit-session-save.php'>
  <table cellspacing='5px'>
    <tr>
      <td>Tag 1</td>
      <td>Tag 2</td>
      <td>Tag 3</td>
    </tr>
    <tr>
      <td><input type='text' name='TAG1' class='popupFormTextInput' style='width:140px' value='<?php echo $_GET['TAG1']; ?>' /></td>
      <td><input type='text' name='TAG2' class='popupFormTextInput' style='width:140px' value='<?php echo $_GET['TAG2']; ?>' /></td>
      <td><input type='text' name='TAG3' class='popupFormTextInput' style='width:140px' value='<?php echo $_GET['TAG3']; ?>' /></td>
    </tr>
  </table>
  <div align='right'>
  <input type='hidden' value='<?php echo $_GET['id']; ?>' name='SessionID' />
  <p><input type="submit" class='glossyButton' value="Save Changes" /></p>
  </div>
</form>
  </div>
<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. <br>Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>