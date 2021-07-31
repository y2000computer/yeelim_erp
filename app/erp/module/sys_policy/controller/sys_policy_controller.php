<?php
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/sys_policy_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('SYS-TRAN-01-005');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';		

$dmPolicy = new sys_policy_model();  //Open datatabase connection
		
switch($IS_action)
{
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;
		
		
	case "new";
		require __DIR__.'/../view/new_inc.php';
		break;		

		
	case "create";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new sys_policy_validation('checkduplicatepolicy',$dmPolicy);
			$policy = $_POST['policy'];
			if($vlValidation->ValidateForm($_POST['policy'])) {
				$eng_name = $policy['eng_name'];
				$duplicate = $dmPolicy->checkduplicatepolicy($eng_name);
				$duplicate = (int)$duplicate;
				if($duplicate == 1){ //duplicate found, exit
					require __DIR__.'/../view/new_inc.php';
				}	else {	

			$sUserID = $_SESSION["sUserID"];
			$last_insert_id=$dmPolicy->create($policy['eng_name'],$policy["status"],$sUserID);
			$arr_policy = $dmPolicy->find($last_insert_id);
			require __DIR__.'/../view/create_inc.php';
			}			
		}
		else {			
			$policy = $_POST['policy'];
			require __DIR__.'/../view/new_inc.php';
			}
		} 
		break;
		
		
	case "add_module_to_policy";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$policy = $_POST['policy'];
			$policy_id = $policy['policy_id'];
			$page = $policy['page'];
			$item_id = $policy['item_id'];
			$lot_id = $policy['lot_id'];
			
			$module_code = $policy['module_code'];
			$rights_level = $policy['rights_level'];
			$rights_create = $policy['rights_create'];
			$rights_update = $policy['rights_update'];
			$rights_void = $policy['rights_void'];
			$status = $policy['status'];
			$vlValidation = new sys_policy_validation('check_module_code',$dmPolicy);
			if($vlValidation->check_module_code($_POST['policy'])) {
				$dmPolicy->attachmoduletopolicy($policy_id,$module_code,$rights_level,$rights_create,$rights_update,$rights_void,$status,$_SESSION["sUserID"]);
		} 
		$result_id=$dmPolicy->paging_config($lot_id);
	
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_policy = $dmPolicy->find($policy_id);
		$arr_policy_module = $dmPolicy->find_policy_module($policy_id);
		$arr_policy_module_status = $dmPolicy->policy_status_module_list_all($policy_id);

			require __DIR__.'/../view/edit_inc.php';		
				break;	
		
		} 
		break;	

		
	case "edit_policy_module";
		$page = $_GET['page'];
		$lot_id = $_GET['lot_id'];
		$item_id = $_GET['item_id'];
		$irow_id = $_GET['irow_id'];
		$arr_policy = $dmPolicy->findby_policy_module($irow_id);
		require __DIR__.'/../view/edit_policy_module_inc.php';
		break;		

		
	case "update_policy_module";

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
						
			$policy = $_POST['policy'];
			$irow_id = $policy['irow_id'];
			$policy_id = $policy['policy_id'];
			$module_code = $policy['module_code'];
			$rights_level = $policy['rights_level'];
			$rights_create = $policy['rights_create'];
			$rights_update = $policy['rights_update'];
			$rights_void = $policy['rights_void'];
			$status = $policy['status'];
		
			$dmPolicy->updatemoduletopolicy($irow_id,$policy_id,$module_code,$rights_level,$rights_create,$rights_update,$rights_void,$status,$_SESSION["sUserID"]);
						
			$lot_id=$_GET["lot_id"];
			$item_id=$_GET["item_id"];	
			$page=$_GET["page"];						
					
			$result_id=$dmPolicy->paging_config($lot_id);
	
			$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);		
			$arr_policy = $dmPolicy->find($item_id);
			$arr_policy_module = $dmPolicy->find_policy_module($item_id);
			$arr_policy_module_status = $dmPolicy->policy_status_module_list_all($item_id);
	
			//require __DIR__.'/../view/edit_policy_module_success_inc.php';		
			require __DIR__.'/../view/edit_inc.php';
				break;			
		} 
		break;			

		

	case "edit";
	
		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];	
		
		$result_id=$dmPolicy->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_policy = $dmPolicy->find($item_id);
		$arr_policy_module = $dmPolicy->find_policy_module($item_id);
		$arr_policy_module_status = $dmPolicy->policy_status_module_list_all($item_id);
		require __DIR__.'/../view/edit_inc.php';
		break;
		
		
	case "update_policy";
	
		$lot_id = $_GET["lot_id"];
		$item_id = $_GET["item_id"];	
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new sys_policy_validation('update_policy',$dmPolicy);
				if($vlValidation->ValidateForm($_POST['policy'])) {
					$result_id=$dmPolicy->paging_config($lot_id);
					$last_insert_id=$dmPolicy->update_policy($_POST['policy'],$_SESSION["sUserID"],$item_id);
					$arr_policy = $dmPolicy->find($item_id);
					require __DIR__.'/../view/updated_policy_inc.php';
				} 
				else {

				$lot_id=$_GET["lot_id"];
				$item_id=$_GET["item_id"];	
				$result_id=$dmPolicy->paging_config($lot_id);
				$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
				$arr_policy = $dmPolicy->find($item_id);
				$arr_policy_module = $dmPolicy->find_policy_module($item_id);
				$arr_policy_module_status = $dmPolicy->policy_status_module_list_all($item_id);
				require __DIR__.'/../view/edit_inc.php';
			}
		} else{
				$lot_id=$_GET["lot_id"];
				$item_id=$_GET["item_id"];	
				$result_id=$dmPolicy->paging_config($lot_id);
				$arr_policy = $dmPolicy->find($item_id);
				require __DIR__.'/../view/edit_inc.php';
		
		}
		break;
		
		
	case "search";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmPolicy->search_policy($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmPolicy->searchphrase($lot_id);
		}
		$result_id=$dmPolicy->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);

		if ($result_id != ''){
			$arr_policy=$dmPolicy->retreive_content($lot_id,$page);
		} else {
			$arr_policy=array();
		}
		
		require __DIR__."'/../view/search_result_inc.php";				
		break;	
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$dmPolicy = $dmPolicy->close();  //Close database connection


?>


