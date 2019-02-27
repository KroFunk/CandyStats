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

  <div style='padding-left:10px;padding-right:10px;'>
  <?php
  if($_POST['submitButton'] == 'Save Changes') {
    //TAG list check and update
    $RawTagArray = array();
    foreach($_POST['TAGS'] as $TAG) {
      $querystring = "SELECT * FROM `sessiontags` WHERE `Tag` LIKE '". strtoupper(htmlentities($TAG,ENT_QUOTES)) ."'";
      $TAGCheck = mysqli_num_rows(mysqli_query($con,$querystring));
      if($TAGCheck == 0) {
        //New Tag, add it to database. 
        $addtagquery = "INSERT INTO `sessiontags` (`TagID`, `Tag`) VALUES (NULL, '". strtoupper(htmlentities($TAG,ENT_QUOTES)) ."');";
        mysqli_query($con,$addtagquery) or die(mysqli_error($con));
      }
      array_push($RawTagArray,htmlentities($TAG,ENT_QUOTES));
    }
    $JSONTagArray = htmlentities(json_encode($RawTagArray),ENT_QUOTES);
    //var_dump($JSONTagArray);
    //echo PHP_EOL;

    $querystring = "UPDATE `logdata` SET `TAGS` = '$JSONTagArray' WHERE `logdata`.`SessionID` = '" . htmlentities($_POST['SessionID'],ENT_QUOTES) . "';";
    $UpdateTags = mysqli_query($con,$querystring);
    //echo $querystring;
    //echo PHP_EOL . PHP_EOL;
    //var_dump($UpdateTags);
    echo "<center><h1 style='margin-top:0;padding-top:0;'>Changes Saved</h1><p class='h1Subheading'>The changes have been saved to the database.</p></center>";
  }
  if($_POST['submitButton'] == 'Delete Session') {
    $querystring = "DELETE FROM `logdata` WHERE `logdata`.`SessionID` = '" . htmlentities($_POST['SessionID'],ENT_QUOTES) . "';";
    $DeleteSession = mysqli_query($con,$querystring);
    echo "<center><h1 style='margin-top:0;padding-top:0;'>Session Deleted</h1><p class='h1Subheading'>All data for the session has been deleted from the database.</p></center>";
  }
  ?>
  <script>
  setTimeout(function(){ parent.location.reload(); }, 2000);
  </script>
  <p><center>You may close this popup if it does not do so automatically.<br><small>Changes will not be displayed until the page is refreshed.</small></center></p>
  </div>
<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. <br>Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>