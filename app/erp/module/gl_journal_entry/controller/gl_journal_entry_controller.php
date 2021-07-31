<?php
require __DIR__.'/../../../func/check_session_func.php';
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/general_validation.php';
require __DIR__.'/../validation/detail_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('GL-TRAN-01-001');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';

$dmGeneralModel = new gl_journal_entry_model();  //Open database connection

$arr_chart_type_master = $dmGeneralModel->chart_type_master_viewall(); 
		
switch($IS_action)
{
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;

	case "search";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmGeneralModel->search_advance($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmGeneralModel->searchphrase($lot_id);
				}
		$result_id=$dmGeneralModel->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_general_model=array();
		//if ($result_id != '') $arr_general_model=$dmGeneralModel->retreive_content($lot_id,$page);
		if ($result_id != '') $arr_general_model=$dmGeneralModel->retreive_content_advance($lot_id,$page);
		require __DIR__."'/../view/search_result_advance_inc.php";				
		break;			

		
	case "new";
		require __DIR__.'/../view/new_inc.php';
		break;		
		
	case "create";

		$general = $_POST['general'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new general_validation('create',$dmGeneralModel);
			if($vlValidation->ValidateFormActionCreate($general)) {
				$item_id=$dmGeneralModel->create($_POST['general']);
				$general = $dmGeneralModel->select($item_id);
				$general['journal_date'] = YMDtoDMY($general['journal_date']);
				$arr_detail = $dmGeneralModel->detail_list($_GET["item_id"]);
				$tab  = 'detail';
				require __DIR__.'/../view/list_detail_inc.php';

			} else {
				require __DIR__.'/../view/new_inc.php';
			}	
		}
		
		break;		
		
	
	case "edit";

		require __DIR__.'/common_paging_inc.php';
		$item_id=$_GET["item_id"];
		$general = $dmGeneralModel->select($_GET["item_id"]);
		$general['journal_date'] = YMDtoDMY($general['journal_date']);

		
		if($tab=='general' ||  $tab=='') {
			require __DIR__.'/../view/edit_inc.php';
		}	
		if($tab=='detail') {
			$arr_detail = $dmGeneralModel->detail_list($_GET["item_id"]);
			if($_GET["irow_id"]<>'') {
				$detail = $dmGeneralModel->detail_select($_GET["irow_id"]);	
				$general['irow_id']  = $detail['irow_id'];
				$general['chart_code'] = $detail['chart_code'];
				$general['chart_name'] = $detail['chart_name'];
				$general['description'] = $detail['description'];
				$general['amount'] = $detail['amount'];
			}
			require __DIR__.'/../view/list_detail_inc.php';

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
					$general['journal_date'] = YMDtoDMY($general['journal_date']);
					require __DIR__.'/../view/edit_inc.php';
	
			} 
			else {
				$general = $_POST['general'] ;
				require __DIR__.'/../view/edit_inc.php';
			}
		}
		
		
		break;


	case "detail_update";
	
		require __DIR__.'/common_paging_inc.php';
		$item_id = $_GET["item_id"];	
		$general = $_POST['general'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
			$vlValidation = new detail_validation('update',$dmGeneralModel);
				if($vlValidation->ValidateFormActionUpdate($item_id, $general)) {
					$void=$dmGeneralModel->detail_update($item_id, $_POST['general']);
					$void=$dmGeneralModel->detail_posting_update($item_id);
					$general = $dmGeneralModel->select($item_id);
					$general['journal_date'] = YMDtoDMY($general['journal_date']);
					$arr_detail = $dmGeneralModel->detail_list($_GET["item_id"]);
					$deleteaction='';
					require __DIR__.'/../view/list_detail_inc.php';
	
			} 
			else {
				$general = $_POST['general'] ;
				$detail = $_POST['detail'] ;
				$arr_detail = $dmGeneralModel->detail_list($_GET["item_id"]);
				require __DIR__.'/../view/list_detail_inc.php';
			}
		}
		
		
		
		break;

		
	case "journal_entry_excel_generate";
	
		require __DIR__.'/common_paging_inc.php';
		$item_id = $_GET["item_id"];	
		$general = $dmGeneralModel->select($_GET["item_id"]);
		$general['journal_date'] = YMDtoDMY($general['journal_date']);
		$arr_detail = $dmGeneralModel->detail_list($_GET["item_id"]);
		require __DIR__."'/../excel/journal_entry_excel_generate_inc.php";				
	
		break;
	
		
		
	case "getchartcode";
		$chart_code = $_GET["chart_code"];	
		$arr_chart = $dmGeneralModel->chart_list($chart_code);
		$chart_name ='';
		foreach ($arr_chart as $arr_chart): 
			$chart_name =$arr_chart['chart_name'];
		endforeach; 	
		echo $chart_name;
		
		break;


	case "list_chart";
		$arr_chart = $dmGeneralModel->chart_listall();
		require __DIR__.'/../view/list_chart_inc.php';
		
		break;
		
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$dmGeneralModel = $dmGeneralModel->close();  
?>