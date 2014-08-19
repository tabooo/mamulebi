<?php
mysqlconnect();
?>
<script type="text/javascript">document.title = 'კერძების დამატება/რედაქტირება';</script>

<script>
function addproduct1(){

				$(function() {
i=1;
prod=",";
while(document.getElementById("prod"+i)!=null){
prod+=document.getElementById("prod"+i).value+":"+document.getElementById("prodraodenoba"+i).value+",";
i++;
}
					name=document.getElementById("product_name").value;
					cat=document.getElementById("product_cat").value;
					fasi=document.getElementById("product_fasi").value;
					adgili=document.getElementById("product_adgili").value;
					raodenoba="";
					visible=document.getElementById("visible").value;
				if(name!="" && cat!="" && fasi!="" && adgili!=""){	
                    $.post('php.php',{dos:"addproduct",name:name,cat:cat,fasi:fasi,adgili:adgili,raodenoba:raodenoba,prod:prod,visible:visible}, function(data){
                       $("#show_results").html(data);
                    })
					.success(function() {
					document.getElementById("product_name").value="";
					document.getElementById("product_fasi").value="";
					document.getElementById("product_raodenoba").value="";
					})
				}
				else alert("გთხოვთ შეავსოთ ველები");
                    return false;	
				}); 	
}
/*function change_show_products(form){
				$(function() {
					id=document.getElementById("show_product_id").value;
					name=document.getElementById("show_product_name").value;
					cat=document.getElementById("show_product_cat").value;
					fasi=document.getElementById("show_product_fasi").value;
					adgili=document.getElementById("show_product_adgili").value;
					raodenoba=document.getElementById("show_product_raodenoba").value;
					visible=document.getElementById("show_visible").value;

					if(name!="" && cat!="" && fasi!=""){
                    $.post('php.php',{dos:"edit_products",id:id,name:name,cat:cat,fasi:fasi,adgili:adgili,raodenoba:raodenoba,visible:visible}, function(data){
                       $("#show_results").html(data);
                    });
					}
					else alert("გთხოვთ შეავსოთ ველები");
				return false;	
				}); 				
}*/
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
</script>
<?php
mysqlconnect();
$shem=mysql_query("select * from productebi where adgili=3 order by saxeli asc") or die(mysql_error());
?>
<script language="javascript">
function addElement() {

  var ni = document.getElementById('shemadgenloba');

  var numi = document.getElementById('theValue');

  var num = (document.getElementById('theValue').value -1)+ 2;

  numi.value = num;

  var newdiv = document.createElement('div');

  var divIdName = 'my'+num+'Div';

  newdiv.setAttribute('shemadgenloba',divIdName);
$.post('php.php',{dos:"addshemadgenloba",adgili:document.getElementById("product_adgili").value,num:num}, function(data){
                       newdiv.innerHTML = data;
                    })

  ni.appendChild(newdiv);

}

function removeElement(divNum) {

  var d = document.getElementById('shemadgenloba');

  var olddiv = document.getElementById(divNum);

  d.removeChild(olddiv);

}
</script>
<h3>პროდუქტის დამატება: </h3>
<form name="addproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>
<td>დასახელება</td><td><input type="text" name="product_name" id="product_name" size="42"/></td>
</tr>
<tr>
<td>კატეგორია</td><td>
<select type="text" name="product_cat" id="product_cat">
	<?php
	mysqlconnect();
	$resp2=mysql_query("select * from cats where visible='1'");
	while($show2=mysql_fetch_array($resp2)){
		echo '<option value="'.$show2["id"].'">'.$show2["name"].'</option>';
	}
	?>  
</select>
</td>
</tr>
<tr>
<td>ფასი</td><td><input type="text" name="product_fasi" id="product_fasi"/></td>
</tr>
<tr>
<td>ადგილი</td><td>
<select type="text" name="product_adgili" id="product_adgili">
<?php
$adg=mysql_query("select * from adgili") or die(mysql_error());
while($adgili=mysql_fetch_array($adg)){
echo '<option value="'.$adgili["id"].'" selected>'.$adgili["name"].'</option>';
}
?>
</select></td>
</tr>
<tr>
<td>შემადგენლობა</td><td><input type="hidden" value="0" id="theValue" /><input type="button" onclick="addElement()" name="add" value="ინგრედიენტის დამატება" /><div id="shemadgenloba"></div></td>
</tr>
<tr>
<td>გამოჩენა</td><td>
<select type="text" name="visible" id="visible">
	<option value="1" selected>კი</option>
	<option value="0">არა</option>  
</select>
  </td>
</tr>
<tr>
<td><input value="დამატება" type="button" onClick="addproduct1()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<?php
	mysqlconnect();
	$resp2=mysql_query("select * from cats");
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
