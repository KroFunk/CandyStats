<?php
require "../resources/config.php";

////////////   Real Time Output    ////////////
set_time_limit( 120);
ignore_user_abort(true);

////////////  SYNTAX ERROR CHECK    ////////////
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Events I am looking for
$EventTypeArray = array("triggered","connected","disconnected","purchased","threw","killed","assisted","blinded");

$NameEventsArray = array("Round_Start","Round_End","Game_Commencing","Match_Start","CT","TERRORIST","sv_cheats");
$NameEventsArrayCash = array("cash_player_killed_teammate","cash_player_respawn_amount","cash_team_winner_bonus_consecutive_rounds","cash_team_rescued_hostage","cash_team_win_by_defusing_bomb","cash_player_interact_with_hostage","cash_team_elimination_bomb_map","cash_player_get_killed","cash_team_loser_bonus","cash_player_rescued_hostage","cash_player_killed_enemy_default","mp_hostagepenalty","cash_team_hostage_interaction","cash_team_win_by_time_running_out_bomb","cash_player_killed_enemy_factor","cash_team_survive_guardian_wave","cash_team_terrorist_win_bomb","cash_team_elimination_hostage_map_t","cash_team_win_by_time_running_out_hostage","cash_player_bomb_planted","cash_player_bomb_defused","cash_team_planted_bomb_but_defused","cash_player_killed_hostage","cash_team_elimination_hostage_map_ct","cash_team_win_by_hostage_rescue","cash_team_loser_bonus_consecutive_rounds","cash_player_damage_hostage","cash_team_hostage_alive");

// Ignore these events in certain circumstances
$skipEventVariableArray = array("STEAM USERID validated","entered the game","switched from team <Unassigned> to <TERRORIST>","switched from team <Unassigned> to <CT>","switched from team <TERRORIST> to <CT>","switched from team <CT> to <TERRORIST>","switched from team <CT> to <Unassigned>","switched from team <TERRORIST> to <Unassigned>");
$skipMiscArray  = array("Dropped_The_Bomb","Got_The_Bomb","Player has left the game - IGNORE","Rescued_A_Hostage","committed suicide","Touched_A_Hostage","connected","connected, address ","purchased","disconnected","disconnected (reason ","switched from team <Unassigned> to <TERRORIST>","switched from team <Unassigned> to <CT>","switched from team <TERRORIST> to <CT>","switched from team <CT> to <TERRORIST>","switched from team <CT> to <Unassigned>","switched from team <TERRORIST> to <Unassigned>");//Sometimes spaces are important!

// These events go into the Misc_3 field for joining the logdata and base score tables. 
$Misc_3_Array   = array("Planted_The_Bomb","Dropped_The_Bomb","Got_The_Bomb","Begin_Bomb_Defuse_Without_Kit","Rescued_A_Hostage","Touched_A_Hostage");
$bombLastPlantedBy  = "";

// When a player connects, they join the array, when they leave they get moved into inactive. Events relating to a player not in the active list should be ignored unless it's a connect string! 
$activePlayers  = array();
$inactivePlayers = array();

// Variable Creation
$SessionID      = "";
$TIMESTAMP      = "";
$TAGS           = "";
$Name           = "";
$SteamID        = "";
$Team           = "";
$EventType      = "";
$EventVariable  = "";
$Misc_1         = "";
$Misc_2         = "";
$Misc_3         = "";
$XYZ_1          = "";
$XYZ_2          = "";
$score          = "";

$isPlayer       = True;
$lessThanPosition = "0";

$rowAccept      = True;
$logClosed      = False;

$queryString = "";

