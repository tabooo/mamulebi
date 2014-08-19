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
function ganuleba(){
	$(function() {
		var answer = confirm("თქვენ გსურთ ბაზის განულება?");
		if (answer){
			$.post('php.php',{dos:"ganuleba"}, function(data){
				$("#show_results").html(data);
			});
		}
		return false;	
	}); 				
}

function showtable(){
document.getElementById('showtable').style.visibility='visible';
}
</script>
<h3>ბაზის განულება</h3>
<script type="text/javascript">document.title = 'განულება';</script>
<input value="განულება" type="button" onClick="ganuleba()"><div style="float:right"></div>
<div id="show_results">
</div>
