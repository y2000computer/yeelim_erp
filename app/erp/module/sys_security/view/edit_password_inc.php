<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';
?>
<link href="/css/center_dialog.css" rel="stylesheet">

		<div class="bodyContent" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="cardWrapper" id="FullContetnDiv">
					<div class="pageTitle">Change password</div>
					<?php echo '<form action="'.actionURL('password_update','').'" method="post" >'; ?>
					<?php
					if(isset($vlValidation)) {
						echo '<span class="alertMsg errorMsg">';
						echo $vlValidation->getProblemMsg();
						echo '</span>';
							}
					?>
						<span class="formRow">
							<span class="formLabel">
								<label for="changepassword_oldPassword" class="">Old Password:</label>
							</span>
							<span class="formInput">
								<input type="password" name="general[old_password]" autocomplete="off" required value="<?php echo $general['old_password'];?>" class="four"/>
							</span>
						</span>
						<span class="formRow">
							<span class="formLabel">
								<label for="changepassword_newPassword" class="">New Password:</label>
							</span>
							<span class="formInput" data-remarks="(Min characters: 6)">
								<input type="password" name="general[new_password]" autocomplete="off" required minlength="6"  value="<?php echo $general['new_password'];?>" class="four"/>
							</span>
						</span>
						<span class="formRow">
							<span class="formLabel">
								<label for="changepassword_repeatPassword" class="">Repeat Password:</label>
							</span>
							<span class="formInput" data-remarks="(Min characters: 6)">
								<input type="password" name="general[repeat_password]" autocomplete="off" required minlength="6"  value="<?php echo $general['repeat_password'];?>" class="four"/>
							</span>
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

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		
