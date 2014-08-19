<?php
session_start();
include("config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
if($_POST['dos']=='login'){
mysqlconnect();
if(stripslashes($_POST['username'])!="" || $_POST['password']!=""){
$username=stripslashes($_POST['username']);
$loginquery=mysql_query("select * from tanamshromlebi where username='$username'") or die(mysql_error());
$login=mysql_fetch_array($loginquery);
if($login['username']!=""){
	if($_POST['password']==$login['password']){
		$_SESSION['username']=$username;
		$_SESSION['role']=$login['role'];
		$_SESSION['userid']=$login['id'];
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
}
if($_POST['dos']=="addcat" || $_POST['dos']=="cats_refresh" || $_POST['dos']=="edit_cats" || $_POST['dos']=="delete_cats"){
mysqlconnect();
if($_POST['dos']=="addcat"){
$cat_id=htmlspecialchars($_POST['id']);
$cat_name=htmlspecialchars($_POST['name']);
$visible=$_POST['visible'];
mysql_query("insert into cats values ('$cat_id','$cat_name','$visible')") or die(mysql_error());
}

if($_POST['dos']=="edit_cats"){
$cat_id=htmlspecialchars($_POST['id']);
$cat_name=htmlspecialchars($_POST['name']);
$visible=$_POST['visible'];
mysql_query("update cats set name='$cat_name',visible='$visible' where id='$cat_id'") or die(mysql_error());
}

if($_POST['dos']=="delete_cats"){
$cat_id=htmlspecialchars($_POST['id']);
mysql_query("delete from cats where id='$cat_id'") or die(mysql_error());
}

$resp=mysql_query("select * from cats order by id asc");
echo"<table><tr><td>ID</td><td>დასახელება</td><td>V</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='cat <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=2 id='show_cat_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=30 id='show_cat_name' value='<?php echo $show['name']; ?>'></td>
<td>
<select type="text" name="show_visible" id="show_visible">
	<option value="1" <?php if($show['visible']=="1") echo "selected"; ?>>კი</option>
	<option value="0" <?php if($show['visible']!="1") echo "selected"; ?>>არა</option>  
</select>
<?php //echo $show['visible']; ?></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_cats(this.form);'>
<!--<input type='button' style='background: white url("images/EditCategory.gif") no-repeat top; width: 20px; height: 20px;'>-->
<!--<a href='javascript:delete_cat("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a>--></td>
</tr></form>
<?php
}
echo "</table>";
}
?>


<?php
if($_POST['dos']=="addtable" || $_POST['dos']=="tables_refresh" || $_POST['dos']=="edit_tables" || $_POST['dos']=="delete_tables" || $_POST['dos']=="search_table_by_seqcia"){
mysqlconnect();
if($_POST['dos']=="addtable"){
//$table_id=htmlspecialchars($_POST['id']);
$table_name=htmlspecialchars($_POST['name']);
$table_seqcia=htmlspecialchars($_POST['seqcia']);
$visible=$_POST['visible'];
mysql_query("insert into tables values (null,'$table_name','$visible','$table_seqcia')") or die(mysql_error());
$resp=mysql_query("select * from tables where seqcia='".$table_seqcia."' order by seqcia, id asc") or die(mysql_error());
}

if($_POST['dos']=="edit_tables"){
$table_id=htmlspecialchars($_POST['id']);
$table_name=htmlspecialchars($_POST['name']);
$table_seqcia=htmlspecialchars($_POST['seqcia']);
$visible=$_POST['visible'];
mysql_query("update tables set name='$table_name',seqcia='$table_seqcia',visible='$visible' where id='$table_id'") or die(mysql_error());
}

if($_POST['dos']=="delete_tables"){
$table_id=htmlspecialchars($_POST['id']);
mysql_query("delete from tables where id='$table_id'") or die(mysql_error());
}

if($resp=="") $resp=mysql_query("select * from tables order by seqcia, id asc") or die(mysql_error());
if($_POST['dos']=="search_table_by_seqcia")  $resp=mysql_query("select * from tables where seqcia='".$_POST['search']."' order by seqcia, id asc") or die(mysql_error());
echo"<table><tr><td>ID</td><td>დასახელება</td><td>ადგილი</td><td>V</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='table <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=2 id='show_table_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=30 id='show_table_name' value='<?php echo $show['name']; ?>'></td>
<td><select id='show_table_seqcia'>
<?php
$seqc=mysql_query("select * from seqciebi");
$selected="";
while($seq=mysql_fetch_array($seqc)){
if($seq['id']==$show['seqcia']) $selected="selected";
echo "<option value='".$seq['id']."' ".$selected.">".$seq['name']."</option>";
$selected="";
}
?></select></td>
<td>
<select type="text" name="show_visible" id="show_visible">
	<option value="1" <?php if($show['visible']=="1") echo "selected"; ?>>კი</option>
	<option value="0" <?php if($show['visible']!="1") echo "selected"; ?>>არა</option>  
</select>
<?php //echo $show['visible']; ?></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_tables(this.form);'>
<!--<input type='button' style='background: white url("images/EditCategory.gif") no-repeat top; width: 20px; height: 20px;'>-->
<a href='javascript:delete_table("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a></td>
</tr></form>
<?php
}
echo "</table>";
}
?>


<?php
if($_POST['dos']=="addproduct" || $_POST['dos']=="edit_products" || $_POST['dos']=="delete_products"  || $_POST['dos']=="search_products" || $_POST['dos']=="search_products_by_cat"){
mysqlconnect();
$resp=mysql_query("select * from product order by id asc");
if($_POST['dos']=="addproduct"){
$name=htmlspecialchars($_POST['name']);
$cat=htmlspecialchars($_POST['cat']);
$fasi=htmlspecialchars($_POST['fasi']);
$adgili=htmlspecialchars($_POST['adgili']);
$raodenoba=htmlspecialchars($_POST['raodenoba']);
$shemadgenloba=$_POST['prod'];
$visible=$_POST['visible'];
mysql_query("insert into product values (null,'$name','$cat','$fasi','$adgili','$raodenoba','$shemadgenloba','$visible')") or die(mysql_error());
$resp=mysql_query("select * from product order by id desc limit 0,1");
}

if($_POST['dos']=="edit_products"){
$id=htmlspecialchars($_POST['id']);
$name=htmlspecialchars($_POST['name']);
$cat=htmlspecialchars($_POST['cat']);
$fasi=htmlspecialchars($_POST['fasi']);
$adgili=htmlspecialchars($_POST['adgili']);
$raodenoba=htmlspecialchars($_POST['raodenoba']);
$shemadgenloba=$_POST['prod'];
$visible=$_POST['visible'];
//if($shemadgenloba!=""){
mysql_query("update product set saxeli='$name', cat='$cat', fasi='$fasi', adgili='$adgili', raodenoba='$raodenoba', shemadgenloba='$shemadgenloba', visible='$visible' where id='$id'") or die(mysql_error());
$text=$id."|".$name."|".$cat."|".$fasi."|".$adgili."|".$shemadgenloba."|".$visible;
addlog($text);
//}
echo '<meta http-equiv="refresh" content="0; URL=index.php?cat=productsedit&prodid='.$id.'">';
//$resp=mysql_query("select * from product where id='$id'");
}

if($_POST['dos']=="delete_products"){
$id=htmlspecialchars($_POST['id']);
mysql_query("delete from product where id='$id'") or die(mysql_error());
$resp=mysql_query("select * from product order by saxeli asc");
}

//if($_POST['dos']=="search_products" || $_POST['dos']=="search_products_by_cat"){
$search=htmlspecialchars($_POST['search']);
if($_POST['dos']=="search_products") $resp=mysql_query("select * from product where saxeli like '%".$search."%' OR id='$search' order by saxeli asc");
if($_POST['dos']=="search_products_by_cat")  $resp=mysql_query("select * from product where cat='$search' order by saxeli asc");
?>
<table><tr><td>ID</td><td>დასახელება</td><td>კატეგორია</td><td>ფასი</td><td>ადგილი</td><td>V</td><td>ქმედება</td></tr>
<?php
while($show=mysql_fetch_array($resp)){
$resp2=mysql_fetch_array(mysql_query("select * from cats where id='".$show['cat']."'"));
$showadgili=mysql_fetch_array(mysql_query("select * from adgili where id='".$show['adgili']."'"));
?>
<form name='product <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=2 id='show_product_id' name='show_product_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=30 id='show_product_name' name='show_product_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><input type='text' size=18 id='show_product_cat' name='show_product_cat' value='<?php echo $resp2['name']; ?>'></td>
<!--<td>
<select type="text" name="show_product_cat" id="show_product_cat">
	<?php
	
	$selected="";
	while($show2=mysql_fetch_array($resp2)){
		if($show['cat']==$show2['id']) $selected="selected";
		echo '<option value="'.$show2["id"].'" '.$selected.'>'.$show2["name"].'</option>';
		$selected="";
	}
	?>  
</select>
</td>-->
<td><input type='text' size=3 id='show_product_fasi' value='<?php echo $show['fasi']; ?>'></td>
<td><input type='text' size=10 id='show_product_adgili' value='<?php echo $showadgili['name']; ?>'></td>
<td><input type='text' size=1 id='show_visible' value='<?php if($show['visible']=="1") {echo "კი";} else {echo "არა";}; ?>'></td>

<td>
<a href="index.php?cat=productsedit&prodid=<?php echo $show['id']; ?>"><input type='button' title='რედაქტირება' value='რედ.'></a>
<!--<input type='button' title='edit' value='edit' onclick='change_show_products(this.form);'>-->
<!--<input type='button' style='background: white url("images/EditCategory.gif") no-repeat top; width: 20px; height: 20px;'>-->
<!--<a href='javascript:delete_product("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a>--></td>
</tr></form>
<?php
}
echo "</table>";
//}
}


if($_POST['dos']=="addtan" || $_POST['dos']=="edit_tan" || $_POST['dos']=="delete_tan"  || $_POST['dos']=="search_tan"){
mysqlconnect();
$resp=mysql_query("select * from tanamshromlebi order by id asc");
if($_POST['dos']=="addtan"){
$tan_name=htmlspecialchars($_POST['tan_name']);
$tan_surname=htmlspecialchars($_POST['tan_surname']);
$tan_username=htmlspecialchars($_POST['tan_username']);
$tan_pass=htmlspecialchars($_POST['tan_pass']);
$tan_email=htmlspecialchars($_POST['tan_email']);
$tan_tel=$_POST['tan_tel'];
$tan_role=$_POST['tan_role'];
$tan_xelfasi=$_POST['tan_xelfasi'];
mysql_query("insert into tanamshromlebi values (null,'$tan_username','$tan_pass','$tan_name','$tan_surname','$tan_email','$tan_tel','$tan_role','$tan_xelfasi')") or die(mysql_error());
$resp=mysql_query("select * from tanamshromlebi order by id asc");
}

if($_POST['dos']=="edit_tan"){
$tan_id=htmlspecialchars($_POST['tan_id']);
$tan_name=htmlspecialchars($_POST['tan_name']);
$tan_surname=htmlspecialchars($_POST['tan_surname']);
$tan_username=htmlspecialchars($_POST['tan_username']);
$tan_pass=htmlspecialchars($_POST['tan_pass']);
$tan_email=htmlspecialchars($_POST['tan_email']);
$tan_tel=$_POST['tan_tel'];
mysql_query("update tanamshromlebi set saxeli='$tan_name', gvari='$tan_surname', username='$tan_username', password='$tan_pass', addr='$tan_email', tel='$tan_tel' where id='$tan_id'") or die(mysql_error());
$resp=mysql_query("select * from tanamshromlebi where id='$tan_id'");
}

if($_POST['dos']=="delete_tan"){
$id=htmlspecialchars($_POST['id']);
mysql_query("delete from tanamshromlebi where id='$id'") or die(mysql_error());
$resp=mysql_query("select * from tanamshromlebi order by id asc");
}

//if($_POST['dos']=="search_products" || $_POST['dos']=="search_products_by_cat"){
$search=htmlspecialchars($_POST['search']);
if($_POST['dos']=="search_tan") $resp=mysql_query("select * from tanamshromlebi where saxeli like '%".$search."%' OR gvari like '%".$search."%' order by id asc");
echo"<table><tr><td>ID</td><td>სახელი</td><td>გვარი</td><td>username</td><td>password</td><td>მის</td><td>ტელ</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='cat <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=2 id='show_tan_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=5 id='show_tan_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><input type='text' size=5 id='show_tan_surname' value='<?php echo $show['gvari']; ?>'></td>
<td><input type='text' size=5 id='show_tan_username' value='<?php echo $show['username']; ?>'></td>
<td><input type='text' size=5 id='show_tan_pass' value='<?php echo $show['password']; ?>'></td>
<td><input type='text' size=5 id='show_tan_email' value='<?php echo $show['email']; ?>'></td>
<td><input type='text' size=5 id='show_tan_tel' value='<?php echo $show['tel']; ?>'></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_tan(this.form);'>
<!--<input type='button' style='background: white url("images/EditCategory.gif") no-repeat top; width: 20px; height: 20px;'>-->
<a href='javascript:delete_tan("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a></td>
</tr></form>
<?php
}
echo "</table>";
}



if($_POST['dos']=="addingr" || $_POST['dos']=="ingr_refresh" || $_POST['dos']=="edit_ingrs" || $_POST['dos']=="delete_ingr" || $_POST['dos']=="search_ingr_by"){
mysqlconnect();
if($_POST['dos']=="addingr"){
$ingr_name=htmlspecialchars($_POST['name']);
$ingr_adgili=htmlspecialchars($_POST['adgili']);
$ingr_raodenoba=0;
$ingr_minraodenoba=htmlspecialchars($_POST['minraodenoba']);
mysql_query("insert into productebi values (null,'$ingr_name','$ingr_raodenoba','$ingr_minraodenoba','$ingr_adgili')") or die(mysql_error());
}

if($_POST['dos']=="edit_ingrs"){
$ingr_id=htmlspecialchars($_POST['id']);
$ingr_name=htmlspecialchars($_POST['name']);
$ingr_raodenoba=htmlspecialchars($_POST['raodenoba']);
$ingr_minraodenoba=htmlspecialchars($_POST['minraodenoba']);
$ingr_adgili=htmlspecialchars($_POST['adgili']);
mysql_query("update productebi set saxeli='$ingr_name',raodenoba='$ingr_raodenoba',minraodenoba='$ingr_minraodenoba',adgili='$ingr_adgili' where id='$ingr_id'") or die(mysql_error());
}

if($_POST['dos']=="delete_ingr"){
$ingr_id=htmlspecialchars($_POST['id']);
mysql_query("delete from productebi where id='$ingr_id'") or die(mysql_error());
}

$resp=mysql_query("select * from productebi order by saxeli asc");
if($_POST['dos']=="search_ingr_by"){
$ingr_action=htmlspecialchars($_POST['action']);
$resp=mysql_query("select * from productebi where adgili='$ingr_action' order by saxeli asc");
}
echo"<table><tr bgcolor='red'><td style='background-color='yellow'>ID</td><td>დასახელება</td><td>ადგილი</td><td>რაოდენობა</td><td>კრიტიკული რაოდენობა</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){
?>
<form name='ingr <?php echo $show['id']; ?>'>
<tr <?php if($show['raodenoba']<=$show['minraodenoba']) echo "bgcolor='yellow'"; ?>>
<td><input type='text' size=2 id='show_ingr_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=20 id='show_ingr_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><select name="show_ingr_adgili" id="adgili">
<?php
$adg=mysql_query("select * from adgili where id in (select distinct nashti from adgili) order by id asc");
$selected="";
while($adgili=mysql_fetch_array($adg)){
if($show['adgili']==$adgili['id']) $selected="selected";
echo '<option value="'.$adgili["nashti"].'" '.$selected.'>'.$adgili["name"].'</option>';
$selected="";
}
?></select></td>
<td><input type='text' size=10 id='show_ingr_raodenoba' value='<?php echo $show['raodenoba']; ?>' disabled></td>
<td><input type='text' size=10 id='show_ingr_minraodenoba' value='<?php echo $show['minraodenoba']; ?>'></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_ingr(this.form);'>
<!--<a href='javascript:delete_ingr("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a></td>-->
</tr></form>
<?php
}
echo "</table>";
}


