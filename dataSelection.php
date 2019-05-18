<?php
  require "resources/config.php";

  $encodedLogArray = file_get_contents("php://input");
  $logArray = json_decode($encodedLogArray);

  /*foreach ($logArray as $key => $value) {
    echo '<div>'.$value.'</div>';
  }*/

  $queryString = "SELECT * FROM `logdata` WHERE `EventType` = 'Loading Map' GROUP BY `EventVariable`";
  $query = mysqli_query($con,$queryString);
  $sessionMap = '';
  while($row = mysqli_fetch_array($query)){
              
    if($sessionMap != $row['EventVariable']){
      if($sessionMap != ''){
        echo '</div><!-- sessionMap' . $row['EventVariable'] . ' -->';//close previous sessionMap div so long as it isn't the first row!
      }
      $sessionMap = $row['EventVariable'];
      echo "<div class='sessionMap' id='sessionMap" . $sessionMap . "' style='overflow:hidden; max-height:30px;'> <div> <div style='padding:5px; cursor:pointer; float:left; width:300px;' onclick='selectSessionMap(`" . $sessionMap . "`)'>" . $sessionMap . "</div></div>";
    }
  }
?>
