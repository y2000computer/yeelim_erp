<?php
if(!isset($_SESSION['security']['sUserID'])) {
	header('Location: '.loginURL()); 
	exit();
}
if(isset($_GET['mode'])) {
	if($_GET['mode']=='debug') {
		echo "<font color = grey>";
		echo "******DEBUG MODE*********";
		echo "<br>";
		echo $_SESSION["source_ip"];
		echo "<br>";
		echo $_SESSION["browser_type"];
		echo "<br>";
		echo $_SESSION["url"];
		echo "<br>";
		echo $_SESSION["sUserID"];
		echo "<br>";
		echo $_SESSION["last_visit_date"];
		echo "<br>";echo "<br>";
		echo $_SESSION["policy_module"];
		echo "<br>";
		echo "<br>";
		echo $_SESSION["sUserID"];
		echo "<br>";
		echo $_SESSION["page"];
		echo "<br>";
		echo $_SESSION["cust_id_list"];
		echo "<br>";
		echo "******DEBUG MODE*********";
		echo "</font>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
	}
}
function module_array(){

	$policy_module = $_SESSION["policy_module"];
	$module_code_array = array();
	$module = explode(",", $policy_module);
	$module_array=array_map('trim',$module);  //trim array empty space

	$moudule_count = count($module_array);
	 for($x=0; $x<$moudule_count; $x++){
		  $module_code_array[] = $module_array[$x];
	 }

	return $module_code_array;
}
?>