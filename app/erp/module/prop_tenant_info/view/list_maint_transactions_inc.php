<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if(isset($paging)) $page =$paging->CalcuatePageNo($item_id,SYSTEM_PAGE_ROW_LIMIT);
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>
					<?php
					if(isset($page)) echo '<a href="'.actionURL('search','?lot_id='.$lot_id.'&page='.$page).'">Search Result</a>';
					echo ' &raquo; ';
					echo 'Edit ';
					?>				
					<div class="pagingNavigation">
						<?php
						if(isset($paging)) {
							if($paging->getPrev_ID($item_id)<>""){
								echo '<a href= "'.actionURL('edit','?item_id='.$paging->getPrev_ID($item_id).'&lot_id='.$lot_id).'" class="commonTextBtn">&lt;&lt;</a>';
							}
								echo '<span class="pageMessage">';
								if (isset($paging)) echo "Record: ".$paging->getCurrentRow($item_id)." of ".$paging->getRecordCount(); 
								echo '</span>';
							
							if($paging->getNext_ID($item_id)<>""){
								echo '<a href= "'.actionURL('edit','?item_id='.$paging->getNext_ID($item_id).'&lot_id='.$lot_id).'" class="commonTextBtn">&gt;&gt;</a>';
							}
						} //if(isset($page))  
						?>
					</div>
				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<div class="fullWidthContent" style="padding-bottom: 0;">
							<span class="contentRow">
							<?php require 'edit_tab_inc.php'; ?>
							</span>
							<span class="contentRow">
							</span>
						</div>

						
						<?php
						if(isset($vlValidation)) {
							if($vlValidation->getProblemMsg()<>'') {
								echo '<span class="alertMsg errorMsg">';
								echo $vlValidation->getProblemMsg();
								echo 'Record not save !';
								echo '</span>';
							} else {
								echo '<span class="alertMsg successMsg">';
								echo 'Update successfully.';
								echo '</span>';
								}
						}	
						?>						

							<span class="formRow formRow-2col">
								<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
										<th style="text-align:left" width ="5%'"><?php echo _t("No");?></th>
										<th style="text-align:left"  width ="12%'">Invoice Date</th>
										<th style="text-align:left"  width ="8%'">Invoice No.</th>
										<th style="text-align:left"  width ="12%'">Period From</th>
										<th style="text-align:left"  width ="12%'">Period To</th>
										<th style="text-align:right"  width ="10%'">Bill Amount</th>
										<th style="text-align:right"  width ="10%'">Bill Balance</th>
										<th style="text-align:left" width ="10%">Status</th>			
										</tr>

										<?php
											$balance = 0;
											$i_count=1;
											foreach ($arr_maint_transactions as $maint_transaction): 
												if ($maint_transaction['status']==1) {
													$balance +=$maint_transaction['balance'];
													}	
													
												if ($maint_transaction['status']==1)  echo '<tr>';
												if ($maint_transaction['status']==0)  echo '<tr style="background: #D1D0CE;">';
	
												echo '<td style="text-align:left" >'.$i_count++.'</td>';
												
												echo '<td style="text-align:left">';
												echo YMDtoDMY($maint_transaction['inv_date']);
												echo '</td>';														
												echo '<td style="text-align:left">';
												echo $maint_transaction['inv_code'];
												echo '</td>';											
												
												echo '<td style="text-align:left">';
												echo YMDtoDMY($maint_transaction['period_date_from']);
												echo '</td>';														
												echo '<td style="text-align:left">';
												echo YMDtoDMY($maint_transaction['period_date_to']);
												echo '</td>';																									echo '<td style="text-align:right">';
												echo number_format($maint_transaction['amount'],2);
												echo '</td>';		
												
												echo '<td style="text-align:right">';
												echo number_format($maint_transaction['balance'],2);
												echo '</td>';
				
												echo '<td>';	
												switch($maint_transaction['status']) {
												case "1": echo "Active"; break;
												case "0": echo "De-active"; break;
												};
												echo '</td>';


												echo '</tr>';
											endforeach; 	

											
											
												echo '<tr>';
													echo '<td>'.'&nbsp;'.'</td>';
													echo '<td>'.'&nbsp;'.'</td>';
													echo '<td>'.'&nbsp;'.'</td>';
													echo '<td>'.'&nbsp;'.'</td>';
													echo '<td>'.'&nbsp;'.'</td>';
													echo '<td style="text-align:right">'.'Balance:'.'</td>';
													echo '<td style="text-align:right">';
													if($balance<>0) echo '<p style="color:red">';
													echo number_format($balance,2);
													if($balance<>0) echo '</p>';							echo '</td>';
													echo '<td>'.'&nbsp;'.'</td>';
												echo '</tr>';
											
										?>	
										
									<tbody>
								</table>
							</span>	
										


							
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>


							
							
							

					</div>
				</div>
			</div>
		</div>

  	
  		
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		