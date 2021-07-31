<?php
require __DIR__.'/../../../template/header_plain_inc.php';
?>
<script>
function returnParts(chart_code, chart_name){
  window.opener.document.getElementById("chart_code").value=chart_code;
  window.opener.document.getElementById("txt_chart_name").innerHTML=chart_name;
  window.close();
}
</script>
<link href="/css/center_dialog.css" rel="stylesheet">

		<div class="bodyContent" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="cardWrapper" id="FullContetnDiv">

						<span class="formRow">
						<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
								<th style="text-align:left" width ="5%'"><?php echo _t("No");?></th>
								<th style="text-align:left" width ="20%'">Chart Code</th>
								<th style="text-align:left" width ="25%'">Chart Type</th>
								<th style="text-align:left" >Chart Name</th>
								<th style="text-align:left" width ="15%">Status</th>
								</tr>							
								<?php
									$i_count=1 ;
									foreach ($arr_chart as $chart): 
										if ($chart['status']==1)  echo '<tr>';
										if ($chart['status']==0)  echo '<tr class="deactive">';
										echo '<td>'.$i_count++.'</td>';
										echo '<td>';
										
										echo '<a href ="javascript:returnParts('.'\''.$chart['chart_code'].'\''  .','. '\''.$chart['chart_name'].'\''   .') ;" >'.$chart['chart_code'].'&nbsp;'.'&raquo;'.'</a>';
										echo '</td>';
										echo '<td>'.htmlspecialchars($chart['type_name']).'</td>';
										echo '<td>'.htmlspecialchars($chart['chart_name']).'</td>';
										echo '<td>';		switch($chart['status']) {
											case "1": echo "Active"; break;
											case "0": echo "De-active"; break;
										};
										echo '</td>';
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
require __DIR__.'/../../../template/footer_plain_inc.php';
?>
		
