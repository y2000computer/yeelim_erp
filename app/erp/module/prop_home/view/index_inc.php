<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';
?>

		<div class="bodyContent sideBarExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<?php include __DIR__.'/../../../template/main_left_menu_inc.php'; ?>

				<div class="sidebarContent" id="SubMenuDiv">
					<div class="sidebarContentCol sidebarContentCol-3 transactions" id="TransactionsDiv">
						<ul>
							<li class="menu_group_headers alignCenter theme-blue"><span>Transactions</span></li>
							<?php
							if(in_array("PROP-TRAN-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_tenant_info/">'.'Tenant Information'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
						</ul>
					</div>
					<div class="sidebarContentCol sidebarContentCol-3 inquiries" id="InquiriesDiv">
						<ul>
							<li class="menu_group_headers alignCenter theme-blue"><span>Inquiries and Reports</span></li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
						</ul>
					</div>
					<div class="sidebarContentCol sidebarContentCol-3 maintenance" id="MaintenanceDiv">
						<ul>
							<li class="menu_group_headers alignCenter theme-blue"><span>Maintenance</span></li>
							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>

						</ul>
					</div>
				</div>
			</div>
		</div>




<?php
require __DIR__.'/../../../template/footer_inc.php';
?>