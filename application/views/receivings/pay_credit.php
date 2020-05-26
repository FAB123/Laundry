<table id="suspended_sales_table" class="table table-striped table-hover">
	<thead>
		<tr bgcolor="#CCC">
			<th><?php echo $this->lang->line('sales_id'); ?></th>
		<th><?php echo $this->lang->line('sales_date'); ?></th>
		<th><?php echo $this->lang->line('reprint_customer'); ?></th>
		<th><?php echo $this->lang->line('sales_credit_balance'); ?></th>
		<th><?php echo $this->lang->line('sales_payment_amount'); ?></th>
        <th><?php echo $this->lang->line('sales_pay'); ?></th>  
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($credit_sales as $credit_sale)
		{
		?>
			<tr>
			<td id="reg_itemsp_name"><?php echo $credit_sale['description'];?></td>
			<td id="reg_itemsp_name"><?php echo $credit_sale['thedate'];?></td>
			<td>
			<?php
					if (isset($credit_sale['customer']))
					{
						$customer = $this->Supplier->get_info($credit_sale['customer']);
						echo $customer->first_name . ' ' . $customer->last_name;
					}
					else
					{
					?>
						&nbsp;
					<?php
					}
					?>
			</td>
			<td id="reg_itemsp_name"><?php echo abs($credit_sale['amount']) ;?>	</td>
			<td>
			<?php echo form_open('receivings/paycredit');?>
				
				<?php echo form_input(array('name'=>'pay_amount','value'=>'0','size'=>'8'));?>
					<?php 
						echo form_hidden('credit_tid', $credit_sale['tid']);
						echo form_hidden('credit_amount', $credit_sale['amount']);
						echo form_hidden('credit_customer', $credit_sale['customer']);
						echo form_hidden('credit_description', $credit_sale['description']);
						echo form_hidden('credit_employee', $credit_sale['employee_id']);
					?>
						<input type="submit" name="submit" value="<?php echo $this->lang->line('sales_pay'); ?>" id="submit" class="btn btn-primary btn-xs pull-right">
					<?php echo form_close(); ?>
				</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
