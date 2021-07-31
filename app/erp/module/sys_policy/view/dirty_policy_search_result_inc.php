<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';

echo '<DIV id="BodyDiv">';

echo '<DIV class="headerNavigation">';
echo 'Menu';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">System</a>';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_security/">Security Policy</a>';
echo ' &raquo; '     ;
echo ' Search Result ';
echo '</div><DIV id="BodyWrapDiv">';
include __DIR__.'/sys_policy_menu_inc.php';
echo '<DIV id="SubMenuDiv"><DIV id="ContentDiv">';


$json_search_items = json_decode($json_searchphrase, true);

$page = !isset($_GET['page']) ? 1 : $_GET['page'];

$arr_count_policy = count($arr_policy);
echo '<form action="'.actionURL('search_policy','').'" method="post" >';
?>

<div id="SearchDiv"><UL>
<li for="search" class="menu_group_headers"><img src ="/images/icons/icon04.png" class="" width="25" height="25" border="0"> Search Policy</label></LI></UL> 
<label class="three">Policy Name:  &nbsp;&nbsp;&nbsp; </label><input type="text"  name="policy[eng_name]"  class="six" value="<?php echo $json_search_items['policy']['eng_name'];?>" />
<p>
<button type="submit">search</button>
</form>

</div>

<?php if ($arr_count_policy >0){?>
<div class="SearchResultTotal">Total Record: <?php echo $paging->getRecordCount();?></div>
<?php } else {?>
<div class="SearchResultTotal">Record Not Found: </div>
<?php } ?>
<table border="0"  cellspacing="0" cellpadding="0" class="SearchResult">
    <tr>
	<th style="text-align:left" ><?php echo _t("No");?></th>
	<th style="text-align:left" >Policy Name</th>
	<th style="text-align:left" >Status</th>
	</tr>
<?php
if ($arr_count_policy >0){

$i_count=1+($page-1)*SYSTEM_PAGE_ROW_LIMIT;
foreach ($arr_policy as $policy): 
	if ($policy['status']==1)  echo '<tr>';
	if ($policy['status']==0)  echo '<tr style="background: #D1D0CE;">';
	echo '<td>'.$i_count++.'</td>';
	echo '<td>';
	echo '<a href="'.actionURL('edit_policy','?item_id='.$policy['policy_id'].'&lot_id='.$lot_id.'&page='.$page).'">'.$policy['eng_name'].'</a>';
	echo '</td>';
	echo '<td>';
	switch($policy['status']) {
		case "1": echo "Active"; break;
		case "0": echo "De-active"; break;
	};
	echo '</td>';
	echo '</tr>';
endforeach; 	
}
?>	
	 
</table>

<br />
<!-- print links -->
<?php 

if($paging->getTotalPages()>1) { 
	if($page >1 ){
		echo '<a href="'.actionURL('search_policy','?lot_id='.$lot_id.'&page='.($page-1)).'" class="pageResults">';
		echo '&lt;&lt;PREV</a>&nbsp;&nbsp;';
	}

	if($page < $paging->getTotalPages() ){
		echo '<a href="'.actionURL('search_policy','?lot_id='.$lot_id.'&page='.($page+1)).'" class="pageResults">';
		echo 'NEXT&gt;&gt;</a>&nbsp;&nbsp;';
	}
}

for($x = 1; $x <= $paging->getTotalPages(); $x++): 

if($x == $page ){
echo '<span class="pageResultsActive">';
echo $x; 
echo '</span>';
}else {
echo '<a href="'.actionURL('search_policy','?lot_id='.$lot_id.'&page='.$x).'" class="pageResults">';
echo $x; 
}
?></a>
<?php endfor; ?>
<div style="clear:both"></div></div></div>
<?php

//echo '<br>';
echo '</DIV></DIV>';
require __DIR__.'/../../../template/footer_inc.php';
?>
