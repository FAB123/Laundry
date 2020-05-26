<?php $this->load->view("partial/header"); ?>

<?php
if(isset($error_message))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error_message."</div>";
	exit;
}
foreach($sales as $name => $value)
{
if($name == "total")
{
	  if (is_numeric($value)) {    	$sales_total = $value;	  }
	  else { $sales_total = 0; }
}
elseif($name == "tax")
{
	if (is_numeric($value)) {    	$sales_tax = $value; }
	else { $sales_tax = 0; }
}
}

foreach($zero_sales as $name => $value)
{
if($name == "total")
{
	if (is_numeric($value)) {    $zero_sales_total = $value; }
	else { $zero_sales_total = 0; }
}
elseif($name == "tax")
{
	if (is_numeric($value)) {   $zero_sales_tax = $value; }
	else { $zero_sales_tax = 0; }
	
}
}

foreach($purchase as $name => $value)
{
if($name == "total")
{
	if (is_numeric($value)) { $purchase_total = $value; }
	else { $purchase_total = 0; }
}
elseif($name == "tax")
{
	if (is_numeric($value)) { $purchase_tax = $value; }
	else { $purchase_tax = 0; }
}
}

foreach($zero_purchase as $name => $value)
{
if($name == "total")
{
	if (is_numeric($value)) {  $zero_purchase_total = $value; }
	else { $zero_purchase_total = 0; }
}
elseif($name == "tax")
{
	if (is_numeric($value)) {  $zero_purchase_tax = $value; }
	else { $zero_purchase_tax = 0; }
}
}
?>


<div class="print_hide" id="control_buttons" style="text-align:right">
	<a href="javascript:window.print();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
	</div>

<?php
	// Temporarily loads the system language for _lang to print invoice in the system language rather than user defined.
	load_language(TRUE,array('vat','common'));
?>

<div id="page-wrap">
	<div id="block1">
		
	<table align="center">
			<td style="font-weight:bold" ><?php echo $this->lang->line('vat_form'); ?></td>
		
	 </table>
	
	<table id="items">
		<tr>
			<td><?php echo $this->lang->line('vat_item_company'); ?></td>
			<td> <?php echo $this->config->item('company'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_company_address'); ?></td>
			<td> <?php echo $this->config->item('address'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_item_number'); ?></td>
			<td><?php echo $this->config->item('vat_no'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_period'); ?></td>
			<td><?php echo $title; ?></td>
		</tr>
    </table>
	
	<table id="items">
		<tr>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_on_sale'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_total_amount'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_adjustment'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_amount'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('st_rated_sale'); ?></td>
			<td><?php echo to_currency($sales_total); ?></td>
			<td><?php  ?></td>
			<td><?php echo to_currency($sales_tax); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('sale_to_gcc'); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('zero_rated_sale'); ?></td>
			<td><?php echo to_currency($zero_sales_total); ?></td>
			<td>0</td>
			<td><?php echo to_currency($zero_sales_tax); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_export'); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('exempt_sales'); ?></td>
			<td>0</td>
			<td>0</td>
			<td></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $this->lang->line('total_sales'); ?></td>
			<td style="font-weight:bold"><?php echo to_currency($sales_total+$zero_sales_total); ?></td>
			<td style="font-weight:bold">0</td>
			<td style="font-weight:bold"><?php echo to_currency($sales_tax+$zero_sales_tax); ?></td>
		</tr>
		
		
		<tr>
			 <td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_on_purchase'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_total_amount'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_adjustment'); ?></td>
			<td style="font-weight:bold"><?php echo $this->lang->line('vat_amount'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_st_purchase'); ?></td>
			<td><?php echo to_currency($purchase_total); ?></td>
			<td>0</td>
			<td><?php echo to_currency($purchase_tax); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_import_cust'); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_import_vat'); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_zero_purchases'); ?></td>
			<td><?php echo to_currency($zero_purchase_total); ?></td>
			<td>0</td>
			<td><?php echo to_currency($zero_purchase_tax); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('vat_exempt_purchase'); ?></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $this->lang->line('total_purchase'); ?></td>
			<td style="font-weight:bold"><?php echo $purchase_total+$zero_purchase_total; ?></td>
			<td style="font-weight:bold">0</td>
			<td style="font-weight:bold"><?php echo $purchase_tax+$zero_purchase_tax; ?></td>
		</tr>
		<tr>
		     <td colspan="3" style="font-weight:bold"><?php echo $this->lang->line('vat_total_due'); ?></td>
			<td> <?php echo to_currency($sales_tax-$purchase_tax); ?></td>
		</tr>
    </table>
	
<script type="text/javascript">
$(window).on("load", function()
{
	// install firefox addon in order to use this plugin
	if(window.jsPrintSetup)
	{
		<?php if(!$this->Appconfig->get('print_header'))
		{
		?>
			// set page header
			jsPrintSetup.setOption('headerStrLeft', '');
			jsPrintSetup.setOption('headerStrCenter', '');
			jsPrintSetup.setOption('headerStrRight', '');
		<?php
		}

		if(!$this->Appconfig->get('print_footer'))
		{
		?>
			// set empty page footer
			jsPrintSetup.setOption('footerStrLeft', '');
			jsPrintSetup.setOption('footerStrCenter', '');
			jsPrintSetup.setOption('footerStrRight', '');
		<?php
		}
		?>
	}
});

</script>
	
	
<?php $this->load->view("partial/footer"); ?>
