<?php
include("config.php");
if(@$_SESSION['username']==""){
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
else {
mysqlconnect();
$saxgvari=mysql_fetch_array(mysql_query("select saxeli, gvari from tanamshromlebi where id='".$_SESSION['userid']."'"));
$saxeli=$saxgvari["saxeli"]." ".$saxgvari["gvari"];

if($_POST['dos']=="print" && $_POST['magida']!=""){
$magida=safe($_POST['magida']);
$procenti=safe($_POST['procenti']);
$fasdaklebisprocenti=safe($_POST['fasdaklebisprocenti']);
$fasdaklebiskodi=safe($_POST['fasdaklebiskodi']);
if(mysql_num_rows(mysql_query("select * from sell_temp where magida='$magida' and print='1'"))>0) die("ზოგი შეკვეთა არ არის ამობეჭდილი");
$pas=mysql_fetch_array(mysql_query("select password from tanamshromlebi where username='admin' AND role='administrator'"));
if($fasdaklebisprocenti!="" && $fasdaklebiskodi!=$pas["password"]) die("ფასდაკლების პაროლი არასწორია");
$mg=mysql_fetch_array(mysql_query("select * from tables where id='$magida'"));
$mgseqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mg['seqcia']."'"));
$date=date("Y-m-d H:i:s",time());
$sum=0;
$resp=mysql_query("select prod_id, ertfasi, saxeli,sum(raodenoba),sum(fasi) from sell_temp where magida='$magida' group by prod_id order by prod_id asc");
echo "<table valign='top' border='1' rules='rows' frame='void' width='255'>"; ?>
<tr><td colspan='5' align='center'><a href="javascript:afterwholeprint2('<?php echo $magida;?>','<?php echo $procenti;?>','<?php echo $fasdaklebisprocenti;?>','<?php echo $fasdaklebiskodi;?>');"><img src='images/logo.jpg' width='110'></a></td></tr>
<?php
echo "<tr><td colspan='5' align='left'>$date</td></tr>
<tr><td colspan='2' align='left'><b>$saxeli</b></td><td colspan='3' align='right'><b>მაგიდა: ".$mg['name']."<br>სექცია: ".$mgseqcia['name']."</b></td></tr>
<tr style='font-size:13px;'><td align='left'><b>№<b></td><td align='left'><b>დასახელება<b></td><td width='60'><b>რაოდ.</b></td><td width='40'><b>ფასი</b></td><td align='right'><b>სულ</b></td></tr>
";
$ii=1;
while($prod=mysql_fetch_array($resp)){
?>
<tr valign='top'><td><?php echo $ii; ?></td><td width="120" align='left'><?php echo $prod['saxeli']; ?></td><td><?php echo $prod['sum(raodenoba)']; ?></td><td><?php echo $prod['ertfasi']; ?></td><td align='right'><?php echo $prod['sum(fasi)']; ?></td></tr>
<?php
$ii++;
$sum=$sum+$prod['sum(fasi)'];
}
$sum=round($sum,2);
$proc=round(($sum*$procenti/100),2);
$fasdakl=round(($sum+$proc)*$fasdaklebisprocenti/100,2);
$sul=$sum+$proc-$fasdakl;
?> 
<tr><td colspan="5" align="right"><font size="3"><i>ჯამი: <?php echo round($sum,2); ?> ლარი</i></font></td></tr>
<tr><td colspan="5" align="right"><font size="3"><i>+მომსახურების <?php echo $procenti; ?>% - <?php echo $proc; ?> ლარი</i></font></td></tr>
<tr><td colspan="5" align="right"><font size="3"><i>-ფასდაკლება <?php echo $fasdaklebisprocenti; ?>% - <?php echo $fasdakl; ?> ლარი</i></font></td></tr>
<tr><td colspan="5" align="right"><a href="javascript:afterwholeprint2('<?php echo $magida;?>','<?php echo $procenti;?>','<?php echo $fasdaklebisprocenti;?>','<?php echo $fasdaklebiskodi;?>');" style="text-decoration:none;font-wight:bold;font-size:25px;"><b>სულ: <?php echo $sul; ?> ლარი</b></a></td></tr>
</table>
<input type="hidden" id="suljami" value="<?php echo $sul; ?>">
<?php
}
?>




<?php
if($_POST['dos']=="printadgili" && $_POST['magida']!="" && $_POST['adgili']!=""){
$magida=safe($_POST['magida']);
$adgili=safe($_POST['adgili']);
$mg=mysql_fetch_array(mysql_query("select * from tables where id='$magida'"));
$mgseqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mg['seqcia']."'"));
$mgadgili=mysql_fetch_array(mysql_query("select * from adgili where id='".$adgili."'"));
$date=date("Y-m-d H:i:s",time());
$sum=0;
$resp=mysql_query("select prod_id, ertfasi, saxeli,sum(raodenoba),sum(fasi) from sell_temp where magida='$magida' AND print='1' AND adgili='$adgili' group by prod_id order by prod_id asc") or die(mysql_error());
echo "<table valign='top' border='1' rules='rows' frame='void'>"; ?>
<tr><td colspan='4' align='center'>
<a href="javascript:afterprint2('<?php echo $magida;?>','<?php echo $adgili;?>');"><img src='images/logo.jpg' width='110'></a>
</td></tr>
<?php
echo "<tr><td colspan='4' align='left'>$date</td></tr>
<tr><td colspan='2' align='left'><b>$saxeli</b></td><td colspan='2' align='right'><b>მაგიდა: ".$mg['name']."<br>სექცია: ".$mgseqcia['name']."<br>გატანის ადგილი:<br> ".$mgadgili['name']."</b></td></tr>
<tr style='font-size:13px;'><td align='left'><b>დასახელება<b></td><td width='60'><b>რაოდ.</b></td><td width='40'><b>ფასი</b></td><td align='right'><b>სულ</b></td></tr>
";
while($prod=mysql_fetch_array($resp)){
?>
<tr><td width="120" align='left'><?php echo $prod['saxeli']; ?></td><td><?php echo $prod['sum(raodenoba)']; ?></td><td><?php echo $prod['ertfasi']; ?></td><td align='right'><?php echo $prod['sum(fasi)']; ?></td></tr>
<?php
$sum=$sum+$prod['sum(fasi)'];
}
?> 

</table>
<?php
}

}
?>
