<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if(isset($paging)) $page =$paging->CalcuatePageNo($item_id,SYSTEM_PAGE_ROW_LIMIT);
?>
<?php
foreach ($arr_user as $user): 
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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('update_user','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >'; ?>

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
							
							
							
							
							<span class="formRow formRow-2col" style="margin-top: 10px;">
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create User:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $user['create_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $user['create_datetime'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update By:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $user['modify_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $user['modify_datetime']; ?></span>
								</span>
							</span>							
							
							
						</form>
					</div>
				</div>



				<div class="sidebarContentWrapper sidebarContentWrapper-2col">
					<div class="sidebarContent">
						<div class="sidebarContentCol">
							<span class="inner_headers inner_headers_fullWidth"><span>Policy Module Prvillege</span></span>
							<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<th>Policy Name</th>
										<th>Status</th>
									</tr>
									
									<?php 
									foreach ($arr_user_policy as $up): 
										if ($up['status']==1)  echo '<tr>';
										if ($up['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$up['eng_name'].'</td>';
										$policy_grant_id = $up['irow_id'];
										$policy_grant_status = $up['status'];
										$policyPVTstatus =  $policy_grant_id.','.$policy_grant_status.','.$IS_para_id;	
										echo '<td width="20%">'.'<a class="commonTextBtn" href="'.actionURL('updatePVTpolicystatus','?policy_grant_id='.$policy_grant_id.'&policy_grant_status='.$policy_grant_status.'&lot_id='.$lot_id.'&item_id='.$item_id.'&page='.$page).'">';
										if($up['status'] == 1){
											echo 'Active';
											} else {
											echo 'De-active';
											}	
										echo '</a></td>';		
										echo '</tr>';	
									endforeach; 
									?>									
									
								</tbody>
							</table>
							<form class="attachPanel" action="<?php echo actionURL('add_policy','?item_id='.$user['user_id'].'&lot_id='.$lot_id.'&page='.$page);?>" method="post">
								<span class="formRow">
									<select name="policy_m[policy_select]" size="8" class="six">
									<?php 
									$x=1;
									foreach ($arr_ava_policy as $ava_policy): 
									
										echo '<option value="'.$ava_policy['policy_id'].'"';
											echo '>'.$x++.'. '.$ava_policy['eng_name'];
											echo '</option>';
									endforeach; 
									?>
									</select>
								</span>
								<span class="formRow">
									<button type="submit" <?php if (empty($arr_ava_policy)) { echo "disabled";}?>>Add Policy</button>
								</span>
							</form>
						</div>
					</div>
					
					
					
					<div class="sidebarContent">
						<div class="sidebarContentCol">
							<span class="inner_headers inner_headers_fullWidth"><span>Network Policy Prvillege</span></span>
							<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<th>Network Name</th>
										<th>Status</th>
									</tr>
									<?php 
									foreach ($arr_user_network as $un): 
										if ($un['status']==1)  echo '<tr>';
										if ($un['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$un['eng_name'].'</td>';
										$network_grant_id = $un['irow_id'];
										$network_grant_status = $un['status'];
										echo '<td width="20%">'.'<a class="commonTextBtn" href="'.actionURL('updatePVTnetworkstatus','?network_grant_id='.$network_grant_id.'&network_grant_status='.$network_grant_status.'&lot_id='.$lot_id.'&item_id='.$item_id.'&page='.$page).'">';
										if($un['status'] == 1){
										echo 'Active';
										} else {
										echo 'De-active';
										}
										echo '</a></td>';		
										echo '</tr>';	
									endforeach; 
									?>
								</tbody>
							</table>
							<form class="attachPanel" action="<?php echo actionURL('add_network','?item_id='.$user['user_id'].'&lot_id='.$lot_id.'&page='.$page);?>" method="post">
								<span class="formRow">
									<select name="network[network_select]" size="8" class="six">
									<?php 
									$x=1;
									foreach ($arr_ava_network as $ava_network): 
									
										echo '<option value="'.$ava_network['network_id'].'"';
											echo '>'.$x++.'. '.$ava_network['eng_name'];
											echo '</option>';
									endforeach; 
									?>									
									</select>
								</span>
								<span class="formRow">
									<button type="submit" <?php if (empty($arr_ava_network)) { echo "disabled";}?>>Add Network Policy</button>
								</span>
							</form>
						</div>
					</div>
					
					
					
					<div class="sidebarContent">
						<div class="sidebarContentCol">
							<span class="inner_headers inner_headers_fullWidth"><span>Company Prvillege</span></span>
							<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<th>Company Name</th>
										<th>Status</th>
									</tr>
									<?php 
									foreach ($arr_user_company as $un): 
										if ($un['status']==1)  echo '<tr>';
										if ($un['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$un['name_eng'].'</td>';
										$company_grant_id = $un['irow_id'];
										$company_grant_status = $un['status'];
										echo '<td width="20%">'.'<a class="commonTextBtn" href="'.actionURL('updatePVTcompanystatus','?company_grant_id='.$company_grant_id.'&company_grant_status='.$company_grant_status.'&lot_id='.$lot_id.'&item_id='.$item_id.'&page='.$page).'">';
										if($un['status'] == 1){
										echo 'Active';
										} else {
										echo 'De-active';
										}
										echo '</a></td>';		
										echo '</tr>';	
									endforeach; 
									?>
								</tbody>
							</table>
							<form class="attachPanel" action="<?php echo actionURL('add_company','?item_id='.$user['user_id'].'&lot_id='.$lot_id.'&page='.$page);?>" method="post">
								<span class="formRow">
									<select name="company[company_select]"  size="10" class="nine">
									<?php 
									$x=1;
									foreach ($arr_ava_company as $ava_company): 
									
										echo '<option value="'.$ava_company['comp_id'].'"';
											echo '>'.$x++.'. '.htmlspecialchars($ava_company['name_eng']);
											echo '</option>';
									endforeach; 
									?>									
									</select>
								</span>
								<span class="formRow">
									<button type="submit" <?php if (empty($arr_ava_company)) { echo "disabled";}?>>Add Company</button>
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
		