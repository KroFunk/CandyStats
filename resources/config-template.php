<?php 
session_start();

//Steam API Key *Required*
$SteamAPI="";

//Date Time format, E.G. "d/m/Y H:i" would be 19/05/2018 11:29 see http://php.net/manual/en/function.date.php for parameter options
$DateTimeFormat = "d/m/Y H:i";

//Date format, E.G. "d/m/Y" would be 19/05/2018 see http://php.net/manual/en/function.date.php for parameter options
$DateFormat = "d/m/Y";

//Time format, E.G. "H:i" would be 11:29 see http://php.net/manual/en/function.date.php for parameter options
$TimeFormat = "H:i";

//SQL connection details *Required*
$SQLServer="";
$SQLUser="";
$SQLPass="";
$SQLDB="";


//########################################################################################
//###################### Nothing should be changed below this point ######################
//########################################################################################

//Attempting to connect to db
$con=mysqli_connect($SQLServer,$SQLUser,$SQLPass,$SQLDB);
//check if the connection was sucessful (Fingers Crossed)
if (mysqli_connect_errno())
{
echo "Connection to the database fell over: " . mysqli_connect_error();
}

?>