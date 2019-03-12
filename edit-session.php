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
      <!--Load the AJAX API-->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawKillsChart);
	  google.charts.setOnLoadCallback(drawDeathsChart);
      google.charts.setOnLoadCallback(drawWeaponChart);


      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawKillsChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Player');
        data.addColumn('number', 'Kills');
        data.addRows([
          
          //################################# Magic happens here ###################################
          //# These are examples.                                                                  #
          //# A query will need to be made that lists all the players killed by a supplied steam   # 
          //# ID and count the number of kills.                                                    #
          //# Then a PHP loop will create the array for the Google Chart/Graph                     #
          //########################################################################################

          // echo "['".$row['Misc_2']."', ".$row['count(*)']."]"
          
		<?php
          $queryString = "SELECT `EventVariable`, count(*) FROM `logdata` WHERE `SteamID` = '" . htmlentities($_GET['ID'], ENT_QUOTES) . "' AND `EventType` = 'killed' AND `EventVariable` LIKE 'STEAM_%' GROUP BY `EventVariable` ORDER BY count(*) DESC";
          $query = mysqli_query($con, $queryString);
          $victimChartArray = array();
		  $i=0;
          while($result = mysqli_fetch_array($query)){
			  if($i > 0){
              echo ',' . PHP_EOL;
            }
          echo "['" . $_SESSION[$result['EventVariable'] . 'name'] . "', " . $result['count(*)'] . "]";
		  $i++;
		  }
          echo PHP_EOL;
        ?>
		  
        ]);

        // Set chart options
        var options = {'title':'Player Kills',
                        backgroundColor: '#171A1C',
                        legend: {position: 'right', textStyle: {color: '#B3B4AE', fontSize: 12}},
                        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
                       'width':490,
                       'height':425};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('kills_div'));
        chart.draw(data, options);
      }

	  function drawDeathsChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Player');
        data.addColumn('number', 'Deaths');
        data.addRows([
          
          //################################# Magic happens here ###################################
          //# These are examples.                                                                  #
          //# A query will need to be made that lists all the players killed by a supplied steam   # 
          //# ID and count the number of kills.                                                    #
          //# Then a PHP loop will create the array for the Google Chart/Graph                     #
          //########################################################################################

          // echo "['".$row['Misc_2']."', ".$row['count(*)']."]"
          
		<?php
          $queryString = "SELECT `SteamID`, count(*) FROM `logdata` WHERE `EventVariable` = '" . htmlentities($_GET['ID'], ENT_QUOTES) . "' AND `EventType` = 'killed' AND `SteamID` LIKE 'STEAM_%' GROUP BY `SteamID` ORDER BY count(*) DESC";
          $query = mysqli_query($con, $queryString);
          $victimChartArray = array();
		  $i=0;
          while($result = mysqli_fetch_array($query)){
			  if($i > 0){
              echo ',' . PHP_EOL;
            }
          echo "['" . $_SESSION[$result['SteamID'] . 'name'] . "', " . $result['count(*)'] . "]";
		  $i++;
		  }
          echo PHP_EOL;
        ?>
		  
        ]);

        // Set chart options
        var options = {'title':'Player Deaths',
                        backgroundColor: '#171A1C',
                        legend: {position: 'right', textStyle: {color: '#B3B4AE', fontSize: 12}},
                        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
                       'width':490,
                       'height':425};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('deaths_div'));
        chart.draw(data, options);
      }
	  
      // Callback that draws the weapon bar graph.
      function drawWeaponChart() {

      // Create the data table
      var data = google.visualization.arrayToDataTable([
        ['Weapon', 'Kills', 'Headshot'],
        <?php
          $queryString = "SELECT `Misc_1`, `Misc_3`, count(*) FROM `logdata` WHERE `SteamID` = '" . htmlentities($_GET['ID'], ENT_QUOTES) . "' AND `EventType` = 'killed' GROUP BY `Misc_3`, `Misc_1` ORDER BY `Misc_1`,`Misc_3` ASC";
          $query = mysqli_query($con, $queryString);
          $weaponChartArray = array();
          while($result = mysqli_fetch_array($query)){
            $weaponChartArray[$result['Misc_1']][$result['Misc_3']] = $result['count(*)'];
          }
          $i = 0;
          foreach($weaponChartArray as $key => $value) {
            if($i > 0){
              echo ',' . PHP_EOL;
            }

            if(!empty($value['Headshot'])){
              $Headshot = $value['Headshot'];
            } else {
              $Headshot = 0;
            }

            if(!empty($value['Kill_Base'])){
              $Kill_Base = $value['Kill_Base'];
            } else {
              $Kill_Base = 0;
            }

          echo "['" . $key . "', " . $Headshot . ", " . $Kill_Base . "]";
          $i++;
          }
          echo PHP_EOL;
        ?>
      ]);

      var options = {
        title:'Weapon Kills',
        backgroundColor: '#171A1C',
        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
        width: 490,
        height: 850,
        legend: { textStyle: {color: '#B3B4AE', fontSize: 10}, position: 'top', maxLines: 2 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        hAxis: {
          textStyle:{
            color: '#B3B4AE'
          }
        },
        vAxis: {
          textStyle:{
            color: '#B3B4AE'
          }
        },
      };

      // Instantiate and draw the chart for Anthony's pizza.
      var chart = new google.visualization.BarChart(document.getElementById('weaons_div'));
      chart.draw(data, options);
      }
    </script>

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
      <td>TIMESTMAP:</td><td><b><?php echo date($DateTimeFormat,strtotime($row['TIMESTAMP'])); ?></b></td>
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
  <p><input name='submitButton' type="submit" class='glossyButton' value="Save Changes" /></p>
  </div>
  <div style='float:left;'>
  <p><input name='submitButton' onclick="return confirm('Are you sure you want to delete this session?\r\n\r\n...You will need to re-upload the logs if you want the data back!');" type="submit" class='glossyButtonRED' value="Delete Session" /></p>
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