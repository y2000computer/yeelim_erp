<?php
require __DIR__.'/../../../func/controller_func.php';
require __DIR__.'/../validation/sys_user_validation.php';

$checkaccess =  new checkaccess_model(); 
list($allow,$level,$add,$change,$delete) = $checkaccess->checkRight('SYS-TRAN-01-001');
if($allow == 0) require __DIR__.'/../../../template/sorry_inc.php';		


$dmUser = new sys_user_model();  //Open datatabase connection
$arr_department_all = $dmUser->department_all();


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

			$vlValidation = new sys_user_validation('create',$dmUser);
			$user = $_POST['user'];
			if($vlValidation->ValidateFormActionCreate($user)) {				
				$email = $user['email'];
				$duplicate = $dmUser->checkduplicatepolicy($email);
				$duplicate = (int)$duplicate;
				if($duplicate == 1){ //duplicate found, exit
					require __DIR__.'/../view/new_inc.php';
				}	else {	

			$sUserID = $_SESSION["sUserID"];
			$last_insert_id=$dmUser->create($user['email'],$user['password'],$user['last_name'],$user["first_name"],$user['depart_code'],$user['status'],$sUserID);
			$arr_user = $dmUser->find($last_insert_id);

			require __DIR__.'/../view/create_inc.php';
			}			
				}
				else {	
					$user = $_POST['user'];
					require __DIR__.'/../view/new_inc.php';
			}
		} 
		break;
		
		
	case "edit_user";
	
		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];	
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_user = $dmUser->find($item_id);
		$arr_user_policy = $dmUser->find_user_policy($item_id);
		$arr_user_policy_status = $dmUser->user_status_policy_list_all($item_id);

		require __DIR__.'/../view/edit_user_inc.php';
		break;
		
			
				
	case "add_policy";

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];	
		
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$policy_m = $_POST['policy_m'];
			$policy_select = $policy_m['policy_select'];
	
			$dmUser->add_policy($policy_select,$_SESSION["sUserID"],$item_id);
	
			$arr_user_policy = $dmUser->user_policy($item_id);
			$arr_user_network = $dmUser->user_network($item_id);
			$arr_ava_policy = $dmUser->user_ava_policy($item_id);
			$arr_ava_network = $dmUser->user_ava_network($item_id);
			$arr_user_company = $dmUser->user_company($item_id);
			$arr_ava_company= $dmUser->user_ava_company($item_id);
			$result_id=$dmUser->paging_config($lot_id);
			$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
			$arr_user = $dmUser->find($item_id);
			require __DIR__.'/../view/edit_user_inc.php';
			} else {
					$user = $dmUser->findby($IS_para_id);
					require __DIR__.'/../view/create_inc.php';
		}
		break;
		
			

	case "add_network";

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];	
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$network = $_POST['network'];
			$network_select = $network['network_select'];
	
			$dmUser->add_network($network_select,$_SESSION["sUserID"],$item_id);
			$arr_user_policy = $dmUser->user_policy($item_id);
			$arr_user_network = $dmUser->user_network($item_id);
			$arr_ava_policy = $dmUser->user_ava_policy($item_id);
			$arr_ava_network = $dmUser->user_ava_network($item_id);
			$arr_user_company = $dmUser->user_company($item_id);
			$arr_ava_company= $dmUser->user_ava_company($item_id);
			$result_id=$dmUser->paging_config($lot_id);
			$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
			$arr_user = $dmUser->find($item_id);

			require __DIR__.'/../view/edit_user_inc.php';
		

		} else {
				$user = $dmUser->findby($IS_para_id);
				require __DIR__.'/../view/create_inc.php';
		}
		break;		
		
	case "edit";
	
		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];		
		
		$arr_user_policy = $dmUser->user_policy($item_id);
		$arr_user_network = $dmUser->user_network($item_id);
		$arr_ava_policy = $dmUser->user_ava_policy($item_id);
		$arr_ava_network = $dmUser->user_ava_network($item_id);
		$arr_user_company = $dmUser->user_company($item_id);
		$arr_ava_company= $dmUser->user_ava_company($item_id);
		
		
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_user = $dmUser->find($item_id);
		require __DIR__.'/../view/edit_user_inc.php';
		break;		
		
		
	case "update_user";
	
		$lot_id = $_GET["lot_id"];
		$item_id = $_GET["item_id"];	
		$user = $_POST['user'] ;
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$vlValidation = new sys_user_validation('update_user',$dmUser);
				//if($vlValidation->EditValidateForm($item_id, $_POST['user'])) {
				if($vlValidation->ValidateFormActionUpdate($item_id, $user)) {					
					$result_id=$dmUser->paging_config($lot_id);
					$last_insert_id=$dmUser->update_user($_POST['user'],$_SESSION["sUserID"],$item_id);
					$arr_user = $dmUser->find($item_id);
		
			require __DIR__.'/../view/updated_user_inc.php';
	
			} 
			else {
			

				$lot_id=$_GET["lot_id"];
				$item_id=$_GET["item_id"];	
				$result_id=$dmUser->paging_config($lot_id);
				$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
				$arr_user = $dmUser->find($item_id);
				
				$arr_user_policy = $dmUser->user_policy($item_id);
				$arr_user_network = $dmUser->user_network($item_id);
				$arr_ava_policy = $dmUser->user_ava_policy($item_id);
				$arr_ava_network = $dmUser->user_ava_network($item_id);
				$arr_user_company = $dmUser->user_company($item_id);
				$arr_ava_company= $dmUser->user_ava_company($item_id);

		

		require __DIR__.'/../view/edit_user_inc.php';
			}
		} else{
				$lot_id=$_GET["lot_id"];
				$item_id=$_GET["item_id"];	
				$result_id=$dmUser->paging_config($lot_id);
				$arr_user = $dmUser->find($item_id);
		require __DIR__.'/../view/edit_inc.php';
		
		}
		break;

	case "updatePVTnetworkstatus";

		$network_grant_id = $_GET["network_grant_id"];
		$network_grant_status = $_GET["network_grant_status"];	
	
		$user = $dmUser->updatePVTnetworkstatus($network_grant_id,  $network_grant_status);

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];

		$arr_user_policy = $dmUser->user_policy($item_id);
		$arr_user_network = $dmUser->user_network($item_id);
		$arr_ava_policy = $dmUser->user_ava_policy($item_id);
		$arr_ava_network = $dmUser->user_ava_network($item_id);
		$arr_user_company = $dmUser->user_company($item_id);
		$arr_ava_company= $dmUser->user_ava_company($item_id);
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_user = $dmUser->find($item_id);
		require __DIR__.'/../view/edit_user_inc.php';
		break;	

	case "updatePVTpolicystatus";

		$policy_grant_id = $_GET["policy_grant_id"];
		$policy_grant_status = $_GET["policy_grant_status"];				

		$user = $dmUser->updatePVTpolicystatus($policy_grant_id, $policy_grant_status);

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];		
		
		$arr_user_policy = $dmUser->user_policy($item_id);
		$arr_user_network = $dmUser->user_network($item_id);
		$arr_ava_policy = $dmUser->user_ava_policy($item_id);
		$arr_ava_network = $dmUser->user_ava_network($item_id);
		$arr_user_company = $dmUser->user_company($item_id);
		$arr_ava_company= $dmUser->user_ava_company($item_id);
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_user = $dmUser->find($item_id);
		require __DIR__.'/../view/edit_user_inc.php';
		break;			


	case "edit_user_return";

		$arr_department_all = $dmUser->department_all();
		$arr_user_policy = $dmUser->user_policy($IS_para_id);
		$arr_user_network = $dmUser->user_network($IS_para_id);
		$arr_ava_policy = $dmUser->user_ava_policy($IS_para_id);
		$arr_ava_network = $dmUser->user_ava_network($IS_para_id);
		$arr_user_company = $dmUser->user_company($item_id);
		$arr_ava_company= $dmUser->user_ava_company($item_id);

		$user = $dmUser->findby($IS_para_id);
		require __DIR__.'/../view/edit_user_inc.php';
		break;
		
		
	case "search";
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$page=1;
				$json_searchphrase = json_encode($_POST);	
				$lot_id=$dmUser->search($json_searchphrase);
		} else {
				$lot_id=$_GET["lot_id"];
				$page=$_GET["page"];		
				$json_searchphrase = $dmUser->searchphrase($lot_id);
		}
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		if ($result_id != ''){
		$arr_user=$dmUser->retreive_content($lot_id,$page);
		} else {
		$arr_user=array();
		}
		require __DIR__."'/../view/search_result_inc.php";				
		
		break;	
		
		
		
	case "add_company";

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];	
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$company = $_POST['company'];
			$company_select = $company['company_select'];
	
			$dmUser->add_company($company_select,$_SESSION["sUserID"],$item_id);
			$arr_user_policy = $dmUser->user_policy($item_id);
			$arr_user_network = $dmUser->user_network($item_id);
			$arr_ava_policy = $dmUser->user_ava_policy($item_id);
			$arr_ava_network = $dmUser->user_ava_network($item_id);
			$arr_user_company = $dmUser->user_company($item_id);
			$arr_ava_company= $dmUser->user_ava_company($item_id);
			$result_id=$dmUser->paging_config($lot_id);
			$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
			$arr_user = $dmUser->find($item_id);

			require __DIR__.'/../view/edit_user_inc.php';
		

		} else {
				$user = $dmUser->findby($IS_para_id);
				require __DIR__.'/../view/create_inc.php';
		}
		break;		
		

		
	case "updatePVTcompanystatus";

		$company_grant_id = $_GET["company_grant_id"];
		$company_grant_status = $_GET["company_grant_status"];	
	
		$user = $dmUser->updatePVTcompanystatus($company_grant_id,  $company_grant_status);

		$lot_id=$_GET["lot_id"];
		$item_id=$_GET["item_id"];	
		$page=$_GET["page"];

		$arr_user_policy = $dmUser->user_policy($item_id);
		$arr_user_network = $dmUser->user_network($item_id);
		$arr_ava_policy = $dmUser->user_ava_policy($item_id);
		$arr_ava_network = $dmUser->user_ava_network($item_id);
		$arr_user_company = $dmUser->user_company($item_id);
		$arr_ava_company= $dmUser->user_ava_company($item_id);
		$result_id=$dmUser->paging_config($lot_id);
		$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
		$arr_user = $dmUser->find($item_id);
		require __DIR__.'/../view/edit_user_inc.php';
		break;	

		
		
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

$dmUser = $dmUser->close();  //Close database connection


?>


