<?php
$arr_charts=$dmBalanceSheet->charts_type($type_code, $json_searchphrase);

$i_count=1 ;
$report_brought_forward_ttl = 0;
$report_previous_balance_ttl = 0;			
$report_current_period_balance_ttl = 0;
$report_ending_balance_ttl = 0;
foreach ($arr_charts as $report): 

	$report_brought_forward = $report['brought_forward'];
	/*
	$report_previous_balance = $dmBalanceSheet->get_previous_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
	*/
	$report_previous_balance = $dmBalanceSheet->get_previous_balance($report['chart_id'],$json_search_items['criteria']);

	/*
	$report_current_period_balance = $dmBalanceSheet->get_current_period_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
	*/
	$report_current_period_balance = $dmBalanceSheet->get_current_period_balance($report['chart_id'],$json_search_items['criteria']);
	

	if($type_code=='120') {		//Equity-gets closed , calcuate P & L
		
		$report_previous_balance_libabilites_without_pl = $report_previous_balance_grand_ttl;
		$report_previous_balance = ($report_previous_balance_assets_grand_ttl + $report_previous_balance_libabilites_without_pl)*-1 ;

		$report_current_period_balance_libabilites_without_pl = $report_current_period_balance_grand_ttl;
		$report_current_period_balance = ($report_current_period_balance_assets_grand_ttl + $report_current_period_balance_libabilites_without_pl)*-1 ;

		$report_ending_balance_libabilites_without_pl = $report_ending_balance_grand_ttl;
		$report_ending_balance = ($report_ending_balance_assets_grand_ttl + $report_ending_balance_libabilites_without_pl)*-1 ;
		

		
	}
	$report_ending_balance = $report_brought_forward + $report_previous_balance + $report_current_period_balance;

	/*
	echo '<br><br> chart id ='.$report['chart_id'] ;
	echo ' -- chart code ='.$report['chart_code'];
	echo ' -- report_brought_forward ='.$report_brought_forward ;
	echo ' -- report_previous_balance ='.$report_previous_balance ;
	echo ' -- report_current_period_balance ='.$report_current_period_balance ;
	echo ' -- report_ending_balance ='.$report_ending_balance;
	*/
	
	$void = $dmReport->chart_brought_forward_update($report['chart_id'],$report_ending_balance);

	
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

	
	

endforeach; 	

$report_brought_forward_grand_ttl += $report_brought_forward_ttl;
$report_previous_balance_grand_ttl += $report_previous_balance_ttl;			
$report_current_period_balance_grand_ttl += $report_current_period_balance_ttl;
$report_ending_balance_grand_ttl += $report_ending_balance_ttl;

$report_brought_forward_grand_ttl = round($report_brought_forward_grand_ttl,2);
$report_previous_balance_grand_ttl = round($report_previous_balance_grand_ttl,2);
$report_current_period_balance_grand_ttl = round($report_current_period_balance_grand_ttl,2);
$report_ending_balance_grand_ttl = round($report_ending_balance_grand_ttl,2);
			
?>
