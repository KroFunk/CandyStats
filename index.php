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
  
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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
    if(checkvalue==true){
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php' ).load();
    } else {
      leaderboard.ajax.url( 'API/GET/leaderboard/datatables.php?hide=bots' ).load();
    }
}

  </script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Global Overview</div>
    <div class='menuButton'><img src="resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='upload/'>Upload Log</a><a href='login/'>Login</a></div>  
  </div>

  <center>
    <h1>Global Stats</h1>
    <p class='h1Subheading'>Below are general stats from all sessions</p>
  </center>
  <table style='width:100%;' cellspacing='0'>
    <tr>
      <td style='width:50%;'>
        <center><h2>Leaderboard</h2></center>
      </td>
      <td>
        <center><h2>Awards</h2></center>
      </td>
    </tr>
    <tr>
    <tr>
    <td valign='top'>

      <!--Leaderboard Table-->

      <table id='globalLeaderboard' class='display'>
        <thead>
        <tr><td>Name</td><td>K</td><td>D</td><td>KD</td></tr>
        </thead>
      </table>
      <input type='checkbox' onclick="showHideBots(this.checked);">Tick this box to include BOTS!

    </td>
    <td valign='top'>

      <!--Award Table-->

      <table id='awards' class='display'>
        <thead>
        <tr><td>Award</td><td>Winner</td><td>Value</td></tr>
        </thead>
      </table>

    </td>
    </tr>
  </table>

  <center>
    <h1>Sessions</h1>
    <p class='h1Subheading'>Below are are all the sessions uploaded to CandyStats.</p>
  </center>
  <table style='width:100%;'>
    <tr>
      <td style='width:48%;padding-left:10px;'>
        <center><h2>Available</h2></center>
      </td>
      <td>
      </td>
      <td style='width:48%;padding-right:10px;'>
        <center><h2>Selected</h2></center>
      </td>
    </tr>
    <tr>
      <td style='padding-left:10px;'>
        <div class='SelectionDiv'>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </div> 
      </td>
      <td>
        <div class='SelectionDiv SelectionButton'>>|</div>
        <div class='SelectionDiv SelectionButton'>></div>
        <div class='SelectionDiv SelectionButton'><</div>
        <div class='SelectionDiv SelectionButton'>|<</div>

      </td>
      <td style='padding-right:10px;'>
        <div class='SelectionDiv'>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
      </td>
    </tr>
    <tr>
  </table>

<hr>
<center><small>Made Possible by Robin Wright @KroFunk and Ian Arnold @Naiboss. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>