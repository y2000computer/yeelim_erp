<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>


	<tr style="">
		<td align="right" style='FONT-SIZE:16px'>
			<?php echo $report['inv_code']; ?>
			&nbsp;
			&nbsp;
		</td>
	</tr>		

	<tr style="">
		<td align="right" style='FONT-SIZE:16px'>
			<?php echo YMDtoDMY($report['inv_date']); ?>
			&nbsp;
			&nbsp;
		</td>
	</tr>	

</table>



<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>


	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" width="95%" style="FONT-SIZE:16px">
			<?php echo $report['tenant_code']; ?>
		</td> 
	</tr>
	
	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE616px"> &nbsp;</td>
		<td align="left" width="95%" style='FONT-SIZE:18px'>
			<?php echo $report['eng_name']; ?>
		</td>
	</tr>

	<tr style="">
	<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['add_1']; ?>
		</td>
	</tr>	

	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['add_2']; ?>
		</td>
	</tr>	

	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['add_3']; ?>
		</td>
	</tr>	


	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['shop_no']; ?>
		</td>
	</tr>	


	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['ref_no']; ?>
		</td>
	</tr>		



</table>


<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>

	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>

	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>

	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>

	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>


</table>


<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>

	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" width="" style='FONT-SIZE:16px'>
			<?php echo YMDtoDMY($report['period_date_from']); ?>
			&nbsp;&nbsp; - &nbsp;&nbsp;
			<?php echo YMDtoDMY($report['period_date_to']); ?>
		</td>
		<td align="right" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="20%" style="FONT-SIZE:16px"> 
			<?php echo $report['amount'];?>
		</td>
		<td align="right" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>		

</table>











