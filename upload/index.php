<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Candy Stats</title>
  <meta name="description" content="PHP Script for storing and reporting on CSGO server logs">
  <meta name="author" content="KroFunk and Naiboss">

  <link rel="stylesheet" href="../resources/styles/style.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="../resources/js/scripts.js?random=<?php echo rand(0,10000); ?>"></script>
</head>

<body>


<div class='bodyWrapper'>
  <div class='menuBar' id='menuBar'>
    <div class='logo'>CandyStats : Upload Log</div>
    <div class='menuButton'><img src="../resources/images/UI/login-nograd.png" /></div>
    <div class='menuLink'><a href='../upload/'>Upload Log</a><a href='../login/'>Login</a></div>  
  </div>

  <div class='contentDiv'>
  <a href='../'>Click here to go back to Game Overview</a>
    
      <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
        <div id="drag_upload_file">
            <!--img src="../resources/images/UI/log.png" /-->
            <p>Drop log file here</p>
            <p>or</p>
            <p><input type="button" class="glossyButton" value="Select File" onclick="file_explorer();"></p>
            <input type="file" id="selectfile">
        </div>
      </div>
    

    

  </div>

  <hr>
  <center><small>Made Possible by Robin Wright @KroFunk and Ian Arnold @Naiboss. Copyright &copy; 2018-<?php echo date('Y') ?>, Licensed under GNU GPL V3.</small></center>
</div>
  
</body>

</html>