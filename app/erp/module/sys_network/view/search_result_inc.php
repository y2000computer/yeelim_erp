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
				$arr_count_network = count($arr_network);
				$ifound_record = 0;
				if ($arr_count_network >0) $ifound_record = $paging->getRecordCount();
				?>
				<div class="sidebarContent" id="SubMenuDiv">
					<div class="sidebarContentCol" id="TransactionsDiv">
						<span class="menu_group_headers"><span>Total Record Found: <?php echo $ifound_record;?></span></span>
						<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>

								<th style="text-align:left" width ="5%'"><?php echo _t("No");?></th>
								<th style="text-align:left" >Network Name</th>
								<th style="text-align:left" >Type</th>
								<th style="text-align:left" >Fixed IP</th><th>IP Range From</th>
								<th style="text-align:left" >IP Range To</th>
								<th style="text-align:left" >Network Mask</th>
								<th style="text-align:left" width ="20%">Status</th>							
								
								</tr>

							<?php
							if ($arr_count_network >0){
								$i_count=1+($page-1)*SYSTEM_PAGE_ROW_LIMIT;
								foreach ($arr_network as $network): 
									if ($network['status']==1)  echo '<tr>';
									if ($network['status']==0)  echo '<tr class="deactive">';
									echo '<td>'.$i_count++.'</td>';
									echo '<td>';
									echo '<a href="'.actionURL('edit','?item_id='.$network['network_id'].'&lot_id='.$lot_id.'&page='.$page).'">'.$network['eng_name'].'&nbsp;'.'&raquo;'.'</a>';
									echo '</td>';
									echo '<td>'.$network['net_type'].'</td>';
									echo '<td>'.$network['fixed_ip'].'</td>';
									echo '<td>'.$network['ip_range_from'].'</td>';
									echo '<td>'.$network['ip_range_to'].'</td>';
									echo '<td>'.$network['network_mask'].'</td>';
									echo '<td>';
									switch($network['status']) {
										case "1": echo "Active"; break;
										case "0": echo "De-active"; break;
									};
									echo '</td>';
									echo '</tr>';
								endforeach; 	
							}
							?>								
								
							</tbody>
						</table>
						<span class="pagination">
						<?php 
						if ($arr_count_network >0){
							
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
							
						}	//if ($arr_count_network >0){
						?>
						
						
						

						</span>
					</div>
				</div>
			</div>
		</div>

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		