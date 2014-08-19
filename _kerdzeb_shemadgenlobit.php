<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

// load library
require 'php-excel.class.php';
$con = mysql_connect("localhost","root","skarlatina");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mamulebi");
mysql_query("SET NAMES 'utf8'");
$data = array(1 => array ('სახელი', 'შემადგენლობა', 'ფასი'));
$prodd=mysql_query("SELECT * FROM product order by cat, id asc") or die(mysql_error());
$kat="";
while($prod=mysql_fetch_array($prodd)){
if($kat!=$prod['cat']) {$kt=mysql_fetch_array(mysql_query("select * from cats where id='".$prod['cat']."'")); echo "======".$kt["name"]."=======<br>";$kat=$prod['cat'];}
$shemadgenn="";
$shemadg=explode(",", $prod['shemadgenloba']);
$i=0;
while($shemadg[$i]!=""){
$shemadgenloba=explode(":", $shemadg[$i]);
$shemraodenoba=$shemadgenloba[1];
$shemid=$shemadgenloba[0];
$shemsaxeli1=mysql_query("select * from productebi where id='$shemid'");
//if(mysql_num_rows($shemsaxeli1)<1) echo $prod['id']." / ".$prod['saxeli']."/".$shemid."<br>";
$shemsaxeli=mysql_fetch_array($shemsaxeli1) ;
$shemadgenn.=$shemsaxeli['saxeli']." (".$shemsaxeli['id'].")-$shemraodenoba; ";
$i++;
}
echo "<b>".$prod['saxeli']."</b> : ".$shemadgenn."<br><br>";
array_push($data,array ($prod['saxeli'], $shemadgenn, $prod['fasi']));
//echo '<tr><td valign="top" align="left" width="200">'.$prod["saxeli"].'<td></td><td><textarea cols="42" rows="5" disabled="disabled" name="product_shemadgenloba_sityvieri" id="product_shemadgenloba_sityvieri">'.$shemadgenn.'</textarea></td><td valign="top" align="left">'.$prod["fasi"].'</td></tr>';
}



/*
while( $qrow = mysql_fetch_array( $resp1 ) )
{
// create a simple 2-dimensional array
array_push($data,array ($qrow['id'], $qrow['saxeli'],"TEST"));
}
// generate file (constructor parameters are optional)
$xls = new Excel_XML('UTF-8', false, 'My Test Sheet');
$xls->addArray($data);
$xls->generateXML('my-test');
*/
?>
