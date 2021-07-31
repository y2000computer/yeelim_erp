<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="8" align="left">Report: Balance Sheet</th>
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
		<td colspan="2"" align="left"><b>ASSETS</b></td>
		<td colspan="6" align="left">&nbsp;</td>
		</tr>		

		<?php
			$report_brought_forward_grand_ttl = 0;
			$report_previous_balance_grand_ttl = 0;			
			$report_current_period_balance_grand_ttl = 0;
			$report_ending_balance_grand_ttl = 0;
		?>			
		
		<!--		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Handle ASSETS
		-->
		<?php
		$chart_type_name = 'Cash';
		$type_code='010';  
		require __DIR__.'/generate_result_types_inc.php';
	
		
		$chart_type_name = 'Account Receivable';
		$type_code='020';  
		require __DIR__.'/generate_result_types_inc.php';
		
		$chart_type_name = 'Current Assets';
		$type_code='030';  
		require __DIR__.'/generate_result_types_inc.php';

		$chart_type_name = 'Inventory';
		$type_code='040';  
		require __DIR__.'/generate_result_types_inc.php';

		$chart_type_name = 'Fixed Assets';
		$type_code='050';  
		require __DIR__.'/generate_result_types_inc.php';

		
		?>

		
		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		
		<td colspan="3"" align="left">&nbsp;</td>
		<td style="text-align:right"><b>Assets Total:</td>
		<td style="text-align:right"><b><?php echo $report_brought_forward_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_previous_balance_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_current_period_balance_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_ending_balance_grand_ttl;?></td>
		</tr>		

		<?php
			$report_brought_forward_assets_grand_ttl = $report_brought_forward_grand_ttl;
			$report_previous_balance_assets_grand_ttl = $report_previous_balance_grand_ttl;			
			$report_current_period_balance_assets_grand_ttl = $report_current_period_balance_grand_ttl;
			$report_ending_balance_assets_grand_ttl = $report_ending_balance_grand_ttl;
		?>			
		

		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		

		<!--		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Handle LIABLILITES 
		-->
		<tr>
		<td colspan="2"" align="left"><b>LIABLILITES</b></td>
		<td colspan="6" align="left">&nbsp;</td>
		</tr>		

		<?php
			$report_brought_forward_grand_ttl = 0;
			$report_previous_balance_grand_ttl = 0;			
			$report_current_period_balance_grand_ttl = 0;
			$report_ending_balance_grand_ttl = 0;
		?>			


		<?php
		$chart_type_name = 'Account Payable';
		$type_code='060';  
		require __DIR__.'/generate_result_types_inc.php';
	
		
		$chart_type_name = 'Current Liabilities';
		$type_code='070';  
		require __DIR__.'/generate_result_types_inc.php';
		
		$chart_type_name = 'Long-term Liabilities';
		$type_code='080';  
		require __DIR__.'/generate_result_types_inc.php';

		$chart_type_name = 'Accumulated Depreciation';
		$type_code='090';  
		require __DIR__.'/generate_result_types_inc.php';

		$chart_type_name = 'Shareholder Equity';
		$type_code='100';  
		require __DIR__.'/generate_result_types_inc.php';

		
		$chart_type_name = 'Dividend';
		$type_code='110';  
		require __DIR__.'/generate_result_types_inc.php';

		$chart_type_name = 'Equity-gets closed';
		$type_code='120';  
		require __DIR__.'/generate_result_types_inc.php';

		
		
		
		
		?>

		
		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		
		<td colspan="3"" align="left">&nbsp;</td>
		<td style="text-align:right"><b>Liabilites Total:</td>
		<td style="text-align:right"><b><?php echo $report_brought_forward_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_previous_balance_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_current_period_balance_grand_ttl;?></td>
		<td style="text-align:right"><b><?php echo $report_ending_balance_grand_ttl;?></td>
		</tr>		

		<?php
			$report_brought_forward_liabilites_grand_ttl = $report_brought_forward_grand_ttl;
			$report_previous_balance_liabilites_grand_ttl = $report_previous_balance_grand_ttl;			
			$report_current_period_balance_liabilites_grand_ttl = $report_current_period_balance_grand_ttl;
			$report_ending_balance_liabilites_grand_ttl = $report_ending_balance_grand_ttl;
		?>			
		

		<tr>
		<td colspan="8">&nbsp;</td>
		</tr>		
		
		
		<!--
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		-->


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
