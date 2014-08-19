<?php
include("config.php");
mysqlconnect();
if(@$_SESSION['username']==""){
echo '<meta http-equiv="refresh" content="1; URL=login.php">';
die();
}
else {
?>
<!DOCTYPE html>
<html>
  <head>
    <title>მამულები - მიმტანი</title>
	<link href="favicon.ico" rel="shortcut icon" />
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<style type="text/css">
     
      /* Custom container */
      .container {
        margin: 0 auto;
        width: 1250px;
		height: 650px;
		border: 1px solid;
		background-color: #3399FF;
      }
	  
	  .btn-primary.active{
		background-color:red;
	  }
	  
	  ::-webkit-scrollbar {
    height: 20px;
	width: 25px;
	background: #000;
    }
::-webkit-scrollbar-thumb {
    background: #CCCCCC;
    -webkit-border-radius: 1ex;
    -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);

}
::-webkit-scrollbar-track {
	width: 5px;
	height:5px;
}
::-webkit-scrollbar-corner {
    background: #000;
}
    </style>
	<script src="js/jasny-bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/jasny-bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-lightbox.min.css">
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.pt-BR.js"></script>
	<script type="text/javascript" src="js/bootstrap-lightbox.min.js"></script>
	
  </head>
  <body oncontextmenu="return false;">
  <div class="container">
  
	<div class="row">
		<div class="span3">
		
			<div id="maincats">
			<?php
				$maincats=mysql_query("select * from adgili order by id asc") or die(mysql_error());
				$sul=mysql_fetch_array(mysql_query("select id from cats where visible='1' order by id desc limit 0,1"));
				while($mc=mysql_fetch_array($maincats)){
				?>
					<button class="btn btn-large" type="button" style="width:230px; height:40px; padding:0; text-align:left; font-size:15px;" onClick="javascript:selectmaincat(<?php echo $mc["id"].",".($sul["id"]+1);?>);" id="selectmaincat<?php echo $mc["id"]; ?>"><img src="<?php echo $mc["pic"]; ?>" style="float:left;" width="50" height="36">&nbsp;<?php echo $mc["name"]; ?></button>
				<?php
				}
			?>
			
			</div>

			<div style="height: 480px; overflow: auto; border: 2px solid black; margin-top:5px;" id="cats"></div>
		</div>
		
		<div class="span7" style="padding:0; background-color:#d9edf7;">
			<p class="label label-success" style="height:40px;margin:0;"><?php echo $_SESSION["username"]; ?><br>(დღის ნავაჭრი 0 ლარი)</p>
			<a class="btn btn-large btn-success" style="font-size:20px;float:right;margin:0;" href="php.php?dos=logout">EXIT</a>
			
			<br>
			<div class="alert alert-block" style="height:80px;margin:0;" id="tables"></div>
			
			<div class="span3" style="margin:0; height: 490px; overflow: auto; border: 2px solid black; background-color:white; float:left;" id="showprods"></div>
			
			<div class="span4" style="margin-left:5px; height: 490px; overflow: auto; border: 2px solid black; background-color:white;" id="showprod"></div>
			
		</div>
		
		<div class="span5" style="padding:0; background-color:#d9edf7; width:450px;" id="results">

		</div>
		
	</div>
	
  </div>

<div id="orderedit" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">შეკვეთის რედაქტირება</h3>
  </div>
  <div class="modal-body" id="orderedit-body">
  </div>
  <div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">გაუქმება</button>
  </div>
</div>

<div id="printwindow" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width:800px;margin-left:-500px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">ჩეკის ბეჭდვა</h3>
  </div>
  <div class="modal-body" style="max-height:400px;max-width:800px;padding-right:40px;" id="printwindow-body">
  </div>
  <div class="modal-footer" id="printwindow-footer">
	<!--<button class="btn" data-dismiss="modal" aria-hidden="true">გაუქმება</button>-->
  </div>
</div>
	
  
<script>
		
$('#printwindow').css(
{
	'margin-left': function () {
		return ($(window).width()-$(this).width())/2;
	}
});
$('#orderedit').css(
{
	'margin-left': function () {
		return ($(window).width()-$(this).width())/2;
	}
});
function selectmaincat(id,sul){
	$(function() {
		$.post('php.php',{dos:"selectmaincat",id:id}, function(data){
		   $("#cats").html(data);
		})
		for(i=0;i<sul;i++){
		if(document.getElementById("selectmaincat"+i)!=null)
		document.getElementById("selectmaincat"+i).classList.remove('btn-danger');
		};
		document.getElementById("selectmaincat"+id).classList.add('btn-danger');
		return false;
	});           
}

