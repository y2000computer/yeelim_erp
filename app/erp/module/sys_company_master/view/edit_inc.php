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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('update','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >'; ?>
						
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
									<label class="">Company Name(Eng) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[name_eng]"  size="50" required="required" class="fifteen" value="<?php echo htmlspecialchars($general['name_eng']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Address(Eng) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_eng_1]"  size="50" class="ten" value="<?php echo htmlspecialchars($general['add_eng_1']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_eng_2]"  size="50" class="ten" value="<?php echo htmlspecialchars($general['add_eng_2']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_eng_3]"  size="50" class="ten" value="<?php echo htmlspecialchars($general['add_eng_3']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_eng_4]"  size="50" class="ten" value="<?php echo htmlspecialchars($general['add_eng_4']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Company Name(Chn) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[name_chn]"  size="50"  required="required" value="<?php echo htmlspecialchars($general['name_chn']);?>" class="eleven"/>
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Address(Chn) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_chn_1]"  size="50" class="nine" value="<?php echo htmlspecialchars($general['add_chn_1']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_chn_2]"  size="50" class="nine" value="<?php echo htmlspecialchars($general['add_chn_2']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_chn_3]"  size="50" class="nine" value="<?php echo htmlspecialchars($general['add_chn_3']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">&nbsp;</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_chn_4]"  size="50" class="nine" value="<?php echo htmlspecialchars($general['add_chn_4']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Telephone :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[tel]"  size="50" class="six" value="<?php echo htmlspecialchars($general['tel']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Fax :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[fax]"  size="50" class="six" value="<?php echo htmlspecialchars($general['fax']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Email :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[email]"  size="50" class="nine" value="<?php echo htmlspecialchars($general['email']);?>" />
								</span>
							</span>							
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Journal Prefix :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[journal_prefix]"  maxlength="2" size="2" class="two" value="<?php echo htmlspecialchars($general['journal_prefix']);?>" />
										(two capital letter only)
								</span>
							</span>							
							<span class="formRow">
							</span>
														
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<select name="general[status]" class="three" required="required"/>
									<option value="1" <?php if ($general['status'] == 1){echo "selected";}?>>Active</option>
									<option value="0" <?php if ($general['status'] == 0){echo "selected";}?>>De-active</option>
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
									<span class="message"><?php echo $general['create_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $general['create_datetime'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update By:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $general['modify_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $general['modify_datetime']; ?></span>
								</span>
							</span>							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		