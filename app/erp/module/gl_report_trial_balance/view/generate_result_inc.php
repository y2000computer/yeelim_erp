<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="8" align="left">Report: Trial Balance</th>
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
		<th style="text-align:left" width ="25%">Chart Name</th>
		<th style="text-align:right" width ="12%">Brought Forward</th>
		<th style="text-align:right" width ="12%">Previous Balance</th>
		<th style="text-align:right" width ="12%">Report Date Balance<br>
		<?php 
			echo $json_search_items['criteria']['journal_date_from'] . '&nbsp; to &nbsp;' ;
			echo $json_search_items['criteria']['journal_date_to'] ;
		?>
		</th>
		<th style="text-align:right" width ="12%">Accumulated<br>Balance</th>

		</tr>	

		<?php
			$i_count=1 ;
			$report_brought_forward_ttl = 0;
			$report_previous_balance_ttl = 0;
			$report_current_period_balance_ttl = 0;
			$report_ending_balance_ttl = 0;
			foreach ($arr_report as $report): 

				$report_brought_forward = $report['brought_forward'];
				$report_previous_balance = $dmReport->get_previous_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
				$report_current_period_balance = $dmReport->get_current_period_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
				$report_ending_balance = $report_brought_forward + $report_previous_balance + $report_current_period_balance;

				$report_brought_forward = round($report_brought_forward,2);
				$report_previous_balance = round($report_previous_balance,2);
				$report_current_period_balance = round($report_current_period_balance,2);
				$report_ending_balance = round($report_ending_balance,2);
				
				$report_brought_forward_ttl += $report_brought_forward;
				$report_previous_balance_ttl += $report_previous_balance;
				$report_current_period_balance_ttl += $report_current_period_balance;
				$report_ending_balance_ttl += $report_ending_balance;

				$report_brought_forward_ttl = round($report_brought_forward_ttl,2);
				$report_previous_balance_ttl = round($report_previous_balance_ttl,2);
				$report_current_period_balance_ttl = round($report_current_period_balance_ttl,2);
				$report_ending_balance_ttl = round($report_ending_balance_ttl,2);
								
				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report_brought_forward).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report_previous_balance).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report_current_period_balance).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report_ending_balance).'</td>';
				echo '</tr>';
			endforeach; 	
		?>								


		<td colspan="3"" align="left">&nbsp;</td>
		<td style="text-align:right">Total:</td>
		<td style="text-align:right"><?php echo $report_brought_forward_ttl;?></td>
		<td style="text-align:right"><?php echo $report_previous_balance_ttl;?></td>
		<td style="text-align:right"><?php echo $report_current_period_balance_ttl;?></td>
		<td style="text-align:right"><?php echo $report_ending_balance_ttl;?></td>
		</tr>		


		
		<td colspan="6" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
