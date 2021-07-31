<?php 
//default page redirection, base on menu order and module order
$module_code_array = array();
$moudule_array = array();
$policy_module = $_SESSION["policy_module"];
$module = explode(",", $policy_module);

$moudule_count = count($module);

 for($x=0; $x<$moudule_count; $x++){
 	 $result = $module[$x];
	 $module_result = explode("-", $result);
 $module_code_array[] = $module_result[0];
 }				

 $section = $module_code_array[0];
 if($section == 'SALE'){
 $section_set = 'sale_home';
 }
 if($section == 'AR'){
 $section_set = 'ar_home';
 }
 if($section == 'PUR'){
 $section_set = 'pur_home';
 }
 if($section == 'AP'){
 $section_set = 'ap_home';
 } 
 if($section == 'IN'){
 $section_set = 'in_home';
 }
 if($section == 'SH'){
 $section_set = 'sh_home';
 }
 if($section == 'GL'){
 $section_set = 'gl_home';
 }
 if($section == 'SYS'){
 $section_set = 'sys_home';
 } 
?>
<!DOCTYPE html>
<html lang="us">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo PORTAL_NAME ?></title>

		<meta http-equiv="expires" content="0">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">

		<link href="/css/stylesheet.css" rel="stylesheet">
		<link href="/css/default.css" rel="stylesheet">
		<link href="/css/dialog.css" rel="stylesheet">
		<link href="/css/jquery-ui.css" rel="stylesheet">


		<script language="javascript" type="text/javascript" src="/js/jquery.js.download"></script>
		<script language="javascript" type="text/javascript" src="/js/axios.min.js.download"></script>
		<script language="javascript" type="text/javascript" src="/js/vue.js.download"></script>
		<script language="javascript" type="text/javascript" src="/js/jquery-ui.js.download"></script>
	</head>
	<body>
		<div class="header" id="HeaderDiv">
			<div class="appInfo" id="AppInfoDiv">
				<span class="projectLogo"><?php echo PORTAL_NAME ?></span>
				<a class="menuBtn commonTextBtn" href="<?php echo '/'.IS_PORTAL.'/'.IS_LANG.'/gl_home';?>">Main Menu</a>
				<span class="label" style="color: #f00;">
				<?php if(ENV=='UAT') echo '(UAT)';?>
				</span>
				
			</div>
			<div class="quickMenu" id="QuickMenuDiv">
				<?php 
					echo '<a class="menuBtn commonTextBtn" href="'.actionURLWithModule('view_company','','sys_security').'" ';
					echo 'Target > ';
					echo $_SESSION["target_comp_name"];
					echo '</a>';
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="changePwBtn commonTextBtn" href="<?php echo actionURLWithModule('edit_password','','sys_security');?>">Change password</a>
				<a class="logoutBtn commonTextBtn" href="<?php echo '/'.IS_PORTAL.'/'.IS_LANG.'/sys_security/logout';?>">Logout</a>
			</div>
		</div>
		
