<?php
//Global Area
DEFINE('PORTAL_NAME', 'Yee Lim ERP Enterprise System');
DEFINE('COPYRIGHT', 'Yee Lim Investment Company Limited.');
DEFINE('DEFAULT_LANGUAGE', 'en-US');
DEFINE('APPLICATION_VERSION', '1.0');
define('DEFAULT_DATE_FORMAT', 'd/m/Y');

//PHP engine setting 
ini_set("magic_quotes_gpc", "0ff");
ini_set("display_errors", "on");
ini_set('error_reporting', E_ALL & ~E_NOTICE); //running on php 7
ini_set('max_file_upload',"20M");
ini_set("max_execution_time","3000");
ini_set("max_input_time","6000");
ini_set("max_input_vars","10000");
ini_set("memory_limit","512M");
ini_set("post_max_size","64M");
ini_set("register_globals","off");
ini_set("session.gc_maxlifetime","600");  //running on php 7
ini_set("date.timezone", "Asia/Hong_Kong");


define('PHOTO_HTTP_HTTPS', 'http://');




?>