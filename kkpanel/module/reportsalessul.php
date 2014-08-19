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
					var fromyear = $('#fromyear').val();
					var frommon = $('#frommon').val();
					var today = $('#today').val();
				 $.post('php.php',{dos:"reportsalessul",fromyear:fromyear,frommon:frommon,today:today}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}
</script>
<h3>საერთო მოგება</h3>
<script type="text/javascript">document.title = 'საერთო მოგება';</script>
<table><tr>
<td>წელი
<select type="text" name="fromyear" id="fromyear">
<option value=""> -- </option>
<?php
$quryear=date("Y",time());
$selected="";
for($i=$quryear;$i>=2011;$i--){
if($i==$quryear) $selected="selected";
echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
$selected="";
}
?>
</select></td>
<td>თვე
<option value=""> -- </option>
<select type="text" name="frommon" id="frommon">
<?php
$qurmon=date("m",time());
$selected="";
for($i=1;$i<=12;$i++){
if($i==$qurmon) $selected="selected";
echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
$selected="";
}
?>
</select>
</td>
<td>
<select type="text" name="today" id="today">
<option value=""> -- </option>
  <?php
  $i=1;
  while($i!=32){
  echo '<option value="'.$i.'">'.$i.'</option>';
  $i++;
  }
  ?>
</select>-მდე
</td>
</tr>
</table><br>
<input value="ძებნა" type="button" onClick="reportsales()"><div style="float:right"><a href="?cat=reports"><input type="button" value="უკან დაბრუნება" /></a></div>
<div id="show_results">
</div>
