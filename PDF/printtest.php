<?php 
function execInBg($printer,$file){
	if(substr(php_uname(), 0, 7)=="Windows"){
		pclose(popen("start /B java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file", "r"));
		echo "1";
	}
	else {
		exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName $printer $file > /dev/null &");
		echo "2";
	}
	unlink($file);
}
//system("mkdir test",$output);
//exec("java -classpath pdfboxapp181.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName \\\\mamulebi\\Canon1 a1.pdf",$output,$return);
//$res=shell_exec("java -classpath pdfboxapp181.jar 2>&1 org.apache.pdfbox.PrintPDF -silentPrint -printerName \\\\192.168.1.3\\Canon1 a1.pdf");
//system("java -classpath pdfboxapp181.jar 2>&1 org.apache.pdfbox.PrintPDF -silentPrint -printerName \\\\192.168.1.3\\Canon1 a1.pdf",$output);
//system("java -classpath pdfbox-app-1.8.1.jar 2>&1 org.apache.pdfbox.PrintPDF -silentPrint -printerName \\\\192.168.1.3\\Canon1 tmpF7.tmp.pdf",$output);
//var_dump($res);
execInBg("\\\\192.168.1.3\\Canon1","a1.pdf");
//echo $output.$return;

?>