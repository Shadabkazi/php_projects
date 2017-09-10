<?php
ob_start();
include 'uploadImage.php';		//code to handle image upload
require 'fpdf.php';				// library used to generate pdf

 
    $error = $_SESSION['error'];
	
	if($error==false){
		echo "There was some problem while uploading file.";
	} 
	else
	{
$even=0;			
$y=20;
$x=20;
$count = 0;
$page_changed=false;			// used to know whether page has changed 
$pdf= new FPDF();
$pdf->AddPage();				// add new pdf page
foreach($_FILES["files"]["name"] as $tmp_name){				//loop for all file name 
if($count<6){
if($even==0){
$pdf->Image("UploadFolder/".$tmp_name,$x,$y,70,70);
$even=1;
$x=$x+80;
}else if($even==1 && $page_changed!=true){
$pdf->Image("UploadFolder/".$tmp_name,$x,$y,70,70);
$even=0;
$y=$y+80;
$x=20;
}else if($even==1 && $page_changed==true){
	$pdf->Image("UploadFolder/".$tmp_name,$x,$y,70,70);
$even=0;
$y=$y+80;
$x=20;
$page_changed=false;
}

}else{
$count=0;
$y=20;
$x=20;
$pdf->AddPage();
$pdf->Image("UploadFolder/".$tmp_name,$x,$y,70,70);
$x=$x+80;
$even=1;
$page_changed=true;
$count++;
continue;
}
$count++;
}

$pdf->Output('','GeneratedOutput.pdf',false);
ob_end_flush();
session_destroy();
	}

?>