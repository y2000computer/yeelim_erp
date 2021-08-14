<?php
require_once __DIR__.'../../../env.php';  
require_once __DIR__.'/erp_autoload_config.php';  
require_once __DIR__.'/func/framework_func.php';
require_once __DIR__.'/func/date_func.php';
require_once __DIR__.'/func/sql_func.php';
require_once __DIR__.'/func/string_func.php';
require_once __DIR__.'/func/translate_func.php';  //using _t(..) to tranlate different language 


$IS_lang= isset($sub_folder[($UrlOffset+2)]) ? $sub_folder[($UrlOffset+2)] : 'NOTDEFINE';
$IS_lang= ($IS_lang=='NOTDEFINE') ? DEFAULT_LANGUAGE : $IS_lang;   //set default

$IS_module= isset($sub_folder[($UrlOffset+3)]) ? $sub_folder[($UrlOffset+3)] : 'NOTDEFINE';
$IS_module= ($IS_module=='NOTDEFINE') ? 'sys_security' : $IS_module;   //set default

DEFINE('IS_LANG', $IS_lang);   //set constant for sub module 
DEFINE('IS_MODULE', $IS_module); //set constant for sub module 


$file = __DIR__.'/module/'.IS_MODULE.'/controller/'.IS_MODULE.'_controller.php';

if (file_exists($file))
{
	require $file;

	} else {
		$sNewLog = new LoggerManager( "error_routing", "1" );
		$sNewLog -> add( "ERP Routing:Module not found" );
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		exit;
	}


?>