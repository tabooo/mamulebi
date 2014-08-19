<?php
//session_start();
function mysqlconnect(){
$host="localhost";
$dbuser="root";
$dbpass="skarlatina";
$db="mamulebi";
$con = mysql_connect($host,$dbuser,$dbpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($db);
mysql_query("SET NAMES 'utf8'");
}

function refreshPage($time,$location) {
	print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time; URL=$location\">";
}

function addlog($text){
$dro=time();
mysql_query("insert into logs values (null,'$text','$dro')");
}

function safe($string)
{
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysql_real_escape_string($string);
    return $string;
}

$komunalur=array('დენი','წყალი','გაზი','ინტერნეტი','ტელეფონი','ნაგავი');

?>