function PlayerActive() {
    if(in_array($GLOBALS['SteamID'],$GLOBALS['activePlayers'])){
        //player is already in array, do nothing for now.
    } else {
        if(!in_array($GLOBALS['SteamID'],$GLOBALS['inactivePlayers'])){
            array_push($GLOBALS['activePlayers'],$GLOBALS['SteamID']);
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Active Players Array updated!".PHP_EOL;

            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
            $GLOBALS['$queryString'] .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `Misc_2`, `Misc_3`, `XYZ_1`, `XYZ_2`) VALUES (NULL, '" . htmlentities($GLOBALS['SessionID'], ENT_QUOTES) . "', '" . htmlentities($GLOBALS['TIMESTAMP'], ENT_QUOTES) . "', '', '', '" . htmlentities($GLOBALS['SteamID'], ENT_QUOTES) . "', '', 'connected', '', '', '', '', '', '');";
            //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
            //mysqli_query($GLOBALS['con'], $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($GLOBALS['con']));

            var_dump($GLOBALS['activePlayers']);
            echo PHP_EOL;
        } else {
            //This player has been marked as inactive!
        }
        
    }
}

if(isset($_GET['debug'])){
    $debug=true;
} else {
    $debug=false;
}
$arr_file_types = ['application/octet-stream'];

foreach($_FILES['files']['type'] as $fileType){
    if (!(in_array($fileType, $arr_file_types))) {
    echo "Error: Only .log files are supported 'application/octet-stream'.\n\nFile provided: " . $fileType;
    return;
} 
}


