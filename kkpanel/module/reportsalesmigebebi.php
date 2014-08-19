
<style>
/* table */
#newspaper-b
{
	/*line-height: 1.6em;*/
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 13px;
	margin: 2px;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
	border: 1px solid #adadad;
}
#newspaper-b th
{
	padding: 5px 5px 5px 5px;
	font-weight: normal;
	font-size: 13px;
	color: #039;
	border: 1px solid #adadad;
}
#newspaper-b tbody
{
	background: #ededed;
}
#newspaper-b td
{
	padding: 3px;
	color: #000000;
	border: 1px solid #adadad;
}
#newspaper-b tbody tr:hover td
{
	color: #039;
	background: #dadada;
}
</style>
<script>
function reportsalesmigebebi(){
				$(function() {
					var adgili=$('#adgili').val();					
					var datarange = $('#daterange').val();
					/*var fromyear = $('#fromyear').val();
					var frommon = $('#frommon').val();
					var fromday = $('#fromday').val();
					var today = $('#today').val();*/
					var product = $('#product').val();
					                    $.post('php.php',{dos:"reportsalesmigebebi",adgili:adgili,datarange:datarange,product:product}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}

function edit_productebi_adgili(form){
				$(function() {
					id=form.show_ingr_id.value;
					adgili=form.show_ingr_adgili.value;
					var answer = confirm("ადგილის შეცვლის დასტური");
	if (answer){
                    $.post('php.php',{dos:"edit_productebi_adgili",id:id,adgili:adgili}, function(data){
                       $("#show_results").html(data);
                    });
				}
			//$("#text").html("<font color='green'><b>ინგრედიენტი წარმატებით შეიცვალა</b></font>");
				return false;	
				}); 				
}

function delete_migeba(id){
var answer2 = prompt("წაშლისათვის გთხოვთ შეიყვანოთ ადმინისტრატორის პაროლი");
	if (answer2=="zaliko"){

				$(function() {
                    $.post('php.php',{dos:"delete_migeba",id:id}, function(data){
                       $("#show_results").html(data);
                    });
				return false;	
				}); 	
} else {alert("არასწორი პაროლი");}			
}

function showtable(){
document.getElementById('showtable').style.visibility='visible';
}
</script>
<h3>მიღებების რეპორტები</h3>
<script type="text/javascript">document.title = 'მიღებების რეპორტები';</script>
<table><tr>
<td>
აირჩიეთ ადგილი:
</td>
<td>
<select name="adgili" id="adgili">
<?php
$pr=mysql_query("select * from adgili where id in (select distinct nashti from adgili) order by id asc");
while($pro=mysql_fetch_array($pr)){
echo '<option value="'.$pro["nashti"].'">'.$pro["name"].'</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td>
აირჩიეთ პერიოდი:
</td>
<td>
<div class="well">

               <form class="form-horizontal">
                 <fieldset>
                  <div class="control-group">
                    
                    <div class="controls">
                     <div class="input-prepend">
                       <span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="reservation" id="daterange" style="height=30px;"/>
                     </div>
                    </div>
                  </div>
                 </fieldset>
               </form>

<?php
$maxdate=date("m/d/Y",time());
?>
               <script type="text/javascript">
               $(document).ready(function() {
                  $('#daterange').daterangepicker(
                     {
                        minDate: '01/01/2013',
                        maxDate: '<?php echo $maxdate;?>',
						            showDropdowns: true
                     }
                  );

               });
               </script>

</div>
</td>
</tr>
<tr>
<td>
აირჩიეთ ინგრედიენტი:
</td>
<td>
<select name="product" id="product">
<option value=""> - </option>
<?php
$pr=mysql_query("select * from productebi order by saxeli asc");
while($pro=mysql_fetch_array($pr)){
echo '<option value="'.$pro["id"].'">'.$pro["saxeli"].'</option>';
}
?>
</select>
</td>
</tr></table>
<br>

<input value="ძებნა" type="button" onClick="reportsalesmigebebi()"><div style="float:right"><a href="?cat=reports"><input type="button" value="<-- უკან დაბრუნება" /></a></div>
<div id="show_results">
</div>
