<?php


$arr_charts=$dmReport->charts_type($type_code, $json_searchphrase);
		
$excel_row++;

$sheet->setCellValue(('A'.$excel_row), ($chart_type_name));
$sheet ->getStyle(('A'.$excel_row.':A'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('B'.$excel_row.':B'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('C'.$excel_row.':C'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);


		

$i_count=1 ;
$report_brought_forward_ttl = 0;
$report_previous_balance_ttl = 0;			
$report_current_period_balance_ttl = 0;
$report_ending_balance_ttl = 0;
foreach ($arr_charts as $report): 

	$excel_row++;
	
	//$report_ttl += $report['amount'];
	$report_brought_forward = $report['brought_forward'];
	/*
	$report_previous_balance = $dmReport->get_previous_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
	*/
	$report_previous_balance = $dmReport->get_previous_balance($report['chart_id'],$json_search_items['criteria']);

	/*
	$report_current_period_balance = $dmReport->get_current_period_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
	*/

	$report_current_period_balance = $dmReport->get_current_period_balance($report['chart_id'],$json_search_items['criteria']);


	if($type_code=='120') {		//Equity-gets closed , calcuate P & L
		
		$report_previous_balance_libabilites_without_pl = $report_previous_balance_grand_ttl;
		$report_previous_balance = ($report_previous_balance_assets_grand_ttl + $report_previous_balance_libabilites_without_pl)*-1 ;

		$report_current_period_balance_libabilites_without_pl = $report_current_period_balance_grand_ttl;
		$report_current_period_balance = ($report_current_period_balance_assets_grand_ttl + $report_current_period_balance_libabilites_without_pl)*-1 ;

		$report_ending_balance_libabilites_without_pl = $report_ending_balance_grand_ttl;
		$report_ending_balance = ($report_ending_balance_assets_grand_ttl + $report_ending_balance_libabilites_without_pl)*-1 ;
		
		
	}
	$report_ending_balance = $report_brought_forward + $report_previous_balance + $report_current_period_balance;

	$report_brought_forward = round($report_brought_forward,2);
	$report_previous_balance = round($report_previous_balance,2);
	$report_current_period_balance = round($report_current_period_balance,2);
	$report_ending_balance = round($report_ending_balance,2);
	
	$report_brought_forward_ttl += $report_brought_forward;
	$report_previous_balance_ttl += $report_previous_balance;
	$report_current_period_balance_ttl += $report_current_period_balance;
	$report_ending_balance_ttl += $report_ending_balance;

	$report_brought_forward_ttl = round($report_brought_forward_ttl,2);
	$report_previous_balance_ttl = round($report_previous_balance_ttl,2);
	$report_current_period_balance_ttl = round($report_current_period_balance_ttl,2);

	//$sheet->setCellValue(('A'.$excel_row), $i_count++);
	$sheet->setCellValue(('B'.$excel_row), ($report['chart_code']));
	$sheet->setCellValue(('C'.$excel_row), ($report['type_name']));	
	$sheet->setCellValue(('D'.$excel_row), ($report['chart_name']));	
	$sheet->setCellValue(('E'.$excel_row), ($report_brought_forward));	
	$sheet->setCellValue(('F'.$excel_row), ($report_previous_balance));	
	$sheet->setCellValue(('G'.$excel_row), ($report_current_period_balance));	
	$sheet->setCellValue(('H'.$excel_row), ($report_ending_balance));	
	
	
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
$sheet->setCellValue(('D'.$excel_row), ('Total:'));	
$sheet->setCellValue(('E'.$excel_row), ($report_brought_forward_ttl));	
$sheet->setCellValue(('F'.$excel_row), ($report_previous_balance_ttl));	
$sheet->setCellValue(('G'.$excel_row), ($report_current_period_balance_ttl));	
$sheet->setCellValue(('H'.$excel_row), ($report_ending_balance_ttl));	
$sheet ->getStyle(('D'.$excel_row.':D'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('E'.$excel_row.':E'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('F'.$excel_row.':F'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('G'.$excel_row.':G'.$excel_row))->applyFromArray($styleArray);
$sheet ->getStyle(('H'.$excel_row.':H'.$excel_row))->applyFromArray($styleArray);

	
$report_brought_forward_grand_ttl += $report_brought_forward_ttl;
$report_previous_balance_grand_ttl += $report_previous_balance_ttl;			
$report_current_period_balance_grand_ttl += $report_current_period_balance_ttl;
$report_ending_balance_grand_ttl += $report_ending_balance_ttl;

$report_brought_forward_grand_ttl = round($report_brought_forward_grand_ttl,2);
$report_previous_balance_grand_ttl = round($report_previous_balance_grand_ttl,2);
$report_current_period_balance_grand_ttl = round($report_current_period_balance_grand_ttl,2);
$report_ending_balance_grand_ttl = round($report_ending_balance_grand_ttl,2);



?>