if($debug==true){
    echo '<pre>';
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Log Processing debug Active!" . PHP_EOL . PHP_EOL;
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Process start time: " . date('Y.m.d H:i:s') . PHP_EOL . PHP_EOL;
    //$file = $_FILES["file"]["tmp_name"]; 
    //var_dump($_FILES);

    //foreach($_FILES["files"]["tmp_name"] as $file){
    $count = count($_FILES['files']['tmp_name']);
    for ($fileIncriment = 0; $fileIncriment < $count; $fileIncriment++) {

    echo "<span style='color:#8e7bd5'>[CandyStats]</span> File Variable set." . PHP_EOL;
    $handle = @fopen($_FILES["files"]["tmp_name"][$fileIncriment],"r"); 
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Handle set; File opened." . PHP_EOL;

    //loop through the log file and insert into database 
    
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Parsing Data..." . PHP_EOL;
    //SessionID is constant and does not need to be re-read.
    $SessionID      = $_FILES["files"]["name"][$fileIncriment];

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

        $TAGS           = "";

        
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
            $queryString .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `XYZ_1`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '" . htmlentities($Name, ENT_QUOTES) . "', NULL, NULL, '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', NULL, NULL);";
            //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
            //mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));
        
        } else if(stripos($string, 'Log file closed') !== false){
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Special Line; Log File Closed..." . PHP_EOL;
            $logClosed = True;

        } else if(@$exploded[3] == "SFUI_Notice_Target_Bombed"){
            $Name           = $bombLastPlantedBy[1];
            $EventType      = "Triggered";
            $EventVariable  = 'SFUI_Notice_Target_Bombed';
            $SteamID        = $bombLastPlantedBy[0];
            $Misc_3         = 'Bomb_Successful';

            echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>EventType:</span><span style='color:#7ad380'>" . $EventType . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>SteamID:</span><span style='color:#7ad380'>" . $SteamID . "</span>" . PHP_EOL;
            echo "<span style='color:#7accd3'>Misc_3:</span><span style='color:#7ad380'>" . $Misc_3 . "</span>" . PHP_EOL;
            //Enter World Row into MySQL!
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
            $queryString .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `Misc_3`, `XYZ_1`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '" . htmlentities($Name, ENT_QUOTES) . "', '" . htmlentities($SteamID, ENT_QUOTES) . "', NULL, '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', NULL, '" . htmlentities($Misc_3, ENT_QUOTES) . "', NULL);";
            //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
            //mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));

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
                    $queryString .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `XYZ_1`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '" . htmlentities($Name, ENT_QUOTES) . "', NULL, NULL, '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', NULL, NULL);";
                    //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
                    //mysqli_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));

                } else if(in_array($Name,$NameEventsArrayCash)){
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> Checking if "' . $Name . '" is in the NameEventsArrayCash...' . PHP_EOL;
                    //Store Cash Event
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> "' . $Name . '" is a Cash NameEvent more processing will happen...' . PHP_EOL;
                } else {
                    echo '<span style="color:#8e7bd5">[CandyStats]</span> <span style="color:#d37a7a;">"' . $Name . '" is not present in the Arrays...' . "</span>" . PHP_EOL;
                    //Query Ian to see if event is worth storing
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#d37a7a;'>Line handled!</span>" . PHP_EOL;
                }
            } else {
                //This line of the log is in regards to a player, continue process.
                echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting SteamID..." . PHP_EOL;
                $SteamID        = str_replace('>','',@explode('<',$explodedName)[2]);
                if($SteamID == 'BOT'){ // Bots don't have STEAM_ at the beginning of their ID, this will allow us to use the identifier in reports but still single them out as synths!
                    $SteamID = $Name;
                }
                
                //Check if this player is in the active array or not, update accordingly
                PlayerActive();

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
                
                if($EventType == 'connected, address '){
                    $EventType = 'connected';
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Active player array updated..." . PHP_EOL;
                    if(in_array($SteamID,$inactivePlayers)){ //this is a connection string, if the player is in the inactive array they will not be readded and the line will be ignored! Remove the entry and call PlayerActive again!
                        $position = array_search($SteamID, $inactivePlayers);
                        unset($activePlayers[$position]);
                    }
                    PlayerActive();
                    $rowAccept = false; // connection strings are handled by the PlayerActive() function.
                }
                if($EventType == 'disconnected (reason '){
                    $EventType = 'disconnected';
                    if(in_array($SteamID,$activePlayers)){
                        $position = array_search($SteamID, $activePlayers);
                        unset($activePlayers[$position]);
                        if(!in_array($SteamID,$inactivePlayers)){
                            array_push($inactivePlayers,$SteamID);
                        }
                        
                        echo "<span style='color:#8e7bd5'>[CandyStats]</span> Setting Misc..." . PHP_EOL;
                        $Misc_1 = $exploded[3];
                        //var_dump($exploded);
                    } else {
                        //player isn't in the array, do nothing for now.
                    }
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Active player array updated..." . PHP_EOL;
                    var_dump($activePlayers);
                }
                if($EventType == 'committedsuicidewith'){
                    if(in_array($SteamID,$activePlayers)){
                        //The player is active, fool is ded.
                        $EventType = 'committed suicide';
                        $Misc_3 = 'Suicide';
                    } else {
                        //Player isn't active, server is just removing the player. 
                        $EventType = 'Player has left the game - IGNORE';
                        $rowAccept = false;
                    }
                }

                if($EventType == 'purchased '){
                    $EventType = 'purchased'; // Squash dem spaces!
                }

                if($EventType == 'triggered '){
                    $EventType = 'triggered'; // Squash dem spaces!
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

                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting EventVariable & Misc Data..." . PHP_EOL;
                
                if($EventType == 'threw'){
                    $EventVariable = explode(' ',htmlentities($exploded[2]))[2];
                    
                    if($EventVariable == 'flashbang'){ //if the item thrown was a flashbang, we want to store the ID.
                        $Misc_1 = str_replace(array("\r","\n"),'',str_replace(')','',explode(' ',$exploded[2])[8]));
                    }
                } else if($EventType == 'killed') {
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0]); // . '<BOT>'); //We already know they arent a BOT because they don't have the STEAM_ prefix
                    }
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = htmlentities($exploded[5]);
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);
                    
                    //extract victim team
                    $victimTeam = str_replace('>','',@explode('<',$exploded[3])[3]);
                    if($Team == $victimTeam) {
                        //This was a teamkill!
                        $Misc_3 = 'Team_Kill';
                    } else {
                        $Misc_3 = 'Kill_Base';

                        if(stripos($exploded[6],'headshot') !== false){
                            $Misc_3 = 'Headshot';
                        }
                        if(stripos($exploded[6],'penetrated') !== false){
                            $Misc_3 = 'Penetrated';
                        }
                        if(stripos($exploded[6],'headshot') !== false && stripos($exploded[6],'penetrated') !== false){
                            $Misc_3 = 'Headshot Penetrated';
                        }
                        
                        /* Turns out there is also domination and revenge tags, searching for strings rather than looking at explicit options might be wiser...
                        if(str_replace(array("\r","\n"," "),'',$exploded[6]) == '(headshot)') {
                            $Misc_3 = 'Headshot';
                        } else if(str_replace(array("\r","\n"," "),'',$exploded[6]) == '(penetrated)') {
                            $Misc_3 = 'Penetrated';
                        } else if(str_replace(array("\r","\n"," "),'',$exploded[6]) == '(headshotpenetrated)') {
                            $Misc_3 = 'Headshot Penetrated';
                        }
                        */
                    }
                    
                } else if($EventType == 'assisted killing '){ //sometimes spaces are important!
                    $EventType = 'assisted killing'; //removing the space!
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0]);// . '<BOT>');
                    }

                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = '';
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);
                    $Misc_3 = 'Kill_Assist';
                
                } else if($EventType == 'blinded') {
                    $EventVariable  = htmlentities(str_replace('>','',explode('<',$exploded[3])[2]));
                    if($EventVariable == 'BOT'){
                        $EventVariable = htmlentities(explode('<',$exploded[3])[0]);// . '<BOT>');
                    }
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $Misc_1           = explode(' ',$exploded[2])[3] . '|' . explode(' ',$exploded[4])[4]; //time in seconds | entindex
                    $Misc_2 = htmlentities(explode('<',$exploded[3])[0]);

                } else if($EventType == 'switched team'){
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;
                    $tempvar = explode('<',$exploded[2])[1];
                    $Misc_1 = htmlentities(substr($tempvar,0,stripos($tempvar,'>')));
                    $tempvar = explode('<',$exploded[2])[2];
                    $Misc_2 = htmlentities(substr($tempvar,0,stripos($tempvar,'>')));
                    $tempvar = '';
                    
                } else if(in_array(html_entity_decode($EventType),$skipEventVariableArray)){ //I know, it's a hack, but at least it's a neat one!
                    $EventVariable  = ''; // Don't judge me!
                } else {
                    $EventVariable  = htmlentities($exploded[3]);


                    //echo 'reached the else!'.PHP_EOL;
                    //Misc_1 should only apply when NOT certain EventTypes are detected. More cases true than not.
                    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Misc..." . PHP_EOL;

                    if(in_array($EventVariable,$Misc_3_Array)){
                        $Misc_3 = $EventVariable;
                        if($EventVariable == 'Planted_The_Bomb'){
                            $bombLastPlantedBy = array($SteamID,$Name);
                        }
                    } 
                    
                    if(in_array(html_entity_decode($EventVariable),$skipMiscArray) || in_array(html_entity_decode($EventType),$skipMiscArray)){
                        $Misc_1 = ''; //I got away with it last time, no reason why I shouldn't do it again!
                        //var_dump($exploded);
                    } else {
                        $Misc_1           = htmlentities($exploded[5]);
                        //var_dump($exploded);
                    }
                }

                echo "<span style='color:#7accd3'>EventVariable:</span><span style='color:#7ad380'>" . $EventVariable . "</span>" . PHP_EOL;

                if(!empty($Misc_1)){
                echo "<span style='color:#7accd3'>Misc_1:</span><span style='color:#7ad380'>" . $Misc_1 . "</span>" . PHP_EOL;
                }
                if(!empty($Misc_2)){
                    echo "<span style='color:#7accd3'>Misc_2:</span><span style='color:#7ad380'>" . $Misc_2 . "</span>" . PHP_EOL;
                }
                if(!empty($Misc_3)){
                    echo "<span style='color:#7accd3'>Misc_3:</span><span style='color:#7ad380'>" . $Misc_3 . "</span>" . PHP_EOL;
                }
                
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting XYZ..." . PHP_EOL;
                if($EventType == "killed"){ 
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
                
            }
        }


        //Enter Row into MySQL!
        if($rowAccept == True){
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
            $queryString .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `Misc_2`, `Misc_3`, `XYZ_1`, `XYZ_2`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '" . htmlentities($Name, ENT_QUOTES) . "', '" . htmlentities($SteamID, ENT_QUOTES) . "', '" . htmlentities($Team, ENT_QUOTES) . "', '" . htmlentities($EventType, ENT_QUOTES) . "', '" . htmlentities($EventVariable, ENT_QUOTES) . "', '" . htmlentities($Misc_1, ENT_QUOTES) . "', '" . htmlentities($Misc_2, ENT_QUOTES) . "', '" . htmlentities($Misc_3, ENT_QUOTES) . "', '" . htmlentities($XYZ_1, ENT_QUOTES) . "', '" . htmlentities($XYZ_2, ENT_QUOTES) . "');";
            //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
        } else {
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#d37a7a;'>Line handled!</span>" . PHP_EOL;
        }


        // Variable Reset!
        //$SessionID      = "";
        //$TIMESTAMP      = ""; // We want to know what the last timestamp was just incase the log doesn't close gracefully!
        $TAGS          = "";
        $Name           = "";
        $SteamID        = "";
        $Team           = "";
        $EventType      = "";
        $EventVariable  = "";
        $Misc_1         = "";
        $Misc_2         = "";
        $Misc_3         = "";
        $XYZ_1          = "";
        $XYZ_2          = "";
        $score          = "";

        $isPlayer       = True;
        $lessThanPosition = "0";

        $rowAccept      = True;
        flush();
        ob_flush();
    }

