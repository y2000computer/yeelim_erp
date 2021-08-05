<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
}
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>

				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('generate','').'" method="post" target="_blank" >';?>
						<input type="hidden" name="criteria[comp_id]"  value="<?php echo $_SESSION["target_comp_id"];?>" >
						
						<?php
						if(isset($vlValidation)) {
							if($vlValidation->getProblemMsg()<>'') {
								echo '<span class="alertMsg errorMsg">';
								echo $vlValidation->getProblemMsg();
								echo 'Criteria not save !';
								echo '</span>';
							} else {
								echo '<span class="alertMsg successMsg">';
								echo 'Output successfully.';
								echo '</span>';
								}
						}	
						?>						
						
				
							<span class="formRow">
								<span class="formLabel">
									<label class="">Building :</label>
								</span>
								<span class="formInput">
									<select name="criteria[build_id]" required class="ten">
									<?php
									echo '<option value=""'.' '.($criteria['build_id']  ==''?'selected':'').'>'.'Please select'.'</option>';
									foreach ($arr_prop_build_master  as $master) { 
									  echo '<option value="'.$master['build_id'].'"'.' '.($general['build_id']  == $master['build_id']?'selected':'').'>'.$master['eng_name'].'&nbsp;'.'('.$master['build_id'].')'.'</option>';
									}
									?>
									</select>
								</span>
							</span>
							<span class="formRow">
							</span>					
						
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Output To :</label>
								</span>
								<span class="formInput">
										<select name="criteria[output]" id="output" required class="five">
										<option value="screen" selected>Screen</option>
										<option value="excel">Excel</option>
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
									<button type="submit">Generate</button>
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
		