<?php
session_start();
include("config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
</head>
<body>
<?php
if($_SESSION['username']==""){
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
else {// echo $_SESSION['username']."(".$_SESSION['role'].")<a href='php.php?dos=logout'>[logout]</a>";
?>
<script type="text/javascript">
function dastur(id){
				$(function() {
                    $.post('php.php',{dos:"dasturproductmigeba",id:id}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
function dacvrilebit(id){
				$(function() {
                    $.post('php.php',{dos:"productmigebadacvrilebit",id:id}, function(data){
                       $("#dacvrilebit").html(data);
                    });
                    return false;
                });           
}

function deletemigeba(id){
				$(function() {
                    $.post('php.php',{dos:"deleteproductmigeba",id:id}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
</script>
<div id="show_results">
<?php
mysqlconnect();
$mi=mysql_query("select * from magidisdaxurva where nanaxia='0' order by dro desc");
echo "<table border='1'><tr><td>ID</td><td>დრო</td><td>სექცია</td><td>მაგიდა</td><td>სახელი</td><td>თანხა</td><td>დაწვრილებით</td><td>ქმედება</td></tr>";
while($mig=mysql_fetch_array($mi)){
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$mig['user']."'"));
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$mig['magida']."'"));
	$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mig['seqcia']."'"));
?>
<tr>
<td><?php echo $mig['id']; ?></td>
<td><?php echo date("Y-m-d H:i:s",$mig['dro']); ?></td>
<td><?php echo $seq['name']; ?></td>
<td><?php echo $mag['name']; ?></td>
<td><?php echo $tan['saxeli']." ".$tan['gvari']; ?></td>
<td><?php echo $mig['tanxa']; ?></td>
<td><input value="დაწვრილებით" type="button" onClick="dacvrilebit('<?php echo $mig['id']; ?>')"></td>
<td><input value="დასტური" type="button" onClick="dastur('<?php echo $mig['id']; ?>')">
<!--<input value="Удалить" type="button" onClick="deletemigeba('<?php echo $mig['id']; ?>')">--></td>
</tr>
<?php
}
echo "</table>";
?>
<?php } ?>
</div><br><br><br>
<div id="dacvrilebit"></div>
<br><input value="დახურვა" type="button" onClick="window.close();">
</body>
</html>