function selectcat(id,sul){
	$(function() {
		$.post('php.php',{dos:"selectcat",id:id}, function(data){
		   $("#showprods").html(data);
		})
		for(i=0;i<sul;i++){
		if(document.getElementById("selectcat"+i)!=null)
		document.getElementById("selectcat"+i).classList.remove('btn-danger');
		};
		document.getElementById("selectcat"+id).classList.add('btn-danger');
		return false;
	});           
}

function selectprod(id,sul){
	$(function() {
		$.post('php.php',{dos:"selectprod",id:id}, function(data){
		   $("#showprod").html(data);
		})
		for(i=0;i<sul;i++){
		if(document.getElementById("selectprod"+i)!=null)
		document.getElementById("selectprod"+i).classList.remove('btn-danger');
		};
		document.getElementById("selectprod"+id).classList.add('btn-danger');
		return false;
	});           
}


function refreshtables(id){
	var num=id;
	$.post('php.php',{dos:"refreshtables",selectedid:num}, function(data){
		$("#tables").html(data);
	});
	$.post('php.php',{dos:"showtable",magida:num}, function(data){
		$("#results").html(data);
	});
}


function chnagepriceraodenoba(){
	document.getElementById("prodfasisul").value=(parseFloat(document.getElementById("prodraodenoba").value)*parseFloat(document.getElementById("prodfasi").value)).toFixed(2);
	return false;            
}

function prodraodenobaadd(){
	document.getElementById("prodraodenoba").value=parseFloat(document.getElementById("prodraodenoba").value)+1;
	document.getElementById("prodfasisul").value=(parseFloat(document.getElementById("prodraodenoba").value)*parseFloat(document.getElementById("prodfasi").value)).toFixed(2);
	return false;            
}
function prodraodenobaremove(){
	if(parseFloat(document.getElementById("prodraodenoba").value)>1){
		document.getElementById("prodraodenoba").value=parseFloat(document.getElementById("prodraodenoba").value)-1;
		document.getElementById("prodfasisul").value=(parseFloat(document.getElementById("prodraodenoba").value)*parseFloat(document.getElementById("prodfasi").value)).toFixed(2);
	}
	return false;            
}
function manualraodenoba(val){
	if(val!='0'){
		document.getElementById("manualraodenoba").value=document.getElementById("manualraodenoba").value+val;
	}
	if(val=='0' && parseFloat(document.getElementById("manualraodenoba").value)>0){
		document.getElementById("manualraodenoba").value=document.getElementById("manualraodenoba").value+val;
	}
	return false;            
}
function manualraodenobachange(val){
	if(val=='change' && parseFloat(document.getElementById("manualraodenoba").value)>0){
		document.getElementById("prodraodenoba").value=document.getElementById("manualraodenoba").value;
		document.getElementById("prodfasisul").value=(parseFloat(document.getElementById("prodraodenoba").value)*parseFloat(document.getElementById("prodfasi").value)).toFixed(2);
	}
	if(val=='clear'){
		document.getElementById("manualraodenoba").value="";
		document.getElementById("prodfasisul").value=(parseFloat(document.getElementById("prodraodenoba").value)*parseFloat(document.getElementById("prodfasi").value)).toFixed(2);d
	}
	return false;            
}


function proddamateba() {
	//alert();
	prod_id=document.getElementById("proddamatebaid").value;
	raodenoba=document.getElementById("prodraodenoba").value;
	magida=document.getElementById("tablenumber").value;
	if(magida=="")alert("გთხოვთ მიუთითოთ მაგიდა "+magida);
	adgili1=document.getElementById("adgili").value;
	$.post('php.php',{dos:"prodamateba",prod_id:prod_id,raodenoba:raodenoba,magida:magida,adgili:adgili1}, function(data){
	  // $("#results").html(data);
	   refreshtables(magida);
	});
	
	$("#proddamateba").unbind('click');
	return false;
}


function orderedit(orderid){
    $("#orderedit").modal("show");
	$.post('orderedit.php',{orderid:orderid}, function(data){
	   $("#orderedit-body").html(data);
	});
}	

