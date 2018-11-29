<?php
require "../resources/config.php";

////////////   Real Time Output    ////////////
set_time_limit( 120);
ignore_user_abort(true);

////////////  SYNTAX ERROR CHECK    ////////////
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$EventTypeArray = array("triggered","connected","disconnected","purchased","threw","killed","assisted","blinded");

$NameEventsArray = array("Round_Start","Round_End","Game_Commencing","Match_Start","CT","TERRORIST","sv_cheats");
$NameEventsArrayCash = array("cash_player_killed_teammate","cash_player_respawn_amount","cash_team_winner_bonus_consecutive_rounds","cash_team_rescued_hostage","cash_team_win_by_defusing_bomb","cash_player_interact_with_hostage","cash_team_elimination_bomb_map","cash_player_get_killed","cash_team_loser_bonus","cash_player_rescued_hostage","cash_player_killed_enemy_default","mp_hostagepenalty","cash_team_hostage_interaction","cash_team_win_by_time_running_out_bomb","cash_player_killed_enemy_factor","cash_team_survive_guardian_wave","cash_team_terrorist_win_bomb","cash_team_elimination_hostage_map_t","cash_team_win_by_time_running_out_hostage","cash_player_bomb_planted","cash_player_bomb_defused","cash_team_planted_bomb_but_defused","cash_player_killed_hostage","cash_team_elimination_hostage_map_ct","cash_team_win_by_hostage_rescue","cash_team_loser_bonus_consecutive_rounds","cash_player_damage_hostage","cash_team_hostage_alive");

$skipEventVariableArray = array("STEAM USERID validated","entered the game","switched from team <Unassigned> to <TERRORIST>","switched from team <Unassigned> to <CT>","switched from team <TERRORIST> to <CT>","switched from team <CT> to <TERRORIST>","switched from team <CT> to <Unassigned>","switched from team <TERRORIST> to <Unassigned>");
$skipMiscArray = array("Rescued_A_Hostage","committed suicide","Touched_A_Hostage","connected, address ","purchased ","disconnected (reason ","switched from team <Unassigned> to <TERRORIST>","switched from team <Unassigned> to <CT>","switched from team <TERRORIST> to <CT>","switched from team <CT> to <TERRORIST>","switched from team <CT> to <Unassigned>","switched from team <TERRORIST> to <Unassigned>");//Sometimes spaces are important!

// Variable Creation
$SessionID      = "";
$TIMESTAMP      = "";
$TAG1           = "";
$TAG2           = "";
$TAG3           = "";
$Name           = "";
$SteamID        = "";
$Team           = "";
$EventType      = "";
$EventVariable  = "";
$Misc           = "";
$XYZ            = "";

$isPlayer       = True;
$lessThanPosition = "0";

$rowAccept      = True;

if(isset($_GET['debug'])){
    $debug=true;
} else {
    $debug=false;
}
$arr_file_types = ['application/octet-stream'];
 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "Error: Only .log files are supported 'application/octet-stream'.\n\nFile provided: " . $_FILES['file']['type'];
    return;
}

