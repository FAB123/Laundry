<table id="suspended_sales_table" class="table table-striped table-hover">
	<thead>
		<tr bgcolor="#CCC">
			<th><?php echo $this->lang->line('sales_id'); ?></th>
			<th><?php echo $this->lang->line('sales_date'); ?></th>
			<th><?php echo $this->lang->line('reprint_customer'); ?></th>
			<th><?php echo $this->lang->line('sales_payment_amount'); ?></th>
			<?php 
			if($this->Employee->has_grant('sales_edit', $this->session->userdata('person_id')))
			{
			?>
			<th><?php echo $this->lang->line('sale_edit'); ?></th>
			<?php
			}
			?>
			<th><?php echo $this->lang->line('sale_reprint'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($reprint_sales as $reprint_sale)
		{
		?>
			<tr>
				<td><?php echo 'POS  ' .$reprint_sale['sale_id'];?></td>
				<td><?php echo date($this->config->item('dateformat'), strtotime($reprint_sale['sale_time']));?></td>
				<td>
					<?php
					if (isset($reprint_sale['customer_id']))
					{
						$customer = $this->Customer->get_info($reprint_sale['customer_id']);
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
				
				<td>
					<?php
					{
						$amounts = $this->Sale->get_amount($reprint_sale['sale_id']);
						//$amounts = $this->Sale->get_sale_payments($reprint_sale['sale_id'])->result();
						echo $amounts->payment_amount;
	
					}
					?>				
				</td>
				
					<?php 
					if($this->Employee->has_grant('sales_edit', $this->session->userdata('person_id')))
					{
					?>
				<td>
					<?php
					    echo form_open('sales/edit_sale');
						echo form_hidden('sale_id', $reprint_sale['sale_id']);
					?>
					<input type="submit" name="submit" value="<?php echo $this->lang->line('sale_edit'); ?>" id="submit" class="btn btn-primary btn-xs pull-right">
					<?php echo form_close();
					?>
				</td>
				<?php
				}
				?>

				<td>
					<?php echo form_open('sales/reprint_recipt');
						echo form_hidden('sale_id', $reprint_sale['sale_id']);
					?>
						<input type="submit" name="submit" value="<?php echo $this->lang->line('sale_reprint'); ?>" id="submit" class="btn btn-primary btn-xs pull-right">
					<?php echo form_close(); ?>
				</td>

			</tr>
		<?php
		}
		?>
	</tbody>
</table>
