<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
$json_search_items = json_decode($json_searchphrase, true);
?>
		<div class="bodyContent sideBarExist breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
				<?php require __DIR__.'/navigation_menu_inc.php'; ?>
				</div>
				<div class="sidebar" id="MainMenuDiv">
				<?php require __DIR__.'/left_menu_inc.php'; ?>
				</div>
				<?php 
				$arr_count_general_model = count($arr_general_model);
				$ifound_record = 0;
				if ($arr_count_general_model >0) $ifound_record = $paging->getRecordCount();
				?>
				<div class="sidebarContent" id="SubMenuDiv">
					<div class="sidebarContentCol" id="TransactionsDiv">
						<span class="menu_group_headers"><span>Total Record Found: <?php echo $ifound_record;?></span></span>
						<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
								<th style="text-align:left" width ="3%'"><?php echo _t("No");?></th>
								<th style="text-align:left" width ="8%'">Journal Date</th>
								<th style="text-align:left" width ="8%'">Journal Code</th>
								<th style="text-align:left" width ="12%'">Chart Code</th>
								<th style="text-align:left" width ="">Chart Name/Description</th>
								<th style="text-align:right" width ="10">Amount</th>
								<th style="text-align:left" width ="6%'">Posting</th>
								<th style="text-align:left" width ="3%'">Year<br>End</th>
								<th  style="text-align:left" width="8%">Last Update</th>
								<th style="text-align:left" width ="6%">Status</th>
								</tr>
								<?php
								if ($arr_count_general_model >0){
									$i_count=1+($page-1)*SYSTEM_PAGE_ROW_LIMIT;
									$last_id = 0;
									foreach ($arr_general_model as $general_model): 
										if ($general_model['status']==1)  echo '<tr>';
										if ($general_model['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$i_count++.'</td>';
										echo '<td>';
										
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
												echo YMDtoDMY($general_model['journal_date']);
											} else {
												echo '&nbsp;';
										}										
										echo '</td>';
										echo '<td>';
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
												echo '<a href="'.actionURL('edit','?item_id='.$general_model[$dmGeneralModel->primary_keyname()].'&lot_id='.$lot_id.'&page='.$page).'">'.htmlspecialchars($general_model['journal_code']).'&nbsp;'.'&raquo;'.'</a>';
											} else {
												echo '&nbsp;';
										}
										echo '</td>';
										echo '<td>'.htmlspecialchars($general_model['chart_code']).'</td>';
										echo '<td>'.htmlspecialchars($general_model['chart_name']).'<br>'.htmlspecialchars($general_model['description']).'</td>';
										echo '<td style="text-align:right">';
										//if($general_model['amount']>0) echo '<font color="red">';
										
										if($general_model['amount']<0) echo '<p style="color:red">';
										echo number_format($general_model['amount'],2);
										if($general_model['amount']<0) echo '</p>';
										echo '</td>';
										echo '<td>';		
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
											if($general_model['posting_is']==0) echo '<p style="color:red">';
											switch($general_model['posting_is']) {
												case "0": echo "Opening"; break;
												case "1": echo "Posted"; break;
											};
											if($general_model['posting_is']==0) echo '</p>';											
											} else {
												echo '&nbsp;';
										}										
										echo '</td>';


										echo '<td>';		
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
												switch($general_model['year_end_is']) {
													case "0": echo "No"; break;
													case "1": echo "Closed"; break;
												};
											} else {
												echo '&nbsp;';
										}										
										echo '</td>';


										echo '<td>';		
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
												echo toDMY($general_model['modify_datetime']);	

											} else {
												echo '&nbsp;';
										}										
										echo '</td>';


										

										echo '<td>';		
										if($last_id <> $general_model[$dmGeneralModel->primary_keyname()]) {
											switch($general_model['status']) {
												case "1": echo "Active"; break;
												case "0": echo "De-active"; break;
											};
											} else {
												echo '&nbsp;';
										}										
										echo '</td>';


										echo '</tr>';
										
										$last_id =  $general_model[$dmGeneralModel->primary_keyname()] ;
	
									endforeach; 	
								}
								?>	
							</tbody>
						</table>
						<span class="pagination">
						<?php 
						if ($arr_count_general_model >0){
							
							if($paging->getTotalPages()>1) { 
								if($page >1 ){
									echo '<a href="'.actionURL('search','?lot_id='.$lot_id.'&page='.($page-1)).'" class="pageResults">'.'&lt;&lt;</a>';
								}
							}
							echo PHP_EOL;
							for($x = 1; $x <= $paging->getTotalPages(); $x++): 
								echo PHP_EOL;
								if($x == $page ){
									echo '<span class="pageResults pageResultsActive">'.$x.'</span>';
									}else {
										echo '<a href="'.actionURL('search','?lot_id='.$lot_id.'&page='.$x).'" class="pageResults">'.$x.'</a>';
										}
								endfor; 


							if($paging->getTotalPages()>1) { 
								if($page < $paging->getTotalPages() ){
									echo '<a  href="'.actionURL('search','?lot_id='.$lot_id.'&page='.($page+1)).'" class="pageResults">'.'&gt;&gt;</a>';
								}
							}
							
							echo PHP_EOL;
							
						}	//if ($arr_count_general_model >0){
						?>
						
						
						

						</span>
					</div>
				</div>
			</div>
		</div>

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		