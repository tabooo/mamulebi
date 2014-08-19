<?php
include("head.php"); 
if ($_SESSION['logged']!="yes"){
?>
<form action="" method="POST">
<table>
<tr>
<td>სახელი</td><td><input type="text" name="username"/></td>
</tr>
<tr>
<td>პაროლი</td><td><input type="text" name="pass"/></td>
</tr>
<tr>
<td><input value="შესვლა" type="submit" name="subuser"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>
</form>
<?php
}
else { ?>

<body background="./images/body.png">	
<div id="leftcolumn">
<?php include("menu.php"); ?>

</div>

<div id="rightcolumn">
<h3>პროდუქციის რედაქტირება: </h3>
<?php
$id=intval($_GET['id']);
if($id!=""){
mysqlconnect();
$resp=mysql_query("select * from news where id='$id'");
$prod=mysql_fetch_array($resp);
?>

<form name="editproduct" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>
<td>სიახლის დასახელება</td><td><input type="text" name="news_name_ge" cols="40" value="<?php echo $prod['name_ge'];?>"/></td>
</tr>
<tr>
<td>დასახელება რუსულად</td><td><input type="text" name="news_name_ru" cols="40" value="<?php echo $prod['name_ru'];?>"/></td>
</tr>
<tr>
<td>ტექსტი</td><td><textarea name="news_desc_ge" rows="10" cols="40"><?php echo $prod['text_ge'];?></textarea></td>
</tr>
<tr>
<td>ტექსტი რუსულად</td><td><textarea name="news_desc_ru" rows="10" cols="40"><?php echo $prod['text_ru'];?></textarea></td>
</tr>
<tr>
<td>თარიღი</td><td><input type="text" name="date" value="<?php echo $prod['date'];?>"/></td>
</tr>
<tr>
<td>აქტიური</td><td><input type="text" name="active" value="<?php echo $prod['active'];?>"/></td>
</tr>
<!--<tr>
<td>სურათი</td><td><input type="file" name="photo"></td>
</tr>
-->
<tr>
<td><input value="დამატება" type="submit" name="sub"></td>
<td><img src="./images/copyright.png"> <b>Panel</b></td>
</tr>
</table>

</form>
<?php
}
else {
?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $("#search").bind('submit',function() {
                    var value = $('#str').val();
                    $.post('search.php',{strnews:value}, function(data){
                        $("#search_results").html(data);
                    });
                    return false;
                });
            });
        </script>
<form id="search" name="search" action="" method="POST" enctype="multipart/form-data">
<table>
<tr>

<td>ID ან სახელი</td><td><input type="text" name="str" id="str"/></td>
<td><input value="ძებნა" type="submit" name="subsearch"></td>
</tr>
</table>
<div id="search_results"></div>
</form>

</div>

<div style="clear: left; margin-bottom: 1em"></div>

</body>
<?php }
 ?>


<?php 
if(isset($_POST['subedit'])){
$id=intval($_GET['id']);
$name_ge=htmlspecialchars($_POST['name_ge']);
$name_en=htmlspecialchars($_POST['name_en']);
$desc_ge=html_entity_decode($_POST['news_desc_ge']);
$desc_ru=$_POST['news_desc_ru'];
$date=$_POST['date'];
$active=intval($_POST['actve']);

mysql_query("update news set name_ge='$name_ge', name_ru='$name_ru', text_ge='$desc_ge', text_ru='$desc_ru', date='$date', active='$active' where id='$id'") or die(mysql_error());
refreshPage(0, "editnews.php?id=".$id);
}


}
?>