if($_POST['dos']=="migebebi_search_products"){
mysqlconnect();
$search=htmlspecialchars($_POST['search']);
$resp=mysql_query("select * from productebi where saxeli like '%".$search."%' OR id='$search' order by saxeli") or die(mysql_error());
echo"<table><tr><td width='60'>ID</td><td width='225'>სახელი</td><td width='75'>ადგილი</td><td width='75'>რაოდენობა</td><td width='75'>ერთ. ფასი</td><td width='75'>ჯამი</td><td width='45'>ვალი</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<tr><td colspan='8'><form name='migebebi<?php echo $show['id']; ?>' action='' method="POST"><table><tr>
<td><input type='text' size='2' id='prod_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size='30' id='prod_name' value="<?php echo $show['saxeli']; ?>"  disabled='disabled'></td>
<td><input type='text' size='5' id='adgili' name="adgili" value='<?php echo $pr['name']; ?>' disabled='disabled'></td>
<td width='85'><input type='text' size='5' id='prod_raodenoba' name='prod_raodenoba' onChange="changemigebebijami(this.form)" value=''></td>
<td><input type='text' size='5' id='prod_ert_fasi' NAME='prod_ert_fasi' onChange="changemigebebijami(this.form)" value=''></td>
<td><input type='text' size='5' id='prod_jami' name='prod_jami' value=''></td>

<td width='45'><input type='checkbox' id='prod_vali'></td>
<td><input type='button' title='დამატება' value='დამატება' onclick='migebebei_add_products(this.form);'></td>
</tr></table></form></td>
</tr>
<?php
}
echo "</table>";
}

