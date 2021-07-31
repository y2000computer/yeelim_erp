<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
	$general['brought_forward'] = 0;
	$general['status'] = 1;
}
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>
					Add 
				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('create','').'" method="post" >';?>
						
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
									<label class="">Chart Code :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[chart_code]"  size="20" required class="four" value="<?php echo htmlspecialchars($general['chart_code']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Chart Name :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[chart_name]"  size="50" required class="fourteen" value="<?php echo htmlspecialchars($general['chart_name']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>
							

							<span class="formRow">
								<span class="formLabel">
									<label class="">Type :</label>
								</span>
								<span class="formInput">
									<select name="general[type_code]" required >
									<?php
									echo '<option value=""'.' '.($general['type_code']  ==''?'selected':'').'>'.'Please select'.'</option>';
									foreach ($arr_chart_type_master  as $master) { 
									  echo '<option value="'.$master['type_code'].'"'.' '.($general['type_code']  == $master['type_code']?'selected':'').'>'.$master['type_name'].'&nbsp;'.'('.$master['type_code'].')'.'</option>';
									}
									?>
									</select>
								</span>
							</span>
							<span class="formRow">
							</span>
							
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Brought Forward :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[brought_forward]"  size="12" required class="five" value="<?php echo htmlspecialchars($general['brought_forward']);?>" />
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
							
							
							
							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		