//check if the log ended gracefully, if not, add disconnect lines for all players in the active player array!
if($logClosed == false){
    echo "<span style='color:#8e7bd5'>[CandyStats]</span>End of file reached but the log has not been closed!".PHP_EOL;
}
echo "<span style='color:#8e7bd5'>[CandyStats]</span>Disconnecting all active players...".PHP_EOL;
foreach($activePlayers as $player){ //always terminate player sessions, if there was another match, they will just rejoin. 
    echo "<span style='color:#8e7bd5'>[CandyStats]</span> Prepping MySQL Command..." . PHP_EOL;
    $queryString .= "INSERT INTO `logdata` (`CSID`, `SessionID`, `TIMESTAMP`, `TAGS`, `Name`, `SteamID`, `Team`, `EventType`, `EventVariable`, `Misc_1`, `Misc_2`, `Misc_3`, `XYZ_1`, `XYZ_2`) VALUES (NULL, '" . htmlentities($SessionID, ENT_QUOTES) . "', '" . htmlentities($TIMESTAMP, ENT_QUOTES) . "', '', '', '" . htmlentities($player, ENT_QUOTES) . "', '', 'disconnected', 'Log End', '', '', '', '', '');";
    //echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#ccac30;'>Query: " . $queryString . "</span>" . PHP_EOL;
}


    
}
echo PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span><span style='color:#ccac30;'> Executing Query</span>";
mysqli_multi_query($con, $queryString) or die("There was a problem with the query and the script has been stopped." . mysqli_error($con));

//echo PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span><span style='color:#ccac30;'> Query: ".PHP_EOL.str_replace(';',';'.PHP_EOL,$queryString)."</span>";

}


echo PHP_EOL . PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span> Process end time: " . date('d/m/y H:i:s') . PHP_EOL;
echo '</pre>';

//echo "Log Uploaded Successfully.";
?>