if($_POST['dos']=="productebi_search_products"){
mysqlconnect();
$search=htmlspecialchars($_POST['search']);
$resp=mysql_query("select * from productebi where saxeli like '%".$search."%' OR id='$search' order by saxeli") or die(mysql_error());
echo"<table><tr bgcolor='red'><td style='background-color='yellow'>ID</td><td>დასახელება</td><td>ადგილი</td><td>რაოდენობა</td><td>კრიტიკული რაოდენობა</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='ingr <?php echo $show['id']; ?>'>
<tr <?php if($show['raodenoba']<=$show['minraodenoba']) echo "bgcolor='yellow'"; ?>>
<td><input type='text' size=2 id='show_ingr_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=20 id='show_ingr_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><select name="show_ingr_adgili" id="adgili">
<?php
$adg=mysql_query("select * from adgili where id in (select distinct nashti from adgili) order by id asc");
$selected="";
while($adgili=mysql_fetch_array($adg)){
if($show['adgili']==$adgili['id']) $selected="selected";
echo '<option value="'.$adgili["nashti"].'" '.$selected.'>'.$adgili["name"].'</option>';
$selected="";
}
?></select></td>
<td><input type='text' size=10 id='show_ingr_raodenoba' value='<?php echo $show['raodenoba']; ?>' disabled></td>
<td><input type='text' size=10 id='show_ingr_minraodenoba' value='<?php echo $show['minraodenoba']; ?>'></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_ingr(this.form);'>
<!--<a href='javascript:delete_ingr("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a></td>-->
</tr></form>
<?php
}
echo "</table>";
}


if($_POST['dos']=="migebebi_add_products"){
mysqlconnect();
$prod_id=htmlspecialchars($_POST['prod_id']);
//$adgili=htmlspecialchars($_POST['adgili']);
$prod_ert_fasi=htmlspecialchars($_POST['prod_ert_fasi']);
$prod_raodenoba=htmlspecialchars($_POST['prod_raodenoba']);
$prod_jami=round($prod_ert_fasi*$prod_raodenoba,2);
$dro=time();
$adgili=mysql_fetch_array(mysql_query("select * from adgili where id in (select adgili from productebi where id='$prod_id')")) or die(mysql_error());
mysql_query("update productebi set raodenoba=raodenoba+$prod_raodenoba where id='$prod_id'") or die(mysql_error());
mysql_query("insert into migebebi values(null, '$prod_id','$prod_raodenoba','".$adgili['id']."','$prod_ert_fasi','$prod_jami','$dro','".$_SESSION['userid']."')") or die(mysql_error());
//mysql_query("insert into xarjebi values(null,'პროდუქტის მიღება: $prod_id / $prod_raodenoba', '$dro', '$prod_jami')");
echo $prod_id." <font color='green'><b> წარმატებით დაემატა</b></font>";
}


if($_POST['dos']=="chamocera_search_products"){
mysqlconnect();
$search=htmlspecialchars($_POST['search']);
$resp=mysql_query("select * from productebi where saxeli like '%".$search."%' OR id='$search' order by saxeli") or die(mysql_error());
echo"<table><tr><td>ID</td><td>სახელი</td><td>რაოდენობა</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='migebebi <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=2 id='prod_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=30 id='prod_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><input type='text' size=5 id='prod_raodenoba' value=''></td>
<td><input type='button' title='ჩამოწერა' value='ჩამოწერა' onclick='chamocera_add_products(this.form);'>
</td>
</tr></form>
<?php
}
echo "</table>";
}

if($_POST['dos']=="chamocera_add_products"){
mysqlconnect();
$prod_id=$_POST['prod_id'];
$prod_raodenoba=$_POST['prod_raodenoba'];
$dro=time();
mysql_query("insert into xarjebi values(null,'პროდუქტის ჩამოწერა:".$prod_id." / ".$prod_raodenoba."','$dro','$kom_tanxa')") or die(mysql_error());
mysql_query("update productebi set raodenoba=raodenoba-'$prod_raodenoba' where id='$prod_id'") or die(mysql_error());
echo "<font color='green'><b>".$prod_id.": წარმატებით ჩამოეწერა</b></green>";
}

// რეპორტები – ადგილის მიხედვით
if($_POST['dos']=="reportsalesadgili"){
$adgili=$_POST['adgili'];
$addsql="";
if($adgili!="") $addsql.="AND adgili='".$adgili."' ";
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
$product="";
mysqlconnect();
$jami=0;
$jami1=0;
	$resp1=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' ".$addsql."order by dro desc");
	$resp=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' ".$addsql."order by dro desc");
	$resp2=mysql_query("select * from migebebi where dro>='$fromday' AND dro<='$today' ".$addsql."order by dro desc");
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['fasi'];
}
while($mig=mysql_fetch_array($resp2)){
$jami+=$mig['jami'];
}
echo "<h2><font color='green'>მიღებულია: </font><font color='red'>".round($jami,2)."</font><font color='green'> ლარის</font>";
echo "<h2><font color='green'>რეალიზებული: </font><font color='red'>".round($jami1,2)."</font><font color='green'> ლარი</font>";
echo "</h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
if($adgili==1) echo "<input type='button' onclick='reportsalesadgilinashti(\"".$adgili."\");' value='ნაშთი'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დრო</td><td width='150'>დასახელება</td><td>სექცია</td><td>ადგილი</td><td>რაოდ.</td><td>ჯამი</td><td>user</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select * from product where id='".$sell['prod_id']."'"));
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'"));
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'"));
	$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['seqcia']."'"));
	//$adg=mysql_fetch_array(mysql_query("select * from adgili where id='".$sell['adgili']."'"));
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prod['saxeli']."</td><td>".$seq['name']."</td><td>".$mag['name']."</td><td>".$sell['raodenoba']."</td><td>".$sell['fasi']."</td><td>".$tan['saxeli']." ".$tan['gvari']."</td></tr>";
	$jami+=$sell['fasi'];
	
}
echo "<tr><td colspan='8'>".$jami." ლარი</td></tr></table>";
}

