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
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<script>
function reportsalesdgiuri(){
				$(function() {
					var fromyear = $('#fromyear').val();
					var frommon = $('#frommon').val();
					var fromday = $('#fromday').val();
					//var today = $('#today').val();
					                    $.post('php.php',{dos:"reportsalesdgiuri",fromyear:fromyear,frommon:frommon,fromday:fromday}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}
function dailyprint(){
				$(function() {
					var fromyear = $('#fromyear').val();
					var frommon = $('#frommon').val();
					var fromday = $('#fromday').val();
					//var today = $('#today').val();
					                    $.post('../PDF/print.php',{dos:"dailyprint",fromyear:fromyear,frommon:frommon,fromday:fromday}, function(data){
                       $("#show_results").html(data);
                    });
				
				return false;	
				}); 				
}
function showtable(){
document.getElementById('showtable').style.visibility='visible';
}
</script>
<h3>დღიური გაყიდული საქონლის რაოდენობა</h3>
<script type="text/javascript">document.title = 'დღიური გაყიდული საქონლის რაოდენობა';</script>
<form method="post" action="module/reportsalesbugalteria_convertxls.php?dos=convertxls">
<table><tr>
<td>წელი
<select type="text" name="fromyear" id="fromyear">
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
<td>დღე
<select type="text" name="fromday" id="fromday">
  <?php
  $i=1;
  while($i!=32){
  echo '<option value="'.$i.'">'.$i.'</option>';
  $i++;
  }
  ?>
</select>
</td>

</tr>
</table><br>
<input value="ძებნა" type="button" onClick="reportsalesdgiuri()">
<div style="float:right"><a href="?cat=reports"><input type="button" value="უკან დაბრუნება" /></a></div>
</form>
<div id="show_results">
</div>
