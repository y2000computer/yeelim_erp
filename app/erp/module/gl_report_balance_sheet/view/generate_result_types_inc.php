		<tr>
		<td colspan="2"" align="left"><?php echo $chart_type_name;?></td>
		<td colspan="6" align="left">&nbsp;</td>
		</tr>		


		<?php
			$arr_charts=$dmReport->charts_type($type_code, $json_searchphrase);
		?>

		
		<?php
			$i_count=1 ;
			$report_brought_forward_ttl = 0;
			$report_previous_balance_ttl = 0;			
			$report_current_period_balance_ttl = 0;
			$report_ending_balance_ttl = 0;
			foreach ($arr_charts as $report): 
				//$report_ttl += $report['amount'];
				$report_brought_forward = $report['brought_forward'];
				/*	
				$report_previous_balance = $dmReport->get_previous_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
				*/
				$report_previous_balance = $dmReport->get_previous_balance($report['chart_id'],$json_search_items['criteria']);
				/*	
				$report_current_period_balance = $dmReport->get_current_period_balance($report['chart_id'],$json_search_items['criteria']['journal_date_from'],$json_search_items['criteria']['journal_date_to']);
				*/
				$report_current_period_balance = $dmReport->get_current_period_balance($report['chart_id'],$json_search_items['criteria']);

				if($type_code=='120') {		//Equity-gets closed , calcuate P & L
					
					$report_previous_balance_libabilites_without_pl = $report_previous_balance_grand_ttl;
					$report_previous_balance = ($report_previous_balance_assets_grand_ttl + $report_previous_balance_libabilites_without_pl)*-1 ;

					$report_current_period_balance_libabilites_without_pl = $report_current_period_balance_grand_ttl;
					$report_current_period_balance = ($report_current_period_balance_assets_grand_ttl + $report_current_period_balance_libabilites_without_pl)*-1 ;

					$report_ending_balance_libabilites_without_pl = $report_ending_balance_grand_ttl;
					$report_ending_balance = ($report_ending_balance_assets_grand_ttl + $report_ending_balance_libabilites_without_pl)*-1 ;
					
					
				}
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
