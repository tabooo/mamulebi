<?php
mysqlconnect();
?>
<script>
function xarjebi_add_kom(form){
kom=form.komunaluri.value;
kom_tanxa=form.tanxakomunaluri.value;
var answer = confirm(kom+" გადახდა "+kom_tanxa+" ლარი");
if (answer){
				$(function() {
if(kom!="" && kom_tanxa!=""){
                    $.post('php.php',{dos:"xarjebi_add_kom",kom:kom,kom_tanxa:kom_tanxa}, function(data){
                       $("#show_answer").html(data);
                    })
			.success(function() {
					form.tanxakomunaluri.value="";
					});
} else {alert("გთხოვთ შეავსოთ ველები")}

                    return false;
                });  
}         
}

function xarjebi_add_sxva(form){
sxva=form.sxvagadasaxadi.value;
sxva_tanxa=form.sxvatanxa.value;
var answer = confirm(sxva+" გადახდა "+sxva_tanxa+" ლარი");
if (answer){
				$(function() {
if(sxva!="" && sxva_tanxa!=""){
                    $.post('php.php',{dos:"xarjebi_add_sxva",sxva:sxva,sxva_tanxa:sxva_tanxa}, function(data){
                       $("#show_answer").html(data);
                    })
			.success(function() {
					form.sxvatanxa.value="";
					});
} else {alert("გთხოვთ შეავსოთ ველები")}

                    return false;
                });  
}         
}
</script>
სხვა ხარჯები<br>
<input type="radio" name="xarjebi" value="კომუნალური გადასახადები" onclick="javascript:document.getElementById('komunalur').style.visibility='visible';document.getElementById('sxvaxarjebi').style.visibility='hidden';">კომუნალური გადასახადები</input>
<input type="radio" name="xarjebi" value="სხვა გადასახადები" onclick="javascript:document.getElementById('komunalur').style.visibility='hidden';document.getElementById('sxvaxarjebi').style.visibility='visible';">სხვა გადასახადები</input>
<div id="show_answer">
</div>
<div id="komunalur" style="visibility:hidden">
<form name="xarjebitan">
<table>
<tr><td>გადასახადი</td><td>თანხა</td><td>ქმედება</td></tr>
<tr>
<td><select type="text" name="komunaluri" id="komunaluri">
  <?php
  $i=0;
  while($komunalur[$i]!=""){
  echo '<option value="'.$komunalur[$i].'">'.$komunalur[$i].'</option>';
$i++;
  }
  ?>
</select>
</td>
<td><input type="text" id="tanxakomunaluri" name="tanxakomunaluri" size="8"></td>
<td><input type="button" value="დასტური" onclick="xarjebi_add_kom(this.form)"></td>
</tr></table>
</form>
</div>


<div id="sxvaxarjebi" style="visibility:hidden">
<form name="xarjebitan">
<table>
<tr><td>გადასახადი</td><td>თანხა</td><td>ქმედება</td></tr>
<tr>
<td><input type="text" id="sxvagadasaxadi" name="sxvagadasaxadi" size="30"></td>
<td><input type="text" id="sxvatanxa" name="sxvatanxa" size="8"></td>
<td><input type="button" value="დასტური" onclick="xarjebi_add_sxva(this.form)"></td>
</form>
</div>


