<?php
include("config.php");
if(@$_SESSION['username']==""){
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
else {
	mysqlconnect();
	$_SESSION["ordereditpass"]="";
	$orderid=safe($_POST["orderid"]);
	
	if($_SESSION["ordereditpass"]==""){
		echo "<input type='password' style='float:left;' placeholder='შეიყვანეთ პაროლი' id='ordereditpass' autofocus><input type='hidden' id='orderid' value='$orderid'> <button class='btn btn-primary' onclick='checkordereditpass();'>შესვლა</button>";
	}

if(@$_POST['dos']=="checkordereditpass" && $_POST['ordereditpass']!=""){
	
	$ordereditpass=safe($_POST['ordereditpass']);
	$orderid=safe($_POST['orderid']);
	$chk=mysql_query("select * from tanamshromlebi where password='$ordereditpass' AND role='administrator'") or die(mysql_error());
	$chkus=mysql_query("select * from sell_temp where id='$orderid' AND user='".$_SESSION['userid']."'");
	if(mysql_num_rows($chk)>0 && $chkus>0){
		$_SESSION["ordereditpass"]="1";
		$order=mysql_fetch_array(mysql_query("select * from sell_temp where id='$orderid'"));
		$printadgili=mysql_fetch_array(mysql_query("select * from adgili where id='".$order['adgili']."'"));
		?>
		<form name='order <?php echo $order['id']; ?>'>
		<table class="table table-bordered">
		<tr bgcolor='gray'><td>დასახელება</td><td>რაოდენობა</td><td>ფასი</td><td>ქმედება</td></tr>
		<tr>
		<input type="hidden" id="ordereditid" name='ordereditid' class="input-small" value="<?php echo $order['id']; ?>">
		<input type="hidden" id="minval" name='minval' value="<?php echo $order['raodenoba']; ?>">
		<input type="hidden" id="ordereditertfasi" value="<?php echo $order['ertfasi']; ?>">
		<td width="100"><?php echo $order["saxeli"]; ?></td>
		<td>
		<input type="button" value="-" class="btn btn-danger" onClick="editorderraodenobaremove(this.form)" style="height: 40px; width: 40px; float:left;" title="რაოდენობის შემცირება"/>
		<input type="text"  class="input-small" style="width:30px;" id="ordereditraodenoba" size="5" value="0">
		<input type="button" value="+" class="btn btn-success" onClick="editorderraodenobaadd(this.form)" style="height: 40px; width: 40px" title="რაოდენობის გაზრდა"/>
		</td>
		<td><input type="text" id="ordereditfasi" size="5" value="0" style="width:60px;"> ლარი</td>
		<td><input type='button' class="btn btn-primary" title='ბეჭდვა' value='ბეჭდვა(<?php echo $printadgili['name']; ?>)' id="ordereditidedit" onclick='ordereditid1(this.form)' style="height: 50px; width: 110px"></td>
		</tr>
		</table>
		</form>
<?php
	} else {
		die("<br><div class='alert alert-error'>არასწორი პაროლი!!!</div>");
	}
}

}
?>
