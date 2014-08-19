<?php
mysqlconnect();
?>
<script>
function chamocera_add_products(form){
			$(function() {
					prod_id=form.prod_id.value;
					prod_raodenoba=form.prod_raodenoba.value;
if(prod_id!="" && prod_raodenoba!=""){
                    $.post('php.php',{dos:"chamocera_add_products",prod_id:prod_id,prod_raodenoba:prod_raodenoba}, function(data){
                       $("#show_answer").html(data);
                    })
			.success(function() {
					form.prod_raodenoba.value="";
					});
} else {alert("გთხოვთ შეავსოთ ველები")}

                    return false;   
                });        
}
function searchproduct(){
				search=document.getElementById("searchfor").value;
				$(function() {
                    $.post('php.php',{dos:"chamocera_search_products",search:search}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 				
}
</script>
<h2><b>მიღებების შეტანა</b></h2>
სახელი ან ID<input type="text" id="searchfor"/><input value="ძებნა" type="button" onClick="searchproduct()"><br /><br />

<div id="show_results">
</div>
<div id="show_answer">
</div>
