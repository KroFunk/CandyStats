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

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawWeaponChart);


      // Callback that draws the weapon bar graph.
      function drawWeaponChart() {

      // Create the data table
      var data = google.visualization.arrayToDataTable([
        ['Weapon', 'Other Kills', 'Headshot Kills'],
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

            if(!empty($value['Headshot Penetrated'])){
              $Headshot += $value['Headshot Penetrated'];
            }

            if(!empty($value['Kill_Base'])){
              $Kill_Base = $value['Kill_Base'];
            } else {
              $Kill_Base = 0;
            }

            if(!empty($value['Penetrated'])){
              $Kill_Base += $value['Penetrated'];
            }

          echo "['" . $key . "', " . $Kill_Base . ", " . $Headshot . "]";
          $i++;
          }
          echo PHP_EOL;
        ?>
      ]);

      var options = {
        title:'Total Weapon Kills',
        titlePosition:'none',
        chartArea:{left:30,top:35,width:'95%',height:'50%'},
        backgroundColor: '#171A1C',
        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
        width: 700,
        height: 400,
        legend: { textStyle: {color: '#B3B4AE', fontSize: 10}, position: 'top', maxLines: 2 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        hAxis: {
          slantedTextAngle: 90,
          textStyle:{
            color: '#B3B4AE',
            fontSize: 12
          }
        },
        vAxis: {
        
          textStyle:{
            color: '#B3B4AE'
          }
        },
      };

      // Instantiate and draw the chart for Anthony's pizza.
      var chart = new google.visualization.ColumnChart(document.getElementById('weaons_div'));
      chart.draw(data, options);
      }
    </script>
  

</head>

<body style='background:#171a1c !important;'>

<!--Div that will hold the pie chart-->
<div id="weaons_div"></div>

</body>

</html>