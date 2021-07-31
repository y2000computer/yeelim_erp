<?php
$module_code_array = array();
$moudule_array = array();
$policy_module = $_SESSION["policy_module"];
$module = explode(",", $policy_module);

$moudule_count = count($module);
///echo $moudule_count;
//print_r($module);
 for($x=0; $x<$moudule_count; $x++){
 	 $result = $module[$x];
	 $module_result = explode("-", $result);
 $module_code_array[] = $module_result[0];
 }
// print_r($module_code_array);
echo '<DIV id="MainMenuDiv">

<UL>
  <LI class="main_menu_selected">System Security Policy </LI>';
  /*
if(in_array("PUR", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_network/">'.'Search Network'.'</a></LI>';
}
if(in_array("PUR", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_network/adv_search_network">'.'Advance Search'.'</a></LI>';
*/
if(in_array("SYS", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_policy/new">Add Policy</a></LI>';
}

echo '</UL></DIV>';
?>
