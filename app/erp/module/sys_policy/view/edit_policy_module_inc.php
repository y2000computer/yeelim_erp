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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('update_policy_module','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >'; ?>
						
						
						<input type='hidden' name="policy[irow_id]" value='<?php echo $policy['irow_id'];?>'>
						
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
									<label class="">Module Code :</label>
								</span>
								<span class="formInput">
										<input type="text" name="policy[module_code]" readonly required size="50" value="<?php echo htmlspecialchars($policy['module_code']);?>" class="five"/>
								</span>
							</span>
							<span class="formRow">
							</span>
							
							
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Level(0-100) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="policy[rights_level]" required size="10" value="<?php echo htmlspecialchars($policy['rights_level']);?>" class="two"/>
								</span>
							</span>
							<span class="formRow">
							</span>
			
		
							<span class="formRow">
								<span class="formLabel">
									<label class="">Create Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled1" type="radio" name="policy[rights_create]" value="1" <?php if ($policy['rights_create']==1) echo 'checked="yes"';?>>
									<label for="sample_radio_enabled1" class="">Enable</label>
									<input id="sample_radio_disabled1" type="radio" name="policy[rights_create]" value="0" <?php if ($policy['rights_create']==0) echo 'checked="yes"';?>>
									<label for="sample_radio_disabled1" class="">Disable</label>
								</span>
							</span>
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Update Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled2" type="radio" name="policy[rights_update]" value="1" <?php if ($policy['rights_update']==1) echo 'checked="yes"';?>>
									<label for="sample_radio_enabled2" class="">Enable</label>
									<input id="sample_radio_disabled2" type="radio" name="policy[rights_update]" value="0" <?php if ($policy['rights_update']==0) echo 'checked="yes"';?>>
									<label for="sample_radio_disabled2" class="">Disable</label>
								</span>
							</span>
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Void Privllege:</label>
								</span>
								<span class="formInput">
									<input id="sample_radio_enabled3" type="radio" name="policy[rights_void]" value="1" <?php if ($policy['rights_void']==1) echo 'checked="yes"';?>>
									<label for="sample_radio_enabled3" class="">Enable</label>
									<input id="sample_radio_disabled3" type="radio" name="policy[rights_void]" value="0" <?php if ($policy['rights_void']==0) echo 'checked="yes"';?>>
									<label for="sample_radio_disabled3" class="">Disable</label>
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
							
					
					
					
					
				</div>
			</div>
		</div>				
				
				

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		