if($debug==true){
    echo '<pre>';
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Log Processing debug Active!" . PHP_EOL . PHP_EOL;
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Process start time: " . date('Y.m.d H:i:s') . PHP_EOL . PHP_EOL;
    $file = $_FILES["file"]["tmp_name"]; 
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> File Variable set." . PHP_EOL;
    $handle = @fopen($file,"r"); 
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Handle set; File opened." . PHP_EOL;

    //loop through the log file and insert into database 
    
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Parsing Data..." . PHP_EOL;
    //SessionID is constant and does not need to be re-read.
    $SessionID      = $_FILES["file"]["name"];

    while ($data = fgets($handle,4096)) { 
        
        $string         = htmlentities($data);
        if(strpos($data,'"') !== false) {
            $exploded       = @explode('"',$data);
        } else {
            $exploded       = '123456789abcdefghijklmnopqrstuvwxyz'; //No data in double quotes present, filling with fluff to help debug any issues!
        }
        

        echo PHP_EOL . PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span> Reading line:" . $string;

        echo "<span style='color:#7accd3'>SessionID:</span><span style='color:#7ad380'>" . $SessionID . "</span>" . PHP_EOL;

        echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Timestamp..." . PHP_EOL;
        $TIMESTAMP      = substr($string,2,21);
        $TIMESTAMP      = str_replace(" -","",$TIMESTAMP);
        $TIMESTAMP      = date('Y-m-d H:i:s', strtotime($TIMESTAMP));
        echo "<span style='color:#7accd3'>TIMESTAMP:</span><span style='color:#7ad380'>" . $TIMESTAMP . "</span>" . PHP_EOL;

        $TAG1           = "";
        $TAG2           = "";
        $TAG3           = "";

        
        $explodedName   = $exploded[1];

        if(stripos($string,'Loading map') !== false){
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Special Line; Loading Map..." . PHP_EOL;
            $Name           = "World";
            $EventType      = "Loading Map";
            $EventVariable  = @explode('<',$explodedName)[0];
            echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>EventType:</span><span style='color:#7ad380'>" . $EventType . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
            //Enter World Row into MySQL!
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
            $queryString = "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAG1`, `TAG2`, `TAG3`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `XYZ_1`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '', '', '" . htmlentities($Name, ENT_QUOTES) . "', NULL, NULL, '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', NULL, NULL);";
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Executing: " . $queryString . "</span>" . PHP_EOL;
            mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));
        
        } else {//end of special considerations!
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Name..." . PHP_EOL;
            $Name          = @explode('<',$explodedName)[0];

            if (@!empty(stripos($exploded[1],'<'))) {
                $isPlayer = true;
            } else {
                $isPlayer = false;
            }
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Is this a player: ";
            echo $isPlayer ? "True" : "False";
            echo PHP_EOL;
            if($isPlayer == false){
                echo '<span style="color:#8e7bd5">[CandyStats]</span> Checking if "' . $Name . '" is in the NameEventsArray...' . PHP_EOL;
                if(in_array($Name,$NameEventsArray)){
                    //Store World Event
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> "' . $Name . '" is an important NameEvent...' . PHP_EOL;
                    $Name           = "World";
                    $EventType      = "Triggered";
                    $EventVariable  = @explode('<',$explodedName)[0];

                    echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
                    echo "<span style='color:#7accd3'>EventType:</span><span style='color:#7ad380'>" . $EventType . "</span>" . PHP_EOL;
                    echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
                    //Enter World Row into MySQL!
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
                    $queryString = "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAG1`, `TAG2`, `TAG3`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `XYZ_1`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '', '', '" . htmlentities($Name, ENT_QUOTES) . "', NULL, NULL, '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', NULL, NULL);";
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Executing: " . $queryString . "</span>" . PHP_EOL;
                    mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));

                } else if(in_array($Name,$NameEventsArrayCash)){
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> Checking if "' . $Name . '" is in the NameEventsArrayCash...' . PHP_EOL;
                    //Store Cash Event
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> "' . $Name . '" is a Cash NameEvent more processing will happen...' . PHP_EOL;
                } else {
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> <span style="color:#d37a7a;">"' . $Name . '" is not present in the Arrays...' . "</span>" . PHP_EOL;
                    //Query Ian to see if event is worth storing
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#d37a7a;'>Line ignored!</span>" . PHP_EOL;
                }
            } else {
                //This line of the log is in regards to a player, continue process.
                echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting SteamID..." . PHP_EOL;
                $SteamID        = str_replace('>','',@explode('<',$explodedName)[2]);
                echo "<span style='color:#7accd3'>SteamID:</span><span style='color:#7ad380'>" . $SteamID . "</span>" . PHP_EOL;
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Team..." . PHP_EOL;
                $Team           = str_replace('>','',@explode('<',$explodedName)[3]);
                echo "<span style='color:#7accd3'>Team:</span><span style='color:#7ad380'>" . $Team . "</span>" . PHP_EOL;
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting EventType..." . PHP_EOL; 
                //Whilst this is where I am grabbing the EventType, it sometimes gets modified, check after extracting EventVariable.

                $EventType      = str_replace(array("\r","\n"),'',substr(htmlentities($exploded[2]),1));
                if($EventType[0] == '[') {
                    $EventType = str_replace(array("\r","\n"),'',str_replace(' ','',substr($EventType,(strpos($EventType,']')+2))));
                }
                if($EventType == 'committedsuicidewith'){
                    $EventType = 'committed suicide';
                }
                if(strpos($EventType,'threw') !== false){
                    //I got lazy, I figure if the line contains threw, then the player threw an Event Var!
                    $EventType = 'threw';
                }
                if(stripos($EventType, 'blinded') !== false) {
                    $EventType = 'blinded';
                }
                if(stripos($EventType, 'switched from team') !== false){
                    $EventType = 'switched team';
                }
                echo "<span style='color:#7accd3'>EventType:</span><span style='color:#7ad380'>" . $EventType . "</span>" . PHP_EOL;

                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting EventVariable..." . PHP_EOL;
                
                if($EventType == 'threw'){
                    $EventVariable = explode(' ',htmlentities($exploded[2]))[2];
                } else if($EventType == 'killed') {
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0] . '<BOT>');
                    }
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = htmlentities($exploded[5]);
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);
                    echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
                } else if($EventType == 'assisted killing '){ //sometimes spaces are important!
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0] . '<BOT>');
                    }
                    echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = '';
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);
                
                } else if($EventType == 'blinded') {
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0] . '<BOT>');
                    }
                    echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = explode(' ',$exploded[2])[3] . '|' . explode(' ',$exploded[4])[4]; //time in seconds | entindex
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);

                } else if($EventType == 'switched team'){
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $tempvar = htmlentities(explode('<',$exploded[2])[1]);
                    $Misc_1 = substr($tempvar,0,stripos(htmlentities($tempvar),'>'));
                    $tempvar = htmlentities(explode('<',$exploded[2])[2]);
                    $Misc_2 = substr($tempvar,0,stripos(htmlentities($tempvar),'>'));
                    $tempvar = '';
                    
                } else if(in_array(html_entity_decode($EventType),$skipEventVariableArray)){ //I know, it's a hack, but at least it's a neat one!
                    $EventVariable  = ''; // Don't judge me!
                } else {
                    $EventVariable  = htmlentities($exploded[3]);
                    
                    //Misc_1 should only apply when NOT certain EventTypes are detected. More cases true than not.
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                       
                    if($EventVariable == 'flashbang' && $EventType != 'purchased '){ // sometimes spaces are important
                        $Misc_1 = str_replace(array("\r","\n"),'',str_replace(')','',explode(' ',$exploded[2])[8]));
                    } else if(in_array(html_entity_decode($EventVariable),$skipMiscArray) || in_array(html_entity_decode($EventType),$skipMiscArray)){
                        $Misc_1 = ''; //I got away with it last time, no reason why I shouldn't do it again!
                        //var_dump($exploded);
                    } else {
                        $Misc_1           = htmlentities($exploded[5]);
                        //var_dump($exploded);
                    }
                }


                

                echo "<span style='color:#7accd3'>Misc_1:</span><span style='color:#7ad380'>" . $Misc_1 . "</span>" . PHP_EOL;
                if(!empty($Misc_2)){
                    echo "<span style='color:#7accd3'>Misc_2:</span><span style='color:#7ad380'>" . $Misc_2 . "</span>" . PHP_EOL;
                }
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting XYZ..." . PHP_EOL;
                if($EventType == "killed" || $EventType == "assisted killing "){ //sometimes spaces are important!
                    $XYZ_1 = substr(htmlentities($exploded[2]),2,(strpos(htmlentities($exploded[2]),']'))-2);
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> XYZ_1:" . $XYZ_1 . PHP_EOL;
                    $XYZ_2 = substr(htmlentities($exploded[4]),2,(strpos(htmlentities($exploded[4]),']'))-2);
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> XYZ_2:" . $XYZ_2 . PHP_EOL;
                }
                if($EventType == "threw"){
                    $subString_1    = substr(htmlentities($exploded[2]),(strpos(htmlentities($exploded[2]),'[') + 1));
                    $XYZ_1            = substr($subString_1,0,(strpos($subString_1,']')));
                }
                if($EventType == "committed suicide"){
                    //var_dump($exploded);
                    $XYZ_1 = substr(htmlentities($exploded[2]),2,(strpos(htmlentities($exploded[2]),']'))-2);
                }
                echo "<span style='color:#7accd3'>XYZ_1:</span><span style='color:#7ad380'>" . $XYZ_1 . "</span>" . PHP_EOL;
                if(!empty($XYZ_2)){
                    echo "<span style='color:#7accd3'>XYZ_2:</span><span style='color:#7ad380'>" . $XYZ_2 . "</span>" . PHP_EOL;
                }
                //Enter Player Row into MySQL!
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
                $queryString = "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAG1`, `TAG2`, `TAG3`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `Misc_2`, `XYZ_1`, `XYZ_2`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '', '', '" . htmlentities($Name, ENT_QUOTES) . "', '" . htmlentities($SteamID, ENT_QUOTES) . "', '" . htmlentities($Team, ENT_QUOTES) . "', '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', '" . htmlentities($Misc_1, ENT_QUOTES) . "', '" . htmlentities($Misc_2, ENT_QUOTES) . "', '" . htmlentities($XYZ_1, ENT_QUOTES) . "', '" . htmlentities($XYZ_2, ENT_QUOTES) . "');";
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Executing: " . $queryString . "</span>" . PHP_EOL;
                mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));
            }
        }
        // Variable Reset!
        //$SessionID      = "";
        $TIMESTAMP      = "";
        $TAG1           = "";
        $TAG2           = "";
        $TAG3           = "";
        $Name           = "";
        $SteamID        = "";
        $Team           = "";
        $EventType      = "";
        $EventVariable  = "";
        $Misc_1         = "";
        $Misc_2         = "";
        $XYZ_1          = "";
        $XYZ_2          = "";

        $isPlayer       = True;
        $lessThanPosition = "0";

        $rowAccept      = True;
        flush();
        ob_flush();
    }

    echo PHP_EOL . PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span> Process end time: " . date('d/m/y H:i:s') . PHP_EOL;
    echo '</pre>';
}

 

//echo "Log Uploaded Successfully.";
?>