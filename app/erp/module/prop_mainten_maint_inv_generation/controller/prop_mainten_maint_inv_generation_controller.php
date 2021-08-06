<?php
require __DIR__.'/../../../func/check_session_func.php';
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/general_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('PROP-MAINT-01-005');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';

//Open report database connnection 
$dmGeneral = new prop_mainten_maint_inv_generation_model();  

$arr_prop_build_master = $dmGeneral->prop_build_master_viewall($_SESSION["target_comp_id"]);

	
switch($IS_action)
{
	
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;
		

		
	case "process";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('update',$dmGeneral);
			if($vlValidation->ValidateForm($_POST['criteria'])) {
				$json_searchphrase = json_encode($_POST);	
				//$arr_report=$dmGeneral->process($json_searchphrase);
				$json_search_items = json_decode($json_searchphrase, true);
				$arr_generation = $dmGeneral->generate($json_searchphrase);
				require __DIR__."'/../view/process_view_inc.php";
				
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

$void = $dmGeneral->close();  

?>


