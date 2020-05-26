<?php 
	// Temporarily loads the system language for to print receipt in the system language rather than user defined.
	load_language(TRUE,array('customers','sales','employees'));
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
			
			<div id="company_name"><?php echo $this->config->item('company_ar'); ?></div>
		<?php
		}
		?>

		
		<div id="company_address"><?php echo nl2br($this->config->item('address_ar')); ?></div>
		<div id="company_address">رقم ضريبة :  <?php echo nl2br($this->config->item('vat_no')); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $this->lang->line('sales_receipt'); ?></div>
		<div id="sale_time"><?php echo $transaction_time ?></div>
	</div>

	<div id="receipt_general_info">
		<?php
		if(isset($customer))
		{
		?>
			<div id="customer"><?php echo $this->lang->line('customers_customer').": ".$customer; ?></div>
		<?php
		}
		?>

		<div id="sale_id"><?php echo $this->lang->line('sales_id').": ".$sale_id; ?></div>

		<?php
		if(!empty($invoice_number))
		{
		?>
			<div id="invoice_number"><?php echo $this->lang->line('sales_invoice_number').": ".$invoice_number; ?></div>
		<?php
		}
		?>

		<div id="employee"><?php echo $this->lang->line('employees_employee').": ".$employee; ?></div>
	</div>

	<table id="receipt_items">
		<tr>
			<th style="width:30%;"><?php echo $this->lang->line('sales_description_abbrv'); ?></th>
			<th style="width:10%;"><?php echo $this->lang->line('sales_qty'); ?></th>
			<th style="width:20%;"><?php echo $this->lang->line('sales_price'); ?></th>
			<th style="width:20%;"><?php echo $this->lang->line('sales_sub_total'); ?></th>
			<th style="width:20%;"><?php echo $this->lang->line('sales_vat'); ?></th>
			<th style="width:30%;"><?php echo $this->lang->line('sales_total'); ?></th>
		</tr>
		<?php
		foreach($cart as $line=>$item)
		{
			$it_total = $item['discounted_total'];
		
		    $x_tax = $item['taxed_rate'];;
		    $n_tax = $item['quantity']*$x_tax;
		
		    if($this->config->item('tax_included'))
		    {
			    $item_sub_total = $it_total-$n_tax;
		   	    $item_total = $it_total;
		    }
            else
		    {
		        $item_sub_total = $it_total;
	    		$item_total = $it_total+$n_tax;
		    }
		
			if($item['print_option'] == PRINT_YES)
			{
			?>
				<tr>
					<th colspan="5"><?php echo ucfirst($item['name'] . ' ' . $item['attribute_values']); ?></th>
				</tr>
				<tr>
					<td></td>
					<?php $total_qty = $total_qty + $item['quantity']; ?>
					<td><?php echo to_quantity_decimals($item['quantity']); ?></td>
					<td><?php echo to_currency_no_money($item['price']); ?></td>
					<td><?php echo to_currency_no_money($item_sub_total); ?></td>
					<td><?php echo to_currency_no_money($item['taxed_rate']*$item['quantity']); ?></td>
					<td><?php echo to_currency_no_money($item_total); ?></td>
				</tr>
				<tr>
					<?php
					if($this->config->item('receipt_show_description'))
					{
					?>
						<td colspan="2"><?php echo $item['description']; ?></td>
					<?php
					}

					if($this->config->item('receipt_show_serialnumber'))
					{
					?>
						<td><?php echo $item['serialnumber']; ?></td>
					<?php
					}
					?>
				</tr>
				<?php
				if($item['discount'] > 0)
				{
				?>
					<tr>
						<?php
						if($item['discount_type'] == FIXED)
						{
						?>
							<td colspan="3" class="discount"><?php echo to_currency($item['discount']) . " " . $this->lang->line("sales_discount") ?></td>
						<?php
						}
						elseif($item['discount_type'] == PERCENT)
						{
						?>
							<td colspan="3" class="discount"><?php echo number_format($item['discount'], 0) . " " . $this->lang->line("sales_discount_included") ?></td>
						<?php
						}	
						?>
						<td class="total-value"><?php echo to_currency($item['discounted_total']); ?></td>
					</tr>
				<?php
				}
			}
		}
		?>
	
		<?php
		if($this->config->item('receipt_show_total_discount') && $discount > 0)
		{
		?>
			<tr>
				<td colspan="5" style='text-align:right;border-top:6px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
				<td style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($prediscount_subtotal); ?></td>
			</tr>
			<tr>
				<td colspan="5" class="total-value"><?php echo $this->lang->line('sales_customer_discount'); ?>:</td>
				<td class="total-value"><?php echo to_currency($discount * -1); ?></td>
			</tr>
		<?php
		}
		?>

		<?php
		if($this->config->item('receipt_show_taxes'))
		{
		?>
			<tr>
				<td colspan="5" style='text-align:right;border-top:2px solid #000000;'></td>
				<td style='text-align:right;border-top:2px solid #000000;'></td>
			</tr>
			
				<tr>
			       	<td>Total</td>
					<td><?php echo to_currency_no_money($total_qty); ?></td>
			       	<td></td>
			       	<td><?php echo to_currency_no_money($subtotal); ?></td>
			      	<td ><?php echo to_currency_no_money($total-$subtotal); ?></td>
			      	<td class="total-value"><?php echo to_currency_no_money($total); ?></td>
				</tr>
				
		<?php
		$rounded_due = round($total);
		}
		?>

		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right;"> </td>
			<td colspan="2" style="text-align:right;"><?php echo $this->lang->line('sales_round_off'); ?> </td>
			<td colspan="3" style="text-align:right;"><?php echo to_currency($rounded_due - $total); ?></td>
		</tr>
		
    	<tr>
		    <td colspan="2" style="text-align:right;"> </td>
			<td colspan="2" style="text-align:right;font-weight: bold;"><?php echo $this->lang->line('sales_net_amount'); ?> </td>
			<td colspan="3" style="text-align:right;font-weight: bold;"><?php echo to_currency($rounded_due); ?></td>
		</tr>

		<?php
		if($this->config->item('receipt_show_payments'))
		{
		    $only_sale_check = FALSE;
    		$show_giftcard_remainder = FALSE;
    		foreach($payments as $payment_id=>$payment)
	    	{
		    	$only_sale_check |= $payment['payment_type'] == $this->lang->line('sales_check');
	    		$splitpayment = explode(':', $payment['payment_type']);
	    		$show_giftcard_remainder |= $splitpayment[0] == $this->lang->line('sales_giftcard');
	    ?>
			<tr>
				<td colspan="3" style="text-align:right;"><?php echo $splitpayment[0]; ?> </td>
				<td class="total-value"><?php echo to_currency( $payment['payment_amount'] * -1 ); ?></td>
			</tr>
		<?php
		}
		}
		?>

		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>

		<?php
		if(isset($cur_giftcard_value) && $show_giftcard_remainder)
		{
		?>
			<tr>
				<td colspan="3" style="text-align:right;"><?php echo $this->lang->line('sales_giftcard_balance'); ?></td>
				<td class="total-value"><?php echo to_currency($cur_giftcard_value); ?></td>
			</tr>
		<?php
		}
		if($this->config->item('receipt_show_amount_change'))
		{
		?>
		<tr>
			<td colspan="3" style="text-align:right;"> <?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due') ; ?> </td>
			<td class="total-value"><?php echo to_currency($amount_change); ?></td>
		</tr>
		<?php
		}
		?>
	</table>

    <div id="sale_return_policy">
     
	</div>

	<div id="barcode">
		<br style = “line-height:450px;”>
		<br style = “line-height:450px;”>
	.
	</div>
</div>