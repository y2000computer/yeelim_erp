<?php
require __DIR__."/../../../classes/phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$inputFileType = 'Xlsx';
$inputFileName = 'journal_entry_template_v01.xlsx';
$sheetname = ['sheet1'];

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__."/".$inputFileName);
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue(('A1'), ($_SESSION["target_comp_name"]));
$sheet->setCellValue(('C4'), ($general['journal_code']));
$sheet->setCellValue(('C5'), ($general['journal_date']));

$styleArray = array(
	'borders' => array(
		'outline' => array(
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
		),
	),
);



$i_count=1;
$excel_row = 7;
foreach ($arr_detail as $detail): 
	
	$excel_row++;

	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($detail['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($detail['chart_name']));
	$sheet->setCellValue(('D'.$excel_row), (htmlspecialchars($detail['description'])));
	$sheet->setCellValue(('E'.$excel_row), ($detail['amount']));
	

	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);


	
endforeach; 	


$sheet->setCellValue(('B'.($excel_row+2)), ('--end of report--'));



$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$dt = new DateTime();
$path = __DIR__.DIR_EXCEL_OUTPUT;
$file_name = 'journal_entry_'.$general['journal_code'].'_'.$dt->format('Y-m-d_H_i_s').'.xlsx';
$writer->save($path.$file_name);



header ("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"".$file_name."\"");
readfile($path.$file_name);
exit;
?>