<?php



$policy_module = $_SESSION["policy_module"];
$module = explode(",", $policy_module);

$moudule_count = count($module);

 for($x=0; $x<$moudule_count; $x++){
 	 $result = $module[$x];
	 $module_result = explode("-", $result);
 $module_code_array[] = $module_result[0];
 }

echo '<DIV id="MainMenuDiv">

<UL>
  <LI class="main_menu_selected">Main Menu</LI>';
if(in_array("SALE", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sale_home/">'.'Sales'.'</a></LI>';
}
if(in_array("AR", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/ar_home/">'.'Receivables'.'</a></LI>';
}
if(in_array("PUR", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/pur_home/">'.'Purchase'.'</a></LI>';
}
if(in_array("AP", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sh_home/">'.'Payable'.'</a></LI>';
}
if(in_array("IN", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/in_home">'.'Inventory'.'</a></LI>';
}
if(in_array("SH", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sh_home/">'.'Shipping'.'</a></LI>';
}
if(in_array("GL", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_home/">'.'General Ledger'.'</a></LI>';
}
if(in_array("SYS", $module_code_array)){  
echo '<LI class="main_menu_unselected"><a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">'.'System'.'</a></LI>';
 }
echo '</UL>
</DIV>';


?>
