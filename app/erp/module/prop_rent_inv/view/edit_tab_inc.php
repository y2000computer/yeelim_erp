<?php
echo '<ul class="tabrow">';	
	
echo '<li '.(($tab=='general' ||  $tab=='')?'class="selected"':'').'>';
echo '<a href="'.actionURL('edit','?tab=general&item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page).'">General</a></li>';
	
echo '<li '.($tab=='rent'?'class="selected"':'').'>';
echo '<a href="'.actionURL('edit','?tab=rent&item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page).'">Rent Transaction</a></li>';
	
	
echo '<li '.($tab=='maint'?'class="selected"':'').'>';
echo '<a href="'.actionURL('edit','?tab=maint&item_id='.$item_id.'&lot_id='.$lot_id.'&page='.$page).'">Maint. Transaction</a></li>';

echo '</ul>';

?>



