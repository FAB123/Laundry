<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('accounts/update_account/'.$trans_id, array('id'=>'accounts_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_payment_amount'), 'amount', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group input-group-sm">
					<?php if (!currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
					<?php echo form_input(array(
							'name'=>'amount',
							'id'=>'amount',
							'class'=>'form-control input-sm',
							'value'=>$payment_info->amount)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('accounts_employee'), 'employee', array('class'=>'control-label col-xs-3 ')); ?>
			<div class='col-xs-6'>
				<?php echo form_input(array('class'=>'form-control input-sm required', 'type'=>'text', 'name'=>'employee', 'value'=>$payment_info->first_name.' '.$payment_info->last_name, 'readonly'=>'true'));?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_information'), 'account', array('class'=>'control-label col-xs-3 ')); ?>
			<div class='col-xs-6'>
				<?php echo form_input(array('class'=>'form-control input-sm required', 'type'=>'text', 'name'=>'account', 'value'=>$payment_info->accounts_first_name.' '.$payment_info->accounts_last_name, 'readonly'=>'true'));?>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('accounts_notes'), 'notes', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_textarea(array(
					'name'=>'notes',
					'id'=>'notes',
					'class'=>'form-control input-sm',
					'value'=>$accounts_info->notes)
					);?>
			</div>
		</div>

	</fieldset>
	<?php echo form_hidden('mode', $mode); ?>
	<?php echo form_hidden('employee_id', $employee_id); ?>
	<?php echo form_hidden('stock_location', $stock_location); ?>
<?php echo form_close(); ?>

<table id="items_count_details" class="table table-striped table-hover">
	<thead>
		<tr style="background-color: #999 !important;">
			<th colspan="4"><?php echo $this->lang->line('accounts_editing_history'); ?></th>
		</tr>
		<tr>
			<th width="34%"><?php echo $this->lang->line('items_inventory_date'); ?></th>
			<th width="40%"><?php echo $this->lang->line('items_inventory_employee'); ?></th>
			<th width="25%"><?php echo $this->lang->line('account_amount'); ?></th>
		</tr>
	</thead>
	<tbody id="inventory_result">
		<?php

		$history_array = $this->Account->get_history_data_for_item($trans_id, $mode)->result_array();
		
	    foreach($history_array as $row)
     	{

     	?>
		<tr>
		<?php 			
		    $employee = $this->Employee->get_info($row['employee_id']);
			$employee_name = $employee->first_name . ' ' . $employee->last_name;
		?>
			<td><?php echo $row['thedate']; ?></td>
			<td><?php echo $employee_name; ?></td>
			<td><?php echo $row['amount'] . ' SR'; ?></td>
		</tr>
     	<?php
    	}
     	?>
	</tbody>
</table>

<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	<?php $this->load->view('partial/datepicker_locale'); ?>

	var amount_validator = function(field) {
		return {
			url: "<?php echo site_url($controller_name . '/ajax_check_amount')?>",
			type: 'POST',
			dataFilter: function(data) {
				var response = JSON.parse(data);
				$(field).val(response.amount);
				return response.success;
			}
		}
	}


	$('#accounts_form').validate($.extend({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response)
				{
					dialog_support.hide();
					table_support.handle_submit("<?php echo site_url($controller_name); ?>", response);
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#error_message_box',

		ignore: '',

		rules:
		{
			amount:
			{
				required: true,
				remote: amount_validator('#amount')
			}
		},

		messages:
		{
			amount:
			{
				required: "<?php echo $this->lang->line('accounts_amount_required'); ?>",
				remote: "<?php echo $this->lang->line('accounts_amount_number'); ?>"
			}
		}
	}, form_support.error));
});
</script>
