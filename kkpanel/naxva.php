<?php
session_start();
include("config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<SCRIPT TYPE="text/javascript">
function lettersOnly(evt) {
       evt = (evt) ? evt : event;
       var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
          ((evt.which) ? evt.which : 0));
       if (charCode > 31 && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122) && (charCode < 48 || charCode > 57)) {
          //alert("Enter letters only.");
          return false;
       }
       return true;
     }
</SCRIPT>
</head>
<body onLoad="document.getElementById('searchnomeri').focus()">
<?php
if($_SESSION['username']==""){
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
else {// echo $_SESSION['username']."(".$_SESSION['role'].")<a href='php.php?dos=logout'>[logout]</a>";
?>
<div id="show_results">
<?php
$id=$_GET['id'];
mysqlconnect();
$mig=mysql_fetch_array(mysql_query("select * from magidisdaxurva where id='$id'"));
echo "<table border='1'><td>სექცია</td><td>მაგიდა</td><td>სახელი</td><td>რაოდენობა</td><td>თანხა</td></tr>";
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$mig['user']."'"));
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$mig['magida']."'"));
	$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mig['seqcia']."'"));
	$shem=explode(",",$mig['shemadgenloba']);
	$i=1;	
while($shem[$i]!=""){
$sell_id=$shem[$i];
$sl=mysql_fetch_array(mysql_query("select * from sell where id='$sell_id'")) or die(mysql_error());
$pr=mysql_fetch_array(mysql_query("select saxeli from product where id='".$sl['prod_id']."'")) or die(mysql_error());
?>
<tr>
<td><?php echo $seq['name']; ?></td>
<td><?php echo $mag['name']; ?></td>
<td><?php echo $pr['saxeli']; ?></td>
<td><?php echo $sl['raodenoba']; ?></td>
<td><?php echo $sl['fasi']; ?></td>
</tr>
<?php
$i++;
}
echo "</table>";
?>
</div><br><br><br>
<div id="dacvrilebit"></div>
<br><input value="დახურვა" type="button" onClick="window.close();">
<?php } ?>
</body>
</html>