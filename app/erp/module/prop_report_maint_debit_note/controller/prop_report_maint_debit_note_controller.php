<?php
require __DIR__.'/../../../func/check_session_func.php';
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/general_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('PROP-REPORT-01-040');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';

//Open report database connnection 
$dmReport = new prop_report_maint_debit_note_model();  

$arr_prop_build_master = $dmReport->prop_build_master_viewall($_SESSION["target_comp_id"]);

	
switch($IS_action)
{
	
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;
		

		
	case "generate";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('update',$dmReport);
			if($vlValidation->ValidateForm($_POST['criteria'])) {
				$json_searchphrase = json_encode($_POST);	
				$arr_report=$dmReport->generate($json_searchphrase);
				$json_search_items = json_decode($json_searchphrase, true);

					$general = $dmReport->prop_build_master_select($_POST['criteria']["build_id"]);

				switch ($_POST['criteria']['output']) {
						case "screen": 
							require __DIR__."'/../view/generate_result_inc.php";				
							break;
						case "excel":
							require __DIR__."'/../excel/generate_excel_inc.php";				
							break;
						case "pdf":
							require __DIR__."'/../pdf/generate_pdf_inc.php";				
							break;
					}
				
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


