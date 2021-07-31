<?php
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/sys_network_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('SYS-TRAN-01-010');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';	

$dmNetwork = new sys_network_model();  //Open database connection
		
switch($IS_action)
{
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;
		
		
	case "new";
		require __DIR__.'/../view/new_inc.php';
		break;		

		
	case "create";

		$network = $_POST['network'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new sys_network_validation('create',$dmNetwrok);
			if($vlValidation->ValidateForm($_POST['network'])) {
				$last_insert_id=$dmNetwork->create($_POST['network'],$_SESSION["sUserID"]);
				$arr_network = $dmNetwork->find($last_insert_id);
				foreach ($arr_network as $network): 
				endforeach;
				require __DIR__.'/../view/edit_inc.php';
			} else {
				require __DIR__.'/../view/new_inc.php';
			}	
		}
		
		break;				
		
	
	case "edit";
	
		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];		
		$result_id=$dmNetwork->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_network = $dmNetwork->find($item_id);
		foreach ($arr_network as $network): 
		endforeach;
		require __DIR__.'/../view/edit_inc.php';
		break;
		
		
	case "update";

		require __DIR__.'/common_paging_inc.php';
		$item_id = $_GET["item_id"];	
		$general = $_POST['general'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new sys_network_validation('update',$dmNetwrok);
				if($vlValidation->ValidateForm2($_POST['network'])) {
					$void=$dmNetwork->update($_POST['network'],$_SESSION["sUserID"],$item_id);
					$arr_network = $dmNetwork->find($item_id);
					foreach ($arr_network as $network): 
					endforeach;
					require __DIR__.'/../view/edit_inc.php';
	
			} 
			else {
				$network = $_POST['network'];
				require __DIR__.'/../view/edit_inc.php';
			}
		}
		break;
		
		
		
	case "search";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmNetwork->search($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmNetwork->searchphrase($lot_id);
		}
				$result_id=$dmNetwork->paging_config($lot_id);
				$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		
				if ($result_id != ''){
				$arr_network=$dmNetwork->retreive_content($lot_id,$page);
				} else {
				$arr_network=array();
				}
			
				require __DIR__."'/../view/search_result_inc.php";				
		
		break;	
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$dmNetwork = $dmNetwork->close();  //Close database connection


?>


