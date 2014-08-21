<?php
include('../config.php');
require('tfpdf.php');

if($_REQUEST['dos']=="afterprint" && $_REQUEST['magida']!="" && $_REQUEST['adgili']!=""){
mysqlconnect();
$saxgvari=mysql_fetch_array(mysql_query("select saxeli, gvari from tanamshromlebi where id='".$_SESSION['userid']."'"));
$saxeli=$saxgvari["saxeli"]." ".$saxgvari["gvari"];
$magida=safe($_REQUEST['magida']);
$adgili=safe($_REQUEST['adgili']);
$mg=mysql_fetch_array(mysql_query("select * from tables where id='$magida'"));
$mgseqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mg['seqcia']."'"));
$mgadgili=mysql_fetch_array(mysql_query("select * from adgili where id='".$adgili."'"));
$date=date("Y-m-d H:i:s",time());
$sum=0;
$resp=mysql_query("select prod_id, ertfasi, saxeli,sum(raodenoba),sum(fasi) from sell_temp where magida='$magida' AND print='1' AND adgili='$adgili' group by prod_id order by prod_id asc");

$file = basename(tempnam('.', 'tmp'));
rename($file, $file.'.pdf');
$file .= '.pdf';

$pdf = new tFPDF();
// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',11);
$pdf->SetLeftMargin(5);
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../images/logo.jpg',25,6,30);
//$pdf->setLineWidth(1);
$pdf->Line(1, 13, 80, 13);
$pdf->Ln(4);
$pdf->Write(4,$date);
$pdf->Line(1, 18, 80, 18);
$pdf->Ln(5);
$pdf->Write(5,$saxeli);
$pdf->Ln(5);
$pdf->Write(5,"მაგიდა: ".$mg['name']);
$pdf->Ln(4);
$pdf->Write(6,"სექცია: ".$mgseqcia['name']);
$pdf->Ln(4);
$pdf->Write(6,"გატანის ადგილი: ".$mgadgili['name']);
$pdf->Line(1, 38, 80, 38);
$pdf->Ln(4);
$pdf->Cell(32 ,10,"დასახელება");
$pdf->Cell(13 ,10,"რაოდ.");
$pdf->Cell(12 ,10,"ფასი");
$pdf->Cell(16 ,10,"ჯამი");
$pdf->Line(1, 44, 80, 44);
while($prod=mysql_fetch_array($resp)){
$pdf->Ln(6);
$saxeli=$prod['saxeli'];
if(strlen($saxeli)>38) $saxeli=substr_replace($saxeli, '', 38, -1)."...";
$pdf->Cell(40 ,10,$saxeli);
$pdf->Cell(7 ,10,$prod['sum(raodenoba)']);
$pdf->Cell(9 ,10,$prod['ertfasi']);
$pdf->Cell(16 ,10,$prod['sum(fasi)']." ლ.");
}
//$pdf->Ln(8);
//$pdf->Line(1,$pdf->GetY(),80,$pdf->GetY());

$printer=$mgadgili["printer"];
//$pdf->Output();
$pdf->Output("files/".$file, 'F');
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer files/$file");
execInBg($printer,"files/".$file);
//delFile($file);
unlink($file);
$resp2=mysql_query("select prod_id, saxeli,sum(raodenoba) as raodenoba,sum(fasi) from sell_temp where magida='$magida' AND adgili='".$adgili."' AND print='1' group by prod_id") or die(mysql_error());
while($prod2=mysql_fetch_array($resp2)){
$raodenoba=$prod2['raodenoba'];
$prod_id=$prod2['prod_id'];
$shem=mysql_fetch_array(mysql_query("select shemadgenloba from product where id='$prod_id'")) or die(mysql_error());
$shemadg=explode(",", $shem['shemadgenloba']);
$i=1;
while($shemadg[$i]!=""){
$shemadgenloba=explode(":", $shemadg[$i]);
$shemraodenoba=$shemadgenloba[1]*$raodenoba;
$shemid=$shemadgenloba[0];
mysql_query("update productebi set raodenoba=raodenoba-'$shemraodenoba' where id='$shemid'") or die(mysql_error());
$i++;
}
}
mysql_query("update sell_temp set print=0 where magida='".$magida."' AND adgili='".$adgili."' AND print='1'") or die(mysql_error());
echo "DONE";

}

