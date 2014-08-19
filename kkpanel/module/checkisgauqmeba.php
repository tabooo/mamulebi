<script>
function checkisgauqmeba(id){
				$(function() {
	                    $.post('php.php',{dos:"checkisgauqmeba",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}
</script>
<div id="show_results">
<?php
$id=$_GET['id'];
mysqlconnect();
$mig=mysql_fetch_array(mysql_query("select * from magidisdaxurva where id='$id'"));
echo date("Y-m-d H:i:s",$mig['dro']);
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
<br><input value="გაუქმება" type="button" onClick="checkisgauqmeba('<?php echo $_GET['id']; ?>');">