// რეპორტები – ადგილის მიხედვით
if($_POST['dos']=="reportsalesadgilinashti"){
$adgili=$_POST['adgili'];
$jami=0;
mysqlconnect();
$ingrs=mysql_query("select * from productebi where adgili='".$adgili."'");
while($ing=mysql_fetch_array($ingrs)){
	$prod=mysql_fetch_array(mysql_query("select * from product where shemadgenloba like ',".$ing['id'].":%' order by id asc limit 0,1"));
	$jami+=$prod['fasi']*$ing['raodenoba'];
}

echo "<h2><font color='green'>ნაშთი: </font><font color='red'>".round($jami,2)."</font><font color='green'> ლარის</font>";
echo "</h2>";

$ingrs2=mysql_query("select * from productebi where adgili='".$adgili."'");
echo "<table>";
echo "<tr><td>დასახელება</td><td>რაოდენობა</td><td>ერთ. ფასი</td><td>ჯამი</td></tr>";
while($ing2=mysql_fetch_array($ingrs2)){
	$prod=mysql_fetch_array(mysql_query("select * from product where shemadgenloba like ',".$ing2['id'].":%' order by id asc limit 0,1"));
	if($prod['id']=="") continue;
	echo "<tr><td>".$prod['saxeli']."(".$ing2['id'].")</td><td>".$ing2['raodenoba']."</td><td>".$prod['fasi']."</td><td>".$prod['fasi']*$ing2['raodenoba']."</td></tr>";
}
echo "</table>";
}

//რეპორტები – სექციების მიხედვით
if($_POST['dos']=="reportsalesseqcia"){
$adgili="";
if($_POST['adgili']!="") $adgili=" AND seqcia='".$_POST['adgili']."'";
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
$tanamshromeli="";
if($_POST['tanamshromeli']!="") $tanamshromeli=" AND user='".$_POST['tanamshromeli']."'";
mysqlconnect();
$jami=0;
$jami1=0;
$jamiuprocento=0;
$raodenoba=0;
$checks="";
$fasdakleba=0;
$resp=mysql_query("select * from sell where ID!=''".$adgili.$tanamshromeli." order by dro desc") or die(mysql_error());
$resp1=mysql_query("select * from magidisdaxurva where ID!=''".$adgili.$tanamshromeli." order by dro desc") or die(mysql_error());
if($datarange!=""){
	$resp=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today'".$adgili.$tanamshromeli." order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select * from magidisdaxurva where dro>='$fromday' AND dro<='$today'".$adgili.$tanamshromeli." order by dro desc") or die(mysql_error());
}
while($sell1=mysql_fetch_array($resp1)){
	$jami1+=$sell1['tanxa'];
	//$jamiuprocento+=$sell1['tanxa']*((100-$sell1['procenti'])/100);
	$jamiuprocento+=$sell1['procentit']-$sell1['uprocentot'];
	//$raodenoba+=$sell1['raodenoba'];
	$checks.=$sell1['id'].",";
	//if($sell1['fasdaklebisprocenti']!="") $fasdakleba+=$sell1['uprocentot']*$sell1['fasdaklebisprocenti']/100;
	if($sell1['fasdaklebisprocenti']!="") $jamiuprocento-=$sell1['uprocentot']*$sell1['fasdaklebisprocenti']/100;
}
echo "<h2><font color='green'>ნამუშევარი: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font></h2>";
echo "<br><h2><font color='green'>მხოლოდ პროცენტი: </font><font color='red'>".round($jamiuprocento,2)."</font><font color='green'> ლარი</font></h2>";
//echo "<br><h2><font color='green'>ფასდაკლება: </font><font color='red'>".round($fasdakleba,2)."</font><font color='green'> ლარი</font></h2>";
//if($_POST['product']!="") echo "(".$raodenoba." ცალი)";
echo "</h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='100'>დრო</td><td width='150'>დასახელება</td><td>სექცია</td><td>ადგილი</td><td>ადგილი</td><td>რაოდ.</td><td>ჯამი</td><td>user</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select * from product where id='".$sell['prod_id']."'")) or die(mysql_error());
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'")) or die(mysql_error());
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'")) or die(mysql_error());
	$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['seqcia']."'"));
	$adg=mysql_fetch_array(mysql_query("select * from adgili where id='".$sell['adgili']."'")) or die(mysql_error());
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prod['saxeli']."</td><td>".$seq['name']."</td><td>".$mag['name']."</td><td>".$adg['name']."</td><td>".$sell['raodenoba']."</td><td>".$sell['fasi']."</td><td>".$tan['saxeli']." ".$tan['gvari']."</td></tr>";
	$jami+=$sell['fasi'];
	
}
echo "<tr><td colspan='8'>".$jami." ლარი (".(($jami*4)/100).")</td></tr></table>";
}


//რეპორტები – ნაშთები
if($_POST['dos']=="reportsalesnashti"){
mysqlconnect();
$adgili=$_POST['adgili'];
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}

