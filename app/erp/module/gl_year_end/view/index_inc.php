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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('process','').'" method="post" onsubmit="return handle_confirm()"  ';?>
						
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
								</span>
								<span class="formInput" >
								</span>
							</span>							
							<span class="formRow">
							</span>
							
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Journal Date From:</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_from" class="datepicker" style="width: 140px" type="text" required name="criteria[journal_date_from]" autocomplete="off" value="<?php echo $general['journal_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>							
							<span class="formRow">
							</span>
							

							<span class="formRow">
								<span class="formLabel">
									<label class="">Journal Date To:</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_to" class="datepicker" style="width: 140px" type="text" required name="criteria[journal_date_to]" autocomplete="off" value="<?php echo $general['journal_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
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

									<div id="formsubmitbutton">
										<button type="submit">Confirm</button>
									</div>	
									<div id="buttonreplacement" style="margin-left:30px; display:none;">
										<img src="/images/icons/preload.gif" alt="loading...">
									</div>
									
								</span>
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
		
		
		<script type="text/javascript">
		/*
		   Replacing Submit Button with 'Loading' Image
		   Version 2.0
		   December 18, 2012

		   Will Bontrager Software, LLC
		   https://www.willmaster.com/
		   Copyright 2012 Will Bontrager Software, LLC

		   This software is provided "AS IS," without 
		   any warranty of any kind, without even any 
		   implied warranty such as merchantability 
		   or fitness for a particular purpose.
		   Will Bontrager Software, LLC grants 
		   you a royalty free license to use or 
		   modify this software provided this 
		   notice appears on all copies. 
		*/
		


		function handle_confirm()
		{
			if ( !confirm ("Are your confirm, the process may take serveral minutes ? ") )
			　　     {　
					return false;
					} else {
						var s = TButtonClicked();
					}			
		}
		
		function TButtonClicked()
		{
		   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
		   document.getElementById("buttonreplacement").style.display = ""; // to display
		   return true;
		}
		var FirstLoading = true;
		function RestoreSubmitButton()
		{
		   if( FirstLoading )
		   {
			  FirstLoading = false;
			  return;
		   }
		   document.getElementById("formsubmitbutton").style.display = ""; // to display
		   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
		}
		// To disable restoring submit button, disable or delete next line.
		document.onfocus = RestoreSubmitButton;
		</script>
		
		
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		