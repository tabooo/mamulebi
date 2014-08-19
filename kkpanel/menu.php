<a href="./index.php" <?php if($_GET['cat']=="index" || $_GET['cat']=="") echo 'style="background-color: red;"'; ?>><img src="./images/HomePage.png"> მთავარი გვერდი</a>
<a href="?cat=tanamshromlebi" <?php if($_GET['cat']=="tanamshromlebi") echo 'style="background-color: red;"'; ?>><img src="./images/AccountEdit.png"> თანამშრომლები</a>
<!--<a href="?cat=cats"<?php if($_GET['cat']=="cats") echo 'style="background-color: red;"'; ?>><img src="./images/AddProduct.png"> კატეგორიები</a>-->
<a href="?cat=products"<?php if($_GET['cat']=="products" || $_GET['cat']=="productsedit") echo 'style="background-color: red;"'; ?>><img src="./images/EditProduct.gif"> კერძები</a>
<a href="?cat=productebi"<?php if($_GET['cat']=="productebi") echo 'style="background-color: red;"'; ?>><img src="./images/AddProduct.png"> ინგრედიენტები</a>
<a href="?cat=tables"<?php if($_GET['cat']=="tables") echo 'style="background-color: red;"'; ?>><img src="./images/AddNews.jpg"> მაგიდები</a>
<a href="?cat=migebebi"<?php if($_GET['cat']=="migebebi") echo 'style="background-color: red;"'; ?>><img src="./images/AddNews.jpg"> მიღებები</a>
<a href="?cat=xarjebi"<?php if($_GET['cat']=="xarjebi" || $_GET['cat']=="xarjebisxva" || $_GET['cat']=="xarjebitan" || $_GET['cat']=="chamocera") echo 'style="background-color: red;"'; ?>><img src="./images/EditNews.png"> ხარჯები</a>
<a href="?cat=reports"<?php if($_GET['cat']=="reports" || $_GET['cat']=="reportsales" || $_GET['cat']=="reportsalestan" || $_GET['cat']=="reportsalessul" || $_GET['cat']=="reportsalesadgili" || $_GET['cat']=="reportsxarjebi" || $_GET['cat']=="reportsalesseqcia" || $_GET['cat']=="reportsalesmigebebi" || $_GET['cat']=="reportsalesbugalteria" || $_GET['cat']=="reportsalesmagida" || $_GET['cat']=="reportsalesdgiuri" || $_GET['cat']=="reportsalesnashti") echo 'style="background-color: red;"'; ?>><img src="./images/EditNews.png"> რეპორტები</a>
<a href="?cat=dakmagidebi"<?php if($_GET['cat']=="dakmagidebi" || $_GET['cat']=="dakmagidebidacvrilebit") echo 'style="background-color: red;"'; ?>><img src="./images/EditNews.png"> დაკავებული მაგიდები</a>
<a href="?cat=ganuleba"<?php if($_GET['cat']=="ganuleba") echo 'style="background-color: red;"'; ?>><img src="./images/EditNews.png"> ბაზის განულება</a>
<!--<a href="acc.php"><img src="./images/AccountEdit.png"> ანგარიშის რედაქტირება</a>-->
<script>
$(function() {
    function callAjax(){
        $('#checkmigeba').load("php.php?dos=checkmigeba");
    }
    setInterval(callAjax, 5000 );
});
</script>
<div id="checkmigeba"></div>
<div id="gasvla"><a href="php.php?dos=logout"><img src="./images/LogOut.png"> სისტემიდან გასვლა</a></div>
