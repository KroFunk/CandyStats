<?php
require "../resources/config.php";

$EventTypeArray = array("triggered","connected","disconnected","purchased","threw","Killed","assisted","blinded");

$NameEventsArray = array("Round_Start","Round_End","Game_Commencing","Match_Start","CT","TERRORIST","sv_cheats");
$NameEventsArrayCash = array("cash_player_killed_teammate","cash_player_respawn_amount","cash_team_winner_bonus_consecutive_rounds","cash_team_rescued_hostage","cash_team_win_by_defusing_bomb","cash_player_interact_with_hostage","cash_team_elimination_bomb_map","cash_player_get_killed","cash_team_loser_bonus","cash_player_rescued_hostage","cash_player_killed_enemy_default","mp_hostagepenalty","cash_team_hostage_interaction","cash_team_win_by_time_running_out_bomb","cash_player_killed_enemy_factor","cash_team_survive_guardian_wave","cash_team_terrorist_win_bomb","cash_team_elimination_hostage_map_t","cash_team_win_by_time_running_out_hostage","cash_player_bomb_planted","cash_player_bomb_defused","cash_team_planted_bomb_but_defused","cash_player_killed_hostage","cash_team_elimination_hostage_map_ct","cash_team_win_by_hostage_rescue","cash_team_loser_bonus_consecutive_rounds","cash_player_damage_hostage","cash_team_hostage_alive");

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
    while ($data = fgets($handle,4096)) { 
        
        $string         = htmlentities($data);
        $exploded       = explode('"',$data);

        echo PHP_EOL . PHP_EOL . "<span style='color:#8e7bd5'>[CandyStats]</span> Reading line:" . $string;
        echo "<span style='color:#8e7bd5'>[CandyStats]</span> Parsing Data..." . PHP_EOL;


        $SessionID      = $_FILES["file"]["name"];
        echo "<span style='color:#7accd3'>SessionID:</span><span style='color:#7ad380'>" . $SessionID . "</span>" . PHP_EOL;

        echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Timestamp..." . PHP_EOL;
        $TIMESTAMP      = substr($string,2,21);
        $TIMESTAMP      = str_replace(" -","",$TIMESTAMP);
        $TIMESTAMP      = strtotime($TIMESTAMP);
        echo "<span style='color:#7accd3'>TIMESTAMP:</span><span style='color:#7ad380'>" . $TIMESTAMP . "</span>" . PHP_EOL;

        $TAG1           = "";
        $TAG2           = "";
        $TAG3           = "";

        echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Name..." . PHP_EOL;
        $explodedName   = $exploded[1];
        $Name           = @explode('<',$explodedName)[0];
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
                echo '<span style="color:#8e7bd5">[CandyStats]</span> "' . $Name . '" is an important NameEvent more processing will happen...' . PHP_EOL;
            } else if(in_array($Name,$NameEventsArrayCash)){
                echo '<span style="color:#8e7bd5">[CandyStats]</span> Checking if "' . $Name . '" is in the NameEventsArrayCash...' . PHP_EOL;
                //Store Cash Event
                echo '<span style="color:#8e7bd5">[CandyStats]</span> "' . $Name . '" is a Cash NameEvent more processing will happen...' . PHP_EOL;
            } else {
                echo '<span style="color:#8e7bd5">[CandyStats]</span> <span style="color:#d37a7a;">"' . $Name . '" is not present in the Arrays...' . "</span>" . PHP_EOL;
                //Query Ian to see if event is worth storing
                echo "<span style='color:#8e7bd5'>[CandyStats]</span> <span style='color:#d37a7a;'>Ian, is this important? Please enter the value that was detected and the parsed line onto the datamodel document!</span>" . PHP_EOL;
            }
        } else {
            //This line of the log is in regards to a player, continue process.
            echo "<span style='color:#7accd3'>Name:</span><span style='color:#7ad380'>" . $Name . "</span>" . PHP_EOL;
            
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting SteamID..." . PHP_EOL;
            $SteamID        = str_replace('>','',explode('<',$explodedName)[2]);
            echo "<span style='color:#7accd3'>SteamID:</span><span style='color:#7ad380'>" . $SteamID . "</span>" . PHP_EOL;
            
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting Team..." . PHP_EOL;
            $Team           = str_replace('>','',explode('<',$explodedName)[3]);
            echo "<span style='color:#7accd3'>Team:</span><span style='color:#7ad380'>" . $Team . "</span>" . PHP_EOL;
            
            echo "<span style='color:#8e7bd5'>[CandyStats]</span> Extracting EventType..." . PHP_EOL;
            $EventType      = htmlentities($exploded[2]);
            echo "<span style='color:#7accd3'>EventType:</span><span style='color:#7ad380'>" . $EventType . "</span>" . PHP_EOL;

            $Misc           = "";

            $XYZ            = "";
        }

    }; 

    echo "Process end time: " . date('d/m/y H:i:s') . PHP_EOL;
    echo '</pre>';
}

 

//echo "Log Uploaded Successfully.";
?>