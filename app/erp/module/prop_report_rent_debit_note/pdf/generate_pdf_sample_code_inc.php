<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING );

$data = array();

$data['header_file']=__DIR__.'/header_v01_inc.php';
$data['content_file']=__DIR__.'/content_v01_inc.php';
$data['footer_file']=__DIR__.'/footer_v01_inc.php';

$data['output_format']='storage';
$data['mar_top']=60;
$data['mar_bot']=5;

$header = getHtml($data['header_file']);
$content = getHtml($data['content_file']);
$footer = getHtml($data['footer_file']);

/*
echo 'data[header_file] ='. ($data['header_file']);
echo '<br>';
echo 'data[content_file] ='. ($data['content_file']);
echo '<br>';
echo 'data[footer_file] ='. ($data['footer_file']);
*/


if (!class_exists('mPDF')) {
	 require __DIR__."/../../../classes/mpdf60/mpdf.php";
	} 
echo '<br> mpdf.php loaded';

$mpdf = new mPDF('zh-HK',    // mode - default ''
			'A4',    // format - A4, for example, default ''
			0,     // font size - default 0
			'',    // default font family
			5,    // 15 margin_left
			5,    // 15 margin right
			($data['mar_top']?$data['mar_top']:88),     // 16 margin top
			($data['mar_bot']?$data['mar_bot']:10),    // margin bottom
			6,     // 9 margin header
			3 ,   // 9 margin footer
			'P');  // L - landscape, P - portrait
$mpdf->useAdobeCJK = true;		// Default setting in config.php

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
$mpdf->writeHtml($content);


$dir=DIR_PUBLIC_HTML.'/prop_rent_debit_note_output/';

if (!is_dir($dir)) 	{
	mkdir($dir,0777,true);
}

$data['filename'] = 'rent_debit_note';
$data['file_extension'] = 'pdf';
$data['fullfilepath']= $dir.$data['filename'].'.'.$data['file_extension'];

echo  'fullfilepath = '.$data['fullfilepath'] .'<br>';


if (file_exists($data['filename'].$data['file_extension'])) {
	unlink($data['filename'].$data['file_extension']);
}



$mpdf->Output($data['fullfilepath'],'F');


header("Content-Type: application/pdf");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=".$data['filename'].'.'.$data['file_extension']);
header("Content-Description: PHP Generated XLS Data");
readfile($data['fullfilepath']);

exit;

function getHtml($file){
	$html='';
	if ($file){
		ob_start();
		//var_dump($file);

		require $file;
		$html = ob_get_clean();
	}
	
	return $html;
}


?>
