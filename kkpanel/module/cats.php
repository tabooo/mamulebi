<script>
function addcat(){
				$(function() {
					id=document.getElementById("cat_id").value;
					name=document.getElementById("cat_name").value;
					visible=document.getElementById("visible").value;
                    $.post('php.php',{dos:"addcat",id:id,name:name,visible:visible}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
function cats_refresh(){
				$(function() {
                    $.post('php.php',{dos:"cats_refresh"}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
function change_show_cats(form){

				$(function() {
//alert(document.getElementById("show_cat_name").value);
				//alert(form.show_cat_id.value); 
					//id=document.getElementById("show_cat_id").value;
					//name=document.getElementById("show_cat_name").value;
					//visible=document.getElementById("show_visible").value;
					id=form.show_cat_id.value;
					name=form.show_cat_name.value;
					visible=form.show_visible.value;
                    $.post('php.php',{dos:"edit_cats",id:id,name:name,visible:visible}, function(data){
                       $("#show_results").html(data);
                    });
				return false;
				}); 				
}
function delete_cat(id){
				$(function() {
                    $.post('php.php',{dos:"delete_cats",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
</script>
<h3>კატეგორიის დამატება: </h3>
<form name="addproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>
<td>კატეგორიის ID</td><td><input type="text" name="cat_id" id="cat_id"/></td>
</tr>
<tr>
<td>დასახელება</td><td><input type="text" name="cat_name" id="cat_name"/></td>
</tr>
<tr>
<td>გამოჩენა</td><td><select type="text" name="visible" id="visible">
	<option value="1" selected>კი</option>
	<option value="0">არა</option>  
</select>
  </td>
</tr>
<tr>
<td><input value="დამატება" type="button" onClick="addcat()"><input value="განახლება" type="button" onClick="cats_refresh()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<div id="show_results">
<?php
$resp=mysql_query("select * from cats order by id asc");
echo"<table><tr><td>ID</td><td>დასახელება</td><td>V</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='cat <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=1 id='show_cat_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
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
?>
</div>
