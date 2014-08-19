<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
$con = mysql_connect("localhost","root","skarlatina");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mamulebi");
mysql_query("SET NAMES 'utf8'");
$prods=mysql_query("SELECT * FROM productebi order by id asc") or die(mysql_error());
$kat="";
while($prod=mysql_fetch_array($prods)){
	if(mysql_num_rows(mysql_query("select * from product where shemadgenloba like '%".$prod['id'].":%'"))<1){
		//mysql_query("delete from productebi where id='".$prod['id']."'");
		$kat.=$prod["saxeli"]." (".number_format($prod["raodenoba"],2, '.', ' ').")<br>";
	}
}
echo $kat;
?>
