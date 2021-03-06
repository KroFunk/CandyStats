<?php
  require "resources/config.php";

  //fetch and decode array of SessionIDs
  $encodedLogArray = file_get_contents("php://input");
  $logArray = json_decode($encodedLogArray);

  if(empty($logArray)){
    exit();
  }

  //This backward chunk is to build the WHERE clause for the SQL query
  $Where = '';

  foreach ($logArray as $key => $value) {
    if($Where == ''){
      $Where .= "`SessionID` = '".$value."'";
    } else {
      $Where .= ' OR `SessionID` = ' . "'".$value."'";
    }    
  }


  $queryString = "SELECT * FROM `logdata` WHERE (".$Where.") AND `EventType` = 'Loading Map' GROUP BY `MapInfo`";
  
  //debug should be commented in production
  //echo $queryString;
  //echo '<hr>';
  
  $query = mysqli_query($con,$queryString);
  $sessionMap = '';

  while($row = mysqli_fetch_array($query)){
              
    if($sessionMap != $row['MapInfo']){
      //I think this was a reduntant check...
      //if($sessionMap != ''){
        //echo '</div><!-- sessionMap' . $row['MapInfo'] . ' -->';//close previous sessionMap div so long as it isn't the first row!
      //}
      $sessionMap = $row['MapInfo'];
      echo "<div class='SelectionDivItem sessionMap' id='sessionMap" . $sessionMap . "' style='overflow:hidden; max-height:30px; padding:5px; cursor:pointer; float:left; width:340px;' onclick='selectSessionMap(`sessionMap" . $sessionMap . "`)'>" . $sessionMap . "</div>";
    }


  }
?>
