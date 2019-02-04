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
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawWeaponChart);


      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

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

          ['IrateDwarf', 3],
          ['SFAIGAMER', 1]

          // echo "['".$row['Misc_2']."', ".$row['count(*)']."]"
          
        ]);

        // Set chart options
        var options = {'title':'Player Kills',
                        backgroundColor: '#171A1C',
                        legend: {position: 'right', textStyle: {color: '#B3B4AE', fontSize: 12}},
                        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
                       'width':400,
                       'height':200};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
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
        width: 400,
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
      var chart = new google.visualization.BarChart(document.getElementById('graph_div'));
      chart.draw(data, options);
      }
    </script>
  

</head>

<body style='background:#171a1c !important;'>

<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
<div id="graph_div"></div>


</body>

</html>