if($_REQUEST['dos']=="afterwholeprint" && $_REQUEST['magida']!="" && $_REQUEST['procenti']!=""){
if(@$_SESSION['userid']!="" || $_SESSION['seqcia']!=""){
mysqlconnect();
$saxgvari=mysql_fetch_array(mysql_query("select saxeli, gvari from tanamshromlebi where id='".$_SESSION['userid']."'"));
$saxeli=$saxgvari["saxeli"]." ".$saxgvari["gvari"];
$magida=safe($_REQUEST['magida']);
$procenti=safe($_REQUEST['procenti']);
$fasdaklebisprocenti=safe($_REQUEST['fasdaklebisprocenti']);
$fasdaklebiskodi=safe($_REQUEST['fasdaklebiskodi']);
if(mysql_num_rows(mysql_query("select * from sell_temp where magida='$magida' AND print='1'"))>0) die("ზოგი შეკვეთა არ არის ამობეჭდილი");
$pas=mysql_fetch_array(mysql_query("select password from tanamshromlebi where username='admin' AND role='administrator'"));
if($fasdaklebisprocenti!="" && $fasdaklebiskodi!=$pas["password"]) die("ფასდაკლების პაროლი არასწორია");

$mg=mysql_fetch_array(mysql_query("select * from tables where id='".$magida."'"));
$mgseqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$mg['seqcia']."'"));

$date=date("Y-m-d H:i:s",time());
$dro=time();
$shemadgenloba="";
$sum=0;
$sul=0;
$procentit=0;
$uprocentot=0;

$resp=mysql_query("select prod_id, ertfasi, saxeli,sum(raodenoba),sum(fasi) from sell_temp where magida='$magida' group by prod_id order by prod_id asc");

$file = basename(tempnam('.', 'tmp'));
rename($file, $file.'.pdf');
$file .= '.pdf';

$pdf = new tFPDF();
// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',11);
$pdf->SetLeftMargin(5);
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../images/logo.jpg',25,6,30);
//$pdf->setLineWidth(1);

$pdf->Line(1, 13, 80, 13);
$pdf->Ln(4);
$pdf->Write(4,$date);
$pdf->Line(1, 18, 80, 18);
$pdf->Ln(5);
$pdf->Write(5,$saxeli);
$pdf->Ln(5);
$pdf->Write(5,"მაგიდა: ".$mg['name']);
$pdf->Ln(4);
$pdf->Write(6,"სექცია: ".$mgseqcia['name']);
$pdf->Line(1, 34, 80, 34);
$pdf->Ln(4);
$pdf->Cell(32 ,10,"დასახელება");
$pdf->Cell(13 ,10,"რაოდ.");
$pdf->Cell(12 ,10,"ფასი");
$pdf->Cell(16 ,10,"ჯამი");
$pdf->Line(1, 40, 80, 40);
while($prod=mysql_fetch_array($resp)){
$pdf->Ln(6);
$saxeli=$prod['saxeli'];
if(strlen($saxeli)>48) $saxeli=substr_replace($saxeli, '', 48, -1)."...";
$pdf->Cell(40 ,10,$saxeli);
$pdf->Cell(7 ,10,$prod['sum(raodenoba)']);
$pdf->Cell(9 ,10,$prod['ertfasi']);
$pdf->Cell(16 ,10,$prod['sum(fasi)']." ლ.");
$ii++;
$sum=$sum+$prod['sum(fasi)'];
}
$pdf->Ln(8);
$pdf->Line(1,$pdf->GetY(),80,$pdf->GetY());

$sum=round($sum,2);
$proc=round(($sum*$procenti/100),2);
$procentit+=round((($sum*(100+$procenti))/100),2);
$uprocentot+=$sum;
$fasdakl=round($sum*$fasdaklebisprocenti/100,2);
$sul=$sum+$proc-$fasdakl;

$pdf->Write(6,"ჯამი: ".number_format(round($sum,2),2, '.', ' ')." ლარი");
$pdf->Ln(5);
$pdf->Write(6,"+მომსახურების: ".$procenti."% – ".$proc." ლარი");
$pdf->Ln(5);
$pdf->Write(6,"-ფასდაკლება: ".$fasdaklebisprocenti."% – ".$fasdakl." ლარი");
$pdf->Ln(6);
$pdf->Line(1, $pdf->GetY(), 80, $pdf->GetY());
$pdf->SetFont('DejaVu','',16);
$pdf->Write(7,"სულ: ".number_format($sul,2, '.', ' ')." ლარი");
$pdf->Ln(6);
if($_REQUEST['check']=="1"){
	$pdf->Write(7,"წინასწარი ჩეკი");
	}

$printer=$mgseqcia["printer"];
//$pdf->Output();
$pdf->Output("files/".$file, 'F');
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file");
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file");
execInBg($printer,"files/".$file);

