<?php
require_once __DIR__.'/../app/config_core.php';

header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter("must-revalidate");
session_start();



$pageURL = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
$url = $_SERVER["REQUEST_URI"];

//Parse URL 
$parsed_url=parse_url($url);
$sub_folder = explode('/',$parsed_url['path']);
$max=count($sub_folder);
$UrlOffset = (trim($sub_folder[1])=='index.php') ? 1 : 0;

$IS_portal= isset($sub_folder[($UrlOffset+1)]) ? $sub_folder[($UrlOffset+1)] : 'NOTDEFINE';
$IS_portal= ($IS_portal=='NOTDEFINE' || $IS_portal=='') ? 'erp' : $IS_portal;  //set default

DEFINE('IS_PORTAL', $IS_portal);   //set constant for sub module 

//Add new case for any new portal 
switch(IS_PORTAL)
{
	case "erp";
		require __DIR__.'/../app/'.IS_PORTAL.'/'.IS_PORTAL.'_routing.php';
			break;			
	case "test";
		require __DIR__.'/../app/'.IS_PORTAL.'/'.IS_PORTAL.'_routing.php';
			break;
	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

?>