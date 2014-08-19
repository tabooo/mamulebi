<script>
function addtan(){
				$(function() {				
					tan_name=document.getElementById("tan_name").value;
					tan_surname=document.getElementById("tan_surname").value;
					tan_username=document.getElementById("tan_username").value;
					tan_pass=document.getElementById("tan_pass").value;
					tan_email=document.getElementById("tan_email").value;
					tan_tel=document.getElementById("tan_tel").value;
					tan_role=document.getElementById("tan_role").value;
					tan_xelfasi=document.getElementById("tan_xelfasi").value;
				if(tan_name!="" && tan_surname!="" && tan_username!="" && tan_pass!=""){	
                    $.post('php.php',{dos:"addtan",tan_name:tan_name,tan_surname:tan_surname,tan_username:tan_username,tan_pass:tan_pass,tan_email:tan_email,tan_tel:tan_tel,tan_role:tan_role,tan_xelfasi:tan_xelfasi}, function(data){
                       $("#show_results").html(data);
                    })
					.success(function() {
					document.getElementById("tan_name").value="";
					document.getElementById("tan_surname").value="";
					document.getElementById("tan_username").value="";
					document.getElementById("tan_pass").value="";
					document.getElementById("tan_email").value="";
					document.getElementById("tan_tel").value="";
					document.getElementById("tan_role").value="user";
					document.getElementById("tan_xelfasi").value="0";
					})
				}
				else alert("გთხოვთ შეავსოთ ველები");
                    return false;
                });
}
function change_show_tan(form){
				$(function() {
					tan_id=form.show_tan_id.value;
					tan_name=form.show_tan_name.value;
					tan_surname=form.show_tan_surname.value;
					tan_username=form.show_tan_username.value;
					tan_pass=form.show_tan_pass.value;
					tan_email=form.show_tan_email.value;
					tan_tel=form.show_tan_tel.value;
					if(tan_name!="" && tan_surname!="" && tan_username!=""){
                    $.post('php.php',{dos:"edit_tan",tan_id:tan_id,tan_name:tan_name,tan_surname:tan_surname,tan_username:tan_username,tan_pass:tan_pass,tan_email:tan_email,tan_tel:tan_tel}, function(data){
                       $("#show_results").html(data);
                    });
					}
					else alert("გთხოვთ შეავსოთ ველები");
				return false;	
				}); 				
}
function delete_tan(id){
    var answer = confirm("თქვენ გსურთ ამის წაშლა?");
	if (answer){
				$(function() {
                    $.post('php.php',{dos:"delete_tan",id:id}, function(data){
                       $("#show_results").html(data);
                    });

				return false;	
				}); 	
}
return false;			
}
function searchproduct(){
				search=document.getElementById("searchfor").value;
				$(function() {
                    $.post('php.php',{dos:"search_tan",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
</script>
<h3>თანამშრომლის დამატება: </h3>
<form name="addproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>
<td>სახელი</td><td><input type="text" name="tan_name" id="tan_name"/></td>
</tr>
<tr>
<td>გვარი</td><td><input type="text" name="tan_surname" id="tan_surname"/></td>
</tr>
<tr>
<td>username</td><td><input type="text" name="tan_username" id="tan_username"/></td>
</tr>
<tr>
<td>password</td><td><input type="text" name="tan_pass" id="tan_pass"/></td>
</tr>
<tr>
<td>მის:</td><td><input type="text" name="tan_email" id="tan_email"/></td>
</tr>
<tr>
<td>ტელ:</td><td><input type="text" name="tan_tel" id="tan_tel"/></td>
</tr>
<tr>
<td>როლი:</td><td><input type="text" name="tan_role" id="tan_role" value="user"/></td>
</tr>
<tr>
<td>ხელფასი:</td><td><input type="text" name="tan_xelfasi" id="tan_xelfasi" value="0"/></td>
</tr>
<tr>
<td><input value="დამატება" type="button" onClick="addtan()"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<br>
Имя или Фамиля<input type="text" id="searchfor"/><input value="ძებნა" type="button" onClick="searchproduct()">
<div id="show_results">
<?php
$resp=mysql_query("select * from tanamshromlebi order by id asc");
echo"<table><tr><td>ID</td><td>Имя</td><td>Фамиля</td><td>username</td><td>password</td><td>email</td><td>Tel</td><td>ქმედება</td></tr>";
while($show=mysql_fetch_array($resp)){?>
<form name='cat <?php echo $show['id']; ?>'><tr>
<td><input type='text' size=1 id='show_tan_id' disabled='disabled' value='<?php echo $show['id']; ?>'></td>
<td><input type='text' size=5 id='show_tan_name' value='<?php echo $show['saxeli']; ?>'></td>
<td><input type='text' size=5 id='show_tan_surname' value='<?php echo $show['gvari']; ?>'></td>
<td><input type='text' size=5 id='show_tan_username' value='<?php echo $show['username']; ?>'></td>
<td><input type='text' size=5 id='show_tan_pass' value='<?php echo $show['password']; ?>'></td>
<td><input type='text' size=5 id='show_tan_email' value='<?php echo $show['email']; ?>'></td>
<td><input type='text' size=5 id='show_tan_tel' value='<?php echo $show['tel']; ?>'></td>
<td><input type='button' title='edit' value='edit' onclick='change_show_tan(this.form);'>
<!--<input type='button' style='background: white url("images/EditCategory.gif") no-repeat top; width: 20px; height: 20px;'>-->
<a href='javascript:delete_tan("<?php echo $show['id']; ?>");'><img src='images/delete.gif' title='Удалить'></a></td>
</tr></form>
<?php
}
echo "</table>";
?>
</div>
