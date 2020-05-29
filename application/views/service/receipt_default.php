<?php 
	// Temporarily loads the system language for to print receipt in the system language rather than user defined.
	load_language(TRUE,array('customers','common','employees'));
?>

<div id="receipt_wrapper" style="font-size:<?php echo $this->config->item('receipt_font_size');?>px">
	<div id="receipt_header">
		<?php
		if($this->config->item('company_logo') != '')
		{
		?>
			<div id="company_name">
				<img id="image" src="<?php echo base_url('uploads/' . $this->config->item('company_logo')); ?>" alt="company_logo" />
			</div>
		<?php
		}
		?>

		<?php
		if($this->config->item('receipt_show_company_name'))
		{
		?>
			<div id="company_name"><?php echo $this->config->item('company'); ?></div>
			<div id="company_name"><?php echo $this->config->item('company_ar'); ?></div>
		<?php
		}
		?>

		<div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
		<div id="company_address"><?php echo nl2br($this->config->item('address_ar')); ?></div>
		<div id="company_address">رقم ضريبة :  <?php echo nl2br($this->config->item('vat_no')); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $this->lang->line('services_receipt'); ?></div>
		<div id="sale_time"><?php echo $transaction_time ?></div>
	</div>

	<div id="receipt_general_info">
		<?php
		//if(isset($customer))
		{
		?>
			<div id="customer"><?php echo $this->lang->line('customers_customer').": ".$service_info->first_name; ?></div>
		<?php
		}
		?>

		<div id="sale_id"><?php echo $this->lang->line('services_order_ids').": ".$service_info->order_id; ?></div>

		<div id="employee"><?php echo $this->lang->line('employees_employee').": ".$employees; ?></div>
	</div>
	
	<table id="receipt_items">
		<tr>
			<th style="width:50%;text-align:center"><?php echo $this->lang->line('services_amount'); ?></th>
			<th style="width:50%;text-align:center"><?php echo $this->lang->line('services_start_date'); ?></th>
			<th style="width:50%;text-align:center"><?php echo $this->lang->line('services_due_date'); ?></th>

		</tr>
	
		<tr>
			<td style="width:50%;text-align:center"><?php echo $service_info->amount; ?></td>
			<td style="width:25%;text-align:center"><?php echo $service_info->start_date; ?></td>
			<td style="width:25%;text-align:center"><?php echo $service_info->due_date; ?></td>
		</tr>
	
		<?php
		if($this->config->item('receipt_show_taxes'))
		{
		?>
			<tr>
				<td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
				<td style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($subtotal); ?></td>
			</tr>
			<?php
			foreach($taxes as $tax_group_index=>$sales_tax)
			{
			?>
				<tr>
					<td colspan="3" class="total-value"><?php echo $sales_tax['tax_group']; ?>:</td>
					<td class="total-value"><?php echo to_currency_tax($sales_tax['sale_tax_amount']); ?></td>
				</tr>
			<?php
			}
			?>
		<?php
		}
		?>

		<tr>
		</tr>


		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>



		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="3" style="text-align:right;"> <?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due') ; ?> </td>
			<td class="total-value"><?php echo to_currency($amount_change); ?></td>
		</tr>
	</table>
	

	<table id="receipt_items">

		
		<?php
		if($this->config->item('receipt_show_taxes'))
		{
		?>
			<tr>
				<td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
				<td style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($subtotal); ?></td>
			</tr>
			<?php
			foreach($taxes as $tax_group_index=>$sales_tax)
			{
			?>
				<tr>
					<td colspan="3" class="total-value"><?php echo $sales_tax['tax_group']; ?>:</td>
					<td class="total-value"><?php echo to_currency_tax($sales_tax['sale_tax_amount']); ?></td>
				</tr>
			<?php
			}
			?>
		<?php
		}
		?>

		<tr>
		</tr>

		<?php $border = (!$this->config->item('receipt_show_taxes') && !($this->config->item('receipt_show_total_discount') && $discount > 0)); ?>
		<tr>
			<td colspan="3" style="text-align:right;<?php echo $border? 'border-top: 2px solid black;' :''; ?>"><?php echo $this->lang->line('sales_total'); ?></td>
			<td style="text-align:right;<?php echo $border? 'border-top: 2px solid black;' :''; ?>"><?php echo to_currency($total); ?></td>
		</tr>

		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>


		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="3" style="text-align:right;"> <?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due') ; ?> </td>
			<td class="total-value"><?php echo to_currency($amount_change); ?></td>
		</tr>
	</table>

	<div id="sale_return_policy">
		<?php echo nl2br($this->config->item('return_policy')); ?>
      <br>
      <img src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
		<?php echo $sale_id; ?>
	</div>

	<div id="barcode">
		<br style = “line-height:100px;”>
    <br style = “line-height:100px;”>
    <br style = “line-height:100px;”>
	.
	</div>
	
</div>
