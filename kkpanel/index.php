<?php
include("head.php");
if ($_SESSION['username']=="" || $_SESSION['role']!="administrator"){
	session_destroy();
	refreshPage(0, "login.php");
echo $_SESSION['username'];
}
?>
<body>	
<div id="leftcolumn">
<?php include("menu.php"); ?>

</div>

<div id="rightcolumn">
<?php 
mysqlconnect();
			$cat="index";
			//if(stripslashes($_GET['cat'])=="") $_GET['cat']="main";
			if(stripslashes(@$_GET['cat'])!="" && file_exists("module/".stripslashes($_GET['cat']).".php")) $cat=stripslashes($_GET['cat']);
			
			include("module/".$cat.".php");
?>
</div>

<div style="clear: left; margin-bottom: 1em"></div>

</body>