if($adgili==1){
	echo "<table border='1' id='newspaper-b' summary='Results'><thead><tr><td>დასახელება</td><td colspan='2'>ნაშთი</td><td colspan='2'>შემოსული</td><td colspan='2'>გასული</td><td colspan='2'>ნაშთი</td></tr></thead>";
	$nashtifromraod=0;
	$nashtifromtanxa=0;
	$shemosuliraod=0;
	$shemosulitanxa=0;
	$gasuliraod=0;
	$gasulitanxa=0;
	$nashtiraod=0;
	$nashtitanxa=0;

	$jaminashti=0;
	$jamishemosuli=0;
	$jamigasuli=0;
	$jaminashtifinal=0;
	$jaminashtifinal2=0;
	$jaminashtifinal3=0;

	$mquery=mysql_query("select * from product where adgili='$adgili'");
	while($mq=mysql_fetch_array($mquery)){
		echo "<tr style='background:#ffffff'><td>".$mq['saxeli']."</td>";
		$dss=explode(",",$mq["shemadgenloba"]);
		$ds=explode(":",$dss[1]);
		
		$nashtifromquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from migebebi where dro<=$fromday and prod_id='".$ds[0]."' group by prod_id"));
		$gayquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from sell where prod_id='".$mq['id']."' and dro<=$fromday group by prod_id"));
		$nashtifromraod=$nashtifromquery["raod"]-$gayquery["raod"]*$ds[1];
		$nashtifromtanxa=$nashtifromraod*$mq["fasi"];
		$jaminashti+=$nashtifromtanxa;
		$jaminashtifinal2+=$nashtifromtanxa;
		
		echo "<td>".$nashtifromraod."</td><td>".$nashtifromtanxa." ლ.</td>";

		$shemosuliquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from migebebi where dro>=$fromday and dro<=$today and prod_id='".$ds[0]."' group by prod_id"));
		$gayqueryper=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod, sum(fasi) as fasi from sell where prod_id='".$mq['id']."' and dro>=$fromday and dro<=$today group by prod_id"));
		$shemosuliraod=$shemosuliquery["raod"];
		$gasuliraod=$gayqueryper["raod"]*$ds[1];
		
		$shemosulitanxa=$shemosuliraod*$mq["fasi"];
		$gasulitanxa=$gayqueryper["fasi"];
		$jamishemosuli+=$shemosulitanxa;
		$jamigasuli+=$gasulitanxa;
		$jaminashtifinal2=$jaminashtifinal2+$shemosulitanxa-$gasulitanxa;
		
		echo "<td>".($shemosuliraod?$shemosuliraod:0)."</td><td>".$shemosulitanxa." ლ.</td>";
		echo "<td>".$gasuliraod."</td><td>".($gasulitanxa?$gasulitanxa:0)." ლ.</td>";
		
		$nash=mysql_fetch_array(mysql_query("select * from productebi where id='".$ds[0]."'"));
		$nashtiraod=$nash["raodenoba"];
		$nashtitanxa=$nashtiraod*$mq["fasi"];
		$jaminashtifinal+=$nashtitanxa;
		$jaminashtifinal3+=$nashtitanxa;
		echo "<td>".($nashtiraod?$nashtiraod:0)."</td><td>".($nashtitanxa?$nashtitanxa:0)." ლ.</td>";
		
		echo "</tr>";
		if(($nashtifromtanxa+$shemosulitanxa-$gasulitanxa)!=$nashtitanxa) echo $mq['saxeli']."<br>";
	}
}else{
	echo "<table border='1' id='newspaper-b' summary='Results'><thead><tr><td>დასახელება</td><td colspan='1'>ნაშთი</td><td colspan='2'>შემოსული</td><td colspan='1'>გასული</td><td colspan='1'>ნაშთი</td></tr></thead>";
	$nashtifromraod=0;
	$gayidulifrom=0;
	$shemosuliraod=0;
	$gayiduli=0;
	$gasuliraod=0;
	$nashtiraod=0;

	$jaminashti=0;
	$jamishemosuli=0;
	$jamigasuli=0;
	$jaminashtifinal=0;
	$mquery=mysql_query("select * from productebi where adgili='$adgili'");
	while($mq=mysql_fetch_array($mquery)){
		echo "<tr style='background:#ffffff'><td>".$mq['saxeli']."</td>";
		$gayqpr=mysql_query("select * from product where shemadgenloba like '%,".$mq['id'].":%'");
		$gayqprr=mysql_query("select * from product where shemadgenloba like '%,".$mq['id'].":%'");
		
		$nashtifromquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from migebebi where dro<=$fromday and prod_id='".$mq['id']."' group by prod_id"));
		
		while($gypr=mysql_fetch_array($gayqpr)){
			$gayquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from sell where prod_id='".$gypr['id']."' and dro<=$fromday group by prod_id"));
			$dss=explode(",",$gypr["shemadgenloba"]);
			$i=1;
			$ds="";
			while($dss[$i]!=""){
				if(strpos($dss[$i],$mq['id'].":") !== false){
					$ds=explode(":",$dss[$i]);
				}
				$i++;
			}
			$gayidulifrom+=$gayquery["raod"]*$ds[1];
		}
		$nashtifromraod=$nashtifromquery["raod"]-$gayidulifrom;
		echo "<td>".$nashtifromraod."</td>";
		
		$shemosuliquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod, sum(jami) as jam from migebebi where dro>=$fromday and dro<=$today and prod_id='".$mq['id']."' group by prod_id"));
		echo "<td>".$shemosuliquery['raod']."</td><td>".$shemosuliquery['jam']." ლ.</td>";	
		
		while($gyprr=mysql_fetch_array($gayqprr)){
			$gayquery=mysql_fetch_array(mysql_query("select *, sum(raodenoba) as raod from sell where prod_id='".$gyprr['id']."' and dro>=$fromday and dro<=$today group by prod_id"));
			$dss=explode(",",$gyprr["shemadgenloba"]);
			$i=1;
			$ds="";
			while($dss[$i]!=""){
				if(strpos($dss[$i],$mq['id'].":") !== false){
					$ds=explode(":",$dss[$i]);
				}
				$i++;
			}
			if($gayquery["raod"]>0 && $ds[1]>0){
				$gayiduli+=$gayquery["raod"]*$ds[1];
			}
		}
		echo "<td>".$gayiduli."</td>";	
		
		$nashtiraod=$nashtifromraod+$shemosuliquery['raod']-$gayiduli;
		if(strval($mq['raodenoba'])==strval($nashtiraod)){
			echo "<td>".$mq['raodenoba']."</td>";
		} else {
			echo "<td>SHECDOMA / ".$mq['raodenoba']." / ".$nashtiraod."</td>";
		}		
		
		echo "</tr>";
		$gayidulifrom=0;
		$gayiduli=0;
	}
}
echo "<tr><td colspan='3' align='right'>$jaminashti ლ.</td><td colspan='2' align='right'>$jamishemosuli ლ.</td><td colspan='2' align='right'>$jamigasuli ლ.</td><td colspan='2' align='right'>$jaminashtifinal2 / $jaminashtifinal ლ.</td></tr></table>";
}


//რეპორტები – სექციების მიხედვით
if($_POST['dos']=="reportsalesdgiuri"){
mysqlconnect();
$fromday=strtotime(safe($_POST['fromyear'])."-".safe($_POST['frommon'])."-".safe($_POST['fromday'])." 02:00:00");
//$today=strtotime(safe($_POST['fromyear'])."-".safe($_POST['frommon'])."-".safe($_POST['fromday']+1)." 02:00:00");
$today=$fromday+86400;
$date=date("Y-m-d H:i:s",time());
$jami1=0;
$jamiuprocento=0;
$resp1=mysql_query("select * from magidisdaxurva where dro>='$fromday' AND dro<='$today' order by dro desc") or die(mysql_error());
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['tanxa'];
$jamiuprocento+=$sell1['procentit']-$sell1['uprocentot'];
}
echo "<br>".date("Y-m-d H:i:s",$today);
echo "<h2><font color='green'>პროცენტით: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font></h2>";
echo "<h2><font color='green'>უპროცენტოთ: </font><font color='red'>".($jami1-$jamiuprocento)."</font><font color='green'> ლარი</font></h2>";
echo "<br><h2><font color='green'>მხოლოდ პროცენტი: </font><font color='red'>".round($jamiuprocento,2)."</font><font color='green'> ლარი</font></h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<br><input type='button' onclick='dailyprint();' value='ბეჭდვა'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დასახელება</td><td>რაოდ</td><td>ჯამი</td></thead>";
$resp=mysql_query("select prod_id,sum(raodenoba) as raodenoba,sum(fasi) as fasi from sell where dro>='".$fromday."' and dro<='".$today."' group by prod_id order by saxeli asc") or die(mysql_error());
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select saxeli from product where id='".$sell['prod_id']."'")) or die(mysql_error());
	$saxeli=$prod['saxeli'];
	echo "<tr style='background:#ffffff'><td>".$saxeli."</td><td>".round($sell['raodenoba'],2)."</td><td>".round($sell['fasi'],2)."</td></tr>";
	
}
echo "</table>";
}

