<?php
include("config.php");
mysqlconnect();
if(@$_SESSION['username']!=""){
echo '<meta http-equiv="refresh" content="1; URL=index.php">';
die();
}
?>
<!DOCTYPE HTML SYSTEM>
<html>
  <head>
    <title>Mamulebi Login</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	 <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body style="margin:0;padding:0;">
<div class="container">

      <form class="form-signin" style="padding-top:0px;max-width:330px;">
        <img src="images/mimtani.jpg" width="60" style="float:left;"><h2 class="form-signin-heading"> მ ა მ უ ლ ე ბ ი</h2>
		<div id="error" style="visibility:hidden;"></div>
<?php
$se=mysql_query("select * from seqciebi");
$selast=mysql_fetch_array(mysql_query("select * from seqciebi order by id desc limit 0,1")) or die(mysql_error());
while($seqcia=mysql_fetch_array($se)){
?>
<input type="button" class="btn btn-success" id="seqcia_<?php echo $seqcia['id']; ?>" value="<?php echo $seqcia['name']; ?>" onClick="seqciaarcheva(this.value,'<?php echo $selast['id']; ?>','<?php echo $seqcia['id']; ?>','<?php echo $seqcia['adgili_id']; ?>')" style="height: 80px; width: 80px;margin-bottom:5px;margin-left:10px;"/>
<?php 
}
?>
<input type="hidden" name="seqcia" id="seqcia" value="" style="height: 30px; width: 100px">
<input type="hidden" name="adgili_id" id="adgili_id" value="">

<div id="next" style="visibility:hidden">
	<?php $us=mysql_query("select * from tanamshromlebi where role='user'");
			echo "<select class='span4' style='height:40px;' name='username' id='username'>";
				  while($users=mysql_fetch_array($us)){
					echo "<option value='".$users['username']."'>".$users['username']."</option>";
				  }
			echo "</select>";
	?>
        <input type="password" class="span4 input-block-level" id="password" placeholder="პაროლი">
        <button type="button"  class="btn btn-large btn-block btn-primary" id="sublogin" data-loading-text="Loading...">შესვლა</button>
</div>
<br>
<div id="next1" style="visibility:hidden">
<table>
<tr>
<td style="border: solid 1px black;" valign="top">
<input type="button" value="1" class="btn btn-info" onClick="manualraodenoba('1')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="2" class="btn btn-info" onClick="manualraodenoba('2')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="3" class="btn btn-info" onClick="manualraodenoba('3')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="4" class="btn btn-info" onClick="manualraodenoba('4')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="5" class="btn btn-info" onClick="manualraodenoba('5')" style="height: 60px; width: 60px; margin-bottom:5px;"/><br>
<input type="button" value="6" class="btn btn-info" onClick="manualraodenoba('6')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="7" class="btn btn-info" onClick="manualraodenoba('7')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="8" class="btn btn-info" onClick="manualraodenoba('8')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="9" class="btn btn-info" onClick="manualraodenoba('9')" style="height: 60px; width: 60px; margin-bottom:5px;"/>
<input type="button" value="0" class="btn btn-info" onClick="manualraodenoba('0')" style="height: 60px; width: 60px; margin-bottom:5px;"/><br>
<input type="button" value="გასუფთავება" class="btn btn-large btn-danger btn-block" onClick="manualraodenobachange('clear')"/>
</td>
</tr>
</table>
</div>
<br>
By <a href="http://bms-page.com" style="text-decoration:none">Kakha Tabagari</a>.
      </form>

</div>


<script type="text/javascript" >
$(function() {
                $("#sublogin").click(function() {  
					
					var username = $('#username').val();
					var password = $('#password').val();
					var seqcia = $('#seqcia').val();
					var adgili_id = $('#adgili_id').val();
					
                    $.post('php.php',{dos:"login",username:username,password:password,seqcia:seqcia,adgili_id:adgili_id}, function(data){
						$("#error").html(data);
						document.getElementById("error").style.visibility="visible";
						//alert(username+password);
                    });
                    return false;
                });
            });
			function manualraodenoba(val){
					if(val!='0'){
						document.getElementById("password").value=document.getElementById("password").value+val;
					}
					if(val=='0' && parseFloat(document.getElementById("password").value)>0){
						document.getElementById("password").value=document.getElementById("password").value+val;
					}
                    return false;            
            }
			function manualraodenobachange(val){
					if(val=='clear'){
						document.getElementById("password").value="";
					}
                    return false;            
            }

function seqciaarcheva(name,sul,id,adgili_id){
	document.getElementById("seqcia").value=name;
	document.getElementById("adgili_id").value=adgili_id;
	document.getElementById("next").style.visibility="visible";
	document.getElementById("next1").style.visibility="visible";
	for(i=0;i<=sul+1;i++){
		if(document.getElementById("seqcia_"+i)!=null){
			document.getElementById("seqcia_"+i).classList.remove('btn-success');
			document.getElementById("seqcia_"+i).classList.remove('btn-danger');
			if(i!=id) document.getElementById("seqcia_"+i).classList.add('btn-success');
		}
	}
	document.getElementById("seqcia_"+id).classList.add('btn-danger');
}

document.onkeydown = function (evt) {
	var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
	if(keyCode == 13) {
		$('#sublogin').click();
	}
}
</script>
</body>
</html>
