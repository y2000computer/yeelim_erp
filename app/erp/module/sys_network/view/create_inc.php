<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';


echo '<DIV id="BodyDiv">';
echo '<DIV class="headerNavigation">';
echo 'Menu';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">System</a>';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/'.IS_MODULE.'/">Network Policy</a>';
echo ' &raquo; ';
echo 'Add';
echo '</DIV>';
foreach ($arr_network as $network): 
endforeach;

echo '<DIV id="BodyWrapDiv">';
echo '<DIV id="FullContetnDiv">';


echo '<div class="messageStackError">';
echo 'Create network successfully';
echo '</div>';
//echo '<br>';
echo '<br>Network Description:&nbsp;'.$network['eng_name'];
echo '<p>Type:&nbsp;'.$network['net_type'];
echo '<p>Fixed IP:&nbsp;'.$network['fixed_id'];
echo '<p>IP Range From:&nbsp;'.$network['ip_range_from'];
echo '<p>IP Range To:&nbsp;'.$network['ip_range_to'];
echo '<p>Network Mask:&nbsp;'.$network['network_mask'];
if($network['status'] == 1){
echo '<p>Status:&nbsp;Active';
} else {
echo '<p>Status:&nbsp;De-active';
}
echo '<br>';
echo '<br>';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/'.IS_MODULE.'/" class="button">Close</a>';

echo '</div>';
require __DIR__.'/../../../template/footer_inc.php';
?>
