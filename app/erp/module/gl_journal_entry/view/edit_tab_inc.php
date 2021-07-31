<?php
echo '<ul class="tabrow">';	
	
echo '<li '.(($tab=='general' ||  $tab=='')?'class="selected"':'').'>';
echo '<a href="'.actionURL('edit','?tab=general&item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page).'">General</a></li>';
	
echo '<li '.($tab=='detail'?'class="selected"':'').'>';
echo '<a href="'.actionURL('edit','?tab=detail&item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page).'">Transaction</a></li>';
	
echo '</ul>';

?>



