<?php $this->load->view("partial/header"); ?>
	
<script type="text/javascript" src="js/plugins/jquery.numpad.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.numpad.css">	

<script>
function getCost(elmnt,line) {
   $("#cost_item_button_"+line).toggle()
}
</script>
    <div class="row">
	    <div class="col-md-12">
			<?php
			if(isset($error))
			{
				echo '<script type="text/JavaScript">swal("Error!", "'.$error.'", "error");</script>' ; 
			}

			if(!empty($warning))
			{
				echo '<script type="text/JavaScript">swal("Warning!", "'.$warning.'", "warning");</script>' ; 
			}

			if(isset($success))
			{
				echo '<script type="text/JavaScript">swal("Success!", "'.$success.'", "success");</script>' ; 
			}
			?>
        </div>

        <div id="sales_cart" class="col-md-8">
			<ul class="nav nav-tabs cart_tab_selection" id="cart_tab_selection" data-tabs="tabs">
				<li <?php echo ($cart_tab == 'sale_tab') ? 'class = "active"' : ''; ?> id="sale_tab" role="presentation">
					<a data-toggle="tab" href="#sale_cart"><?php echo $this->lang->line("sales_cart_tab"); ?></a>
				</li>
				<li <?php echo ($cart_tab == 'pay_tab') ? 'class = "active"' : ''; ?> id="pay_tab" role="presentation">
					<a data-toggle="tab" href="#payment_cart"><?php echo $this->lang->line("sales_payment_tab"); ?></a>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane <?php echo ($cart_tab == 'sale_tab') ? 'fade in active' : ''; ?>" id="sale_cart">
            	<?php echo form_open($controller_name."/change_mode", array('id'=>'mode_form', 'class'=>'form-horizontal panel panel-default')); ?>
					<div class="panel-body form-group">
						<ul>
							<li class="pull-left">
								<div id="mode" class="btn-group" data-toggle="buttons">
							    	<a class="btn btn-rounded btn-lg btn-info <?php echo ($mode == 'sale_work_order')?'active':''; ?>" data-toggle="tab">
										<?php echo form_radio(array('name'=>'mode', 'type'=>'radio', 'onchange'=>"$('#mode_form').submit();", 'id'=>'mode', 'value'=>'sale_work_order')); ?> <?php echo $this->lang->line('sales_work_order'); ?> </a>
								
									<a class="btn btn-rounded btn-lg btn-info <?php echo ($mode == 'sale_invoice')?'active':''; ?>" data-toggle="tab">
										<?php echo form_radio(array('name'=>'mode', 'type'=>'radio', 'onchange'=>"$('#mode_form').submit();", 'id'=>'mode', 'value'=>'sale_invoice')); ?> <?php echo $this->lang->line('sales_receipt'); ?> </a>
									
									<a class="btn btn-rounded btn-lg btn-info <?php echo ($mode == 'return')?'active':''; ?>" data-toggle="tab">
										<?php echo form_radio(array('name'=>'mode', 'type'=>'radio', 'onchange'=>"$('#mode_form').submit();", 'id'=>'mode', 'value'=>'return')); ?> <?php echo $this->lang->line('sales_return'); ?> </a>
								</div>
							</li>
							
							<li class="pull-left">
								<?php
								if(count($stock_locations) > 1)
								{
								?>
									<div id="mode" class="btn-group" data-toggle="buttons">
									<?php
									foreach($stock_locations as $stock_key=>$stock_locations_opt)
									{
									?>
									<a class="btn btn-rounded btn-info <?php echo ($stock_location == $stock_key)?'active':''; ?>" data-toggle="tab">
									<?php echo form_radio(array('name'=>'stock_location', 'type'=>'radio', 'onchange'=>"$('#mode_form').submit();", 'id'=>'stock_location', 'value'=>$stock_key)); ?> <?php echo $stock_locations_opt; ?> </a>
									<?php
									}
									?>
									</div>
								<?php
								}
								?>
							</li>
													
							<li class="pull-right">
								<div class="btn-group">
									<button type="button" class="btn btn-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu
									<span class="sr-only">Toggle Dropdown</span>
									</button>
						  
									<div class="dropdown-menu">
										<?php echo anchor($controller_name."/reprint", '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('sales_reprint_sales'),
											array('class'=>'dropdown-item modal-dlg', 'id'=>'show_suspended_sales_button', 'title'=>$this->lang->line('sales_reprint_sales'))); ?>
										<div class="dropdown-divider"></div>				
										<?php echo anchor($controller_name."/addsp", '<span class="glyphicon glyphicon-th-large">&nbsp</span>' . $this->lang->line('sales_sp_sales'),
											array('class'=>'dropdown-item modal-dlg modal-dlg-wide', 'id'=>'show_suspended_sales_button', 'title'=>$this->lang->line('sales_sp_sales'))); ?>
										<div class="dropdown-divider"></div>
										<?php echo anchor($controller_name."/suspended", '<span class="glyphicon glyphicon-repeat">&nbsp</span>' . $this->lang->line('sales_suspended_sales'),
											array('class'=>'dropdown-item modal-dlg', 'id'=>'show_suspended_sales_button', 'title'=>$this->lang->line('sales_suspended_sales'))); ?>
											<div class="dropdown-divider"></div>
										<?php echo anchor($controller_name, '<span class="glyphicon glyphicon-blackboard">&nbsp</span>' . $this->lang->line('sales_second_display'),
                                             array('class'=>'dropdown-item', 'id'=>'show_second_display', 'title'=>$this->lang->line('sales_second_display'))); ?>

										<?php
										if($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id')))
										{
										?>
										<div class="dropdown-divider"></div>
												<?php echo anchor($controller_name."/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_takings'),
															array('class'=>'dropdown-item', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_takings'))); ?>
										<?php
										}
										?>
									    <?php
										if($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id')))
										{
										?>
										<div class="dropdown-divider"></div>
												<?php echo anchor($controller_name."/work_orders", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_work_orders'),
															array('class'=>'dropdown-item', 'id'=>'sales_work_order_button', 'title'=>$this->lang->line('sales_work_orders'))); ?>
										<?php
										}
										?>
									</div>
								</div>
							</li>	
							
						</ul>
					</div>
					<?php echo form_close(); ?>
									
	    			<div class="panel-body form-group">
						<div class="sales_category">
							<div class="panel-body form-group">
								<div class="sales_category__panel">
									<div class="sales_category__panel--toggle-button" id="get_list_cat">				
									</div>
								</div>

								<div class="sales__category--wrapper list-of-categories" style="display: block">
								</div>		
							</div>
						</div>

						<div class="sales_category">
							<div class="sales_category_image panel-body form-group list-of-items" style="display: none">
							</div>
						</div>
				    </div>
					
				</div>
				
				<div class="tab-pane  <?php echo ($cart_tab == 'pay_tab') ? 'fade in active' : ''; ?>" id="payment_cart">
					<div class="panel-body">
						<?php echo form_open($controller_name."/select_customer", array('id'=>'select_customer_form', 'class'=>'form-horizontal')); ?>
							<?php
							if(isset($customer))
							{
							?>
								<table class="sales_table_100">
									<tr>
										<th style='width: 55%;'><?php echo $this->lang->line("sales_customer"); ?></th>
										<th style="width: 45%; text-align: right;"><?php echo anchor('customers/view/'.$customer_id, $customer, array('class' => 'modal-dlg', 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('customers_update'))); ?></th>
									</tr>
									<?php
									if(!empty($customer_email))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_email"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $customer_email; ?></th>
										</tr>
									<?php
									}
									?>
									<?php
									if(!empty($customer_address))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_address"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $customer_address; ?></th>
										</tr>
									<?php
									}
									?>
									<?php
									if(!empty($customer_location))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_location"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $customer_location; ?></th>
										</tr>
									<?php
									}
									?>
									<?php
									if(!empty($customer_account_balance))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_balance"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo anchor('accounts/manage/0/'.$customer_id, to_currency($customer_account_balance)); ?></th>
										</tr>
									<?php
									}
									?>
									<tr>
										<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_discount"); ?></th>
										<th style="width: 45%; text-align: right;"><?php echo ($customer_discount_type == FIXED)?to_currency($customer_discount):$customer_discount . '%'; ?></th>
									</tr>
									<?php if($this->config->item('customer_reward_enable') == TRUE): ?>
									<?php
									if(!empty($customer_rewards))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("rewards_package"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $customer_rewards['package_name']; ?></th>
										</tr>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("customers_available_points"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $customer_rewards['points']; ?></th>
										</tr>
									<?php
									}
									?>
									<?php endif; ?>
									<tr>
										<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_total"); ?></th>
										<th style="width: 45%; text-align: right;"><?php echo to_currency($customer_total); ?></th>
									</tr>
									<?php
									if(!empty($mailchimp_info))
									{
									?>
										<tr>
											<th style='width: 55%;'><?php echo $this->lang->line("sales_customer_mailchimp_status"); ?></th>
											<th style="width: 45%; text-align: right;"><?php echo $mailchimp_info['status']; ?></th>
										</tr>
									<?php
									}
									?>
								</table>

								<?php echo anchor($controller_name."/remove_customer", '<span class="glyphicon glyphicon-remove">&nbsp</span>' . $this->lang->line('common_remove').' '.$this->lang->line('customers_customer'),
									array('class'=>'btn btn-danger btn-lg', 'id'=>'remove_customer_button', 'title'=>$this->lang->line('common_remove').' '.$this->lang->line('customers_customer'))); ?>
							<?php
							}
							else
							{
							?>
								<div class="form-group" id="select_customer">
									<label id="customer_label" for="customer" class="control-label" style="margin-bottom: 1em; margin-top: -1em;"><?php echo $this->lang->line('sales_select_customer') . ' ' . $customer_required; ?></label>
									<?php echo form_input(array('name'=>'customer', 'id'=>'customer', 'class'=>'form-control input-sm', 'value'=>$this->lang->line('sales_start_typing_customer_name')));?>

									<button class='btn btn-info btn-sm modal-dlg' data-btn-submit="<?php echo $this->lang->line('common_submit') ?>" data-href="<?php echo site_url("customers/view"); ?>"
											title="<?php echo $this->lang->line($controller_name. '_new_customer'); ?>">
										<span class="glyphicon glyphicon-user">&nbsp</span><?php echo $this->lang->line($controller_name. '_new_customer'); ?>
									</button>

								</div>
							<?php
							}
							?>
						<?php echo form_close(); ?>

						<table class="sales_table_100" id="pos_sale_totals">
							<tr>
								<th style="width: 55%;"><?php echo $this->lang->line('sales_quantity_of_items',$item_count); ?></th>
								<th style="width: 45%; text-align: right;"><?php echo $total_units; ?></th>
							</tr>
							<tr>
								<th style="width: 55%;"><?php echo $this->lang->line('sales_sub_total'); ?></th>
								<th style="width: 45%; text-align: right;"><?php echo to_currency($subtotal); ?></th>
							</tr>

							<?php
							foreach($taxes as $tax_group_index=>$sales_tax)
							{
							?>
								<tr>
									<th style='width: 55%;'><?php echo $sales_tax['tax_group']; ?></th>
									<th style="width: 45%; text-align: right;"><?php echo to_currency_tax($sales_tax['sale_tax_amount']); ?></th>
								</tr>
							<?php
							}
							?>

							<tr>
								<th style='width: 55%;'><?php echo $this->lang->line('sales_total'); ?></th>
								<th style="width: 45%; text-align: right;"><span id="sale_total"><?php echo to_currency($total); ?></span></th>
							</tr>
						</table>

						<?php
						// Only show this part if there are Items already in the sale.
						if(count($cart) > 0)
						{
						?>
							<table class="sales_table_100" id="payment_totals">
								<tr>
									<th style="width: 55%;"><?php echo $this->lang->line('sales_payments_total');?></th>
									<th style="width: 45%; text-align: right;"><?php echo to_currency($payments_total); ?></th>
								</tr>
								<tr>
									<th style="width: 55%;"><?php echo $this->lang->line('sales_amount_due');?></th>
									<th style="width: 45%; text-align: right;"><span id="sale_amount_due"><?php echo to_currency($amount_due); ?></span></th>
								</tr>
							</table>

							<div id="payments_details">
							
							 	<?php
								// Only show this part if there is at least one payment entered.
								if(count($payments) > 0)
								{
								?>
									<table class="sales_table_100" id="cash_register">
										<thead>
											<tr>
												<th style="width: 10%;"><?php echo $this->lang->line('common_delete'); ?></th>
												<th style="width: 60%;"><?php echo $this->lang->line('sales_payment_type'); ?></th>
												<th style="width: 20%;"><?php echo $this->lang->line('sales_payment_amount'); ?></th>
											</tr>
										</thead>

										<tbody id="payment_contents">
											<?php
											foreach($payments as $payment_id=>$payment)
											{
											?>
												<tr>
													<td><?php echo anchor($controller_name."/delete_payment/$payment_id", '<span class="glyphicon glyphicon-trash"></span>'); ?></td>
													<td><?php echo $payment['payment_type']; ?></td>
													<td style="text-align: right;"><?php echo to_currency( $payment['payment_amount'] ); ?></td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								<?php
								}
								?>
								
								<?php
							// Only show this part if the payment cover the total
							if($payments_cover_total || !$pos_mode)
							{
							?>
							
								<div class="form-group form-group-sm">
									<div class="col-xs-12">
										<?php echo form_label($this->lang->line('common_comments'), 'comments', array('class'=>'control-label', 'id'=>'comment_label', 'for'=>'comment')); ?>
										<?php echo form_textarea(array('name'=>'comment', 'id'=>'comment', 'class'=>'form-control input-sm', 'value'=>$comment, 'rows'=>'2')); ?>
									</div>
								</div>

								<div class="form-group form-group-sm">
									<div class="col-xs-6">
										<label for="sales_print_after_sale" class="control-label checkbox">
											<?php echo form_checkbox(array('name'=>'sales_print_after_sale', 'id'=>'sales_print_after_sale', 'value'=>1, 'checked'=>$print_after_sale)); ?>
											<?php echo $this->lang->line('sales_print_after_sale')?>
										</label>
									</div>
									
									<div class="col-xs-6">
										<label for="sales_print_as_pdf" class="control-label checkbox">
											<?php echo form_checkbox(array('name'=>'sales_print_as_pdf', 'id'=>'sales_print_as_pdf', 'value'=>1, 'checked'=>$print_as_pdf)); ?>
											<?php echo $this->lang->line('sales_print_as_pdf')?>
										</label>
									</div>

									<?php
									if(!empty($customer_email))
									{
									?>
										<div class="col-xs-6">
											<label for="email_receipt" class="control-label checkbox">
												<?php echo form_checkbox(array('name'=>'email_receipt', 'id'=>'email_receipt', 'value'=>1, 'checked'=>$email_receipt)); ?>
												<?php echo $this->lang->line('sales_email_receipt');?>
											</label>
										</div>
									<?php
									}
									?>

								</div>								
							<?php
							}
							?>
								
								
								<?php
								// Show Complete sale button instead of Add Payment if there is no amount due left
								if($payments_cover_total)
								{
								?>
									<?php echo form_open($controller_name."/add_payment", array('id'=>'add_payment_form', 'class'=>'form-horizontal')); ?>
										<table class="sales_table_100">
											<tr>
												<td><span id="amount_tendered_label"><?php echo $this->lang->line('sales_amount_tendered'); ?></span></td>
												<td>
													<?php echo form_input(array('name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control input-sm disabled', 'disabled'=>'disabled', 'value'=>'0', 'size'=>'5', 'tabindex'=>++$tabindex, 'onClick'=>'this.select();')); ?>
												</td>
											</tr>
										</table>
									<?php echo form_close(); ?>
										<?php
										// Only show this part if the payment cover the total and in sale or return mode
										if($pos_mode == '1')
										{
										?>
										<div class='btn btn-lg btn-success col-md-12' id='finish_sale_button' tabindex="<?php echo ++$tabindex; ?>"><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $this->lang->line('sales_complete_sale'); ?></div>
										<?php
										}
										?>
								<?php
								}
								else
								{
								?>
								    <div id="pos_sales_payment" class="col-md-12">
										<?php echo form_open($controller_name."/add_payment", array('id'=>'add_payment_form', 'class'=>'form-horizontal')); ?>
											<div  class="btn-group" data-toggle="buttons">
												<?php
												foreach($payment_options as $payment_key=>$payment_opt)
												{
													if(!$selected_payment_type)
													{
														$selected_payment_type = $payment_key;
													}
												?>
												<a rel='<?php echo$payment_key ?>' class="pos_payment_type btn btn-rounded btn-lg btn-info <?php echo ($selected_payment_type == $payment_key)?'active':''; ?>" >
												<?php echo form_radio(array('name'=>'payment_type', 'type'=>'radio', 'id'=>'payment_types', 'value'=>$payment_key)); ?> <?php echo $payment_opt; ?> </a>
												<?php
												}
												?>
											</div>
		
												<table>
													<tr>
														<td style="width: 45%; text-align: left;"><span id="amount_tendered_label"><?php echo $this->lang->line('sales_amount_tendered'); ?></span></td>
														<td style="width: 55%;">
															<?php echo form_input(array('name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control is-valid input-sm non-giftcard-input', 'value'=>to_currency_no_money($amount_due), 'size'=>'5', 'tabindex'=>++$tabindex, 'onClick'=>'this.select();')); ?>
															<?php echo form_input(array('name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control is-valid input-sm giftcard-input', 'disabled' => true, 'value'=>to_currency_no_money($amount_due), 'size'=>'5', 'tabindex'=>++$tabindex)); ?>
														</td>
													</tr>
												</table>
											
										<?php echo form_close(); ?>
										<div class='btn btn-lg btn-success col-md-12' id='add_payment_button' tabindex="<?php echo ++$tabindex; ?>"><span class="glyphicon glyphicon-credit-card">&nbsp</span><?php echo $this->lang->line('sales_add_payment'); ?></div>
									</div>

									
								<?php
								}
								?>

							
							</div>

							<?php echo form_open($controller_name."/cancel", array('id'=>'buttons_form')); ?>
								<div class="form-group" id="buttons_sale">
									
									<?php
									// Only show this part if the payment covers the total
									if(!$pos_mode && isset($customer))
									{
									?>
										<div class='btn btn-sm btn-success' id='finish_invoice_quote_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $mode_label; ?></div>
									<?php
									}
									?>
								</div>
							<?php echo form_close(); ?>							
						<?php
						}
						?>
					</div>
				</div>	
			</div>	
		</div>
		
		<div  id="overall_sales" class="panel panel-default col-md-4">
			<table class="sales_table_1001" id="sale_totals">
				<tr>
					<th style="width: 55%;"><?php echo $this->lang->line('sales_quantity_of_items',$item_count); ?></th>
					<th style="width: 45%; text-align: right;"><?php echo $total_units; ?></th>
				</tr>

				<tr>
					<th style='width: 55%;'><?php echo $this->lang->line('sales_total'); ?></th>
					<th style="width: 45%; text-align: right;"><span id="sale_total"><?php echo to_currency($total); ?></span></th>
				</tr>
			</table>	
	
	
		   <?php $tabindex = 0; ?>

			<?php echo form_open($controller_name."/add", array('id'=>'add_item_form', 'class'=>'form-horizontal panel panel-default')); ?>
			<div class="panel-body form-group">
				<ul>
					<li class="pull-center sales_search">
						<?php echo form_input(array('name'=>'item', 'id'=>'item', 'class'=>'form-control input-sm tab'.$tabindex, 'size'=>'50', 'tabindex'=>++$tabindex)); ?>
						<span class="ui-helper-hidden-accessible" role="status"></span>
					</li>
				</ul>
			</div>
			<?php echo form_close(); ?>
	
	
			<div class="table-responsive">
				<table class="table table-bordered" id="register">
					<thead>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line('common_delete'); ?></th>
							<th style="width: 30%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_price'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_qty'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_total'); ?></th>
							<th style="width: 5%;"></th>
						</tr>
					</thead>

					<tbody id="cart_contents">
						<?php
						if(count($cart) == 0)
						{
						?>
							<tr>
								<td colspan='10'>
									<div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
								</td>
							</tr>
						<?php
						}
						else
						{
							foreach(array_reverse($cart, TRUE) as $line=>$item)
							{
						?>

								<?php echo form_open($controller_name."/edit_item/$line", array('class'=>'form-horizontal', 'id'=>'cart_'.$line)); ?>
									<tr>
										<td>
											<?php echo anchor($controller_name . "/delete_item/$line", '<span class="glyphicon glyphicon-trash"></span>'); ?>
											<?php echo form_hidden('location', $item['item_location']); ?>
											<?php echo form_hidden('discount', $item['discount']); ?>
											<?php echo form_input(array('type'=>'hidden', 'name'=>'item_id', 'value'=>$item['item_id'])); ?>
										</td>
										<?php
										if($item['item_type'] == ITEM_TEMP)
										{
										?>
											<td style="align: center;">
												<?php echo form_input(array('name'=>'name','id'=>'name', 'class'=>'form-control input-sm', 'value'=>$item['name'], 'tabindex'=>++$tabindex));?>
											</td>
										<?php
										}
										else
										{
										?>
										
											
										<td onclick="getCost(this, '<?php echo $line; ?>')" style="align: center;">
											<?php echo $item['name']; ?>									
											<button style="display:none;" id='cost_item_button_<?php echo $line; ?>' class='btn btn-info btn-sm pull-right modal-dlg' data-href="<?php echo site_url($controller_name."/get_sale_item_info/".$item['item_id']."/".$customer_id); ?>"
												title="<?php echo $this->lang->line($controller_name . '_item_sale_list'); ?>"><span class="glyphicon glyphicon-usd"></span></button> 
										</td>
										<?php
										}
										?>
										<?php
										if($sales_price_allowed)
										{
										?>
											<td><?php echo form_input(array('name'=>'price', 'class'=>'priceinput form-control input-sm tab'.$tabindex, 'value'=>to_currency_no_money($item['price']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));?></td>
										<?php
										}
										else
										{
										?>
											<td>
												<?php echo to_currency($item['price']); ?>
												<?php echo form_hidden('price', to_currency_no_money($item['price'])); ?>
											</td>
										<?php
										}
										?>

										<td>
											<?php
												echo form_input(array('name'=>'quantity', 'class'=>'qtyInput form-control input-sm tab'.$tabindex, 'value'=>to_quantity_decimals($item['quantity']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
											?>
										</td>
										
										<td>
											<?php
											if($item['item_type'] == ITEM_AMOUNT_ENTRY)
											{
												echo form_input(array('name'=>'discounted_total', 'class'=>'form-control input-sm', 'value'=>to_currency_no_money($item['discounted_total']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
											}
											else
											{
												echo to_quantity_decimals($item['discounted_total']);
											}
											?>
										</td>

										
										<td><a href="javascript:document.getElementById('<?php echo 'cart_'.$line ?>').submit();" title=<?php echo $this->lang->line('sales_update')?> ><span class="glyphicon glyphicon-refresh"></span></a></td>
										</tr>
								<?php echo form_close(); ?>
						<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>	
			
			
			<?php echo form_open($controller_name."/cancel", array('id'=>'buttons_form')); ?>
				<div class="form-group" id="buttons_sale">
					<div class='btn btn-sm btn-default pull-left' id='suspend_sale_button'><span class="glyphicon glyphicon-align-justify">&nbsp</span><?php echo $this->lang->line('sales_suspend_sale'); ?></div>
					<?php
					// Only show this part if the payment covers the total
					if(!$pos_mode && isset($customer))
					{
					?>
						<div class='btn btn-sm btn-success' id='finish_invoice_quote_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $mode_label; ?></div>
					<?php
					}
					?>

					<div class='btn btn-sm btn-danger pull-right' id='cancel_sale_button'><span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('sales_cancel_sale'); ?></div>
				</div>
			<?php echo form_close(); ?>
		</div>		
    </div>

<script type="text/javascript">
	$.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
	$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
	$.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
	$.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
	$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
	$.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};

$(document).ready(function()
{
	$('#register .qtyInput').numpad(open);
	$('#register .priceinput').numpad(open);
	$('#amount_tendered').numpad({onKeypadOpen: function(){
        $(this).find('.nmpd-display').focus().select();
    }});

	$(document).on("click",".pos_payment_type",function(e) {
		 e.preventDefault();
		var id= $(this).attr("rel");
		check_pos_payment_type(id);
	});
	
	$(document).on("change",'[name="price"],[name="quantity"]',function() {
		
		var input=$(this).attr("name");
		var value =$(this).val();
		
		if($(this).parents("tr").find('[name="location"]').length){
			var location =$(this).parents("tr").find('[name="location"]').val();
		}else{
			var location = $(this).parents("tr").find('[name="location"]').val();
		}

		if($(this).parents("tr").find('[name="location"]').length){
			var location =$(this).parents("tr").find('[name="location"]').val();
		}else{
			var location = $(this).parents("tr").prev("tr").find('[name="location"]').val();
		}

		if($(this).parents("tr").find('[name="price"]').length){
			var price =$(this).parents("tr").find('[name="price"]').val();
		}else{
			var price = $(this).parents("tr").prev("tr").find('[name="price"]').val();
		}


		if($(this).parents("tr").find('[name="quantity"]').length){
			var quantity =$(this).parents("tr").find('[name="quantity"]').val();
		}else{
			var quantity = $(this).parents("tr").prev("tr").find('[name="quantity"]').val();
		}

		if($(this).parents("tr").find('[name="discount"]').length){
			var discount =$(this).parents("tr").find('[name="discount"]').val();
		}else{
			var discount = $(this).parents("tr").prev("tr").find('[name="discount"]').val();
		}

		if($(this).parents("tr").find('[name="description"]').length){
			var description =$(this).parents("tr").find('[name="description"]').val();
		}else{
			var description = $(this).parents("tr").next("tr").find('[name="description"]').val();
		}

		if($(this).parents("tr").find('[name="serialnumber"]').length){
			var serialnumber =$(this).parents("tr").find('[name="serialnumber"]').val();
		}else{
			var serialnumber = $(this).parents("tr").next("tr").find('[name="serialnumber"]').val();
		}

		var data={
			"csrf":$('[name="csrf"]').val(),
			"location":location,
			"price":price,
			"quantity":quantity,
			"discount":discount,
			"description":description,
			"serialnumber":serialnumber
			};
		$(this).parents("tr").prevAll("form:first").ajaxSubmit({
		  data:data,
      	  success: processJson
   		 });
	});
	
	function check_pos_payment_type(id)
	{
		var cash_rounding = <?php echo json_encode($cash_rounding); ?>;
		
		if(id == "<?php echo $this->lang->line('sales_giftcard'); ?>")
		{
			$("#sale_total").html("<?php echo to_currency($total); ?>");
			$("#sale_amount_due").html("<?php echo to_currency($amount_due); ?>");
			$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
			$("#amount_tendered:enabled").val('').focus();
			$(".giftcard-input").attr('disabled', false);
			$(".non-giftcard-input").attr('disabled', true);
			$(".giftcard-input:enabled").val('').focus();
		}
		else if(id == "<?php echo $this->lang->line('sales_cash'); ?>" && cash_rounding)
		{
			$("#sale_total").html("<?php echo to_currency($cash_total); ?>");
			$("#sale_amount_due").html("<?php echo to_currency($cash_amount_due); ?>");
			$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
			$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($cash_amount_due); ?>");
			$(".giftcard-input").attr('disabled', true);
			$(".non-giftcard-input").attr('disabled', false);
		}
		else
		{
			$("#sale_total").html("<?php echo to_currency($non_cash_total); ?>");
			$("#sale_amount_due").html("<?php echo to_currency($non_cash_amount_due); ?>");
			$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
			$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($non_cash_amount_due); ?>");
			$(".giftcard-input").attr('disabled', true);
			$(".non-giftcard-input").attr('disabled', false);
		}
	}	
	
	
	$('#show_second_display').click(function () {
	second_display = window.open('sales/customer_display', "second_display"); });
	
	$(document).on("click",".ui-menu-item",function(e){
		e.preventDefault();
		//console.log("here");
		$("#add_item_form").ajaxSubmit({
      	  success: processJson
   		 });
	});
	/*V1.1*/
  var $project = $('#item');  
  $project.autocomplete({
	source: "<?php echo site_url($controller_name . '/item_search'); ?>",
	minChars: 0,
	autoFocus: false,
   	delay: 500,
	select: function (a, ui) {
		$(this).val(ui.item.value);
		
		return false;
	}
  });

  function processJson(data) {
  	setData(data);
	$("#item").val("");
	$("#item").focus();
	$('#register .qtyInput').numpad(open);
	$('#register .priceinput').numpad(open);
    }


  $project.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    
    var $li = $('<li>'),
        $img = $('<img>');

       if(item.icon){
       		var iconSrc='<?php echo base_url("uploads/item_pics/"); ?>' + item.icon;
	    }else{
	    	var iconSrc='<?php echo base_url("uploads/item_pics/"); ?>' + "no-img.png";
	    }
	    $img.attr({
	      src:iconSrc,
	      alt: item.label,
	      class:"icon_autocomplete"

	    });

    $li.attr('data-value', item.label);
    $li.append('<a href="#">');
    var label ="<span class='item_label'>"+item.label+"</span>";
   // $li.find('a').append($img).append(label);    
    $li.find('a').append(label);    

    return $li.appendTo(ul);
  };
  /*V1.1*/
 // $('#item').focus();
$('#item').keypress(function (e) {
		if (e.which == 13) {
			$('#add_item_form').ajaxSubmit({
				    success: processJson
				});
			return false;
		}
	});


	 $(document).on("click",".select_item",function(e) {
		 e.preventDefault();
		var id= $(this).attr("rel");
		$(".sales_search #item").val(id);

      // $("#add_item_form").submit();
	    $("#add_item_form").ajaxSubmit({
            success: processJson
        });

	});

	$("input[name='item_number']").change(function(){
		var item_id = $(this).parents("tr").find("input[name='item_id']").val();
		var item_number = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_number');?>",
			method: 'post',
			data: {
				"item_id" : item_id,
				"item_number" : item_number,
			},
			dataType: 'json'
		});
	});

	$("input[name='name']").change(function(){
		var item_id = $(this).parents("tr").find("input[name='item_id']").val();
		var item_name = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_name');?>",
			method: 'post',
			data: {
				"item_id" : item_id,
				"item_name" : item_name,
			},
			dataType: 'json'
		});
	});

	$("input[name='item_description']").change(function(){
		var item_id = $(this).parents("tr").find("input[name='item_id']").val();
		var item_description = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_description');?>",
			method: 'post',
			data: {
				"item_id" : item_id,
				"item_description" : item_description,
			},
			dataType: 'json'
		});
	});

	$('#item').focus();

	$('#item').blur(function()
	{
		$(this).val("<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
	});

	$('#item').autocomplete(
	{
		source: "<?php echo site_url($controller_name . '/item_search'); ?>",
		minChars: 0,
		autoFocus: false,
		delay: 500,
		select: function (a, ui) {
			$(this).val(ui.item.value);
			$("#add_item_form").submit();
			return false;
		}
	});

		$('#item').keypress(function (e) {
		if (e.which == 13) {
			$('#add_item_form').ajaxSubmit({
			    success: processJson
			});
			return false;
		}
	});

	var clear_fields = function()
	{
		if($(this).val().match("<?php echo $this->lang->line('sales_start_typing_item_name') . '|' . $this->lang->line('sales_start_typing_customer_name'); ?>"))
		{
			$(this).val('');
		}
	};

	$('#item, #customer').click(clear_fields).dblclick(function(event)
	{
		$(this).autocomplete("search");
	});

	$('#customer').blur(function()
	{
		$(this).val("<?php echo $this->lang->line('sales_start_typing_customer_name'); ?>");
	});

	$("#customer").autocomplete(
	{
		source: "<?php echo site_url("customers/suggest"); ?>",
		minChars: 0,
		delay: 10,
		select: function (a, ui) {
			$(this).val(ui.item.value);
			$("#select_customer_form").submit();
		}
	});

	$('#customer').keypress(function (e) {
		if(e.which == 13) {
			$('#select_customer_form').submit();
			return false;
		}
	});

	$(".giftcard-input").autocomplete(
	{
		source: "<?php echo site_url("giftcards/suggest"); ?>",
		minChars: 0,
		delay: 10,
		select: function (a, ui) {
			$(this).val(ui.item.value);
			$("#add_payment_form").submit();
		}
	});

	$('#comment').keyup(function()
	{
		$.post("<?php echo site_url($controller_name."/set_comment");?>", {comment: $('#comment').val()});
	});

	<?php
	if($this->config->item('invoice_enable') == TRUE)
	{
	?>
		$('#sales_invoice_number').keyup(function()
		{
			$.post("<?php echo site_url($controller_name."/set_invoice_number");?>", {sales_invoice_number: $('#sales_invoice_number').val()});
		});

		var enable_invoice_number = function()
		{
			var enabled = $("#sales_invoice_enable").is(":checked");
			$("#sales_invoice_number").prop("disabled", !enabled).parents('tr').show();
			return enabled;
		}

		enable_invoice_number();

		$("#sales_invoice_enable").change(function()
		{
			var enabled = enable_invoice_number();
			$.post("<?php echo site_url($controller_name."/set_invoice_number_enabled");?>", {sales_invoice_number_enabled: enabled});
		});
	<?php
	}
	?>

	$("#sales_print_after_sale").change(function()
	{
		$.post("<?php echo site_url($controller_name."/set_print_after_sale");?>", {sales_print_after_sale: $(this).is(":checked")});
	});

	$("#price_work_orders").change(function()
	{
		$.post("<?php echo site_url($controller_name."/set_price_work_orders");?>", {price_work_orders: $(this).is(":checked")});
	});

	$('#email_receipt').change(function()
	{
		$.post("<?php echo site_url($controller_name."/set_email_receipt");?>", {email_receipt: $(this).is(":checked")});
	});	
	
	$('ul.cart_tab_selection li').click(function() {
		$.post("<?php echo site_url($controller_name."/set_cart_tab");?>", {card_tab: $(this).attr('id')}, function() {
            window.location.assign("<?php echo site_url($controller_name) ?>")
        });
    });

	$("#finish_sale_button").click(function()
	{
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name."/complete"); ?>");
		$('#buttons_form').submit();
	});

	$("#finish_invoice_quote_button").click(function()
	{
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name."/complete"); ?>");
		$('#buttons_form').submit();
	});

	$("#suspend_sale_button").click(function()
	{
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name."/suspend"); ?>");
		$('#buttons_form').submit();
	});

	$("#cancel_sale_button").click(function()
	{
		if(confirm("<?php echo $this->lang->line("sales_confirm_cancel_sale"); ?>"))
		{
			$('#buttons_form').attr('action', "<?php echo site_url($controller_name."/cancel"); ?>");
			$('#buttons_form').submit();
		}
	});

	$("#add_payment_button").click(function()
	{
		$('#add_payment_form').submit();
	});

	$("#payment_types").change(check_payment_type).ready(check_payment_type);
	
	$("#cart_contents input").keypress(function(event)
	{
		if(event.which == 13)
		{
			$(this).parents("tr").prevAll("form:first").submit();
		}
	});

	$("#amount_tendered").keypress(function(event)
	{
		if(event.which == 13)
		{
			$('#add_payment_form').submit();
		}
	});

	$("#finish_sale_button").keypress(function(event)
	{
		if(event.which == 13)
		{
			$('#finish_sale_form').submit();
		}
	});

	dialog_support.init("a.modal-dlg, button.modal-dlg");
	dialog_support.init("a.modal-dlg-wide, button.modal-dlg-wide");

	table_support.handle_submit = function(resource, response, stay_open)
	{
		$.notify(response.message, { type: response.success ? 'success' : 'danger'} );

		if(response.success)
		{
			if(resource.match(/customers$/))
			{
				$("#customer").val(response.id);
				$("#select_customer_form").submit();
			}
			else
			{
				var $stock_location = $("select[name='stock_location']").val();
				$("#item_location").val($stock_location);
				$("#item").val(response.id);
				if(stay_open)
				{
					$("#add_item_form").ajaxSubmit();
				}
				else
				{
					$("#add_item_form").submit();
				}
			}
		}
	}


	
});

function setData(data){
	
	$(".alert").remove();
	$(data).find(".alert").insertBefore("#register_wrapper");

	$("#cart_contents").html($(data).find("#cart_contents").html());
	
  	$("#sale_totals").html($(data).find("#sale_totals").html());
	    
  	if($(data).find("#payment_totals").length)
	{
  		$("#payment_totals").html($(data).find("#payment_totals").html());
	}
  	else{
  		$("#payment_totals").html("");
  	}
  	if($(data).find("#amount_tendered").length){
  		$("#amount_tendered").val($(data).find("#amount_tendered").val());	
  	}else{
  		$("#amount_tendered").val("0");	
  	}
  	
  	// in first time
  	if($("#finish_sale").length==0){
  		$(data).find("#finish_sale").insertAfter("#sale_totals");
  	}
  	if($("#payment_totals").length==0){
  		$(data).find("#payment_totals").insertAfter("#sale_totals");
  	}
    if($("#payment_details").length==0){
		$(data).find("#payment_details").insertAfter("#payment_totals");  		
  	}
   	if($("#buttons_form").length==0){
 		$(data).find("#buttons_form").insertAfter("#payment_details");  		
  	}  	

}

function check_payment_type()
{
	var cash_rounding = <?php echo json_encode($cash_rounding); ?>;
	
	if ($('#payment_types').val() != ''){
		$('#payment_types').val(["<?php echo $this->lang->line('sales_cash'); ?>"]);
	}

	if($("#payment_types").val() == "<?php echo $this->lang->line('sales_giftcard'); ?>")
	{
		$("#sale_total").html("<?php echo to_currency($total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
		$("#amount_tendered:enabled").val('').focus();
		$(".giftcard-input").attr('disabled', false);
		$(".non-giftcard-input").attr('disabled', true);
		$(".giftcard-input:enabled").val('').focus();
	}
	else if($("#payment_types").val() == "<?php echo $this->lang->line('sales_cash'); ?>" && cash_rounding)
	{
		$("#sale_total").html("<?php echo to_currency($cash_total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($cash_amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
		$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($cash_amount_due); ?>");
		$(".giftcard-input").attr('disabled', true);
		$(".non-giftcard-input").attr('disabled', false);
	}
	else
	{
		$("#sale_total").html("<?php echo to_currency($non_cash_total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($non_cash_amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
		$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($non_cash_amount_due); ?>");
		$(".giftcard-input").attr('disabled', true);
		$(".non-giftcard-input").attr('disabled', false);
	}
}
	$(function(){
	 $(document).on("click",".list-of-categories a",function(e) {
		 e.preventDefault();
		var result = "";
		var cat= $(this).attr("rel");
		jQuery.ajax({
			url:"sales/get_item_by_cat",
			type:'post',
			data:{
				"category":cat
			},
			success:function(r){
				var data  = jQuery.parseJSON(r);
				var result ="";
				$.each(data,function(i,item){ 

				     if(item.icon){
				       		var iconSrc=item.icon;
					    }else{
					    	var iconSrc="no-img.png";
					    }
    					result += '<a class="btn btn-app table_cat select_item" rel='+item.value+'><div style="background-image:url(\'<?php echo base_url("uploads/item_pics/"); ?>'+iconSrc+'\'); background-size: 80px 80px; height: 80px;width: 80px;"></div><div class="centered">Centered</div><br>';				
						result +=item.label+"</a>";	
				});
				$(".list-of-items").show();
				$(".list-of-items").html(result);
			}

		});	
	});
		$("#get_list_cat").click(function(e){
			e.preventDefault();
			var result = "";
			if($(".hide_cat").length > 0)
				return true;
			
			jQuery.ajax({
				url:"sales/get_cat",
				type:'post',
				success:function(r){
					var data  = jQuery.parseJSON(r);
					$.each(data,function(i,v){
						if(v.category)
						result +="<a class='sales__category--item btn btn-lg cat_button' rel='"+v.category+"'  href='#'>"+v.category+"</a>";
					});
	
					$(".list-of-categories").show();
					$(".list-of-categories").html(result);
					$(".show_categories--button span").text("Hide Categories");
					$(".show_categories--button").addClass("hide_cat");
					$(".list-of-categories a:first").click();
				}

			});			
			
		});
	
	$("#get_list_cat").trigger("click");
	 $(document).on("click",".hide_cat",function(e) {
		 e.preventDefault();
		 	$(".show_categories--button span").text("Show Categories");
			$(".show_categories--button").removeClass("hide_cat");
			$(".list-of-categories").hide();
			$(".list-of-items").hide();
	});
	});
</script>

<style>
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>


<?php $this->load->view("partial/footer"); ?>
