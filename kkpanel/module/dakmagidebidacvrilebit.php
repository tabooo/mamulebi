<h3>დაკავებული მაგიდები: </h3>
<?php
$magida=$_GET['magida'];
$bgcolor="green";
$sum=0;
$nom=1;
$resp=mysql_query("select * from sell_temp where magida='$magida' order by id desc") or die(mysql_error());
echo "<div style='width:500px;max-height:625px;overflow:auto;'><table valign='top' border='1'><tr bgcolor='gray'><td>№</td><td>დასახელება</td><td>რაოდენობა</td><td>მიმტანი</td><td>სულ ფასი</td></tr>";
while($prod=mysql_fetch_array($resp)){
if($prod['print']==0) $bgcolor="red";
else $bgcolor="green";
$mimtani=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$prod['user']."'"));
?>
<tr bgcolor="<?php echo $bgcolor; ?>" height="40">
<td><b><?php echo $nom; ?></b></td>
<td width="200"><b>
<?php if($prod['print']==0) {?><a href="javascript:orderedit('<?php echo $prod['id']; ?>')"><?php } ?>
<?php echo "<b>".$prod['saxeli']."</b>"; ?>
<?php if($prod['print']==0) {?></a><?php } ?>
</b></td>
<td width="100"><b><?php echo $prod['raodenoba']; ?></b></td>
<td><b><?php echo $mimtani['saxeli']." ".$mimtani['gvari']; ?></b></td>
<td><b><?php echo $prod['fasi']; ?> ლარი</b></td></tr>
<?php
$sum=$sum+$prod['fasi'];
$nom++;
}
echo "</table></div><br><b>სულ: ".$sum."</b><br>";
?>
<a href="?cat=dakmagidebi"><input type="button" value="უკან დაბრუნება" /></a>