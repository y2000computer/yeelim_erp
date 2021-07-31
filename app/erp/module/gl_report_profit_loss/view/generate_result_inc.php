<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="8" align="left">Report: Profit & Loss</th>
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
		<th style="text-align:right" width ="12%">Ending Balance</th>

		</tr>	

		
		<tr>
		<td colspan="3"" align="left">Income</td>
		<td colspan="5" align="left">&nbsp;</td>
		</tr>		


		<?php
			$type_code='130';  //Income
			$arr_charts_income=$dmReport->charts_type($type_code, $json_searchphrase);
		
		?>

		<?php
			$report_brought_forward_grand_ttl = 0;
			$report_previous_balance_grand_ttl = 0;			
			$report_current_period_balance_grand_ttl = 0;
			$report_ending_balance_grand_ttl = 0;
		?>		
		
		<?php
			$i_count=1 ;
			$report_brought_forward_ttl = 0;
			$report_previous_balance_ttl = 0;			
			$report_current_period_balance_ttl = 0;
			$report_ending_balance_ttl = 0;
			foreach ($arr_charts_income as $report): 
				//$report_ttl += $report['amount'];
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

				
				echo '<tr>';
				//echo '<td>'.$i_count++.'</td>';
				echo '<td></td>';
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

		<?php
			$report_brought_forward_grand_ttl += $report_brought_forward_ttl;
			$report_previous_balance_grand_ttl += $report_previous_balance_ttl;			
			$report_current_period_balance_grand_ttl += $report_current_period_balance_ttl;
			$report_ending_balance_grand_ttl += $report_ending_balance_ttl;
			
			$report_brought_forward_grand_ttl = round($report_brought_forward_grand_ttl,2);
			$report_previous_balance_grand_ttl = round($report_previous_balance_grand_ttl,2);
			$report_current_period_balance_grand_ttl = round($report_current_period_balance_grand_ttl,2);
			$report_ending_balance_grand_ttl = round($report_ending_balance_grand_ttl,2);
			
		?>

		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		
		<tr>
		<td colspan="3"" align="left">Expense</td>
		<td colspan="5" align="left">&nbsp;</td>
		</tr>		


		<?php
			$type_code='140';  //Expense
			$arr_charts_expense=$dmReport->charts_type($type_code, $json_searchphrase);
		
		?>
		
		
		<?php
			$i_count=1 ;
			$report_brought_forward_ttl = 0;
			$report_previous_balance_ttl = 0;			
			$report_current_period_balance_ttl = 0;
			$report_ending_balance_ttl = 0;
			foreach ($arr_charts_expense as $report): 
				//$report_ttl += $report['amount'];
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

				
				echo '<tr>';
				//echo '<td>'.$i_count++.'</td>';
				echo '<td></td>';
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
		
		<?php
			$report_brought_forward_grand_ttl += $report_brought_forward_ttl;
			$report_previous_balance_grand_ttl += $report_previous_balance_ttl;			
			$report_current_period_balance_grand_ttl += $report_current_period_balance_ttl;
			$report_ending_balance_grand_ttl += $report_ending_balance_ttl;

			$report_brought_forward_grand_ttl = round($report_brought_forward_grand_ttl,2);
			$report_previous_balance_grand_ttl = round($report_previous_balance_grand_ttl,2);
			$report_current_period_balance_grand_ttl = round($report_current_period_balance_grand_ttl,2);
			$report_ending_balance_grand_ttl = round($report_ending_balance_grand_ttl,2);
			
		?>
		
		
		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		
		<tr>
		<td colspan="3"" align="left">Cost of Sales</td>
		<td colspan="5" align="left">&nbsp;</td>
		</tr>		


		<?php
			$type_code='150';  //Cost of Sales
			$arr_charts_cost_of_sales=$dmReport->charts_type($type_code, $json_searchphrase);
		
		?>
		
		
		<?php
			$i_count=1 ;
			$report_brought_forward_ttl = 0;
			$report_previous_balance_ttl = 0;			
			$report_current_period_balance_ttl = 0;
			$report_ending_balance_ttl = 0;
			foreach ($arr_charts_cost_of_sales as $report): 
				//$report_ttl += $report['amount'];
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

				
				echo '<tr>';
				//echo '<td>'.$i_count++.'</td>';
				echo '<td></td>';
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

		<?php
			$report_brought_forward_grand_ttl += $report_brought_forward_ttl;
			$report_previous_balance_grand_ttl += $report_previous_balance_ttl;			
			$report_current_period_balance_grand_ttl += $report_current_period_balance_ttl;
			$report_ending_balance_grand_ttl += $report_ending_balance_ttl;

			$report_brought_forward_grand_ttl = round($report_brought_forward_grand_ttl,2);
			$report_previous_balance_grand_ttl = round($report_previous_balance_grand_ttl,2);
			$report_current_period_balance_grand_ttl = round($report_current_period_balance_grand_ttl,2);
			$report_ending_balance_grand_ttl = round($report_ending_balance_grand_ttl,2);
			
		?>
		
		
		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		

		<?php
			$pl_wording = 'Loss';
			if($report_ending_balance_grand_ttl <=0) {
				$pl_wording = 'Profit ';
				} else {
					$pl_wording = 'Loss ';
				}
		?>
		
		<td colspan="3"" align="left">&nbsp;</td>
		<td style="text-align:right"><?php echo $pl_wording;?> Total:</td>
		<td style="text-align:right"><?php echo $report_brought_forward_grand_ttl;?></td>
		<td style="text-align:right"><?php echo $report_previous_balance_grand_ttl;?></td>
		<td style="text-align:right"><?php echo $report_current_period_balance_grand_ttl;?></td>
		<td style="text-align:right"><?php echo $report_ending_balance_grand_ttl;?></td>
		</tr>		
		

		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		<td colspan="8" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
