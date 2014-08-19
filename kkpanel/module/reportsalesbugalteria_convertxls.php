<?php
include('../php-excel.class.php');
include('../config.php');
if($_GET['dos']=="convertxls"){
$data = array(1 => array ('სახელი', 'რაოდენობა','ფასი'));
$fromday=strtotime($_POST['fromyear']."-".$_POST['frommon']."-".$_POST['fromday']." 00:00:00");
$today=strtotime($_POST['fromyear']."-".$_POST['frommon']."-".$_POST['fromday']." 23:59:59");
mysqlconnect();
$resp=mysql_query("select prod_id,sum(raodenoba) as raodenoba, sum(fasi) as fasi from sell where dro>='".$fromday."' and dro<='".$today."' group by prod_id order by saxeli asc") or die(mysql_error());
while($sell=mysql_fetch_array($resp)){
$prod=mysql_fetch_array(mysql_query("select saxeli from product where id='".$sell['prod_id']."'")) or die(mysql_error());
array_push($data,array ($prod['saxeli'], $sell['raodenoba'], $sell['fasi']));
}
$xls = new Excel_XML('UTF-8', false, 'My Test Sheet');
$xls->addArray($data);
$xls->generateXML('for_bugalter');
}
?>
