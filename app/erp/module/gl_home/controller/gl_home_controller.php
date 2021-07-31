<?php
require __DIR__.'/../../../func/controller_func.php';

switch($IS_action)
{
	case "/";
		require __DIR__.'/../view/index_inc.php';
		break;

	default:
		header('Status: 404 Not Found');
		echo '<html><body><h1>Page Not Found, Please contact System Support</h1></body></html>';
		break;
}

?>


