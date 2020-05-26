<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('accounts/update_transfer_fund/'.$trans_id, array('id'=>'accounts_form', 'class'=>'form-horizontal')); ?>
	<fieldset id="item_basic_info">
	
	<?php if ($transfer_info->credit_amount) { ?>
			<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_credits'), 'credit_amount', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group input-group-sm">
					<?php if (!currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
					<?php echo form_input(array(
							'name'=>'credit_amount',
							'id'=>'credit_amount',
							'class'=>'form-control input-sm',
							'value'=>$transfer_info->credit_amount)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ($transfer_info->debit_amount) { ?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_debits'), 'debit_amount', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group input-group-sm">
					<?php if (!currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
					<?php echo form_input(array(
							'name'=>'debit_amount',
							'id'=>'debit_amount',
							'class'=>'form-control input-sm',
							'value'=>$transfer_info->debit_amount)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
        <?php } ?>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_transfer_amount'), 'transfer_from_label', array('class'=>'required control-label col-xs-3')); ?>
			
			<div class='col-xs-6'>
				<?php echo form_label($transfer_info->description, 'transfer_from_label', array('class'=>'control-label col-xs-12')); ?>
			</div>
		</div>
	</fieldset>
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
					table_support.refresh();
					table_support.handle_submit("<?php echo site_url($controller_name . '/cashflow'); ?>", response);
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#error_message_box',

		ignore: '',

		rules:
		{
			credit_amount:
			{
				required: true,
				remote: amount_validator('#credit_amount')
			},
			debit_amount:
			{
				required: true,
				remote: amount_validator('#debit_amount')
			}
		},

		messages:
		{
			credit_amount:
			{
				required: "<?php echo $this->lang->line('accounts_amount_required'); ?>",
				remote: "<?php echo $this->lang->line('accounts_amount_number'); ?>"
			},
			debit_amount:
			{
				required: "<?php echo $this->lang->line('accounts_amount_required'); ?>",
				remote: "<?php echo $this->lang->line('accounts_amount_number'); ?>"
			}
		}
	}, form_support.error));
});
</script>
