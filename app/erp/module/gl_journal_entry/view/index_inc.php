<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='/') {
	$json_search_items =array();
	$time = strtotime(date("Y/m/d"));
	//$json_search_items['general']['journal_date_from']  = date("d/m/Y", strtotime("-3 month", $time));
	$json_search_items['general']['journal_date_from']  = date("d/m/Y", strtotime("-12 month", $time));
	$json_search_items['general']['journal_date_to'] =  date('d/m/Y') ;
}
?>
		<div class="bodyContent sideBarExist breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
				<?php require __DIR__.'/navigation_menu_inc.php'; ?>
				</div>
				<div class="sidebar" id="MainMenuDiv">
				<?php require __DIR__.'/left_menu_inc.php'; ?>
				</div>
				<div class="sidebarContent" id="SubMenuDiv">
					<div class="sidebarContentCol" id="TransactionsDiv">
						</span>
					</div>
				</div>
			</div>
		</div>
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		