function checkordereditpass(){
    ordereditpass=document.getElementById("ordereditpass").value;
	orderid=document.getElementById("orderid").value;
	$.post('orderedit.php',{dos:"checkordereditpass",ordereditpass:ordereditpass,orderid:orderid}, function(data){
	   $("#orderedit-body").html(data);
	});
}	

function editorderraodenobaadd(form){
	form.ordereditraodenoba.value=parseFloat(form.ordereditraodenoba.value)+1;
	form.ordereditfasi.value=(parseFloat(form.ordereditraodenoba.value)*parseFloat(form.ordereditertfasi.value)).toFixed(2);
	return false;            
}
function editorderraodenobaremove(form){
	minval=form.minval.value;
if(-1*parseFloat(form.ordereditraodenoba.value)<minval){
	form.ordereditraodenoba.value=parseFloat(form.ordereditraodenoba.value)-1;
	form.ordereditfasi.value=(parseFloat(form.ordereditraodenoba.value)*parseFloat(form.ordereditertfasi.value)).toFixed(2);
}
	return false;          
}


function ordereditid1(form){
var orderid1=form.ordereditid.value;
var fasi1=form.ordereditfasi.value;
var raodenoba1=form.ordereditraodenoba.value;
$.post('PDF/print.php',{dos:"orderedit",orderid:orderid1,raodenoba:raodenoba1,fasi:fasi1}, function(data){
	//$("#orderedit-body").html(data);
	refreshtables(document.getElementById("tablenumber").value);
	$("#orderedit").modal("hide");
});
}


function print_window(adgili,magida) {
	$("#printwindow").modal("show");
	$.post('print.php',{dos:"printadgili", magida:magida, adgili:adgili}, function(data){
	   $("#printwindow-body").html(data);
	   $("#printwindow-footer").html('<button class="btn" data-dismiss="modal" aria-hidden="true">გაუქმება</button><button class="btn btn-primary" aria-hidden="true" onclick="afterprint2('+magida+','+adgili+')">ბეჭდვა</button>');
	   
	});
	
}

function afterprint2(magida,adgili){
	$(function() {				
		$.post('PDF/print.php',{dos:"afterprint",magida:magida,adgili:adgili}, function(data){
		}).success(function() {
			refreshtables(magida);
			$("#printwindow").modal("hide");
		});
		return false;		
	});  
    			
}


function magidis_daxurva(magida){
$("#printwindow").modal("show");
$("#printwindow-body").html("იტვირთება...");
procenti=document.getElementById("procentisul").value;
fasdaklebisprocenti=document.getElementById("fasdaklebisprocenti").value;
fasdaklebiskodi=document.getElementById("fasdaklebiskodi").value;
$.post('print.php',{dos:"print", magida:magida, procenti:procenti,fasdaklebisprocenti:fasdaklebisprocenti,fasdaklebiskodi:fasdaklebiskodi}, function(data){
	   $("#printwindow-body").html(data);
	   $("#printwindow-footer").html('<button class="btn" data-dismiss="modal" aria-hidden="true">გაუქმება</button><button class="btn btn-primary" aria-hidden="true" onclick="afterwholeprint2(\''+magida+'\',\''+procenti+'\',\''+fasdaklebisprocenti+'\',\''+fasdaklebiskodi+'\')">ბეჭდვა</button>');
	   
	});
	
}


function afterwholeprint2(magida,procenti,fasdaklebisprocenti,fasdaklebiskodi){
	//document.getElementById('disablingDiv').style.display='block';
	suljami=document.getElementById("suljami").value;
	$(function() {				
		$.post('PDF/print.php',{dos:"afterwholeprint",magida:magida,suljami:suljami,procenti:procenti,fasdaklebisprocenti:fasdaklebisprocenti,fasdaklebiskodi:fasdaklebiskodi}, function(data){
		}).success(function() {
			refreshtables(magida);
			$("#printwindow").modal("hide"); 				
		});			
		return false;		
	});  
	    			
}


function deletefromtableid(id,magida){
	$(function() {
		$.post('php.php',{dos:"deletefromtable",id:id,magida:magida}, function(data){
			//$("#results").html(data);
			refreshtables(document.getElementById("tablenumber").value);
		});
				
		return false;
	});			
}


window.onfocus=function(){
var num=document.getElementById("tablenumber").value;
refreshtables(num);
}
			
refreshtables(0);
</script>
  </body>
</html>
<?php } ?>