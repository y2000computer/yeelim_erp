<?php

//Environment 
define('ENV', 'UAT');  //define('ENV', 'PROD');


//MySQL Database Connection setting
DEFINE('DB_HOST', 'localhost:3307'); //sam notebook
//DEFINE('DB_HOST', 'localhost');

DEFINE('DB_USERNAME', 'user_uat');
DEFINE('DB_PASSWORD', 'www.291073Ma!');  
DEFINE('DB_DBNAME', 'yeelim_db_erp_uat');

//PDO_MysSQL connection string 
DEFINE('MYSQL_CONNECTION_STRING', ('mysql:host='.DB_HOST.';dbname='.DB_DBNAME));
DEFINE('DB_CONNECTION_STRING', MYSQL_CONNECTION_STRING);

//Error log file setting 
define('DIR_FS_DOCS', __DIR__.'/log');
define('DIR_FS_STORE_LOG_USER', DIR_FS_DOCS . '/users/');

//Debug setting
define('DEBUG_MODE', false);
define('DIR_PUBLIC_HTML', __DIR__.'/../../document');
define('DIR_PUBLIC_UPLOAD', '../document');

//Encryption setting
define('SALT', 'REVAMP'); 
DEFINE('SYSTEM_PAGE_ROW_LIMIT', '50');


//Email setting
$smtp['smtp_server'] = 'mail.hkber.com.hk';
$smtp['smtp_port'] = '25';
$smtp['outgoing_email_address'] = 'do_not_reply@hkber.com.hk';
$smtp['outgoing_email_address_password']  = 'do_not_reply.pwd';
$smtp['fr_email']  = 'do_not_reply@hkber.com.hk';
$smtp['from']  = 'do_not_reply';

//Other
define('DIR_EXCEL_OUTPUT', '/../../../../../document/excel_output/');


?>