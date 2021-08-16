<?php
require __DIR__."/../../../classes/phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$inputFileType = 'Xlsx';
$inputFileName = 'gl_report_general_ledger_template_v01.xlsx';
$sheetname = ['sheet1'];

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__."/".$inputFileName);
$sheet = $spreadsheet->getActiveSheet();


$sheet->setCellValue('C2', $_SESSION["target_comp_name"]);
$sheet->setCellValue('C3', date('d/m/Y  H:i:s'));
$date_range_show = $json_search_items['criteria']['journal_date_from'] . '  to ' ;
$date_range_show .=  $json_search_items['criteria']['journal_date_to'] ;
$sheet->setCellValue('C4', $date_range_show);


$styleArray = array(
	'borders' => array(
		'outline' => array(
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
		),
	),
);

$i_count=1 ;
$excel_row = 6;
foreach ($arr_report as $report): 

	$chart_brought_forward = $report['brought_forward'];
	$chart_previous_balance = $dmReport_tb->get_previous_balance($report['chart_id'],$json_search_items['criteria']);
	$chart_current_period_balance = $dmReport_tb->get_current_period_balance($report['chart_id'],$json_search_items['criteria']);
	$chart_ending_balance = $chart_brought_forward + $chart_previous_balance + $chart_current_period_balance;

	$chart_brought_forward = round($chart_brought_forward,2);
	$chart_previous_balance = round($chart_previous_balance,2);
	$chart_current_period_balance = round($chart_current_period_balance,2);
	$chart_ending_balance = round($chart_ending_balance,2);


	$excel_row++;
	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($report['type_name']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['chart_name']));	
	$sheet->setCellValue(('E'.$excel_row), (' '));	
	$sheet->setCellValue(('F'.$excel_row), (' '));	
	$sheet->setCellValue(('G'.$excel_row), ('Brought Forward:'));	
	$sheet->setCellValue(('H'.$excel_row), ($chart_brought_forward));	
	
	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);
	
	$excel_row++;
	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($report['type_name']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['chart_name']));	
	$sheet->setCellValue(('E'.$excel_row), (' '));	
	$sheet->setCellValue(('F'.$excel_row), (' '));	
	$sheet->setCellValue(('G'.$excel_row), ('Previous Balance:'));	
	$sheet->setCellValue(('H'.$excel_row), ($chart_previous_balance));	
	
	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);


	
	
	$ar = json_decode($json_searchphrase, true);
	$ar['criteria']['chart_code_from'] = $report['chart_code'];
	$ar['criteria']['chart_code_to'] = $report['chart_code'];
	$json_searchphrase = json_encode($ar);	
	$arr_current_trans=$dmReport->current_trans($json_searchphrase);
	foreach ($arr_current_trans as $current_tran): 

		$excel_row++;
		$sheet->setCellValue(('A'.$excel_row), $i_count++);
		$sheet->setCellValue(('B'.$excel_row), ($current_tran['chart_code']));
		$sheet->setCellValue(('C'.$excel_row), ($current_tran['type_name']));	
		$sheet->setCellValue(('D'.$excel_row), ($current_tran['chart_name']));	
		$sheet->setCellValue(('E'.$excel_row), (toDMY($current_tran['journal_date'])));	
		$sheet->setCellValue(('F'.$excel_row), ($current_tran['journal_code']));	
		$sheet->setCellValue(('G'.$excel_row), ($current_tran['description']));	
		$sheet->setCellValue(('H'.$excel_row), ($current_tran['amount']));	
		
		
		$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
		$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);
		
	

	endforeach; 	

	$excel_row++;
	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($report['type_name']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['chart_name']));	
	$sheet->setCellValue(('E'.$excel_row), (' '));	
	$sheet->setCellValue(('F'.$excel_row), (' '));	
	$sheet->setCellValue(('G'.$excel_row), ('Current Balance:'));	
	$sheet->setCellValue(('H'.$excel_row), ($chart_current_period_balance));	
	
	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);



	$excel_row++;
	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($report['type_name']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['chart_name']));	
	$sheet->setCellValue(('E'.$excel_row), (' '));	
	$sheet->setCellValue(('F'.$excel_row), (' '));	
	$sheet->setCellValue(('G'.$excel_row), ('Ending Balance:'));	
	$sheet->setCellValue(('H'.$excel_row), ($chart_ending_balance));	
	
	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);



	$excel_row++;
	$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), (' '));	
	$sheet->setCellValue(('C'.$excel_row), (' '));	
	$sheet->setCellValue(('D'.$excel_row), (' '));	
	$sheet->setCellValue(('E'.$excel_row), (' '));	
	$sheet->setCellValue(('F'.$excel_row), (' '));	
	$sheet->setCellValue(('G'.$excel_row), (' '));	
	$sheet->setCellValue(('H'.$excel_row), (' '));	
	
	
	$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
	$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);


endforeach; 	





$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$dt = new DateTime();
$path = __DIR__.DIR_EXCEL_OUTPUT;
$file_name = 'gl_report_general_ledger_'.$dt->format('Y-m-d_H_i_s').'.xlsx';
$writer->save($path.$file_name);

header ("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"".$file_name."\"");
readfile($path.$file_name);

exit();




?>
