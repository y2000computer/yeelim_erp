<?php
require __DIR__."/../../../classes/phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$inputFileType = 'Xlsx';
$inputFileName = 'prop_report_rent_overdue_template_v02.xlsx';
$sheetname = ['sheet1'];

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__."/".$inputFileName);
$sheet = $spreadsheet->getActiveSheet();


$sheet->setCellValue('C2', $general["eng_name"]);
$sheet->setCellValue('C3', date('d/m/Y  H:i:s'));


$styleArray = array(
	'borders' => array(
		'outline' => array(
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
		),
	),
);

$last_tenant_code ='';
$tenant_row_newcol_is = false;
$tenant_row_balance_ttl = 0;
$report_ttl = 0;
$i_count=1;
$excel_row = 5;
foreach ($arr_report as $report): 
	
	$excel_row++;

	$report_ttl += $report['balance'];
	$report_ttl = round($report_ttl,2);
	
	if ($last_tenant_code == '') {
		$last_tenant_code = trim($report['tenant_code']);
		$tenant_row_newcol_is = true;
	}

	if ($last_tenant_code <> trim($report['tenant_code'])) {
		//print empty col 
		//$excel_row++;

		$sheet->setCellValue(('K'.$excel_row), ('Grand Total:'));	
		$sheet->setCellValue(('L'.$excel_row), ($tenant_row_balance_ttl));	
		$sheet ->getStyle(('K'.$excel_row.':K'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('L'.$excel_row.':L'.$excel_row))->applyFromArray($styleArray);

		
		//skip two  empty col 
		$excel_row++;
		$excel_row++;

		$tenant_row_balance_ttl = 0;
		$last_tenant_code = trim($report['tenant_code']);
		
	}

    $tenant_row_balance_ttl += $report['balance'];

	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['build_eng_name']));
	$sheet->setCellValue(('C'.$excel_row), ($report['tenant_code']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['eng_name']));	
	$sheet->setCellValue(('E'.$excel_row), ($report['ref_no']));	
	$sheet->setCellValue(('F'.$excel_row), ($report['shop_no']));	
	$sheet->setCellValue(('G'.$excel_row), (YMDtoDMY($report['inv_date'])));	
	$sheet->setCellValue(('H'.$excel_row), ($report['inv_code']));	
	$sheet->setCellValue(('I'.$excel_row), (YMDtoDMY($report['period_date_from'])));	
	$sheet->setCellValue(('J'.$excel_row), (YMDtoDMY($report['period_date_to'])));	
	$sheet->setCellValue(('K'.$excel_row), ($report['amount']));	
	$sheet->setCellValue(('L'.$excel_row), ($report['balance']));	

	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('I'.$excel_row.':I'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('J'.$excel_row.':J'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('K'.$excel_row.':K'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('L'.$excel_row.':L'.$excel_row))->applyFromArray($styleArray);

	
endforeach; 	

//print last tenant col sum 
$excel_row++;
$sheet->setCellValue(('K'.$excel_row), ('Grand Total:'));	
$sheet->setCellValue(('L'.$excel_row), ($tenant_row_balance_ttl));	
$sheet ->getStyle(('K'.$excel_row.':K'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('L'.$excel_row.':L'.$excel_row))->applyFromArray($styleArray);


//skip two  empty col 
$excel_row++;
$excel_row++;


//Print report balance:
$excel_row++;
$sheet->setCellValue(('K'.$excel_row), ('Report Total:'));	
$sheet->setCellValue(('L'.$excel_row), ($report_ttl));	
$sheet ->getStyle(('K'.$excel_row.':K'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('L'.$excel_row.':L'.$excel_row))->applyFromArray($styleArray);


$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$dt = new DateTime();
$path = __DIR__.DIR_EXCEL_OUTPUT;
$file_name = 'prop_report_rent_overdue_'.$dt->format('Y-m-d_H_i_s').'.xlsx';
$writer->save($path.$file_name);

header ("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"".$file_name."\"");
readfile($path.$file_name);

exit();




?>
