<?php
  require "resources/config.php";

  $encodedLogArray = file_get_contents("php://input");
  $logArray = json_decode($encodedLogArray);

  $Where = '';

  foreach ($logArray as $key => $value) {
    if($Where == ''){
      $Where .= "`SessionID` = '".$value."'";
    } else {
      $Where .= ' OR `SessionID` = ' . "'".$value."'";
    }
    
  }

  $queryString = "SELECT * FROM `logdata` WHERE ".$Where." AND `EventType` = 'Loading Map' GROUP BY `MapInfo`";
  //echo $queryString;
  $query = mysqli_query($con,$queryString);
  $sessionMap = '';
  while($row = mysqli_fetch_array($query)){
              
    if($sessionMap != $row['MapInfo']){
      if($sessionMap != ''){
        echo '</div><!-- sessionMap' . $row['MapInfo'] . ' -->';//close previous sessionMap div so long as it isn't the first row!
      }
      $sessionMap = $row['MapInfo'];
      echo "<div class='SelectionDivItem sessionMap' id='sessionMap" . $sessionMap . "' style='overflow:hidden; max-height:30px;'> <div> <div style='padding:5px; cursor:pointer; float:left; width:300px;' onclick='selectSessionMap(`" . $sessionMap . "`)'>" . $sessionMap . "</div></div>";
    }
  }
?>
