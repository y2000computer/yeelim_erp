<?php
require __DIR__."/../../../classes/phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$inputFileType = 'Xlsx';
$inputFileName = 'gl_report_balance_sheet_template_v01.xlsx';
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

$i_count=1;
$excel_row = 6;


///////////////////////////////////
//ASSETS
///////////////////////////////////

$excel_row++;

$sheet->setCellValue(('A'.$excel_row), ('ASSETS'));
$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);

$report_brought_forward_grand_ttl = 0;
$report_previous_balance_grand_ttl = 0;			
$report_current_period_balance_grand_ttl = 0;
$report_ending_balance_grand_ttl = 0;


$chart_type_name = 'Cash';
$type_code='010';  
require __DIR__.'\generate_excel_result_types_inc.php';



$chart_type_name = 'Account Receivable';
$type_code='020';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Current Assets';
$type_code='030';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Inventory';
$type_code='040';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Fixed Assets';
$type_code='050';  
require __DIR__.'\generate_excel_result_types_inc.php';



$excel_row++;
$sheet->setCellValue(('D'.$excel_row), ('Assets Total:'));	
$sheet->setCellValue(('E'.$excel_row), ($report_brought_forward_grand_ttl));	
$sheet->setCellValue(('F'.$excel_row), ($report_previous_balance_grand_ttl));	
$sheet->setCellValue(('G'.$excel_row), ($report_current_period_balance_grand_ttl));	
$sheet->setCellValue(('H'.$excel_row), ($report_ending_balance_grand_ttl));	
$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);


$report_brought_forward_assets_grand_ttl = $report_brought_forward_grand_ttl;
$report_previous_balance_assets_grand_ttl = $report_previous_balance_grand_ttl;			
$report_current_period_balance_assets_grand_ttl = $report_current_period_balance_grand_ttl;
$report_ending_balance_assets_grand_ttl = $report_ending_balance_grand_ttl;



///////////////////////////////////
//LIABLILITES 
///////////////////////////////////

$excel_row++;

$sheet->setCellValue(('A'.$excel_row), ('LIABLILITES '));
$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);


$report_brought_forward_grand_ttl = 0;
$report_previous_balance_grand_ttl = 0;			
$report_current_period_balance_grand_ttl = 0;
$report_ending_balance_grand_ttl = 0;

$chart_type_name = 'Account Payable';
$type_code='060';  
require __DIR__.'\generate_excel_result_types_inc.php';


$chart_type_name = 'Current Liabilities';
$type_code='070';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Long-term Liabilities';
$type_code='080';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Accumulated Depreciation';
$type_code='090';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Shareholder Equity';
$type_code='100';  
require __DIR__.'\generate_excel_result_types_inc.php';


$chart_type_name = 'Dividend';
$type_code='110';  
require __DIR__.'\generate_excel_result_types_inc.php';

$chart_type_name = 'Equity-gets closed';
$type_code='120';  
require __DIR__.'\generate_excel_result_types_inc.php';



$excel_row++;
$sheet->setCellValue(('D'.$excel_row), ('Liabilites Total:'));	
$sheet->setCellValue(('E'.$excel_row), ($report_brought_forward_grand_ttl));	
$sheet->setCellValue(('F'.$excel_row), ($report_previous_balance_grand_ttl));	
$sheet->setCellValue(('G'.$excel_row), ($report_current_period_balance_grand_ttl));	
$sheet->setCellValue(('H'.$excel_row), ($report_ending_balance_grand_ttl));	
$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);


$report_brought_forward_assets_grand_ttl = $report_brought_forward_grand_ttl;
$report_previous_balance_assets_grand_ttl = $report_previous_balance_grand_ttl;			
$report_current_period_balance_assets_grand_ttl = $report_current_period_balance_grand_ttl;
$report_ending_balance_assets_grand_ttl = $report_ending_balance_grand_ttl;
			

		





$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$dt = new DateTime();
$path = __DIR__.DIR_EXCEL_OUTPUT;
$file_name = 'gl_report_balance_sheet_'.$dt->format('Y-m-d_H_i_s').'.xlsx';
$writer->save($path.$file_name);

header ("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"".$file_name."\"");
readfile($path.$file_name);

exit();




?>