// რეპორტები - კერძების მიხედვით
if($_POST['dos']=="reportsales"){
$product="";
if($_POST['product']!="") $product="AND prod_id='".$_POST['product']."'";
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
mysqlconnect();
$jami=0;
$jami1=0;
$raodenoba1=0;
$raodenoba=0;
	$resp=mysql_query("select * from sell where id!='' ".$product." order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select * from sell where id!='' ".$product." order by dro desc") or die(mysql_error());
	if($datarange!=""){
		$resp=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' ".$product." order by dro desc") or die(mysql_error());
		$resp1=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' ".$product." order by dro desc") or die(mysql_error());
	}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['fasi'];
$raodenoba1+=$sell1['raodenoba'];
}
echo "<h2><b><font color='green'>ჯამი: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font></h2>";
if($_POST['product']!="") echo "<h2><b><font color='green'>რაოდენობა: </font><font color='red'>".$raodenoba1."</font><font color='green'></font></h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დრო</td><td width='150'>დასახელება</td><td>მაგიდა</td><td>ადგილი</td><td>რაოდ.</td><td>ჯამი</td><td>user</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select * from product where id='".$sell['prod_id']."'")) or die(mysql_error());
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'")) or die(mysql_error());
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'")) or die(mysql_error());
	$adg=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['adgili']."'")) or die(mysql_error());
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prod['saxeli']."</td><td>".$mag['name']."</td><td>".$adg['name']."</td><td>".$sell['raodenoba']."</td><td>".$sell['fasi']."</td><td>".$tan['saxeli']." ".$tan['gvari']."</td></tr>";
	$jami+=$sell['fasi'];$raodenoba+=$sell['raodenoba'];
	
}
echo "<tr><td colspan='7'>".$jami." lari</td></tr></table>";
}

// რეპორტები – თანამშრომლის მიხედვით
if($_POST['dos']=="reportsalestan"){
$tanamshromeli=$_POST['tanamshromeli'];
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
mysqlconnect();
$jami=0;
$jami1=0;
$raodenoba1=0;
$raodenoba=0;
$resp=mysql_query("select * from sell where user='$tanamshromeli' order by dro desc") or die(mysql_error());
$resp1=mysql_query("select sum(fasi) as fasi from sell where user='$tanamshromeli' order by dro desc") or die(mysql_error());
if($datarange!=""){
	$resp=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' AND user='$tanamshromeli' order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select sum(fasi) as fasi from sell where dro>='$fromday' AND dro<='$today' AND user='$tanamshromeli' order by dro desc") or die(mysql_error());
}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['fasi'];
}
echo "<h2><font color='green'>ნამუშევარი: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font> (ხელფასი 4% = <font color='blue'>".round((($jami1*4)/100),2)." </font>ლარი)</h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დრო</td><td width='150'>დასახელება</td><td>მაგიდა</td><td>სექცია</td><td>ადგილი</td><td>რაოდ.</td><td>ჯამი</td><td>user</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select * from product where id='".$sell['prod_id']."'")) or die(mysql_error());
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'")) or die(mysql_error());
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'")) or die(mysql_error());
	$seqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['seqcia']."'"));
	$adg=mysql_fetch_array(mysql_query("select * from adgili where id='".$sell['adgili']."'")) or die(mysql_error());
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prod['saxeli']."</td><td>".$mag['name']."</td><td>".$seqcia['name']."</td><td>".$adg['name']."</td><td>".$sell['raodenoba']."</td><td>".$sell['fasi']."</td><td>".$tan['saxeli']." ".$tan['gvari']."</td></tr>";
	$jami+=$sell['fasi'];
	
}
echo "<tr><td colspan='7'>".$jami." ლარი (".round((($jami*4)/100),2).")</td></tr></table>";
}

// რეპორტები – დახურული მაგიდები
if($_POST['dos']=="reportsalesmagida"){
$seqcia=$_POST['seqcia'];
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
mysqlconnect();
$jami=0;
$jami1=0;
$resp=mysql_query("select * from magidisdaxurva where seqcia='".$seqcia."' order by user desc");
$resp1=mysql_query("select * from magidisdaxurva where seqcia='".$seqcia."' order by user desc");
if($datarange!=""){
	$resp=mysql_query("select * from magidisdaxurva where dro>='$fromday' AND dro<='$today' AND seqcia='".$seqcia."' order by user desc");
	$resp1=mysql_query("select * from magidisdaxurva where dro>='$fromday' AND dro<='$today' AND seqcia='".$seqcia."' order by user desc");
}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['tanxa'];
}
echo "<h2><font color='green'>ნამუშევარი: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font>";
echo "</h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><table border='1'><tr><td>#</td><td>დრო</td><td>სექცია</td><td>მაგიდა</td><td>სახელი</td><td>თანხა</td><td>დაწვრილებით</td></tr>";
while($mig=mysql_fetch_array($resp)){
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
<td><input value="დაწვრილებით" type="button" onClick="window.open('naxva.php?id=<?php echo $mig['id']; ?>')"></td>
</tr>
<?php
}
echo "</div></table>";
}

// მიღებების რეპორტები
if($_POST['dos']=="reportsalesmigebebi"){
$adgili=$_POST['adgili'];
$datarange=$_POST['datarange'];
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
$product="";
if($_POST['product']!="") $product=" AND prod_id='".$_POST['product']."'";
mysqlconnect();
$jami=0;
$jami1=0;
$raodenoba=0;

$resp=mysql_query("select * from migebebi where adgili='".$adgili."'".$product." order by dro desc") or die(mysql_error());
$resp1=mysql_query("select * from migebebi where adgili='".$adgili."'".$product." order by dro desc") or die(mysql_error());
if($datarange!=""){
	$resp=mysql_query("select * from migebebi where dro>='$fromday' AND dro<='$today' AND adgili='".$adgili."'".$product." order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select * from migebebi where dro>='$fromday' AND dro<='$today' AND adgili='".$adgili."'".$product." order by dro desc") or die(mysql_error());
}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['jami'];
$raodenoba+=$sell1['raodenoba'];
}
echo "<h2><font color='green'>მისაღები ფასით: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font>";
if($adgili==1){
	$jami2=0;
	//$ingrs=mysql_query("select * from productebi where adgili='".$adgili."'");
	$ingrs=mysql_query("select * from migebebi where adgili='".$adgili."'".$product."");
	if($datarange!=""){
		$ingrs=mysql_query("select * from migebebi where dro>='$fromday' AND dro<='$today' AND adgili='".$adgili."'".$product." order by dro desc") or die(mysql_error());
	}
	while($ing=mysql_fetch_array($ingrs)){
		$prod2=mysql_fetch_array(mysql_query("select * from product where shemadgenloba like ',".$ing['prod_id'].":%' order by id asc limit 0,1"));
		$jami2+=$prod2['fasi']*$ing['raodenoba'];
	}
	echo "<h2><font color='green'>გასაყიდი ფასით: </font><font color='red'>".$jami2."</font><font color='green'> ლარი</font>";
}
if($_POST['product']!="") echo "(".$raodenoba." ერთეული)";
echo "</h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td>დრო</td><td>დასახელება</td><td>რაოდ.</td><td>ჯამი</td><td>ადგილი</td><td>ქმედება</td></thead>";
while($sell=mysql_fetch_array($resp)){
$prod=mysql_fetch_array(mysql_query("select * from productebi where id='".$sell['prod_id']."'")) or die(mysql_error());
	//$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'")) or die(mysql_error());
	//$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'")) or die(mysql_error());
	//$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['seqcia']."'"));
	$adg=mysql_fetch_array(mysql_query("select * from adgili where id='".$sell['adgili']."'")) or die(mysql_error());
	//echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prod['saxeli']."</td><td>".$adg['name']."</td><td>".$sell['raodenoba']."</td><td>".$sell['jami']." ლარი</td></tr>";
	$jami+=$sell['jami'];
	
?>
<form name='ingr <?php echo $sell['id']; ?>'>
<tr style='background:#ffffff'>
<td width='60'><?php echo date("Y-m-d H:i",$sell['dro']); ?></td>
<td width='80'><?php echo $prod['saxeli']."</td>" ?>
<td><?php echo $sell['raodenoba']."</td><td>".$sell['jami']; ?> ლარი</td>
<td><select name="show_ingr_adgili" id="show_ingr_adgili">
<?php
$ad=mysql_query("select * from adgili order by id asc");
$selected="";
while($add=mysql_fetch_array($ad)){
if($add["id"]==$adg["id"]) $selected="selected";
echo '<option value="'.$add["id"].'" '.$selected.'>'.$add["name"].'</option>';
$selected="";
}
?>
</select></td>
<td>
<input type='hidden' value='<?php echo $sell['id']; ?>' id='show_ingr_id' name='show_ingr_id'>
<!--<input type='button' title='edit' value='edit' onclick='edit_productebi_adgili(this.form);'>-->
<a href='javascript:delete_migeba("<?php echo $sell['id']; ?>");'><img src='images/delete.gif' title='წაშლა'></a>
</td>
</tr></form>
<?php
	
}
echo "<tr><td colspan='8'>".$jami." ლარი </td></tr></table>";
}

