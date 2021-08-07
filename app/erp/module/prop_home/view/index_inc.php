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
							<?php
							if(in_array("PROP-TRAN-01-005", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_rent_inv/">'.'Rent Invoice'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-TRAN-01-010", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_rent_payment/">'.'Rent Payment'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>														
							<?php
							if(in_array("PROP-TRAN-01-015", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_maint_inv/">'.'Maint. Invoice'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>			
							<?php
							if(in_array("PROP-TRAN-01-020", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_maint_payment/">'.'Maint. Payment'.'&nbsp;'.'&raquo;'.'</a>';
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

							<?php
							if(in_array("PROP-REPORT-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_tenant_info/">'.'Tenant Information Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-035", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_rent_debit_note/">'.'Rent Debit Note'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>							
							<?php
							if(in_array("PROP-REPORT-01-005", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_rent_inv/">'.'Rent Invoice Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-010", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_rent_payment/">'.'Rent Payment Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-025", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_rent_overdue/">'.'Rent Overdue Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-040", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_maint_debit_note/">'.'Maint. Debit Note'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>							
							<?php
							if(in_array("PROP-REPORT-01-015", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_maint_inv/">'.'Maint. Invoice Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-020", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_maint_payment/">'.'Maint. Payment Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>
							<?php
							if(in_array("PROP-REPORT-01-030", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_report_maint_overdue/">'.'Maint. Overdue Report'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>

							<li class="menu_group_item">&nbsp;</li>
							<li class="menu_group_item">&nbsp;</li>
						</ul>
					</div>
					<div class="sidebarContentCol sidebarContentCol-3 maintenance" id="MaintenanceDiv">
						<ul>
							<li class="menu_group_headers alignCenter theme-blue"><span>Maintenance</span></li>
							<?php
							if(in_array("PROP-MAINT-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_mainten_rent_inv_generation/">'.'Rent Invoice Generation'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</p></li>';
							}
							?>		
							<?php
							if(in_array("PROP-MAINT-01-005", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_mainten_maint_inv_generation/">'.'Maint. Invoice Generation'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</p></li>';
							}
							?>													
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
