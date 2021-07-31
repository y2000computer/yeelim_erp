<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
	$user['status'] = 1;
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
									<label class="">Email :</label>
								</span>
								<span class="formInput">
										<input type="text" name="user[email]" required size="50" value="<?php echo htmlspecialchars($user['email']);?>" class="nine"/>
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Password:</label>
								</span>
								<span class="formInput">
										<input type="text" name="user[password]" required size="30"  value="<?php echo htmlspecialchars($user['password']);?>" class="five"/>
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Last Name:</label>
								</span>
								<span class="formInput">
										<input type="text" name="user[last_name]" required size="50"  value="<?php echo htmlspecialchars($user['last_name']);?>" class="six"/>
								</span>
							</span>							
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">First Name:</label>
								</span>
								<span class="formInput">
										<input type="text" name="user[first_name]" required size="50"  value="<?php echo htmlspecialchars($user['first_name']);?>" class="eight"/>
								</span>
							</span>							
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Department:</label>
								</span>
								<span class="formInput">
										<select name="user[depart_code]" required class="six"/>
										<?php 
										foreach ($arr_department_all as $dc): 
											echo '<option value="'.$dc['depart_code'].'"';
											echo '>'.$dc['eng_name'];
											echo '</option>';
										endforeach; 
										?>										
										</select>
								</span>
							</span>							
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<select name="user[status]" required class="three">
									<option value="1" <?php if ($user['status'] == 1){echo "selected";}?>>Active</option>
									<option value="0" <?php if ($user['status'] == 0){echo "selected";}?>>De-active</option>
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
		