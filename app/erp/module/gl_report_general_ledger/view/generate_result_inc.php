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
			foreach ($arr_report as $report): 
				$chart_brought_forward = $report['brought_forward'];
				$chart_previous_balance = $dmReport_tb->get_previous_balance($report['chart_id'],$json_search_items['criteria']);
				$chart_current_period_balance = $dmReport_tb->get_current_period_balance($report['chart_id'],$json_search_items['criteria']);
				$chart_ending_balance = $chart_brought_forward + $chart_previous_balance + $chart_current_period_balance;

				$chart_brought_forward = round($chart_brought_forward,2);
				$chart_previous_balance = round($chart_previous_balance,2);
				$chart_current_period_balance = round($chart_current_period_balance,2);
				$chart_ending_balance = round($chart_ending_balance,2);

				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'Brought Forward:'.'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($chart_brought_forward).'</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'Previous Balance:'.'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($chart_previous_balance).'</td>';
				echo '</tr>';

				
				
				$ar = json_decode($json_searchphrase, true);
				$ar['criteria']['chart_code_from'] = $report['chart_code'];
				$ar['criteria']['chart_code_to'] = $report['chart_code'];
				$json_searchphrase = json_encode($ar);	
				$arr_current_trans=$dmReport->current_trans($json_searchphrase);
				foreach ($arr_current_trans as $current_tran): 
					echo '<tr>';
					echo '<td>'.$i_count++.'</td>';
					echo '<td>'. $report['chart_code'] .'</td>';
					echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
					echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
					echo '<td>'.htmlspecialchars(toDMY($current_tran['journal_date'])).'</td>';
					echo '<td>'.htmlspecialchars($current_tran['journal_code']).'</td>';
					echo '<td>'.htmlspecialchars($current_tran['description']).'</td>';
					echo '<td style="text-align:right" >'.htmlspecialchars($current_tran['amount']).'</td>';
					echo '</tr>';	

				endforeach; 	


				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'Current Balance:'.'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($chart_current_period_balance).'</td>';
				echo '</tr>';


				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'. $report['chart_code'] .'</td>';
				echo '<td>'.htmlspecialchars($report['type_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['chart_name']).'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'Ending Balance:'.'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($chart_ending_balance).'</td>';
				echo '</tr>';



				echo '<tr>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '<td>'.'&nbsp;'.'</td>';
				echo '</tr>';




			endforeach; 	
		?>								



		<tr>		
		<td colspan="8" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