if($_REQUEST['check']!="1"){
	execInBg($printer,"files/".$file);
//delFile($file);
	unlink($file);

	mysql_query("insert into magidisdaxurva values (null,'$uprocentot','$procentit','$sul','$dro','$magida','".$_SESSION['seqcia']."','$adgili','$procenti','$fasdaklebisprocenti','$shemadgenloba','".$_SESSION['userid']."','0')");
	$lastid=mysql_insert_id();
	$rr=mysql_num_rows(mysql_query("select * from sell_temp where magida='$magida'"));
	$i=0;
	while($i!=$rr){
	$as=mysql_fetch_array(mysql_query("select id from sell_temp where magida='$magida' order by id limit 0,1"));
	mysql_query("insert into sell (prod_id,raodenoba,ertfasi,fasi,saxeli,cat,dro,year,month,day,hour,min,sec,magida,seqcia,adgili,print,user) select prod_id,raodenoba,ertfasi,fasi,saxeli,cat,dro,year,month,day,hour,min,sec,magida,seqcia,adgili,print,user from sell_temp where id='".$as['id']."'") or die(mysql_error());
	$lastins=mysql_insert_id();
	mysql_query("update magidisdaxurva set shemadgenloba=CONCAT(shemadgenloba,',".$lastins."') where id='".$lastid."'");
	mysql_query("delete from sell_temp where magida='$magida' and id='".$as['id']."'");
	$i++;
	}
}
die("DONE");
} else {
	die("გთხოვთ გაიაროთ ავტორიზაცია ახლიდან!");
}
}


if($_REQUEST['dos']=="orderedit" && $_REQUEST['orderid']!="" && $_REQUEST['raodenoba']!="" && $_REQUEST['fasi']!=""){
mysqlconnect();
$saxgvari=mysql_fetch_array(mysql_query("select saxeli, gvari from tanamshromlebi where id='".$_SESSION['userid']."'"));
$saxeli=$saxgvari["saxeli"]." ".$saxgvari["gvari"];
$orderid=safe($_REQUEST['orderid']);
$raodenoba=safe($_REQUEST['raodenoba']);
$fasi=safe($_REQUEST['fasi']);
$ord=mysql_fetch_array(mysql_query("select * from sell_temp where id='$orderid'"));
$magida=mysql_fetch_array(mysql_query("select * from tables where id='".$ord['magida']."'"));
$seqcia=mysql_fetch_array(mysql_query("select * from seqciebi where id='".$magida['seqcia']."'"));
$qmedeba="";
$qm="";
if($raodenoba>0) {$qmedeba="დამატება"; $qm="+";} else { $qmedeba="გამოკლება"; $qm="-";}
$file = basename(tempnam('.', 'tmp'));
rename($file, $file.'.pdf');
$file .= '.pdf';

$pdf = new tFPDF();
// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',12);
$pdf->SetLeftMargin(5);
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$time=date("h:i:s", time());

$pdf->Write(5,"ყუდადღება!!! ".$qmedeba."  ".$time);
$pdf->Ln(4);
$pdf->Cell(25 ,10,"მაგ.");
$pdf->Cell(32 ,10,"დასახელება");
$pdf->Cell(15 ,10,"რაოდ.");
$pdf->Line(1, 22, 80, 22);
$pdf->Ln(6);
$saxeli=$ord["saxeli"];
if(strlen($saxeli)>42) $saxeli=substr_replace($saxeli, '', 36, -1)."...";
$pdf->Cell(25 ,10,$magida["name"]."/".$seqcia["name"]);
$pdf->Cell(32 ,10,$saxeli);
$pdf->Cell(15 ,10,$qm.$raodenoba);

$mgadgili=mysql_fetch_array(mysql_query("select * from adgili where id='".$ord['adgili']."'"));
$printer=$mgadgili["printer"];
//$pdf->Output();
$pdf->Output("files/".$file, 'F');
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer files/$file");
execInBg($printer,"files/".$file);
//delFile($file);
unlink($file);
$resp=mysql_query("select * from sell_temp where id='$orderid'") or die(mysql_error());
$prod=mysql_fetch_array($resp);
$prod_id=$prod['prod_id'];
$shem=mysql_fetch_array(mysql_query("select shemadgenloba from product where id='$prod_id'")) or die(mysql_error());
$shemadg=explode(",", $shem['shemadgenloba']);
$i=1;
while($shemadg[$i]!=""){
$shemadgenloba=explode(":", $shemadg[$i]);
$shemraodenoba=$shemadgenloba[1]*$raodenoba;
$shemid=$shemadgenloba[0];
mysql_query("update productebi set raodenoba=raodenoba-'$shemraodenoba' where id='$shemid'") or die(mysql_error());
$i++;
}
mysql_query("update sell_temp set raodenoba=raodenoba+'$raodenoba', fasi=fasi+'$fasi' where id='$orderid'") or die(mysql_error());
mysql_query("insert into orderedit values (null,'$orderid','$raodenoba')") or die(mysql_error());
echo "DONE";

}


