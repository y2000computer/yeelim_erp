<?php
require __DIR__.'/../../../func/check_session_func.php';
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/general_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('PROP-TRAN-01-005');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';

$dmGeneralModel = new prop_rent_inv_model();  //Open database connection

$arr_prop_build_master = $dmGeneralModel->prop_build_master_viewall($_SESSION["target_comp_id"]);

		
switch($IS_action)
{
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;

	case "search";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$_SESSION["target_build_id"] = $_POST['general']['build_id'];
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmGeneralModel->search($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmGeneralModel->searchphrase($lot_id);
				}
		$result_id=$dmGeneralModel->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_general_model=array();
		if ($result_id != '') $arr_general_model=$dmGeneralModel->retreive_content($lot_id,$page);
		require __DIR__."'/../view/search_result_inc.php";				
		break;			
		
	case "new";
		require __DIR__.'/../view/new_step_01_inc.php';
		break;		

	case "new_step_02";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$_SESSION["target_build_id"] = $_POST['general']['build_id'];	
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmGeneralModel->search_tenant_info($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmGeneralModel->searchphrase($lot_id);
				}
		$result_id=$dmGeneralModel->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_general_model=array();
		if ($result_id != '') $arr_general_model=$dmGeneralModel->retreive_content_tenant_info($lot_id,$page);	
		require __DIR__.'/../view/new_step_02_inc.php';
		break;
	
		case "new_step_03";

		require __DIR__.'/common_paging_inc.php';
		$item_id=$_GET["item_id"];
		$general = $dmGeneralModel->tenant_info_select($_GET["item_id"]);
		$general['rent_date'] = YMDtoDMY($general['rent_date']);
		require __DIR__.'/../view/new_step_03_inc.php';
		break;			
		
		case "create";
		$general = $_POST['general'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('create',$dmGeneralModel);
			if($vlValidation->ValidateFormActionCreate($general)) {
				$item_id=$dmGeneralModel->create($_POST['general']);
				$general = $dmGeneralModel->select($item_id);
				$general['inv_date'] = YMDtoDMY($general['inv_date']);
				$general['period_date_from'] = YMDtoDMY($general['period_date_from']);
				$general['period_date_to'] = YMDtoDMY($general['period_date_to']);
				require __DIR__.'/../view/edit_inc.php';
			} else {
				require __DIR__.'/../view/new_step_03_inc.php';
			}	
		}
		
	break;		
		
	
	case "edit";

		require __DIR__.'/common_paging_inc.php';
		$item_id=$_GET["item_id"];
		$general = $dmGeneralModel->select($_GET["item_id"]);
		$general['inv_date'] = YMDtoDMY($general['inv_date']);
		$general['period_date_from'] = YMDtoDMY($general['period_date_from']);
		$general['period_date_to'] = YMDtoDMY($general['period_date_to']);

		if($tab=='general' ||  $tab=='') {
			require __DIR__.'/../view/edit_inc.php';
		}	
	

		break;
		
		
	case "update";
	
		require __DIR__.'/common_paging_inc.php';
		$item_id = $_GET["item_id"];	
		$general = $_POST['general'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('update',$dmGeneralModel);
				if($vlValidation->ValidateFormActionUpdate($item_id, $general)) {
					$void=$dmGeneralModel->update($item_id, $_POST['general']);
					$general = $dmGeneralModel->select($item_id);
					$general['inv_date'] = YMDtoDMY($general['inv_date']);
					$general['period_date_from'] = YMDtoDMY($general['period_date_from']);
					$general['period_date_to'] = YMDtoDMY($general['period_date_to']);
					require __DIR__.'/../view/edit_inc.php';
	
			} 
			else {
				$general = $_POST['general'] ;
				require __DIR__.'/../view/edit_inc.php';
			}
		}
		
		
		break;
		
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$dmGeneralModel = $dmGeneralModel->close();  
?>


