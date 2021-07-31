<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';
?>
<link href="/css/center_dialog.css" rel="stylesheet">

		<div class="bodyContent" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="cardWrapper" id="FullContetnDiv">
					<div class="pageTitle">Company List </div>

						<span class="formRow">
						<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
								<th style="text-align:center" width="25">Selection&nbsp;</th>
								<th style="text-align:left" width="75%">Company Name</th>
								</tr>							
								<?php
								foreach ($arr_company as $company): 
									echo '<tr>';
									echo '<td style="text-align:center" >';
									if($company['comp_id']<>$_SESSION["target_comp_id"]) {
										echo '<a href="'.actionURLWithModule('target_company','?comp_id='.$company['comp_id'].'&name_eng='.$company['name_eng'].'').'">';
										echo 'Set Target'.'&nbsp;'.'&raquo;';
										echo '</a>';
										} else {
											echo '&nbsp;';
											echo 'Target';
											}
									echo '</td>';		
									
									echo '<td style="text-align:left" >'.$company['name_eng'].'</td>';
									echo '</tr>';
								endforeach; 	
								?>							
							</tbody>
						</table>
						

						</span>

				</div>
			</div>
		</div>

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		
