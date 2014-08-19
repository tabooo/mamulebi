<?php
mysqlconnect();
?>
<script>
function xarjebi_add_tan(form){
tan_id=form.tanamshromeli.value;
tan_xelfasi=form.xelfasi.value;
var answer = confirm("ხელფასის გაცემა "+tan_xelfasi+" ლარი");
if (answer){
				$(function() {
if(tan_id!="" && tan_xelfasi!=""){
                    $.post('php.php',{dos:"xarjebi_add_tan",tan_id:tan_id,tan_xelfasi:tan_xelfasi}, function(data){
                       $("#show_answer").html(data);
                    })
			.success(function() {
					form.tan_xelfasi.value="";
					});
} else {alert("გთხოვთ შეავსოთ ველები")}

                    return false;
                });  
}         
}
</script>
ხელფასის გაცემა
<form name="xarjebitan">
<table>
<tr><td>თანამშრომელი</td><td>ხელფასი</td><td>ქმედება</td></tr>
<tr>
<td><select type="text" name="tanamshromeli" id="tanamshromeli">
  <?php
  $tt=mysql_query("select * from tanamshromlebi");
  while($ttt=mysql_fetch_array($tt)){
  echo '<option value="'.$ttt['id'].'">'.$ttt['saxeli'].' '.$ttt['gvari'].'</option>';
  }
  ?>
</select>
</td>
<td><input type="text" id="xelfasi" name="xelfasi" size="8"></td>
<td><input type="button" value="დასტური" onclick="xarjebi_add_tan(this.form)"></td>
</form>
<div id="show_answer">
</div>