/* მიღების რეპორტიდან რედაქტირება
if($_POST['dos']=="edit_productebi_adgili"){
mysqlconnect();
$id=htmlspecialchars($_POST['id']);
$adgili=htmlspecialchars($_POST['adgili']);
mysql_query("update migebebi set adgili='".$adgili."' where id='$id'") or die(mysql_error());
echo "<font color='green'>ადგილი წარმატებით შეიცვალა</font>";
}*/

// მიღების წაშლა
if($_POST['dos']=="delete_migeba"){
mysqlconnect();
$id=htmlspecialchars($_POST['id']);
$resp=mysql_fetch_array(mysql_query("select * from migebebi where id='$id'")) or die(mysql_error());
mysql_query("update productebi set raodenoba=raodenoba-'".$resp['raodenoba']."' where id='".$resp['prod_id']."'") or die(mysql_error());
mysql_query("delete from migebebi where id='$id'") or die(mysql_error());
echo "<font color='green'>მიღება წარმატებით წაიშალა (".$resp['prod_id']."/".$resp['raodenoba'].")</font>";
} 

// დღიური გაყიდული საქონლის რაოდენობა
if($_POST['dos']=="reportsalesbugalteria"){
$fromday=strtotime($_POST['fromyear']."-".$_POST['frommon']."-".$_POST['fromday']." 00:00:00");
$today=strtotime($_POST['fromyear']."-".$_POST['frommon']."-".$_POST['fromday']." 23:59:59");
mysqlconnect();
$resp=mysql_query("select prod_id,sum(raodenoba) as raodenoba,sum(fasi) as fasi from sell where dro>='".$fromday."' and dro<='".$today."' group by prod_id order by saxeli asc") or die(mysql_error());
//echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:visible'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დასახელება</td><td>რაოდ.</td><td>ფასი</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prod=mysql_fetch_array(mysql_query("select saxeli from product where id='".$sell['prod_id']."'")) or die(mysql_error());
	echo "<tr style='background:#ffffff'><td>".$prod['saxeli']."</td><td>".$sell['raodenoba']."</td><td>".$sell['fasi']."</td></tr>";
}
echo "</table>";
}

// ხარჯების რეპორტები
if($_POST['dos']=="reportsxarjebi"){
$product=$_POST['product'];
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
mysqlconnect();
$jami=0;
$jami1=0;
$resp=mysql_query("select * from xarjebi order by dro desc") or die(mysql_error());
$resp1=mysql_query("select * from xarjebi order by dro desc") or die(mysql_error());

if($datarange!=""){
	$resp=mysql_query("select * from xarjebi where dro>='$fromday' AND dro<='$today' order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select * from xarjebi where dro>='$fromday' AND dro<='$today' order by dro desc") or die(mysql_error());
}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['tanxa'];
}
echo "<h2><b><font color='green'>ჯამი: </font><font color='red'>".$jami1."</font><font color='green'> ლარი</font></h2>";
echo "<br><input type='button' onclick='showtable();' value='დაწვრილებით'>";
echo "<div id='showtable' style='visibility:hidden'><br><table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დრო</td><td width='150'>ხარჯი</td><td width='200'>დასახელება</td><td width='50'>რაოდენობა</td><td>ჯამი</td></thead>";
while($sell=mysql_fetch_array($resp)){
$prodsaxraod=explode(":", $sell['text']);
$prodsaxid=explode("/",$prodsaxraod[1]);
	$prod=mysql_fetch_array(mysql_query("select * from productebi where id='".trim($prodsaxid[0])."'"));
	/*$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$sell['user']."'")) or die(mysql_error());
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$sell['magida']."'")) or die(mysql_error());
	$adg=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$sell['adgili']."'")) or die(mysql_error());*/
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$sell['text']."</td><td>".$prod['saxeli']."</td><td>".$prodsaxid[1]."</td><td>".$sell['tanxa']."</td></tr>";
	$jami+=$sell['tanxa'];
	
}
echo "<tr><td colspan='7'>".$jami." lari</td></tr></table>";
}

// საერთო მოგება
if($_POST['dos']=="reportsalessul"){
$today=time();
if($_POST['fromyear']!=""){
	$today=strtotime($_POST['fromyear']."-12-31 23:59:59");
	if($_POST['frommon']!=""){
		$today=strtotime($_POST['fromyear']."-".$_POST['frommon']."-31 23:59:59");
		if($_POST['today']!=""){
			$today=strtotime($_POST['fromyear']."-".$_POST['frommon']."-".$_POST['today']." 23:59:59");
		}
	}
}
mysqlconnect();
$jami=0;
$xarji1=0;
$jami1=0;
$migebaxarji1=0;
$sulxarji=0;
	$resp=mysql_query("select * from magidisdaxurva where dro<='$today' order by dro desc") or die(mysql_error());
	$resp1=mysql_query("select * from sell where dro<='$today' order by dro desc") or die(mysql_error());
	$xarji=mysql_query("select * from xarjebi where  dro<='$today' order by dro desc") or die(mysql_error());
	$migebaxarji=mysql_query("select * from migebebi where dro<='$today' order by dro desc") or die(mysql_error());
while($sell=mysql_fetch_array($resp)){
$jami+=$sell['tanxa'];
}
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['fasi'];
}
while($xarj=mysql_fetch_array($xarji)){
$xarji1+=$xarj['tanxa'];
}
while($migxarj=mysql_fetch_array($migebaxarji)){
$migebaxarji1+=$migxarj['jami'];
}
$sulxarji=$migebaxarji1+$xarji1;
echo "<h2><font color='green'>შემოსულია: </font><font color='red'>".round($jami,2)."</font><font color='green'> ლარი;<br><font color='green'>უპროცენტოდ: </font><font color='red'>".round($jami1,2)."</font><font color='green'> ლარი<br>გახარჯულია: </font><font color='red'>".round($sulxarji,2)."</font><font color='green'> ლარი</font></h2>";
echo "<h2><font color='blue'>მოგება: </font><font color='red'>".round(($jami-$sulxarji),2)."</font><font color='blue'> ლარი</font> (".round((($jami-$sulxarji)/$jami*100),2)."%)</h2>";
}

