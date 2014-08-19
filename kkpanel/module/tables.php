<script>
function addtable(){
				$(function() {
					//id=document.getElementById("table_id").value;
					name=document.getElementById("table_name").value;
					visible=document.getElementById("visible").value;
					seqcia=document.getElementById("table_seqcia").value;

                    $.post('php.php',{dos:"addtable",name:name,seqcia:seqcia,visible:visible}, function(data){
                       $("#show_results").html(data);
					   document.getElementById("table_name").value="";
                    });
                    return false;
                });           
}
function tables_refresh(){
				$(function() {
                    $.post('php.php',{dos:"tables_refresh"}, function(data){
                       $("#show_results").html(data);
                    });
                    return false;
                });           
}
function change_show_tables(form){
				$(function() {
				//alert(form.show_table_id.value); form.show_cat_id.value;
					id=form.show_table_id.value;
					name=form.show_table_name.value;
					visible=form.show_visible.value;
					seqcia=form.show_table_seqcia.value;
                    $.post('php.php',{dos:"edit_tables",id:id,name:name,seqcia:seqcia,visible:visible}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
function delete_table(id){
    var answer = confirm("თქვენ გსურთ ამის წაშლა?");
	if (answer){
				$(function() {
                    $.post('php.php',{dos:"delete_tables",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 	
}			
}
function searchtablebyseqcia(search){
				$(function() {
                    $.post('php.php',{dos:"search_table_by_seqcia",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
</script>
<h3>მაგიდის დამატება: </h3>
<form name="addproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<!--<tr>
<td>მაგიდის ID</td><td><input type="text" name="table_id" id="table_id"/></td>
</tr>-->
<tr>
<td>დასახელება</td><td><input type="text" name="table_name" id="table_name"/></td>
</tr>
<tr>
<td>ადგილი</td><td>
<select name="table_seqcia" id="table_seqcia"/>
<?php
$seqc=mysql_query("select * from seqciebi");
while($seq=mysql_fetch_array($seqc)){
echo "<option value='".$seq['id']."'>".$seq['name']."</option>";
}
?>
</select></td>
</tr>
<tr>
<td>გამოჩენა</td><td><select type="text" name="visible" id="visible">
	<option value="1" selected>კი</option>
	<option value="0">არა</option>  
</select>
  </td>
</tr>
<tr>
<td><input value="დამატება" type="button" onClick="addtable()"><input value="განახლება" type="button" onClick="tables_refresh()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<?php
	mysqlconnect();
	$resp2=mysql_query("select * from seqciebi");
	while($show2=mysql_fetch_array($resp2)){
		?>
		<input value="<?php echo $show2['name']; ?>" type="button" onClick="searchtablebyseqcia('<?php echo $show2['id']; ?>')">
		<?php
	}
	?>
<br>
<div id="show_results">
<?php
$resp=mysql_query("select * from tables order by seqcia, id asc");
echo"<table><tr><td>ID</td><td>დასახელება</td><td>ადგილი</td><td>V</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='table <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=1 id='show_table_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
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
?>
</div>
