<?php
session_start();

function mysqlconnect(){
$con = mysql_connect("127.0.0.1","root","skarlatina");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mamulebi");
mysql_query("SET NAMES 'utf8'");
}

function mysqlconnect2($host,$dbuser,$dbpass,$db){
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

function addlogs($action){
	$date=time();
	mysql_query("INSERT INTO logs VALUES(null,'$action','$date')") or die(mysql_error());
}

function safe($string)
{
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysql_real_escape_string($string);
    return $string;
}

function checkmagida($magidaid){
	mysqlconnect();
	$magida=safe($magidaid);
	$resp=mysql_query("select * from sell_temp where magida='$magida' AND user='".$_SESSION['userid']."'");
	$resp2=mysql_query("select * from sell_temp where magida='$magida'");
	$resp3=mysql_query("select * from tables where id='$magida'");
	if((mysql_num_rows($resp)>0 || mysql_num_rows($resp2)<1) && mysql_num_rows($resp3)>0) {
		return true;
	}else {
		die("აირჩიეთ მაგიდა");
		return false;
	}
}
?>
