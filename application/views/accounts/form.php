<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('accounts/save/'.$account_id, array('id'=>'accounts_form', 'class'=>'form-horizontal')); ?>
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
							'value'=>'')
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
				<?php echo form_input(array('class'=>'form-control input-sm required', 'type'=>'text', 'name'=>'employee', 'value'=>$employee, 'readonly'=>'true'));?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_information'), 'account', array('class'=>'control-label col-xs-3 ')); ?>
			<div class='col-xs-6'>
				<?php echo form_input(array('class'=>'form-control input-sm required', 'type'=>'text', 'name'=>'account', 'value'=>$account, 'readonly'=>'true'));?>
			</div>
		</div>
	
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('sales_stock_location'), 'stock_location_label', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_dropdown('stock_location_show', $stock_locations, $stock_location, array('class'=>'form-control', 'disabled'=>'true', 'id'=>'stock_location_show'));?>
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
				required: "<?php echo $this->lang->line('expenses_amount_required'); ?>",
				remote: "<?php echo $this->lang->line('expenses_amount_number'); ?>"
			}
		}
	}, form_support.error));
});
</script>
