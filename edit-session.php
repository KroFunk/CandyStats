<?php
  require "resources/config.php";
  $autocompletearray = '';
  $query = mysqli_query($con,'SELECT * FROM `sessiontags`');
  while ($row = mysqli_fetch_array($query)){
    if(empty($autocompletearray)){
      $autocompletearray = '"'.$row['Tag'].'"';
    } else {
      $autocompletearray .= ', "'.$row['Tag'].'"';
    }
  }

?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Candy Stats</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link rel="stylesheet" href="resources/styles/style.css.php">
  <link rel="stylesheet" type="text/css" href="resources/styles/jquery.dataTables.dark.css">
  
  <script src='resources/js/scripts.js'></script>

  <style>
    * {
      box-sizing: border-box;
    }

    /*the container must be positioned relative:*/
    .autocomplete {
      position: relative;
      display: inline-block;
      width:100%;
    }

    .autocomplete-items {
      position: absolute;
      border: 1px solid #24292E;
      border-bottom: none;
      border-radius:4px;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }

    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #171A1C; 
      border-bottom:1px solid #24292E
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
      background-color: #24292E; 
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
      background-color: #8e7bd5 !important; 
      color: #ffffff; 
    }
  </style>
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
  $TAGS = json_decode(html_entity_decode($row['TAGS']));
  $TAGDivs = '';
  $randomnumber = 0; //in this case, the number doesn't have to be all that random...I think. 
  if(!empty($TAGS)){
    foreach($TAGS as $TAG){
    $TAGDivs .= '<div id="' . $TAG . $randomnumber . '" class="SelectionDivItem">' . $TAG . '<input type="hidden" name="TAGS[]" value="' . $TAG . '" /><div style="float:right;"><img style="cursor:pointer;" onclick="removeTag(this.parentNode.parentNode.id)" src="resources/images/UI/cross.png" /></div></div>';
    $randomnumber++;
    }
  }
  ?>
  <table>
    <tr>
      <td>SessionID:</td><td><b><?php echo $_GET['id']; ?></b></td>
    </tr>
    <tr>
      <td>TIMESTMAP:</td><td><b><?php echo date($DateFormat,strtotime($row['TIMESTAMP'])); ?></b></td>
    </tr>
  </table>
  <div style='padding-left:5px;'>TAGS:</div>
  <form autocomplete="off" method='POST' action='edit-session-save.php'>
  <div class="SelectionDivNoHover" id='tagdiv' style='height:110px !important;'>

  <?php echo $TAGDivs; ?>

  </div>
  <div class='autocomplete'>
    <input type='text' name='TAG1' id='TAG1' class='popupFormTextInput' style='width:100%; border-top-left-radius:0; border-top-right-radius:0;' onkeyup="return addtag(event)" value='' placeholder='Enter TAG...' /> 
  </div>
  <div style='float:right;'>
  <input type='hidden' value='<?php echo $_GET['id']; ?>' name='SessionID' />
  <p><input type="submit" class='glossyButton' value="Save Changes" /></p>
  </div>
  <div style='float:left;'>
  <p><input type="submit" class='glossyButtonRED' value="Delete Session" /></p>
  </div>
</form>
<script src='resources/js/autocomplete.js'></script>
<script>
  autocompletearray = [<?php echo $autocompletearray; ?>];
  autocomplete(document.getElementById("TAG1"), autocompletearray);
  
</script>

  </div>
<hr style="clear:both;">
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. <br>Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>