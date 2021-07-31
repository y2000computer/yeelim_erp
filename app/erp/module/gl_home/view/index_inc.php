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
							if(in_array("GL-TRAN-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_journal_entry/">'.'Journal Entry'.'&nbsp;'.'&raquo;'.'</a>';
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
							if(in_array("GL-REPORT-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_chart/">'.'Chart of Account'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>							
							<?php
							if(in_array("GL-REPORT-01-010", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_journal_entry/">'.'Journal Entry'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>														
							<?php
							if(in_array("GL-REPORT-01-020", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_general_ledger/">'.'General Ledger'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>							
							<?php
							if(in_array("GL-REPORT-01-030", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_trial_balance/">'.'Trial Balance'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>														
							<?php
							if(in_array("GL-REPORT-01-040", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_profit_loss/">'.'Profit & Loss'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>																					
							<?php
							if(in_array("GL-REPORT-01-050", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_report_balance_sheet/">'.'Balance Sheet'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</P></li>';
							}
							?>																												
							<li class="menu_group_item"></li>
						</ul>
					</div>
					<div class="sidebarContentCol sidebarContentCol-3 maintenance" id="MaintenanceDiv">
						<ul>
							<li class="menu_group_headers alignCenter theme-blue"><span>Maintenance</span></li>
							<?php
							if(in_array("GL-MAINT-01-001", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_chart_master/">'.'Chart Master'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</p></li>';
							}
							?>
							<?php
							if(in_array("GL-MAINT-01-010", module_array())){ 
							echo '<li class="menu_group_item"><p>';  
							echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_year_end/">'.'Year End'.'&nbsp;'.'&raquo;'.'</a>';
							echo '</p></li>';
							}
							?>							
						</ul>
					</div>
				</div>
			</div>
		</div>




<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
