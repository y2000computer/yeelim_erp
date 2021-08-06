<?php
require __DIR__.'/../../../template/header_inc.php';
?>

		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>

					</div>
				
				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.'/'.IS_PORTAL.'/'.IS_LANG.'/prop_home/'.'" method="post" >'; ?>
						
						<?php
						if(isset($vlValidation)) {
							if($vlValidation->getProblemMsg()<>'') {
								echo '<span class="alertMsg errorMsg">';
								echo $vlValidation->getProblemMsg();
								echo 'Process problem, Process in-complete !';
								echo '</span>';
							} else {
								echo '<span class="alertMsg successMsg">';
								echo 'Process successfully.';
								echo '</span>';
								}
						}	
						?>						
						
						
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>

							<span class="formRow">
							</span>
							<span class="formRow">
							</span>
							
							
							
							<span class="formRow">
								<span class="formLabel">
									<button type="submit">Close</button>
								</span>
								<span class="formInput">
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
		