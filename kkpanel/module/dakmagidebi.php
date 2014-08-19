<h3>დაკავებული მაგიდები: </h3>
<?php
	mysqlconnect();
	/*$resp2=mysql_query("select * from seqciebi");
	while($show2=mysql_fetch_array($resp2)){
		?>
		<input value="<?php echo $show2['name']; ?>" type="button" onClick="searchtablebyseqcia('<?php echo $show2['id']; ?>')">
		<?php
	}*/
	?>
<br>
<div id="show_results">
<?php
$resp=mysql_query("select * from tables where id in (select magida from sell_temp group by magida) order by id asc");
echo"<table><tr><td>ID</td><td>მაგიდა</td><td>სექცია</td><td>მიმტანი</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){
$dak=0;
$dakm=mysql_query("select * from sell_temp where magida='".$show['id']."' limit 0,1") or die(mysql_error());
if(mysql_num_rows($dakm)>0) $dak=1;
else $bgcolor="green";
$dakmm=mysql_fetch_array($dakm);
$mimtani=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$dakmm['user']."' limit 0,1"));
?>
<form name='table <?php echo $show['id']; ?>'><tr <?php if($dak==1) echo "bgcolor='red'"; ?>>
<td><input type='text' size=1 id='show_table_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=1 id='show_table_name' value='<?php echo $show['name']; ?>'></td>
<td>
<?php
$seqc=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$show['seqcia']."'"));
echo "<input type='text' size='5' value='".$seqc['name']."'>";
?></td>
<td><b><?php echo $mimtani['saxeli']." ".$mimtani['gvari']; ?></b></td>
<td><a href="?cat=dakmagidebidacvrilebit&magida=<?php echo $show['id']; ?>"> <input type='button' title='დაწვრილებით' value='დაწვრილებით'></a>
</td>
</tr></form>
<?php
}
echo "</table>";
?>
</div>
