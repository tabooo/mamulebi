<?php
mysqlconnect();
?>
<script>
function editproduct1(){
				$(function() {
prod=",";
if(document.getElementById("prod0")!=null){
i=0;

while(document.getElementById("prod"+i)!=null){
if(document.getElementById("prod"+i).value!="" && document.getElementById("prodraodenoba"+i).value!=""){
prod+=document.getElementById("prod"+i).value+":"+document.getElementById("prodraodenoba"+i).value+",";
}
i++;
}
} else {prod=document.getElementById("product_shemadgenloba").value;}
					id=document.getElementById("product_id").value;
					name=document.getElementById("product_name").value;
					cat=document.getElementById("product_cat").value;
					fasi=document.getElementById("product_fasi").value;
					adgili=document.getElementById("product_adgili").value;
					raodenoba="";
					visible=document.getElementById("visible").value;
				if(id!="" && name!="" && cat!="" && fasi!="" && adgili!=""){	
                    $.post('php.php',{dos:"edit_products",id:id,name:name,cat:cat,fasi:fasi,adgili:adgili,raodenoba:raodenoba,prod:prod,visible:visible}, function(data){
                       $("#show_results").html(data);
                    })}else alert("გთხოვთ შეავსოთ ველები");
                    return false;	
				});	
}

