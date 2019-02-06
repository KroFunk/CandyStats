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
    google.charts.setOnLoadCallback(drawKillsChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawKillsChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Player');
        data.addColumn('number', 'Kills');
        data.addRows([
        
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
                        titlePosition:'none',
                        backgroundColor: '#171A1C',
                        chartArea:{left:5,top:5,width:'100%',height:'100%'},
                        legend: {position: 'right', textStyle: {color: '#B3B4AE', fontSize: 12}},
                        titleTextStyle: {color: '#FFF6EF', fontName: 'Arial', fontSize: 24, bold: 0},
                       'width':350,
                       'height':280};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('kills_div'));
        chart.draw(data, options);
      }

	  
    </script>
  

</head>

<body style='background:#171a1c !important;'>

<!--Div that will hold the pie chart-->
<div id="kills_div"></div>

</body>

</html>