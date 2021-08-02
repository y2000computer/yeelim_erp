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
								<span class="menu_group_headers">
									<span>
										Journal Date:
										<?php echo $general['journal_date'];?>
										&nbsp;&nbsp;&nbsp;
										Journal Code :<?php echo htmlspecialchars($general['journal_code']); 
										echo '&nbsp;&nbsp;&nbsp;&nbsp;';
										echo '<a class="commonTextBtn" href="'.actionURL('journal_entry_excel_generate','?item_id='.$item_id.'&lot_id='.$lot_id.'&tab='.$tab.'&deleteaction='.$deleteaction).'" target="_blank">
										Download Journal Entry Excel</a>'; 										
										?>									
									</span>
								</span>
							</span>
						</div>
						<form class="fullWidthForm fullWidthForm-2col" action="<?php echo actionURL('detail_update','?item_id='.$item_id.'&lot_id='.$lot_id.'&tab='.$tab.'&deleteaction='.$deleteaction);?>" method="post" style="padding-top: 0;">

						<input type="hidden" name="general[comp_id]"  value="<?php echo $_SESSION["target_comp_id"];?>" >
						<input type="hidden" name="general[irow_id]"   value="<?php echo $general['irow_id'];?>" />
						<input type="hidden" name="general[deleteaction]"   value="<?php echo $deleteaction;?>" />
						
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
										<th style="text-align:left" width ="8%'">Chart Code</th>
										<th style="text-align:left" width ="15%'">Chart Type</th>
										<th style="text-align:left" width ="20%'">Chart Name</th>
										<th style="text-align:left" >Description</th>
										<th style="text-align:right" width ="10%'">Amount</th>
										<th style="text-align:center" width ="5%">&nbsp;</th>
										</tr>

										<?php
											$balance = 0;
											$i_count=1;
											foreach ($arr_detail as $detail): 
												$balance +=$detail['amount'];
												echo '<tr>';
												echo '<td style="text-align:left" >'.$i_count++.'</td>';
												
												echo '<td style="text-align:left">';
												echo '<a href="'.actionURL('edit','?item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page.'&tab='.$tab.'&irow_id='.$detail['irow_id']).'">'.$detail['chart_code'].'&nbsp;'.'&raquo;'.'</a>';
												echo '</td>';														
												
												echo '<td style="text-align:left" >'.$detail['type_name'].'</td>';
												echo '<td style="text-align:left" >'.$detail['chart_name'].'</td>';
												echo '<td style="text-align:left" >'.htmlspecialchars($detail['description']).'</td>';
												echo '<td style="text-align:right">';
												if($detail['amount']<0) echo '<p style="color:red">';
												echo number_format($detail['amount'],2);
												if($detail['amount']<0) echo '</p>';
												echo '</td>';		
												echo '<td style="text-align:center">';
												echo '<a href="'.actionURL('edit','?item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page.'&tab='.$tab.'&irow_id='.$detail['irow_id'].'&deleteaction='.'yes').'">'.'Delete'.'&nbsp;'.'&raquo;'.'</a>';
												echo '</td>';				
												echo '</tr>';
											endforeach; 	

											
											
												echo '<tr>';
												echo '<td>'.'&nbsp;'.'</td>';
												echo '<td>'.'&nbsp;'.'</td>';
												echo '<td>'.'&nbsp;'.'</td>';
												echo '<td>'.'&nbsp;'.'</td>';
												echo '<td style="text-align:right">'.'Balance:'.'</td>';
												echo '<td style="text-align:right">';
												if($balance<>0) echo '<p style="color:red">';
												echo number_format($balance,2);
												if($balance<>0) echo '</p>';												
												echo '</td>';
												echo '<td>'.'&nbsp;'.'</td>';
												echo '</tr>';
											
										?>	
										
									<tbody>
								</table>
							</span>	
										
							<span class="formRow formRow-2col">
								<span class="formLabel">
									<label class="">Chart Code :</label>
								</span>
								<span class="formInput" style="min-width: 200px; max-width: 200px;">
									<input id="chart_code" type="text"  name="general[chart_code]"  autocomplete="off" class="four" required value="<?php echo htmlspecialchars($general['chart_code']);?>" onkeyup="show_chart_code(this.value)"  />
								</span>
									<a href="javascript:popupwindow('<?php echo actionURL('list_chart','')?>','chart_list',1000,800);"><img border="0" alt="Browse" src="/images/icons/browse.png" onmouseover="this.src='/images/icons/browse_hover.png';"" onmouseout="this.src='/images/icons/browse.png';""></a>									
									&nbsp;&nbsp;
									<label class="">
									Chart Name:  <span id="txt_chart_name"><?php echo $general['chart_name']?></span>									
									</label>
							</span>

					
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Description :</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[description]"  autocomplete="off" class="fifteen" required value="<?php echo htmlspecialchars($general['description']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Amount(+/-) :</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[amount]"  autocomplete="off" class="four" required value="<?php echo htmlspecialchars($general['amount']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>
							
							
							
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>
							

							
							<span class="formRow">
								<span class="formLabel">
								</span>
								<span class="formInput">
								   <?php
										if($general['year_end_is']<>1) { 

											echo '<button type="submit">';
											if($deleteaction=='yes') {
												echo 'DELETE CONFIRM';
											} else {
												echo 'CONFIRM';
											}
											echo '</button>';
										} //if($general['year_end_is']<>1) { 	
								   ?>									
									
								</span>
							</span>

							
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>


							
							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$(document).ready
			(
				function ()
				{
					$(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
				}
			);
		</script>							

		<script>
		function show_chart_code(str) {
			if (str.length == 0) {
				document.getElementById("txt_chart_name").innerHTML = "";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("txt_chart_name").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "<?php echo actionURL('getchartcode','?chart_code=')?>"+str, true);
				xmlhttp.send();
			}
		}
		</script>  	

		<script>
		var newwindow;
		function popupwindow(url, title, w, h)
		{
			var left = (screen.width - w) / 2;
			var top = (screen.height - h) / 4;    
			newwindow=window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
			if (window.focus) {
					newwindow.focus()
				}
		   
		}
		</script>  		
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		