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
  
  <script src="resources/js/jquery-1.10.2.js"></script>
  <script type="text/javascript" charset="utf8" src="resources/js/jquery.dataTables.js"></script>
  <script src="resources/js/scripts.js"></script>
  
  <script>
  $(document).ready( function () {
    leaderboard = $('#globalLeaderboard').DataTable( {
      'columnDefs': [
        {
            "targets": 0,
            "className": "text-left"
        },
        {
            "targets": 1,
            "width":"15%",
            "className": "text-right"
        },
        {
            "targets": 2,
            "width":"15%",
            "className": "text-right"
        },
        {
            "targets": 3, 
            "width":"15%",
            "className": "text-right"
        }
      ],
      "order": [[ 3, "desc" ]],
      "lengthChange": false,
      "ajax": 'API/GET/leaderboard/datatables.php?hide=bots'
    });
  } );

    $(document).ready( function () {
    awards = $('#awards').DataTable( {
      "ordering": false,
      "paging": false,
      "info": false,
      "ajax": 'API/GET/awards/datatables.php'
    });
  } );

  function showHideBots(checkvalue) {
    if(checkvalue=='Show BOTS!'){
      leaderboard.clear();
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php' ).load();
      document.getElementById('showHideBotsButton').value = 'Hide BOTS!';
    } else {
      leaderboard.clear();
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php?hide=bots' ).load();
      document.getElementById('showHideBotsButton').value = 'Show BOTS!';
    }
  }

    function fullList(checkvalue) {
    if(checkvalue=='Show all players!'){
      leaderboard.page.len(-1).draw();
      document.getElementById('fullListButton').value = 'Show Top 10!';
    } else {
      leaderboard.page.len(10).draw();
      document.getElementById('fullListButton').value = 'Show all players!';

    }
  }
  </script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Global Overview</div>
    <div class='menuButton'><img src="resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='team_calculator/'>Team Calculator</a><a href='config/'>Config Variables</a><a href='upload/'>Upload Log</a>|&nbsp;&nbsp;<a href='login/'>Login</a></div>  
  </div>

  <?php 
  session_destroy();
  echo '<p>PHP Session data has been unset!</p>'; 
  ?>
  

<hr>
<center><small>Made Possible by Robin Wright <a href='https://twitter.com/krofunk' class='footerLink' target='_new'>@KroFunk</a> and Ian Arnold <a href='https://twitter.com/naiboss'  class='footerLink' target='_new'>@Naiboss</a>. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>

<!-- yes, this script is supposed to be down here! http://krofunk.github.io/LightBox/ -->
<script type="text/javascript" src="resources/js/lightbox.wrapper.js"></script>
</body>

</html>