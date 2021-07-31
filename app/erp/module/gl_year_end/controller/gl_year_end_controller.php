<?php
require __DIR__.'/../../../func/check_session_func.php';
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/general_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('GL-MAINT-01-010');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';

//Open report database connnection 
$dmReport = new gl_year_end_model();  
$dmBalanceSheet = new gl_report_balance_sheet_model();   //other models


	
switch($IS_action)
{
	
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;
		

		
	case "process";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('update',$dmReport);
			if($vlValidation->ValidateForm($_POST['criteria'])) {
				$json_searchphrase = json_encode($_POST);	
				//$arr_report=$dmReport->process($json_searchphrase);
				$json_search_items = json_decode($json_searchphrase, true);
				require __DIR__."'/../controller/handle_process_inc.php";				
				require __DIR__."'/../view/process_view_inc.php";
				///////////////////////////////////////////////////////////////////////////////////////////////
				// Update Journal year end status, readonly all journal after year end 
				///////////////////////////////////////////////////////////////////////////////////////////////
				$void=$dmReport->journal_entry_marked_year_end($json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
				
				
			} else {
				$json_searchphrase = json_encode($_POST);	
				$json_search_items = json_decode($json_searchphrase, true);
				require __DIR__.'/../view/index_inc.php';
				}			
		}		
		break;	
	
	
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$void = $dmReport->close();  

?>


