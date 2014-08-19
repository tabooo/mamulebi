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
function reportsales(){
				$(function() {
					var product=$('#product').val();
					var datarange = $('#daterange').val();
					                    $.post('php.php',{dos:"reportsales",product:product,datarange:datarange}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}

function showtable(){
document.getElementById('showtable').style.visibility='visible';
}
</script>
<h3>რეპორტები - კერძების მიხედვით</h3>
<script type="text/javascript">document.title = 'რეპორტები - კერძების მიხედვით';</script>
<table>
<tr>
<td width="200">
ამოირჩიეთ კერძი:
</td>
<td>
<select name="product" id="product">
<option value=""> - </option>
<?php
$pr=mysql_query("select * from product order by saxeli asc");
while($pro=mysql_fetch_array($pr)){
echo '<option value="'.$pro["id"].'">'.$pro["saxeli"].'</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td width="200">
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
</table><br>
<input value="ძებნა" type="button" onClick="reportsales()"><div style="float:right"><a href="?cat=reports"><input type="button" value="უკან დაბრუნება" /></a></div>
<div id="show_results">
</div>
