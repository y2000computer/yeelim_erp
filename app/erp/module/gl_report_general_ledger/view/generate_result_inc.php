<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="8" align="left">Report: General Ledger</th>
		</tr>
		<tr>
		<th colspan="8" align="left">Company: <?php echo $_SESSION["target_comp_name"];?></th>
		</tr>

		<tr>
		<th colspan="8" align="left">Report Date: <?php echo date('d/m/Y  H:i:s');?></th>
		</tr>
		
		<tr>
		<th colspan="8" align="left">Journal Date From : 
		<?php 
			echo $json_search_items['criteria']['journal_date_from'] . '&nbsp; to &nbsp;' ;
			echo $json_search_items['criteria']['journal_date_to'] ;
		?>
		</th>
		</tr>
		
		<td colspan="8" align="left">&nbsp;</td>
		</tr>		

		<tr>
		<th style="text-align:left" width ="3%'"><?php echo _t("No");?></th>
		<th style="text-align:left" width ="6%">Chart Code</th>
		<th style="text-align:left" width ="15%">Chart Type</th>
		<th style="text-align:left" width ="20%">Chart Name</th>
		<th style="text-align:left" width ="6%">Journal Date</th>
		<th style="text-align:left" width ="7%">Journal Code</th>
		<th style="text-align:left" width ="">Journal Description</th>
		<th style="text-align:right" width ="12%">Amount</th>
		</tr>	

		<?php
			$i_count=1 ;
			$report_ttl = 0;
			foreach ($arr_report as $report): 
				$report_ttl += $report['amount'];
				$report_ttl = round($report_ttl,2);
				
				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td>'.htmlspecialchars(toDMY($report['journal_date'])).'</td>';
				echo '<td>'.htmlspecialchars($report['journal_code']).'</td>';
				echo '<td>'.htmlspecialchars($report['description']).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report['amount']).'</td>';
				echo '</tr>';
			endforeach; 	
		?>								

		<td colspan="6" align="left">&nbsp;</td>
		<td style="text-align:right">Report Balance:</td>
		<td style="text-align:right"><?php echo $report_ttl;?></td>
		</tr>		


		
		<td colspan="8" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
