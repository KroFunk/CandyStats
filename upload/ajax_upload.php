<?php
require "../resources/config.php";

$EventTypeArray = array("triggered","connected","disconnected","purchased","threw","Killed","assisted","blinded");

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
    echo "Log Processing debug Active!" . PHP_EOL . PHP_EOL;
    echo "Process start time: " . date('Y.m.d H:i:s') . PHP_EOL . PHP_EOL;
    $file = $_FILES["file"]["tmp_name"]; 
    echo "File Variable set.";
    $handle = fopen($file,"r"); 
    echo "Handle set; File opened.";

    //loop through the csv file and insert into database 
    while ($data = fgets($handle,4096)) { 
        
        $string         = $data;
        $exploded       = explode('"',$data);

        echo PHP_EOL . PHP_EOL . "Reading line:" . $string;
        echo "Parsing Data..." . PHP_EOL;
/* TEMPORARY!

        $SessionID      = $_FILES["file"]["name"];
        echo "SessionID:" . $SessionID . PHP_EOL;

        echo "Extracting Timestamp..." . PHP_EOL;
        $TIMESTAMP      = substr($string,2,21);
        $TIMESTAMP      = str_replace(" -","",$TIMESTAMP);
        $TIMESTAMP      = strtotime($TIMESTAMP);
        echo "TIMESTAMP:" . $TIMESTAMP . PHP_EOL;
*/

        $TAG1           = "";
        $TAG2           = "";
        $TAG3           = "";

        echo "Extracting Name..." . PHP_EOL;
        @echo $exploded[1] . PHP_EOL;
        /*
        This is not the proper way of doing this. it should be:
        
        if (strpos($exploded[1], '<') !== false) {
        $isPLayer = True;
        }
        
        but it wasn't working for some reason. See output below...
        
        #############################################################################################
        Reading line:L 11/17/2018 - 12:27:17: server_cvar: "cash_team_win_by_defusing_bomb" "3500"
        Parsing Data...
        SessionID:l188_039_040_013_27015_201811171227_000.log
        Extracting Timestamp...
        TIMESTAMP:1542457637
        Extracting Name...
        cash_team_win_by_defusing_bomb
        bool(false)
        Do I think this a player?  False

        ^ strpos is false, so false is expected. 

        Reading line:L 11/17/2018 - 12:32:05: "KroFunk<20><>" STEAM USERID validated
        Parsing Data...
        SessionID:l188_039_040_013_27015_201811171227_000.log
        Extracting Timestamp...
        TIMESTAMP:1542457925
        Extracting Name...
        KroFunk<20><>
        int(7)
        Do I think this a player? 7 False.

        ^ strpos is an int, false not expected but it's what I got!
        #############################################################################################
        */
        if (@!empty(stripos($exploded[1],'<'))) {
            $isPlayer = true;
        } else {
            $isPlayer = false;
        }
        echo "Is this a player: ";
        echo $isPlayer ? "True" : "False";
        /*echo "var_dump stripos: ";
        var_dump(stripos($exploded[1],'<'));
        echo PHP_EOL . "var_dump isPlayer ";
        var_dump($isPlayer);*/
        if($isPlayer == false){
            echo PHP_EOL . "Ian, is this important? Please enter the value that was detected and the parsed line onto the datamodel document!";
        }

        


        $Name           = "";
        $SteamID        = "";
        $Team           = "";
        $EventType      = "";
        $Misc           = "";
        $XYZ            = "";
    }; 

    echo "Process end time: " . date('d/m/y H:i:s') . PHP_EOL;
    echo '</pre>';
}

 

//echo "Log Uploaded Successfully.";
?>