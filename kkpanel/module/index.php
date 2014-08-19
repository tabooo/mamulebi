<?php
if(isset($_POST['subchangepass']) && $_POST['oldpass']!="" && $_POST['newpass1']!="" && $_POST['newpass2']!=""){
	if($_POST['newpass1']==$_POST['newpass2']){
		$useradmin=mysql_fetch_array(mysql_query("select * from tanamshromlebi where username='".$_SESSION['username']."'"));
		if($useradmin["password"]==$_POST["oldpass"]){
			mysql_query("update tanamshromlebi set password='".mysql_real_escape_string($_POST['newpass1'])."' where username='".$_SESSION['username']."'");
			echo "<font color='green'><b>პაროლი წარმატებით შეიცვალა</b></font>";
			refreshPage(3, "index.php");
			die();
		}else{
			echo "<font color='red'><b>ძველი პაროლი არასწორია</b></font>";
			refreshPage(3, "index.php");
			die();
		}
	} else{
		echo "<font color='red'><b>ახალი პაროლები არ მეთხვევა ერთმანეთს</b></font>";
		refreshPage(3, "index.php");
		die();
	}
}
?>
<p><h2>BMS Configuration Tools</h2></p>
<p><b>პაროლის შეცვლა</b></p>
<p>
<form action="" method="post">
<input type="password" size="30" name="oldpass" placeholder="ძველი პაროლი"><br>
<input type="password" size="30" name="newpass1" placeholder="ახალი პაროლი"><br>
<input type="password" size="30" name="newpass2" placeholder="გაიმეორეთ ახალი პაროლი"><br>
<input type="submit" name="subchangepass" value="შეცვლა">
</form>
<b></b></p>

<p><b>&nbsp;</b></p>

<p><a href="http://bms-page.com" target="_blank">www.bms-page.com</a>, [<a href="mailto:tabagari89@gmail.com">tabagari89@gmail.com</a>] .</p>
<p>Tel.: (+995) 598 177 384; (+995) 592 23 12 78  // Technical Support </p>

<p><b>All Rights Reserved. " Georgia 2011"</b></p>
<p><a target="_blank" href="http://bms-page.com"><img src="./images/bms_logo.png"width="150"></a></p>



