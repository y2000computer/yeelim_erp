<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="5" align="left">Report: Chart of Account</th>
		</tr>
		<tr>
		<th colspan="5" align="left">Company: <?php echo $_SESSION["target_comp_name"];?></th>
		</tr>

		<tr>
		<th colspan="5" align="left">Report Date: <?php echo date('d/m/Y  H:i:s');?></th>
		</tr>

		<td colspan="5" align="left">&nbsp;</td>
		</tr>		

		<tr>
		<th style="text-align:left" width ="5%'"><?php echo _t("No");?></th>
		<th style="text-align:left" width ="10%">Chart Code</th>
		<th style="text-align:left" width ="25%">Chart Type</th>
		<th style="text-align:left" width ="35%">Chart Name</th>
		<th style="text-align:right" width ="15%">Brought Forward</th>
		</tr>	

		<?php
			$i_count=1 ;
			$brought_forward_ttl = 0;
			foreach ($arr_report as $report): 
				$brought_forward_ttl += $report['brought_forward'];
				$brought_forward_ttl = round($brought_forward_ttl,2);
				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report['brought_forward']).'</td>';
				echo '</tr>';
			endforeach; 	
		?>								

		<td colspan="3" align="left">&nbsp;</td>
		<td style="text-align:right">Report Balance:</td>
		<td style="text-align:right"><?php echo $brought_forward_ttl;?></td>
		</tr>		

		
		<td colspan="5" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
