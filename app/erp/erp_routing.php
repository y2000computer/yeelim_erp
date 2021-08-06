<?php
require_once __DIR__.'/erp_config.php';  
require_once __DIR__.'/erp_autoload_config.php';  
require_once __DIR__.'/func/framework_func.php';
require_once __DIR__.'/func/date_func.php';
require_once __DIR__.'/func/sql_func.php';
require_once __DIR__.'/func/string_func.php';
require_once __DIR__.'/func/translate_func.php';  //using _t(..) to tranlate different language preference


$IS_lang= isset($sub_folder[($UrlOffset+2)]) ? $sub_folder[($UrlOffset+2)] : 'NOTDEFINE';
$IS_lang= ($IS_lang=='NOTDEFINE') ? DEFAULT_LANGUAGE : $IS_lang;   //set default

$IS_module= isset($sub_folder[($UrlOffset+3)]) ? $sub_folder[($UrlOffset+3)] : 'NOTDEFINE';
$IS_module= ($IS_module=='NOTDEFINE') ? 'sys_security' : $IS_module;   //set default

DEFINE('IS_LANG', $IS_lang);   //set constant for sub module 
DEFINE('IS_MODULE', $IS_module); //set constant for sub module 

////Add new case for any new module
switch(IS_MODULE)
{


	case "home";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
		break;

/*********************************************GL***********************************/						
	case "gl_home";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_journal_entry";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
			

/*********************************************GL Report******************************/						
	case "gl_report_chart";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_report_journal_entry";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_report_general_ledger";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_report_trial_balance";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_report_profit_loss";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_report_balance_sheet";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
		
		
/*********************************************GL Maintenance*************************/						
	case "gl_chart_master";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;
	case "gl_year_end";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;

		
		
/*********************************************SYSTEM***********************************/			
	case "sys_home";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;				
	case "sys_security";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;				
	case "sys_user";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;	
	case "sys_policy";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;		
	case "sys_network";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;	

	case "sys_company_master";
		require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
			break;	


/*********************************************PROP***********************************/						
case "prop_home";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
case "prop_tenant_info";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
case "prop_rent_inv";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
case "prop_rent_payment";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_maint_inv";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_maint_payment";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;


/*********************************************PROP Report******************************/		
	case "prop_report_tenant_info";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_report_rent_inv";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_report_rent_payment";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_report_maint_inv";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	case "prop_report_maint_payment";
require __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';
	break;
	
	
	
				
			
		


			
/* Schedule Job */
/* Schedule Job */
			
/* One off Used */
/* One off Used */

/* test Used */
/* test Used */

	default:
		$sNewLog = new LoggerManager( "error_routing", "1" );
		$sNewLog -> add( "ERP Routing:Module not found" );
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}
?>