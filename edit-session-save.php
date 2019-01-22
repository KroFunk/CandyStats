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
    <h1 style='margin-top:0;padding-top:0;'>Changes Saved</h1>
    <p class='h1Subheading'>The changes have been saved to the database.</p>
  </center>
  <div style='padding-left:10px;padding-right:10px;'>
  <?php
  //TAG1
  $querystring = "SELECT * FROM `sessiontags` WHERE `Tag` LIKE '". strtoupper(htmlentities($_POST['TAG1'],ENT_QUOTES)) ."'";
  $TAGCheck = mysqli_num_rows(mysqli_query($con,$querystring));
  if($TAGCheck == 0) {
    //New Tag, add it to database. 
    $addtagquery = "INSERT INTO `sessiontags` (`TagID`, `Tag`) VALUES (NULL, '". strtoupper(htmlentities($_POST['TAG1'],ENT_QUOTES)) ."');";
    mysqli_query($con,$addtagquery) or die(mysqli_error($con));
  }

  //TAG2
  $querystring = "SELECT * FROM `sessiontags` WHERE `Tag` LIKE '". strtoupper(htmlentities($_POST['TAG2'],ENT_QUOTES)) ."'";
  $TAGCheck = mysqli_num_rows(mysqli_query($con,$querystring));
  if($TAGCheck == 0) {
    //New Tag, add it to database. 
    $addtagquery = "INSERT INTO `sessiontags` (`TagID`, `Tag`) VALUES (NULL, '". strtoupper(htmlentities($_POST['TAG2'],ENT_QUOTES)) ."');";
    mysqli_query($con,$addtagquery) or die(mysqli_error($con));
  }

  //TAG3
  $querystring = "SELECT * FROM `sessiontags` WHERE `Tag` LIKE '". strtoupper(htmlentities($_POST['TAG3'],ENT_QUOTES)) ."'";
  $TAGCheck = mysqli_num_rows(mysqli_query($con,$querystring));
  if($TAGCheck == 0) {
    //New Tag, add it to database. 
    $addtagquery = "INSERT INTO `sessiontags` (`TagID`, `Tag`) VALUES (NULL, '". strtoupper(htmlentities($_POST['TAG3'],ENT_QUOTES)) ."');";
    mysqli_query($con,$addtagquery) or die(mysqli_error($con));
  }

  //$query = mysqli_query($con,$querystring);
  //$row = mysqli_fetch_array($query);
  
  ?>
  <p>You may close this popup if it does not do so automatically.</p>
  </div>
<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. <br>Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>