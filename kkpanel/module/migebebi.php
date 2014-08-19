<?php
mysqlconnect();
?>
<script>
function migebebei_add_products(form){
			$(function() {
					prod_vali=0;
					if(form.prod_vali.checked==1) prod_vali=1;
					prod_id=form.prod_id.value;
					adgili=form.adgili.value;
					prod_name=form.prod_name.value;
					prod_ert_fasi=form.prod_ert_fasi.value;
					prod_raodenoba=form.prod_raodenoba.value;
					prod_jami=form.prod_jami.value;
	var answer = confirm("დამატების დასტური: "+prod_name+" – "+prod_raodenoba + "("+prod_jami+"ლარის)");
	if (answer){
if(prod_id!="" && prod_ert_fasi!="" && prod_raodenoba!=""){
                    $.post('php.php',{dos:"migebebi_add_products",adgili:adgili,prod_vali:prod_vali,prod_id:prod_id,prod_ert_fasi:prod_ert_fasi,prod_raodenoba:prod_raodenoba,prod_jami:prod_jami}, function(data){
                       $("#show_answer").html(data);
                    })
			.success(function() {
					form.prod_ert_fasi.value="";
					form.prod_raodenoba.value="";
					form.prod_jami.value="";
					});
} else {alert("გთხოვთ შეავსოთ ველები")}
}

                    return false;   
                });        
}
function searchproduct(){
				search=document.getElementById("searchfor").value;
				$(function() {
                    $.post('php.php',{dos:"migebebi_search_products",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}

function changemigebebijami(form){
				form.prod_jami.value=(form.prod_ert_fasi.value*form.prod_raodenoba.value).toFixed(2);			
}
</script>
<h2><b>მიღებების შეტანა</b></h2>
სახელი ან ID<input type="text" id="searchfor"/><input value="ძებნა" type="button" onClick="searchproduct()"><br /><br />

<div id="show_results">
</div>
<div id="show_answer">
</div>
