<?php


///////////////////////////////////////////////////////////////////////////////////////////////
// Clear brought forward all chart type: income and Expense 
///////////////////////////////////////////////////////////////////////////////////////////////

$type_code='130';  //Income
$arr_charts_income=$dmReport->charts_type($type_code, $json_searchphrase);
		

foreach ($arr_charts_income as $report): 

	$void = $dmReport->chart_brought_forward_update($report['chart_id'],0);

endforeach; 	


$type_code='140';  //Expense
$arr_charts_expense=$dmReport->charts_type($type_code, $json_searchphrase);

foreach ($arr_charts_expense as $report): 

	$void = $dmReport->chart_brought_forward_update($report['chart_id'],0);

endforeach; 	


///////////////////////////////////////////////////////////////////////////////////////////////
// ASSETS
///////////////////////////////////////////////////////////////////////////////////////////////

$report_brought_forward_grand_ttl = 0;
$report_previous_balance_grand_ttl = 0;			
$report_current_period_balance_grand_ttl = 0;
$report_ending_balance_grand_ttl = 0;

$chart_type_name = 'Cash';
$type_code='010';  
require __DIR__.'/handle_chart_types_inc.php';
		
$chart_type_name = 'Account Receivable';
$type_code='020';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Current Assets';
$type_code='030';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Inventory';
$type_code='040';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Fixed Assets';
$type_code='050';  
require __DIR__.'/handle_chart_types_inc.php';


$report_brought_forward_assets_grand_ttl = $report_brought_forward_grand_ttl;
$report_previous_balance_assets_grand_ttl = $report_previous_balance_grand_ttl;			
$report_current_period_balance_assets_grand_ttl = $report_current_period_balance_grand_ttl;
$report_ending_balance_assets_grand_ttl = $report_ending_balance_grand_ttl;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// LIABLILITES 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$report_brought_forward_grand_ttl = 0;
$report_previous_balance_grand_ttl = 0;			
$report_current_period_balance_grand_ttl = 0;
$report_ending_balance_grand_ttl = 0;


$chart_type_name = 'Account Payable';
$type_code='060';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Current Liabilities';
$type_code='070';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Long-term Liabilities';
$type_code='080';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Accumulated Depreciation';
$type_code='090';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Shareholder Equity';
$type_code='100';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Dividend';
$type_code='110';  
require __DIR__.'/handle_chart_types_inc.php';

$chart_type_name = 'Equity-gets closed';
$type_code='120';  
require __DIR__.'/handle_chart_types_inc.php';


$report_brought_forward_liabilites_grand_ttl = $report_brought_forward_grand_ttl;
$report_previous_balance_liabilites_grand_ttl = $report_previous_balance_grand_ttl;			
$report_current_period_balance_liabilites_grand_ttl = $report_current_period_balance_grand_ttl;
$report_ending_balance_liabilites_grand_ttl = $report_ending_balance_grand_ttl;



?>