// ლოგები
if($_POST['dos']=="searchlogs"){
$datarange=$_POST['datarange'];
$today=time();
$fromday=strtotime("01/01/2012 00:00:01");
if($datarange!=""){
$day=explode(" - ",$datarange);
			$today=strtotime($day[1]." 23:59:59")+7200;
			$fromday=strtotime($day[0]." 00:00:01")+7200;
}
mysqlconnect();
	$resp=mysql_query("select * from logs where dro>='$fromday' AND dro<='$today' order by dro desc");
echo "<table border='1' id='newspaper-b' summary='Results'><thead><tr><td width='150'>დრო</td><td width='30'>ID</td><td width='150'>დასახელება</td><td>კატეგორია</td><td>ფასი</td><td>ადგილი</td><td>გამოჩენა</td></thead>";
while($sell=mysql_fetch_array($resp)){
	$prodtext=explode("|",$sell['text']);
	//$prod=mysql_fetch_array(mysql_query("select * from product where id='".$prodtext[0]."'"));
	$cat=mysql_fetch_array(mysql_query("select * from cats where id='".$prodtext[2]."' limit 0,1"));
	$adg=mysql_fetch_array(mysql_query("select * from adgili where id='".$prodtext[4]."' limit 0,1"));
	echo "<tr style='background:#ffffff'><td>".date("Y-m-d H:i:s",$sell['dro'])."</td><td>".$prodtext[0]."</td><td>".$prodtext[1]."</td><td>".$cat['name']."</td><td>".$prodtext[3]."</td><td>".$adg['name']."</td><td>".$prodtext[6]."</td></tr>";
	
}
echo "</table>";
}


if($_POST['dos']=="xarjebi_add_tan"){
mysqlconnect();
$tan_id=$_POST['tan_id'];
$tan_xelfasi=$_POST['tan_xelfasi'];
$dro=time();
$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='$tan_id'"));
mysql_query("insert into xarjebi values(null,'ხელფასის გაცემა:".$tan['saxeli']." ".$tan['gvari']." (".$tan_id.")','$dro','$tan_xelfasi')") or die(mysql_error());
echo "<font color='green'><b>ხარჯი წარმატებით გაიცა</b></green>";
}

if($_POST['dos']=="xarjebi_add_kom"){
mysqlconnect();
$kom=$_POST['kom'];
$kom_tanxa=$_POST['kom_tanxa'];
$dro=time();
mysql_query("insert into xarjebi values(null,'კომუნალური გადასახადი:".$kom."','$dro','$kom_tanxa')") or die(mysql_error());
echo "<font color='green'><b>".$kom.": ხარჯი წარმატებით გაიცა</b></green>";
}

if($_POST['dos']=="xarjebi_add_sxva"){
mysqlconnect();
$sxva=$_POST['sxva'];
$sxva_tanxa=$_POST['sxva_tanxa'];
$dro=time();
mysql_query("insert into xarjebi values(null,'".$sxva."','$dro','$sxva_tanxa')") or die(mysql_error());
echo "<font color='green'><b>".$sxva.": ხარჯი წარმატებით გაიცა</b></green>";
}

if($_POST['dos']=="productmigebadacvrilebit"){
$id=$_POST['id'];
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
}


if($_POST['dos']=="dasturproductmigeba"){
$id=$_POST['id'];
mysqlconnect();
mysql_query("update magidisdaxurva set nanaxia='1' where id='$id'") or die(mysql_error());
$mi=mysql_query("select * from magidisdaxurva where nanaxia='0' order by dro desc");
echo "<table border='1'><tr><td>ID</td><td>დრო</td><td>სექცია</td><td>მაგიდა</td><td>სახელი</td><td>თანხა</td><td>დაწვრილებით</td><td>ქმედება</td></tr>";
while($mig=mysql_fetch_array($mi)){
	$tan=mysql_fetch_array(mysql_query("select * from tanamshromlebi where id='".$mig['user']."'")) or die(mysql_error());
	$mag=mysql_fetch_array(mysql_query("select * from tables where id='".$mig['magida']."'")) or die(mysql_error());
	$seq=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mig['seqcia']."'")) or die(mysql_error());
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
}

if($_POST['dos']=="checkisgauqmeba"){
mysqlconnect();
$id=$_POST['id'];
$mig=mysql_fetch_array(mysql_query("select * from magidisdaxurva where id='$id'")) or die(mysql_error());
$shem=explode(",",$mig['shemadgenloba']);
$i=1;
while($shem[$i]!=""){
$sell_id=$shem[$i];
$sl=mysql_fetch_array(mysql_query("select * from sell where id='$sell_id'")) or die(mysql_error());
$pr=mysql_fetch_array(mysql_query("select * from product where id='".$sl['prod_id']."'")) or die(mysql_error());
$shemadg=explode(",", $pr['shemadgenloba']);
$k=1;
$shemraodenoba=0;
while($shemadg[$k]!=""){
$shemadgenloba=explode(":", $shemadg[$k]);
$shemraodenoba=$shemadgenloba[1]*$sl['raodenoba'];
$shemid=$shemadgenloba[0];
mysql_query("update productebi set raodenoba=raodenoba+".$shemraodenoba." where id='".$shemid."'") or die(mysql_error());
echo  $shemid." : ".$shemraodenoba."<br>";
$k++;
}
echo $pr['saxeli']." / ".$sl['raodenoba']."<br>";
mysql_query("delete from sell where id='$sell_id'");
$i++;
}
mysql_query("delete from magidisdaxurva where id='$id'");
echo "finish";
}


if($_POST['dos']=="addshemadgenloba"){
$adgili=htmlspecialchars($_POST['adgili']);
$num=htmlspecialchars($_POST['num']);
mysqlconnect();
$resp=mysql_query("select * from productebi order by saxeli asc") or die(mysql_error());
echo "<select name='prod".$num."' id='prod".$num."'><option value='' selected/></option>";
while($shemadg=mysql_fetch_array($resp)){
echo "<option value='".$shemadg['id']."'/>".$shemadg['saxeli']."</option>"; 
}
echo "<input type='text' name='prodraodenoba".$num."' id='prodraodenoba".$num."' value=''><input type='button' value='დამატება' onClick='changeshem()'><br />";
}

if($_POST['dos']=="edit_shemadgenloba_id"){
$id=htmlspecialchars($_POST['id']);
$shem=htmlspecialchars($_POST['shemadgenloba']);
mysqlconnect();
mysql_query("update product set shemadgenloba='$shem' where id='$id'");
echo '<meta http-equiv="refresh" content="0; URL=index.php?cat=productsedit&prodid='.$id.'">';
}

if($_POST['dos']=="ganuleba"){
mysqlconnect();
//exec('mysqldump --user=root --password=skarlatina --host=127.0.0.1 mamulebi > C:\xampp\htdocs\mamulebi\backups\file.sql');
$dbhost   = "127.0.0.1";
$dbuser   = "root";
$dbpwd    = "skarlatina";
$dbname   = "mamulebi";
$dumpfile = $dbname . "_" . date("Y-m-d_H-i-s") . ".sql";

passthru("C:/xampp/mysql/bin/mysqldump --opt --host=$dbhost --user=$dbuser --password=$dbpwd $dbname > C:/xampp/htdocs/mamulebi/backups/$dumpfile");
echo "$dumpfile "; passthru("tail -1 $dumpfile");

mysql_query("truncate table sell") or die(mysql_error());
mysql_query("truncate table sell_temp");
mysql_query("truncate table logs");
mysql_query("truncate table magidisdaxurva");
mysql_query("truncate table migebebi");
mysql_query("truncate table orderedit");
mysql_query("truncate table xarjebi");
mysql_query("truncate table valebi");
mysql_query("update productebi set raodenoba=0;");
$files = glob('../PDF/files/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
echo '<br>ბაზა წარმატებით განულდა!სსს';
}

if($_GET['dos']=="logout"){
session_destroy();
echo '<meta http-equiv="refresh" content="0; URL=login.php">';
}

if($_GET['dos']=="checkmigeba"){
	mysqlconnect();
	$mag=mysql_query("select * from magidisdaxurva where nanaxia='0'");
	if(mysql_num_rows($mag)>0) echo "<a href='nanaxia.php' target='_blank'><img src='images/checkmigeba.png' width='40'>".mysql_num_rows($mag)."</a>";
	else echo "<img src='images/checkmigeba_off.png' width='40'>";
}
?>
</body>
</html>