if($_POST['dos']=="dailyprint"){
mysqlconnect();
$fromday=strtotime(safe($_POST['fromyear'])."-".safe($_POST['frommon'])."-".safe($_POST['fromday'])." 02:00:00");
$today=strtotime(safe($_POST['fromyear'])."-".safe($_POST['frommon'])."-".safe($_POST['fromday']+1)." 02:00:00");
$date2=date("H:i:s",time());
$date=date("Y-m-d",$fromday);

////////////////////////////////////////
$jami1=0;
$jamiuprocento=0;
$resp1=mysql_query("select * from magidisdaxurva where dro>='$fromday' AND dro<='$today' order by dro desc") or die(mysql_error());
while($sell1=mysql_fetch_array($resp1)){
$jami1+=$sell1['tanxa'];
$jamiuprocento+=$sell1['procentit']-$sell1['uprocentot'];
}
//////////////////////////////////////////
$file = basename(tempnam('.', 'tmp'));
rename($file, $file.'.pdf');
$file .= '.pdf';

$pdf = new tFPDF();
// Ajoute une police Unicode (utilise UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',12);
$pdf->SetLeftMargin(5);
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../images/logo.jpg',25,6,30);
//$pdf->setLineWidth(1);
$pdf->Line(1, 13, 80, 13);
$pdf->Ln(4);
$pdf->Write(4,$date." ".$date2);
$pdf->Line(1, 18, 80, 18);
$pdf->Ln(5);
$pdf->Write(5,"პროცენტით: ".$jami1." ლ.");
$pdf->Ln(5);
$pdf->Write(6,"უპროცენტოთ: ".($jami1-$jamiuprocento)." ლ.");
$pdf->Ln(5);
$pdf->Write(6,"პროცენტი: ".$jamiuprocento." ლ.");
//////////////////////////////////////
$jamiadg=0;
$adgquery=mysql_query("select * from adgili");
while($adg=mysql_fetch_array($adgquery)){
	$resp=mysql_query("select * from sell where dro>='$fromday' AND dro<='$today' AND adgili='".$adg['id']."' order by dro desc");
	while($sell1=mysql_fetch_array($resp)){
		$jamiadg+=$sell1['fasi'];
	}
	$pdf->Ln(5);
	$pdf->Write(6,$adg['name'].": ".$jamiadg." ლ.");
	$jamiadg=0;
}
/////////////////////////////////////
$pdf->Line(1, 50, 80, 50);
$pdf->Ln(4);
$pdf->Cell(42 ,10,"დასახელება");
$pdf->Cell(17 ,10,"რაოდ.");
$pdf->Cell(25 ,10,"ჯამი");
$pdf->Line(1, 56, 80, 56);
$resp=mysql_query("select prod_id,sum(raodenoba) as raodenoba,sum(fasi) as fasi from sell where dro>='".$fromday."' and dro<='".$today."' group by prod_id order by saxeli asc") or die(mysql_error());
while($sell=mysql_fetch_array($resp)){
$prod=mysql_fetch_array(mysql_query("select saxeli from product where id='".$sell['prod_id']."'")) or die(mysql_error());
$pdf->Ln(6);
$saxeli=$prod['saxeli'];
if(strlen($saxeli)>42) $saxeli=substr_replace($saxeli, '', 42, -1);
$pdf->Cell(42 ,10,$saxeli);
$pdf->Cell(17 ,10,round($sell['raodenoba'],2));
$pdf->Cell(25 ,10,round($sell['fasi'],2)." ლ.");
}
//$pdf->Ln(8);
//$pdf->Line(1,$pdf->GetY(),80,$pdf->GetY());

//$printer=$mgadgili["printer"];
//$pdf->Output();
$pdf->Output("files/".$file, 'F');
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer files/$file");
execInBg("BARI","files/".$file);
//delFile($file);
unlink($file);
echo "DONE";

}


function execInBg($printer,$file){
	if(substr(php_uname(), 0, 7)=="Windows"){
		pclose(popen("start /B java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file", "r"));
		//pclose(popen("start /B del $file", "r"));
		//unlink($file);
	}
	else {
		exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file > /dev/null &");
		//exec("del $file > /dev/null &");
		//unlink($file);
	}
	
}
function delFile($file){
	if(substr(php_uname(), 0, 7)=="Windows"){
		pclose(popen("start /B del $file", "r"));
	}
	else {
		exec("del $file > /dev/null &");
	}
	
}
?>
