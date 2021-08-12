<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>


	<tr style="">
		<td align="left" width="5%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" width="25%" style='FONT-SIZE:16px'>
			<?php echo YMDtoDMY($report['inv_date']); ?>
		</td>
		<td align="left" width="40%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="30%" style='FONT-SIZE:16px'>
		<?php echo $report['tenant_code']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>		

	

</table>



<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>


	<tr style="">
		<td align="left" width="95%" style="FONT-SIZE:16px">&nbsp;</td> 
	</tr>

	<tr style="">
		<td align="left" width="95%" style="FONT-SIZE:16px">&nbsp;</td> 
	</tr>

	<tr style="">
		<td align="left" width="95%" style="FONT-SIZE:16px">&nbsp;</td> 
	</tr>

	
	<tr style="">
		<td align="left" width="95%" style='FONT-SIZE:16px'>
			<?php echo $report['eng_name']; ?>&nbsp;
		</td>
	</tr>

	<tr style="">
		<td align="left" width="95%" style='FONT-SIZE:16px'>
			<?php echo $report['add_1']; ?>&nbsp;
		</td>
	</tr>	

	<tr style="">
		<td align="left" width="95%" style='FONT-SIZE:18px'>
			<?php echo $report['add_2']; ?>&nbsp;
		</td>
	</tr>	

	<tr style="">
		<td align="left" width="95%" style='FONT-SIZE:16px'>
			<?php echo $report['add_3']; ?>&nbsp;
		</td>
	</tr>		


</table>

<table  width="100%"  border="3"  bordercolor="#ff0000"  style='border-collapse:collapse; font-family:Arial, Helvetica, sans-serif'>

	<tr style="">
		<td align="left" width="30%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['shop_no']; ?>&nbsp;
		</td>
	</tr>	

	<tr style="">
		<td align="left" width="30%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>&nbsp;</td>
	</tr>	


	<tr style="">
		<td align="left" width="30%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" style='FONT-SIZE:16px'>
			<?php echo $report['ref_no']; ?>&nbsp;
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
		<td align="left" width="" style='FONT-SIZE:16px'>&nbsp;</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="30%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>


	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" width="" style='FONT-SIZE:16px'>
			<?php echo YMDtoDMY($report['period_date_from']); ?>
			&nbsp;&nbsp; - &nbsp;&nbsp;
			<?php echo YMDtoDMY($report['period_date_to']); ?>
		</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="30%" style="FONT-SIZE:16px"> 
			<?php echo '&nbsp;HK$&nbsp;'. number_format($report['amount'],2);?>
		</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>		


	<tr style="">
		<td align="left" width="20%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="left" width="" style='FONT-SIZE:16px'>&nbsp;</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
		<td align="right" width="30%" style="FONT-SIZE:16px"> 
			==========
		</td>
		<td align="right" width="1%" style="FONT-SIZE:16px"> &nbsp;</td>
	</tr>		


</table>












