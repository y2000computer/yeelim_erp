<?php
require __DIR__.'/../../../template/report_header_inc.php';
echo '<DIV id="BodyDiv">';
?>

	<table class="searchResult" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		
		<tr>
		<th colspan="5" align="left">Report: Rent Payment Report</th>
		</tr>

		<tr>
		<th colspan="5" align="left">Building: <?php echo $general["eng_name"];?></th>
		</tr>

		<tr>
		<th colspan="5" align="left">Report Date: <?php echo date('d/m/Y  H:i:s');?></th>
		</tr>

		<td colspan="5" align="left">&nbsp;</td>
		</tr>		

		<tr>
		<th style="text-align:left" width ="5%'"><?php echo _t("No");?></th>
		<th style="text-align:left" width ="15%">Building</th>
		<th style="text-align:left" width ="6%">Payment Date</th>
		<th style="text-align:left" width ="6%">Payment No.</th>
		<th style="text-align:left" width ="8%">Tenant Code</th>
		<th style="text-align:left" width ="">Name</th>
		<th style="text-align:left" width ="5%">Ref No.</th>
		<th style="text-align:left" width ="5%">Shop No.</th>
		<th style="text-align:left" width ="6%">Invoice Date</th>
		<th style="text-align:left" width ="8%">Invoice No.</th>
		<th style="text-align:left" width ="6%">Period Date From</th>
		<th style="text-align:left" width ="6%">Period Date To</th>
		<th style="text-align:right" width ="8%">Invoice Amt.</th>
		<th style="text-align:right" width ="8%">Payment Amount</th>

		</tr>	

		<?php
			$i_count=1 ;
			foreach ($arr_report as $report): 
				echo '<tr>';
				echo '<td>'.$i_count++.'</td>';
				echo '<td>'.htmlspecialchars($report['build_eng_name']).'</td>';
				echo '<td>'.htmlspecialchars(YMDtoDMY($report['payment_date'])).'</td>';
				echo '<td>'.htmlspecialchars($report['payment_code']).'</td>';
				echo '<td>'.htmlspecialchars($report['tenant_code']).'</td>';
				echo '<td>'.htmlspecialchars($report['tenant_eng_name']).'</td>';
				echo '<td>'.htmlspecialchars($report['ref_no']).'</td>';
				echo '<td>'.htmlspecialchars($report['shop_no']).'</td>';
				echo '<td>'.htmlspecialchars(YMDtoDMY($report['inv_date'])).'</td>';
				echo '<td>'.htmlspecialchars($report['inv_code']).'</td>';
				echo '<td>'.htmlspecialchars(YMDtoDMY($report['period_date_from'])).'</td>';
				echo '<td>'.htmlspecialchars(YMDtoDMY($report['period_date_to'])).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report['inv_amount']).'</td>';
				echo '<td style="text-align:right" >'.htmlspecialchars($report['amount']).'</td>';
				echo '</tr>';
			endforeach; 	
		?>								

		<td colspan="14" align="left">&nbsp;</td>
		</tr>		

		
		<td colspan="14" align="left">*End of Report*</td>
		</tr>		
		
		
		</tbody>
	</table>
						



<?php
require __DIR__.'/../../../template/report_footer_inc.php';
?>