function delete_product(id){
				$(function() {
                    $.post('php.php',{dos:"delete_products",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
function searchproduct(){
				search=document.getElementById("searchfor").value;
				$(function() {
                    $.post('php.php',{dos:"search_products",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
function searchproductbycat(search){
				$(function() {
                    $.post('php.php',{dos:"search_products_by_cat",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}

function changeshem(){
	i=0;
	shem=",";
	while(document.getElementById("prod"+i)!=null){
		shem+=document.getElementById("prod"+i).value+":"+document.getElementById("prodraodenoba"+i).value+",";
		i++;
	}
	document.getElementById("product_shemadgenloba").value=shem;
}

function deleteshem(i){
	var shem=document.getElementById("product_shemadgenloba").value;
	
	shem=shem.replace(document.getElementById("prod"+i).value+":"+document.getElementById("prodraodenoba"+i).value+",","");
	document.getElementById("product_shemadgenloba").value=shem;
	id=document.getElementById("product_id").value;
	$.post('php.php',{dos:"edit_shemadgenloba_id",id:id,shemadgenloba:shem}, function(data){
                       $("#show_results").html(data);
                    })
}
</script>
<?php
$shem=mysql_query("select * from productebi order by saxeli asc") or die(mysql_error());
?>
<script language="javascript">

function addElement() {

	i=0;
	while(document.getElementById("prod"+i)!=null){
		i++;
	}

  var ni = document.getElementById('shemadgenloba');

  var numi = document.getElementById('theValue');

  var num = (document.getElementById('theValue').value -1)+ 2;

  numi.value = num;

  var newdiv = document.createElement('div');

  var divIdName = 'my'+num+'Div';

  newdiv.setAttribute('shemadgenloba',divIdName);
$.post('php.php',{dos:"addshemadgenloba",adgili:document.getElementById("product_adgili").value,num:i}, function(data){
                       newdiv.innerHTML = data;
                    })

  ni.appendChild(newdiv);

}
</script>

<?php
$prodid=$_GET['prodid'];
$prod=mysql_fetch_array(mysql_query("select * from product where id='$prodid'")) or die(mysql_error());
?>
<h3>პროდუქტის რედაქტირება: </h3>
<form name="editproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>
<td>ID</td><td><input type="text" name="product_id" id="product_id" disabled='disabled' value="<?php echo $prod['id']; ?>"/></td>
</tr>
<tr>
<td>დასახელება</td><td><input type="text" name="product_name" size="42" id="product_name" value="<?php echo $prod['saxeli']; ?>"/></td>
</tr>
<tr>
<td>კატეგორია</td><td>
<select type="text" name="product_cat" id="product_cat">
	<?php
	$resp2=mysql_query("select * from cats where visible='1'");
	$selected="";
	while($show2=mysql_fetch_array($resp2)){
		if($prod['cat']==$show2['id']) $selected="selected";
		echo '<option value="'.$show2["id"].'" '.$selected.'>'.$show2["name"].'</option>';
$selected="";
	}
	?>  
</select>
</td>
</tr>
<tr>
<td>ფასი</td><td><input type="text" name="product_fasi" id="product_fasi" value="<?php echo $prod['fasi']; ?>"/></td>
</tr>
<tr>
<td>ადგილი</td><td>
<select type="text" name="product_adgili" id="product_adgili">
<?php
$adg=mysql_query("select * from adgili") or die(mysql_error());
$selected="";
while($adgili=mysql_fetch_array($adg)){
if($prod['adgili']==$adgili['id']) $selected="selected";
echo '<option value="'.$adgili["id"].'" '.$selected.'>'.$adgili["name"].'</option>';
$selected="";
}
?>
</select></td>
</tr>
<tr>
<td valign="top">შემადგენლობა</td><td>
<input type="text" name="product_shemadgenloba" size="90" id="product_shemadgenloba" value="<?php echo $prod['shemadgenloba']; ?>"/><br>

<?php
$tvitgirebuleba=0;

$shemadgenn="";
$shemadg=explode(",", $prod['shemadgenloba']);
$i=1;
while($shemadg[$i]!=""){

$shemadgenloba=explode(":", $shemadg[$i]);
$shemraodenoba=$shemadgenloba[1];
$shemid=$shemadgenloba[0];

$shemsaxeli1=mysql_query("select saxeli from productebi where id='$shemid'");
$shemsaxeli=mysql_fetch_array($shemsaxeli1) ;

$ingredienti=mysql_query("select * from migebebi where id='$shemid'");
$fasi=0;
$cona=0;
while($ingred=mysql_fetch_array($ingredienti)){
	$fasi=$fasi+$ingred['jami'];
	$cona=$cona+$ingred['raodenoba'];
}
if($cona!=0){
$sashfasi=$shemraodenoba*$fasi/$cona;
$tvitgirebuleba=$tvitgirebuleba+$sashfasi;
} else{
	echo "<b>".$shemsaxeli['saxeli']."</b> არ არის შეტანილი მიღებებში<br>";
}

echo "<input type='text' value='".$shemsaxeli['saxeli']."' id='shemsaxeli".$i."' name='shemsaxeli' disabled><input type='text' value='".$shemraodenoba."' id='prodraodenoba".$i."' name='prodraodenoba".$i."'><input type='hidden' value='".$shemid."' id='prod".$i."' name='prod".$i."'><input type='button' value='შეცვლა' onClick='changeshem()'><input type='button' value='X წაშლა' onClick='deleteshem(\"".$i."\")'><br>";
$shemadgenn.=$shemsaxeli['saxeli']."(".$shemid."):".$shemraodenoba.", ";
$i++;
}
?>
<!--<textarea cols="42" rows="5" disabled="disabled" name="product_shemadgenloba_sityvieri" id="product_shemadgenloba_sityvieri"><?php echo $shemadgenn; ?></textarea>-->
<br><input type="hidden" value="0" id="theValue" /><input type="button" onclick="addElement()" name="add" value="ინგრედიენტის დამატება" /><div id="shemadgenloba"></div></td>
</tr>

<tr>
<td valign="top">თვითღირებულება</td>
<td><?php echo $tvitgirebuleba; ?></td>
</tr>

<tr>
<td>გამოჩენა</td><td>
<select type="text" name="visible" id="visible">
	<option value="1" <?php if($prod['visible']=="1") echo "selected"; ?>>კი</option>
	<option value="0" <?php if($prod['visible']!="1") echo "selected"; ?>>არა</option>  
</select>
  </td>
</tr>
<tr>
<td><input value="რედაქტირება" type="button" onClick="editproduct1()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<?php
	mysqlconnect();
	$resp2=mysql_query("select * from cats where visible='1'");
	while($show2=mysql_fetch_array($resp2)){
		?>
		<input value="<?php echo $show2['name']; ?>" type="button" onClick="searchproductbycat('<?php echo $show2['id']; ?>')">
		<?php
	}
	?>
<br>
სახელი ან ID<input type="text" id="searchfor"/><input value="ძებნა" type="button" onClick="searchproduct()">
<div id="show_results">
</div>
