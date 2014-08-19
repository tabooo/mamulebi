<script type="text/javascript">document.title = 'ინგრედიენტის დამატება/რედაქტირება';</script>

<script>
function addingr(){
				$(function() {
					//id=document.getElementById("ingr_id").value;
					name=document.getElementById("ingr_name").value;
					//raodenoba=document.getElementById("ingr_raodenoba").value;
					minraodenoba=document.getElementById("ingr_minraodenoba").value;
					adgili=document.getElementById("adgili").value;
if(name!=""){
                    $.post('php.php',{dos:"addingr",name:name,minraodenoba:minraodenoba,adgili:adgili}, function(data){
                       $("#show_results").html(data);
                    });
		    $("#text").html("<font color='green'><b>ინგრედიენტი წარმატებით დაემატა</b></font>");
document.getElementById("ingr_name").value="";
//document.getElementById("ingr_raodenoba").value="";
                    return false;
}
                });           
}
function ingr_refresh(){
				$(function() {
                    $.post('php.php',{dos:"ingr_refresh"}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
function change_show_ingr(form){
				$(function() {
				//alert(form.show_ingr_id.value); form.show_cat_id.value;
					id=form.show_ingr_id.value;
					name=form.show_ingr_name.value;
					raodenoba=form.show_ingr_raodenoba.value;
					minraodenoba=form.show_ingr_minraodenoba.value;
					adgili=form.show_ingr_adgili.value;
                    $.post('php.php',{dos:"edit_ingrs",id:id,name:name,raodenoba:raodenoba,minraodenoba:minraodenoba,adgili:adgili}, function(data){
                       $("#show_results").html(data);
                    });
			$("#text").html("<font color='green'><b>ინგრედიენტი წარმატებით შეიცვალა</b></font>");
				return false;	
				}); 				
}
function delete_ingr(id){
				$(function() {
                    $.post('php.php',{dos:"delete_ingr",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}

function search_ingr_by(action){
				$(function() {
                    $.post('php.php',{dos:"search_ingr_by",action:action}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}

function searchproduct(){
				search=document.getElementById("searchfor").value;
				$(function() {
                    $.post('php.php',{dos:"productebi_search_products",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
</script>
<h3>ინგრედიენტის დამატება: </h3>
<form name="addproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<!--<tr>
<td>მაგიდის ID</td><td><input type="text" name="ingr_id" id="ingr_id"/></td>
</tr>-->
<tr>
<td>დასახელება</td><td><input type="text" name="ingr_name" id="ingr_name"/></td>
</tr>
<!--<tr>
<td>რაოდენოიბა</td><td><input type="text" name="ingr_raodenoba" id="ingr_raodenoba"/></td>
</tr>-->
<tr>
<td>კრიტიკული რაოდენოიბა</td><td><input type="text" name="ingr_minraodenoba" id="ingr_minraodenoba"/></td>
</tr>
<tr>
<td>ადგილი</td>
<td><select name="adgili" id="adgili">
<?php
$pr=mysql_query("select * from adgili where id in (select distinct nashti from adgili) order by id asc");
while($pro=mysql_fetch_array($pr)){
echo '<option value="'.$pro["nashti"].'">'.$pro["name"].'</option>';
}
?>
</select></td>
</tr>
<tr>
<td><input value="დამატება" type="button" onClick="addingr()"><input value="განახლება" type="button" onClick="ingr_refresh()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<?php
$pr=mysql_query("select * from adgili where id in (select distinct nashti from adgili) order by id asc");
while($pro=mysql_fetch_array($pr)){
?>
<input type="button" onclick="search_ingr_by('<?php echo $pro["nashti"]; ?>')" value="<?php echo $pro["name"]; ?>ს ინგრედიენტები">
<?php
}
?>
<!--<input type="button" onclick="search_ingr_by('minraodenoba')" value="კრიტიკული რაოდენობა"><br>
<input type="button" onclick="search_ingr_by('bari')" value="ბარის ინგრედიენტები">
<input type="button" onclick="search_ingr_by('samzareulo')" value="სამზარეულოს ინგრედიენტები"><br>-->
<br>სახელი ან ID<input type="text" id="searchfor"/><input value="ძებნა" type="button" onClick="searchproduct()">
<div id="text"></div>
<div id="show_results">
<?php
$resp=mysql_query("select * from productebi order by id asc");
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
?>
</div>
