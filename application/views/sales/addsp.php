<table width='80%' align='center' cellpadding='3'>
	<tbody>

		
		<?php
		if(count($addsp_sales) == 0)
		{
		?>
			<div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
		<?php
		}
		else
		{
			$count = 0;
			foreach ($addsp_sales as $addsp_sale)
			{
				if ($count % 5 ==0 and $count!=0)
				{
					echo '</tr><tr>';
				}
			?>		
				<td>
					<?php echo form_open('sales/add');
						echo form_hidden('item', $addsp_sale['item_id']);
					?>
						<input type="submit" style="height: 70px; width: 150px" name="submit" value="<?php echo $addsp_sale['name'] ?> - <?php echo $addsp_sale['unit_price'] ?> SR" id="submit" class="btn btn-primary btn-xs pull-right">						
					<?php echo form_close(); ?>
				</td>
				<?php 
				$count++; 
			}
		}
		?>
	</tbody>
</table>
