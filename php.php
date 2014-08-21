<?php
include("config.php");
if(@$_SESSION['username']==""){
if(@$_POST['dos']=='login'){
mysqlconnect();
$username=safe($_POST['username']);
$password=safe($_POST['password']);
$seqcia=safe($_POST['seqcia']);
$adgili_id=safe($_POST['adgili_id']);
if($username!="" || $password!=""){
$loginquery=mysql_query("select * from tanamshromlebi where username='$username'") or die(mysql_error());
$login=mysql_fetch_array($loginquery);
if($login['username']!=""){
	if($password==$login['password']){
		$_SESSION['username']=$username;
		$_SESSION['role']=$login['role'];
		$_SESSION['userid']=$login['id'];
		$seqcia=mysql_fetch_array(mysql_query("select id from seqciebi where name='".$seqcia."'"));
		$_SESSION['seqcia']=$seqcia["id"];
		$_SESSION['adgili_id']=$adgili_id;
		echo '<div id="success"><p>ავტორიზაცია წარმატებით გაიარეთ<br>თუ ავტომატურად არ გადადის მთავარ გვერდზე <a href="index.php">დააჭირეთ აქ.</a></p></div>';
		echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		die();
	}
	echo '<p class="error">
<img src="images/error.png" height="16px" width="16px"/>
 არასწორი პაროლი! 
</p>'; die();
}
else {
echo '<p class="error">
<img src="images/error.png" height="16px" width="16px"/>არასწორი სახელი</p>'; die();
}
}
else die();
}else {
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
}
else {
if(@$_POST['dos']!=''){
?>

<?php
//მთავარი კატეგორიის აღცევის შემთხვევაში <<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(@$_POST['dos']=="selectmaincat" && @$_POST['id']!=""){
mysqlconnect();
$id=safe($_POST['id']);
$resp=mysql_query("select * from cats where visible='1' AND adgili='".$id."' order by id asc") or die(mysql_error());
$sul=mysql_fetch_array(mysql_query("select id from cats where visible='1' AND adgili='".$id."' order by id desc limit 0,1"));
while($prod=mysql_fetch_array($resp)){
?>
<button class="btn btn-large" type="button" style="width:190px; height:40px; padding:0; text-align:left; font-size:15px;" onClick="javascript:selectcat(<?php echo $prod['id']; ?>,<?php echo ($sul['id']+1); ?>);" id="selectcat<?php echo $prod['id']; ?>"><img src="<?php echo $prod['pic']; ?>" style="float:left;" width="50" height="36">&nbsp;<?php echo $prod['name']; ?></button>
<?php
}
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>


<?php
// კატეგორიის აღცევის შემთხვევაში  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(@$_POST['dos']=="selectcat" && @$_POST['id']!=""){
mysqlconnect();
$id=safe(@$_POST['id']);
$resp=mysql_query("select * from product where cat='".$id."' AND visible='1' order by saxeli asc") or die(mysql_error());
$sul=mysql_fetch_array(mysql_query("select id from product where visible='1' order by id desc limit 0,1"));
while($prod=mysql_fetch_array($resp)){
?>
<button class="btn btn-large" type="button" style="width:190px; height:40px; padding:0; text-align:left; font-size:15px; padding-left:3px;" onClick="javascript:selectprod(<?php echo $prod['id']; ?>,<?php echo $sul['id']; ?>);" id="selectprod<?php echo $prod['id']; ?>"><?php echo $prod['saxeli']; ?></button>
<?php
}
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>


<?php
// მაგიდების გამოჩენა  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(@$_POST['dos']=="refreshtables"){
mysqlconnect();
$selectedid=safe(@$_POST['selectedid']);
$dak="";
$resp=mysql_query("select DISTINCT magida from sell_temp where magida in (select id from tables where seqcia='".$_SESSION['seqcia']."')") or die(mysql_error());
while($prod=mysql_fetch_array($resp)){
$dak=$dak.$prod['magida'].",";
}
$dakavebuli=explode(",", $dak);
echo '<input type="hidden" name="dakavebulimagidebi" id="dakavebulimagidebi" value="'.$dak.'" />';
$table=mysql_query("select * from tables where seqcia='".$_SESSION['seqcia']."' order by id asc") or die(mysql_error());
while($tbl=mysql_fetch_array($table)){
$disabled="disabled";
$btndak="btn-danger";
if(mysql_num_rows(mysql_query("select * from sell_temp where magida='".$tbl['id']."'"))<1){$disabled="";}
else {if(mysql_num_rows(mysql_query("select * from sell_temp where magida='".$tbl['id']."' AND user='".$_SESSION['userid']."'"))>0){$disabled="";}}
?>
<button <?php echo $disabled; ?> class="btn btn-large <?php if($selectedid==$tbl['id']) echo "btn-success"; else { if(in_array($tbl['id'], $dakavebuli)) echo "btn-danger";}?>" style="width:40px;padding:10px;" onclick="javascript:refreshtables(<?php echo $tbl['id']; ?>)" id="table_<?php echo $tbl['id']; ?>"><?php echo $tbl['name']; ?></button>
<?php
}
?>
<input type="hidden" value="<?php echo $selectedid; ?>" name="tablenumber" id="tablenumber" size="1" disabled />
<?php
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>


<?php
// მაგიდის არჩევისას <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(@$_POST['dos']=="showtable" && $_POST['magida']!=""){
mysqlconnect();
$magida=safe($_POST['magida']);
checkmagida($magida);
$disabled="disabled='disabled'";
$magdax="";
$resp3=mysql_query("select distinct adgili from sell_temp where magida='$magida' AND print='1'") or die(mysql_error());
$resp4=mysql_query("select distinct adgili from sell_temp where magida='$magida'") or die(mysql_error());
if(mysql_num_rows($resp3)>0 || mysql_num_rows($resp4)<1) $magdax="disabled";
$suljami=mysql_fetch_array(mysql_query("select sum(fasi) from sell_temp where magida='$magida' order by id desc")) or die(mysql_error());
?>

	<button class="btn btn-large btn-warning" style="font-size:20px;float:left;margin:0;" onClick="magidis_daxurva('<?php echo $magida; ?>')" <?php echo $magdax; ?>>მაგიდის დახურვა</button>
	<p class="label label-inverse" style="width:200px;max-width:230px;margin:0;float:right;font-size:28px;padding-top:15px;padding-bottom:15px;"><?php echo $suljami["sum(fasi)"]; ?> ლარი</p>
	<input type="hidden" name="procentisul" id="procentisul" value="8">
<table><tr>
<td>
<fieldset>

<table width="100%" class="table-bordered">
<thead>
<td><b>მომსახურეობის პროცენტი</b></td><td  align="right" width="230"><b>ფასდაკლება</b></td>
</thead>
<tr>
<td>
<div class="btn-group" data-toggle="buttons-radio">
  <button type="button" onClick="document.getElementById('procentisul').value='0';" class="btn btn-primary btn-large">0%</button>
  <button type="button" onClick="document.getElementById('procentisul').value='8';" class="btn btn-primary btn-large active">8%</button>
  <button type="button" onClick="document.getElementById('procentisul').value='15';" class="btn btn-primary btn-large">15%</button>
</div>
</td>
<td rowspan=3 valign="top" align="right" >
<input type="number" min="0" max="100"class="input-small" style="height:30px;" for="a" name="fasdaklebisprocenti" id="fasdaklebisprocenti" placeholder="%" maxlength="3" pattern="([0-9]|[0-9]|[0-9])" size=1 value="">

<input type="password" class="input-small" name="fasdaklebiskodi" id="fasdaklebiskodi" placeholder="პაროლი" size=8 value="">
</td>
</tr>
</table>
</fieldset>
</td>
</tr></table>
<?php
$adgilebi="";
$resp2=mysql_query("select distinct adgili from sell_temp where magida='$magida' AND print='1'") or die(mysql_error());
while($prod2=mysql_fetch_array($resp2)){
$adgilebi.=$prod2['adgili'].",";
}
$adgilebi2=explode(",", $adgilebi);
$ad=mysql_query("select * from adgili");
echo "<table><tr>";
$ads='';
while($ads=mysql_fetch_array($ad)){
$i=0;
while($adgilebi2[$i]!=""){
if($ads['id']==$adgilebi2[$i]) $disabled="";
$i++;
}
?>
<td>
<table><tr>
<td><input type="button" class="btn btn-success" value="<?php echo $ads['name']; ?>" onclick="print_window(<?php echo $ads['id']; ?>,<?php echo $magida; ?>)" <?php echo $disabled; ?> style="height: 60px; width: 100px" /></td>
</tr></table>
</td>
<?php
$disabled="disabled='disabled'";
}
?>
<td><button class="btn" onClick="print_check('<?php echo $magida; ?>')" style="height: 60px; width: 100px"><i class="icon-print"></i> ჩეკი</button></td>
<?php
echo "</tr></table>";

$bgcolor="success";
$nom=1;
$resp=mysql_query("select * from sell_temp where magida='$magida' order by id desc") or die(mysql_error());
echo "<div style='width:450px;max-height:470px;overflow:auto;'>
<table class='table table-bordered' width='100%'>
<tr bgcolor='#FFFFCC'>
<td>№</td><td>დასახელება</td><td>რაოდენობა</td><td>ფასი</td><td>ქმედება</td>
</tr>";
while($prod=mysql_fetch_array($resp)){
if($prod['print']==0) $bgcolor="error";
else $bgcolor="success";
?>
<tr class="<?php echo $bgcolor; ?>" height="40">
<td><b><?php echo $nom; ?></b></td>
<td width="200"><b>
<?php if($prod['print']==0) {?><a href="javascript:orderedit(<?php echo $prod['id'];?>)"><?php } ?>
<?php echo "<b>".$prod['saxeli']."</b>"; ?>
<?php if($prod['print']==0) {?></a><?php } ?>
</b></td><td width="100"><b><?php echo $prod['raodenoba']; ?></b></td><td><b><?php echo $prod['fasi']; ?> ლარი</b></td><td bgcolor="white" align="center">
<?php if($prod['print']==1) {?><input type="button" class="btn btn-danger" value="წაშლა" onclick='javascript:deletefromtableid("<?php echo $prod['id']; ?>","<?php echo $prod['magida']; ?>")' id='deletefromtable' name='deletefromtable' style="height: 40px; width: 80px;"/>
<?php } ?></td></tr>
<?php
$nom++;
}
echo "</table></div>";
?>

<?php
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>



<?php
// პროდუქტის არჩევისას <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(@$_POST['dos']=="selectprod" && $_POST['id']!=""){
mysqlconnect();
$id=safe($_POST['id']);
$resp=mysql_query("select * from product where id='".$_POST['id']."'") or die(mysql_error());
$prod=mysql_fetch_array($resp);
?>
<input type="hidden" name="proddamatebaid" id="proddamatebaid" value="<?php echo $prod['id']; ?>"/>
<table width="100%" border="0">
<tr>
<td>
<input type="text" name="prodsaxeli" id="prodsaxeli" readonly="readonly" value="<?php echo $prod['saxeli']; ?>" style="width:250px;"/>
</td>
</tr><tr>
<td>
<input type="button" value="-" class="btn btn-danger" onClick="prodraodenobaremove()" style="height: 40px; width: 40px" title="რაოდენობის შემცირება"/>
<input type="text" name="prodraodenoba" readonly="readonly" size="1" style="width:50px;" id="prodraodenoba" value="1" size="1" onChange="chnagepriceraodenoba()"  title="რაოდენობის"/>
<input type="button" value="+" class="btn btn-success" onClick="prodraodenobaadd()" style="height: 40px; width: 40px" title="რაოდენობის გაზრდა"/>
</td>
</tr><tr>
<td>
<input type="text" name="prodfasi" id="prodfasi" size="5" readonly="readonly" value="<?php echo $prod['fasi']; ?> ლარი" size="1"/> 
</td>
</tr><tr>
<td>
<input type="text" name="prodfasisul" id="prodfasisul" size="5" readonly="readonly" value="<?php echo $prod['fasi']; ?> ლარი" size="2"/> 
</td>
</tr>
<tr>
<td>
<select name="adgili" id="adgili" style="height:40px;font-size:23px;">
<?php
$adgil=mysql_query("select * from adgili") or die(mysql_error());
$selected="";
while($adg=mysql_fetch_array($adgil)){
if($adg['id']==$prod['adgili']) $selected="selected";
echo "<option value='".$adg['id']."' ".$selected.">".$adg['name']."</option>";
$selected="";
}
?>
<option />
</select>
</td>
</tr>
<tr>
<td>
<table>
<tr>
<td style="border: solid 1px black;" valign="top">
<input type="text" name="manualraodenoba" id="manualraodenoba" style="width:250px;"/><br>
<input type="button" value="1" class="btn btn-info" onClick="manualraodenoba('1')" style="height: 50px; width: 48px"/>
<input type="button" value="2" class="btn btn-info" onClick="manualraodenoba('2')" style="height: 50px; width: 48px"/>
<input type="button" value="3" class="btn btn-info" onClick="manualraodenoba('3')" style="height: 50px; width: 48px"/>
<input type="button" value="4" class="btn btn-info" onClick="manualraodenoba('4')" style="height: 50px; width: 48px"/>
<input type="button" value="5" class="btn btn-info" onClick="manualraodenoba('5')" style="height: 50px; width: 48px"/><br>
<input type="button" value="6" class="btn btn-info" onClick="manualraodenoba('6')" style="height: 50px; width: 48px"/>
<input type="button" value="7" class="btn btn-info" onClick="manualraodenoba('7')" style="height: 50px; width: 48px"/>
<input type="button" value="8" class="btn btn-info" onClick="manualraodenoba('8')" style="height: 50px; width: 48px"/>
<input type="button" value="9" class="btn btn-info" onClick="manualraodenoba('9')" style="height: 50px; width: 48px"/>
<input type="button" value="0" class="btn btn-info" onClick="manualraodenoba('0')" style="height: 50px; width: 48px"/><br>
<input type="button" value=" წაშლა " class="btn btn-danger" onClick="manualraodenobachange('clear')" style="height: 50px; width: 80px;"/>
<input type="button" value=" შეცვლა" class="btn btn-success" onClick="manualraodenobachange('change')" style="height: 50px; width: 170px;"/><br>
</td>
</tr><tr>
<td valign="top">
<input type="button" id="proddamateba" name="proddamateba" class="btn btn-inverse" onclick="proddamateba();" value="შეკვეთა" style="height: 70px; width: 280px; font-size:45px;"/>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>



<?php
// პროდუქტის დამატება <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if($_POST['dos']=="prodamateba" && $_POST['prod_id']>0 && $_POST['raodenoba']>0 && $_POST['magida']>0){
mysqlconnect();
$prod_id=safe($_POST['prod_id']);
$raodenoba=safe($_POST['raodenoba']);
$magida=safe($_POST['magida']);
$adgili=safe($_POST['adgili']);
$date = time();
$year=date('Y');
$month=date('m');
$day=date('d');
$hour=date('H');
$min=date('i');
$sec=date('s');
if(checkmagida($magida)){
$resp=mysql_query("select * from product where id='$prod_id'");
$prod=mysql_fetch_array($resp);
$fasisul=$raodenoba*$prod['fasi'];
$ertfasi=$prod['fasi'];
mysql_query("insert into sell_temp values (null,'".$prod_id."','".$raodenoba."','".$ertfasi."','".$fasisul."','".$prod['saxeli']."','".$prod['cat']."','$date','$year','$month','$day','$hour','$min','$sec','".$magida."','".$_SESSION['seqcia']."','$adgili','1','".$_SESSION['userid']."')") or die(mysql_error());
}else{
	die("აირჩიეთ მაგიდა");
}
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>

<?php
// შეკვეტის წაშლა მაგიდიდან <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if($_POST['dos']=="deletefromtable" && $_POST['id']!=""){
mysqlconnect();
mysql_query("delete from sell_temp where id='".safe($_POST['id'])."' AND print='1'") or die(mysql_error());
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>

<?php
}
}

if(@$_GET['dos']=="logout"){
session_destroy();
echo '<meta http-equiv="refresh" content="0; URL=login.php">';
}
?>
