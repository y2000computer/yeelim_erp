<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if(isset($paging)) $page =$paging->CalcuatePageNo($item_id,SYSTEM_PAGE_ROW_LIMIT);
?>
<?php
foreach ($arr_policy as $policy): 
endforeach;
?>
		<link href="/css/userModule.css" rel="stylesheet">

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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('update_policy','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >'; ?>

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
						
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Security Policy Name :</label>
								</span>
								<span class="formInput">
										<input type="text" name="policy[eng_name]" required="required" size="50" value="<?php echo htmlspecialchars($policy['eng_name']);?>" class="twelve"/>
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<select name="policy[status]" required class="three">
									<option value="1" <?php if ($policy['status'] == 1){echo "selected";}?>>Active</option>
									<option value="0" <?php if ($policy['status'] == 0){echo "selected";}?>>De-active</option>
									</select>
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
									<button type="submit">Confirm</button>
								</span>
							</span>
							
							
							
							
							<span class="formRow formRow-2col" style="margin-top: 10px;">
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create User:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $policy['create_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $policy['create_datetime'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update By:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $policy['last_modify_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $policy['last_modify_datetime']; ?></span>
								</span>
							</span>							
							
							
						</form>
					</div>
				</div>



				<div class="sidebarContentWrapper sidebarContentWrapper-3col">
					<div class="sidebarContent">
						<div class="sidebarContentCol">
							<span class="inner_headers inner_headers_fullWidth"><span>Module Prvillege</span></span>
							<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
									<th style="text-align:left" width="3%">No.</th>
									<th style="text-align:left" width="5%">&nbsp;</th>
									<th style="text-align:left" >Module Code</th>
									<th style="text-align:left" >Module Name</th>
									<th style="text-align:left" >Level</th>
									<th style="text-align:left" >Create</th>
									<th style="text-align:left" >Update</th>
									<th style="text-align:left" >Void</th>
									<th style="text-align:left" >Status</th>								
									</tr>
									
									<?php
									$k=1;
									foreach ($arr_policy_module as $policy): 
										if ($policy['status']==1)  echo '<tr>';
										if ($policy['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$k++.'</td>';
										echo '<td style="text-align:center">'.'<a class="commonTextBtn" href="'.actionURL('edit_policy_module','?item_id='.$policy['policy_id'].'&lot_id='.$lot_id.'&page='.$page.'&irow_id='.$policy['irow_id']).'">'.'Edit'.'</a></td>';		
										echo '<td>'.$policy['module_code'].'</td>';
										echo '<td>'.$policy['eng_name'].'</td>';
										echo '<td>'.$policy['rights_level'].'</td>';
										echo '<td>'.($policy['rights_create']==1? 'Yes':'No').'</td>';
										echo '<td>'.($policy['rights_update']==1? 'Yes':'No').'</td>';
										echo '<td>'.($policy['rights_void']==1? 'Yes':'No').'</td>';
										echo '<td>';
										
											switch($policy['status']) {
											case "1": echo "Active"; break;
											case "0": echo "De-active"; break;
										};
										echo '</td>';
										echo '</tr>';

									endforeach; 									
									?>
	
									
									
								</tbody>
							</table>
							<form class="attachPanel" action="<?php echo actionURL('add_module_to_policy',$item_id);?>" method="post">
								<span class="formRow">
									<select name="policy[module_code]" size="10" class="fifteen">
									<?php 
									$x=1;
									foreach ($arr_policy_module_status as $policy_module_select): 
									
										echo '<option value="'.$policy_module_select['module_code'].'"';
											echo '>'.$x++.'. '.$policy_module_select['eng_name'] ;
											echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$policy_module_select['module_code'].")";
											echo '</option>'.chr(13);
									endforeach; 
									?>
									</select>
								</span>
								
							
		
							<span class="formRow">
								<span class="formLabel">
									<label class="">Level(0-100) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="policy[rights_level]" required="required" size="10" value="<?php echo htmlspecialchars($policy['level']);?>" class="two"/>
								</span>
							</span>
			
		
							<span class="formRow">
								<span class="formLabel">
									<label class="">Create Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled1" type="radio" name="policy[rights_create]" value="1" checked="yes">
									<label for="sample_radio_enabled1" class="">Enable</label>
									<input id="sample_radio_disabled1" type="radio" name="policy[rights_create]" value="0">
									<label for="sample_radio_disabled1" class="">Disable</label>
								</span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Update Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled2" type="radio" name="policy[rights_update]" value="1" checked="yes">
									<label for="sample_radio_enabled2" class="">Enable</label>
									<input id="sample_radio_disabled2" type="radio" name="policy[rights_update]" value="0">
									<label for="sample_radio_disabled2" class="">Disable</label>
								</span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Void Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled3" type="radio" name="policy[rights_void]" value="1" checked="yes">
									<label for="sample_radio_enabled3" class="">Enable</label>
									<input id="sample_radio_disabled3" type="radio" name="policy[rights_void]" value="0">
									<label for="sample_radio_disabled3" class="">Disable</label>
								</span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled4" type="radio" name="policy[status]" value="1" checked="yes">
									<label for="sample_radio_enabled4" class="">Active</label>
									<input id="sample_radio_disabled4" type="radio" name="policy[status]" value="0">
									<label for="sample_radio_disabled4" class="">De-active</label>
								</span>
							</span>

							
							
							 <input type='hidden' name="policy[policy_id]" value='<?php echo $item_id;?>'>
							 <input type='hidden' name="policy[page]" value='<?php echo $page;?>'>
							 <input type='hidden' name="policy[item_id]" value='<?php echo $item_id;?>'>
							 <input type='hidden' name="policy[lot_id]" value='<?php echo $lot_id;?>'>							
							
								<span class="formRow">
									<button type="submit" <?php if (empty($arr_policy_module_status)) { echo "disabled";}?>>Add Module</button>
								</span>
								
							<span class="formRow">
								<span class="formLabel">
								</span>
								<span class="formInput">
								</span>
							</span>
								
								
							</form>
						</div>
					</div>
					
					
					
							
				
					
					
					
				</div>
			</div>
		</div>				
				
				

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		